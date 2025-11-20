<?php

namespace App\Http\Requests;

use App\Models\Rapport;
use Illuminate\Foundation\Http\FormRequest;

class OpportuniteRequest extends FormRequest
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
            Rapport::$colTitre   => ["required", "string"],
            Rapport::$colFichier => ["nullable", "file", "mimes:pdf", "max:" . $this->maxSize],
        ];
    }
}
