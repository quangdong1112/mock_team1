<?php

namespace App\Http\Requests;

use App\Rules\MultiDateFormat;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class RegisterOTRequest extends FormRequest
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
            'request_type' => 'required|regex:/^5$/',
            'request_for_date' => 'required|date_format:Y-m-d',
            'check_in' => 'required|date_format:H:i',
            'check_out' => 'required|date_format:H:i',
            'reason' => 'required'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(
            response()->json(
                [
                    'status' => 'error',
                    'code' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                    'error' => $errors,
                ],
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            )
        );
    }
}
