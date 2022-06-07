<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class MemberRequest extends FormRequest
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
            'avatar' => 'mimes:jpg,png|max:4096',
            'avatar_official' => 'mimes:jpg,png|max:4096',
            'gender' => 'required',
            'birth_date' => 'required|date',
            'other_email' => 'required|email',
            'identity_number' => 'required|numeric|digits_between:1,12',
            'identity_card_date' => 'required|date',
            'identity_card_place' => 'required|max:50',
            'skype' => 'nullable|max:30',
            'passport_number' => 'nullable|max:20',
            'passport_expiration'  => 'nullable|date',
            'nationality' => 'required|max:50',
            'bank_name' => 'required|max:70',
            'bank_account' => 'required|max:20',
            'marital_status' => 'required',
            'academic_level' => 'required|max:50',
            'permanent_address' => 'required|max:255',
            'temporary_address' => 'required|max:255',
            'tax_identification' => 'nullable|max:20',
            'healthcare_provider' => 'nullable|max:30',
            'emergency_contact_relationship' => 'required|max:50',
            'emergency_contact_name' => 'required|max:70',
            'emergency_contact_number' => 'required|max:20',
            'start_date_official' => 'nullable|date',
            'start_date_probation' => 'nullable|date'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(
            response()->json(
                [
                    'status' => 'error',
                    'code' => 422,
                    'error' => $errors,
                ], 422)
        );
    }
}
