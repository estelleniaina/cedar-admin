<?php

namespace App\Http\Controllers;

use App\Enums\RubriqueType;
use App\Models\Rubrique;

class RubriqueController extends Controller
{
    protected $rubrique;
    public function __construct()
    {
        $this->rubrique = new Rubrique();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getActualite()
    {
        $mReturn = $this->rubrique->getActualites();
        return is_string($mReturn) ? responseError($mReturn) : responseSuccess($mReturn);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInfoActualite($slug)
    {
        $mReturn = Rubrique::getInfo($slug);
        return is_string($mReturn) ? responseError($mReturn) : responseSuccess($mReturn);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCentreActualite($centreId)
    {
        $mReturn = Rubrique::getActualites($centreId);
        return is_string($mReturn) ? responseError($mReturn) : responseSuccess($mReturn);
    }

    public function getLatestActualite()
    {
        $mReturn = $this->rubrique->getLatest();
        return is_string($mReturn) ? responseError($mReturn) : responseSuccess($mReturn);
    }
}
