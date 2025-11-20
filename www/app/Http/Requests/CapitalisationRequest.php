<?php

namespace App\Http\Requests;

use App\Models\Capitalisation;
use Illuminate\Foundation\Http\FormRequest;

class CapitalisationRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            Capitalisation::$colFichier => ["required", "file", "mimes:pdf", "max:" . config('constant.MAX_UPLOAD_FILE')],
        ];
    }
}
