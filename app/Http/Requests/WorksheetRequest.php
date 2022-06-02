<?php

namespace App\Http\Requests;

use App\Rules\MultiDateFormat;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class WorksheetRequest extends FormRequest
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
            'work_date' => 'nullable',
            'start_date' => [
                'nullable',
                new MultiDateFormat(),
                'before:today',
            ],
            'end_date' => [
                'nullable',
                new MultiDateFormat(),
                'before:today',
            ],
            'per_page'=> [
                'nullable',
                'numeric',
                Rule::in([30, 50, 100]),
            ]
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
