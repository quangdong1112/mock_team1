<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class RegisterLeaveRequest extends FormRequest
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
        if ($this->method() == 'POST' || $this->method() == 'PUT') {
            return [
                'request_type' => 'required|regex:/^[23]$/',
                'request_for_date' => 'required|date_format:Y-m-d',
                'check_in' => 'required|date_format:H:i',
                'check_out' => 'required|date_format:H:i',
                'reason' => 'required',
                'leave_all_day' => 'required_without_all:leave_start,leave_end,leave_time|numeric',
                'leave_start' => 'required_without:leave_all_day|date_format:H:i',
                'leave_end' => 'required_without:leave_all_day|date_format:H:i',
                'leave_time' => 'required_without:leave_all_day|date_format:H:i',
            ];
        }

        if ($this->method() == 'GET') {
            return [
                'request_for_date' => 'required|date_format:Y-m-d',
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
