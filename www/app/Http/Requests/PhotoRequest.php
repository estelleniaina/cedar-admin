<?php

namespace App\Http\Requests;

use App\Models\Gallery;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PhotoRequest extends FormRequest
{
    private $maxSize = 1000 * 1024; // 1000Mb

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
           Gallery::$colPhoto => array("required"),
           'image.*' => ["file", "mimes:png,jpg,jpeg", "max:" . $this->maxSize],
        ];
    }


    /**
     * @param Validator $validator
     * Use to not redirect on welcome page if error
     */
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors()->first(), Config('constant.STATUS_ERROR_FORM')));
    }
}
