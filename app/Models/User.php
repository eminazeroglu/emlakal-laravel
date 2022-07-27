<?php

namespace App\Models;

use App\Services\System\ImageUploadService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'permission_id',
        'language',
        'name',
        'surname',~
        'password',
        'photo_path',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['fullname', 'status'];

    protected ImageUploadService $imageService;
    protected string             $path = 'user';

    public function __construct()
    {
        $this->imageService = new ImageUploadService();
    }

    public function permissionGroup(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(PermissionGroup::class, 'id', 'permission_id');
    }

    public function permissions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PermissionPivotGroup::class, 'group_id', 'permission_id')->with('permission');
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function fullname(): Attribute
    {
        return new Attribute(
            get: fn() => $this->name . ' ' . $this->surname
        );
    }

    public function status(): Attribute
    {
        return new Attribute(
            get: fn() => $this->is_active ? 'confirmed' : 'unconfirmed'
        );
    }

    public function photo(): Attribute
    {
        return new Attribute(
            get: fn() => $this->imageService->getPhoto($this->path, $this->photo_name, 'default_user.webp')
        );
    }

    public function scopeActive($q, $val = 1)
    {
        return $q->where('is_active', $val);
    }

    public function scopeEmail($q, $email)
    {
        return $q->where('email', $email);
    }

    public function scopeEmailLike($q, $email)
    {
        return $q->where('email', 'like', '%' . $email . '%');
    }

    public function scopeEmailNot($q, $email)
    {
        if (is_array($email)):
            return $q->whereNotIn('email', $email);
        else:
            return $q->where('email', '!=', $email);
        endif;
    }

    public function scopePassword($q, $val)
    {
        return $q->where('password', $val);
    }

    public function scopeUserName($q, $val)
    {
        return $q->where('user_name', $val);
    }

    public function scopeLanguage($q, $val)
    {
        return $q->where('language', $val);
    }

    public function scopeOnlyUser($q)
    {
        return $q->where('permission_id', 1);
    }

    public function scopeOnlyAdmin($q)
    {
        return $q->where('permission_id', '>', 1);
    }

    public function scopeName($q, $val)
    {
        return $q->where('name', $val);
    }

    public function scopeNameLike($q, $val)
    {
        return $q->where('name', 'like', '%' . $val . '%');
    }

    public function scopeSurname($q, $val)
    {
        return $q->where('surname', $val);
    }

    public function scopeSurnameLike($q, $val)
    {
        return $q->where('surname', 'like', '%' . $val . '%');
    }

    public function scopeFullName($q, $val)
    {
        $explode = @explode(' ', $val);
        if (@$explode[0] && @$explode[1]):
            return $q->where('name', $explode[0])->where('surname', $explode[1]);
        endif;
    }

    public function scopeFullNameLike($q, $val)
    {
        return $q->where(function ($q) use ($val) {
            $q->where('name', 'like', '%' . $val . '%');
            $q->orWhere('surname', 'like', '%' . $val . '%');
        });
    }
}
