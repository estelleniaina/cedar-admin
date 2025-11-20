<?php

namespace App\Http\Requests;

use App\Models\Partenaire;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PartenaireRequest extends FormRequest
{
    private $maxSize = 10 * 1024; // 10Mb

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            Partenaire::$colNom => array("required", "string"),
            Partenaire::$colLogo => array("nullable", "file", "mimes:png,jpg,jpeg", "max:" . $this->maxSize),
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
