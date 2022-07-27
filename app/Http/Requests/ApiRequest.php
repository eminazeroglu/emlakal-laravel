<?php

namespace App\Http\Requests;

use App\Interfaces\ApiRequestInterface;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiRequest extends FormRequest implements ApiRequestInterface
{

    protected $permission;

    public function __construct($permission = null)
    {
        $this->permission = $permission;
    }

    public function authorize(): bool
    {
        if ($this->permission):
            if ($this->id) return helper()->can($this->permission, 'update');
            else return helper()->can($this->permission, 'create');
        endif;
        return true;
    }

    public function rules(): array
    {
        return [];
    }

    public function messages(): array
    {
        return [];
    }

    public function failedValidation(Validator $validator)
    {
        $response = $this->transformValidationErrors($validator->errors()->toArray());
        throw new HttpResponseException(response()->json($response, 422));
    }

    private function transformValidationErrors(array $errors): array
    {
        array_walk($errors, static fn(&$value) => $value = $value[0]);
        return $errors;
    }
}
