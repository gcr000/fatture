<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:customers'],
            'phone' => ['required', 'max:255'],
            'new_customer' => ['nullable'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Il nome è obbligatorio',
            'name.string' => 'Il nome deve essere una stringa',
            'name.max' => 'Il nome non può superare i 255 caratteri',

            'surname.required' => 'Il cognome è obbligatorio',
            'surname.string' => 'Il cognome deve essere una stringa',
            'surname.max' => 'Il cognome non può superare i 255 caratteri',

            'email.required' => 'L\'email è obbligatoria',
            'email.email' => 'L\'email deve essere un indirizzo email valido',
            'email.max' => 'L\'email non può superare i 255 caratteri',
            'email.unique' => 'L\'email è già stata utilizzata',

            'phone.required' => 'Il telefono è obbligatorio',
            'phone.max' => 'Il telefono non può superare i 255 caratteri',

            'new_customer.boolean' => 'Il campo new_customer deve essere un booleano',
        ];
    }
}
