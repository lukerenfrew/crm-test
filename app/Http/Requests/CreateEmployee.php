<?php

namespace App\Http\Requests;

use App\Company;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateEmployee extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'firstname' => ['required'],
            'surname' => ['required'],
            'email' => ['email'],
            'company' => [Rule::in(Company::pluck('id')),],
        ];
    }

    public function messages(): array
    {
        return [
            'firstname.required' => 'The first name field is required',
            'surname.required' => 'The last name field is required',
        ];
    }
}
