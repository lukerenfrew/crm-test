<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompany extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required'],
            'logo' => ['required'],
            'website' => ['required'],
        ];
    }
}
