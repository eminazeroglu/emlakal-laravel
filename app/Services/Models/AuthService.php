<?php

namespace App\Services\Models;

use App\Events\UserRegisterEvent;
use App\Http\Resources\AuthResource;
use App\Models\User;
use App\Notifications\UserForgetPasswordNotification;
use App\Services\BaseModelService;
use App\Services\System\ImageUploadService;
use Illuminate\Support\Facades\Hash;

class AuthService extends BaseModelService
{
    public function __construct()
    {
        parent::__construct(new User());
    }

    public function getPermissions($user): array
    {
        $permissions = [];
        if ($user->permissionGroup && $user->permissionGroup->permissions):
            foreach ($user->permissionGroup->permissions as $permission):
                foreach ($permission->permission->option as $option):
                    $permissions[] = $permission->permission->key . ':' . $option['value'];
                endforeach;
            endforeach;
        endif;
        return $permissions;
    }

    public function login($request): \Illuminate\Http\JsonResponse
    {
        $email    = $request->input('email');
        $password = $request->input('password');
        $user     = $this->model->query()->with(['permissions', 'permissionGroup'])->email($email)->first();

        if (Hash::check($password, $user->password)):
            if ($user->is_active == 0):
                return response()->json(['email' => helper()->translate('notification.ProfileNotActive.Description')], 422);
            elseif ($user->is_block == 1):
                return response()->json(['email' => helper()->translate('notification.ProfileBlock.Description')], 422);
            else:
                $user->tokens()->delete();
                $permission = $this->getPermissions($user);
                $token      = $user->createToken('token', $permission)->plainTextToken;
                if ($token):
                    return response()->json($token);
                endif;
            endif;
        endif;
        return response()->json([
            'password' => helper()->translate('validator.HasNoLabel', ':label', helper()->translate('login.Label.Password'))
        ], 422);
    }

    public function register($request): \Illuminate\Http\JsonResponse
    {
        $data = $this->model->query()->create($request->all());
        event(new UserRegisterEvent($data));
        return response()->json($data);
    }

    /*
     * Check Token
     * */
    public function checkToken(): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        if (auth()->id()):
            return response()->json(new AuthResource($user));
        endif;
        return response()->json('Not found', 404);
    }

    /*
     * Check Email
     * */
    public function checkEmail($request): \Illuminate\Http\JsonResponse
    {
        if ($request->email):
            $user = $this->model->query()->email($request->email)->first();
            if ($user) {
                return response()->json(['email' => false]);
            }
        endif;
        return response()->json(['email' => true]);
    }

    /*
     * Forget Password
     * */
    public function forgetPassword($request): \Illuminate\Http\JsonResponse
    {
        $email = $request->email;
        $user  = $this->model->query()->email($email)->first();
        if ($user):
            $link = route('web.reset_password', ['hash' => helper()->enCrypto($user->id)]);
            if ($request->platform === 'crm'):
                $link = request()->header('Origin') . '/#/auth/reset-password?hash=' . helper()->enCrypto($user->id);
            endif;

            try {
                $user->notify(new UserForgetPasswordNotification([
                    'title'   => 'Şifrənizi yeniləyin',
                    'subject' => 'Şifrənizi yeniləyin',
                    'button'  => [
                        'text' => 'Şifrə yenilə',
                        'url'  => $link
                    ],
                    'body'    => 'Şifrənizi yeniləmək üçün zəhmət olmasa aşağdakı linkə keçid edin'
                ]));
            }
            catch (\Exception) {

            }
            return response()->json('Please check your e-mail address');
        endif;
        return response()->json('Not found', 404);
    }

    /*
     * Reset Password
     * */
    public function resetPassword($request): \Illuminate\Http\JsonResponse
    {
        $id       = helper()->deCrypto($request->hash);
        $password = $request->password;

        $user = $this->model->query()->find($id);
        if ($user):
            $user->password = bcrypt($password);
            $user->save();
            return response()->json(new AuthResource($user));
        endif;
        return response()->json('Not found', 404);
    }

    /*
     * Logout
     * */
    public function logout(): \Illuminate\Http\JsonResponse|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        if (auth()->check()):
            auth()->user()->tokens()->delete();
            session()->flush();
            if (str(request()->path())->startsWith('api'))
                return response()->json('Success');
            return redirect(url()->previous());
        endif;
        return response()->json('Not found', 404);
    }

    /*
     * Profile
     * */
    public function profile($request): \Illuminate\Http\JsonResponse
    {
        $photo_name = $request->photo_name;
        $user       = (new UserService())->getByToken();;
        if ($user):
            if ($request->old_password && $request->new_password)
                $user->password = bcrypt($request->new_password);
            if ($request->language)
                $user->language = $request->language;
            $user->name    = $request->name;
            $user->surname = $request->surname;
            if (@$photo_name):
                $imageService = new ImageUploadService();
                $photo        = $imageService->setFile($photo_name)
                    ->setBase64(true)
                    ->setPath('user')
                    ->setRemoveFile($user->photo_name ?? null)
                    ->upload();
                if ($photo)
                    $user->photo_name = $photo;
            endif;
            $user->save();
            return response()->json(new AuthResource($user));
        endif;
        return response()->json('Not found', 404);
    }
}
