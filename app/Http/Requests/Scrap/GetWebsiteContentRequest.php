<?php

namespace App\Http\Requests\Scrap;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class GetWebsiteContentRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'link' => 'url|required'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => "failed",
            'errors' => $validator->errors(),
        ], Response::HTTP_BAD_REQUEST));
    }

    public function messages()
    {
        return [
            'link.url' => 'Link not in URL Format',
            'link.required' => 'Please insert the link'
        ];
    }
}
