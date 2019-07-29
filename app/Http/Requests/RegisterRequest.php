<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',  
            'email' => 'required|unique:users|email',
            'username' => 'required|unique:users',
            'password' => 'required|min:8'
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors   = [];
        $messages = $validator->getMessageBag();

        foreach ($messages->keys() as $key) {
            $errors[$key] = $messages->get($key, $this->messageFormat)[0];
        }
        throw new HttpResponseException(response()->json($errors, 422));
    }
}
