<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class RegisterForgetRequest extends FormRequest
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
        if ($this->method() == 'GET') {
            return [
                'request_for_date' => 'required|date_format:Y-m-d',
            ];
        } else {
            return [
                'request_type' => 'required|regex:/^1$/',
                'request_for_date' => 'required|date_format:Y-m-d',
                'check_in' => 'required|date_format:H:i',
                'check_out' => 'required|date_format:H:i',
                'reason' => 'required|string|max:100',
                'error_count' => 'required|regex:/^[01]$/'
            ];
        }


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
