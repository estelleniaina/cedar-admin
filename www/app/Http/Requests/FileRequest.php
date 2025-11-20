<?php

namespace App\Http\Requests;

use App\Rules\CheckFile;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Tymon\JWTAuth\Http\Middleware\Check;

class FileRequest extends FormRequest
{
    private $maxSize = 50 * 1024; // 50Mb

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'centre_id' => ["numeric", "min:1"],
            'lien' => ["nullable", "string"],
            'fichier' => ["nullable", "file", "mimes:pdf,doc,docx,pptx,ppt", "max:" . $this->maxSize],
        ];
    }

//    /**
//     * @param Validator $validator
//     * Use to not redirect on welcome page if error
//     */
//    protected function failedValidation(Validator $validator) {
//        throw new HttpResponseException(response()->json($validator->errors()->first(), Config('constant.STATUS_ERROR_FORM')));
//    }
}
