<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApproveRequest extends FormRequest
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
                'status' => [
                    'required',
                    'regex:/^(-1|2)$/',
                ],
                'comment' => 'required|string|max:100',
            ];
        }
    }
}
