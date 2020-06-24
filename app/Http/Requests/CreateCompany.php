<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompany extends FormRequest
{
    use UploadsLogo;

    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['email'],
            'logo' => ['image', 'dimensions:min_width=100,min_height=100'],
        ];
    }
}
