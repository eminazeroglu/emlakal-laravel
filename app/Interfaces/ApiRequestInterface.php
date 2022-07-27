<?php

namespace App\Interfaces;

interface ApiRequestInterface
{
    public function authorize(): bool;

    public function rules(): array;

    public function messages(): array;
}
