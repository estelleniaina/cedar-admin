<?php

namespace App\Http\Controllers;

use App\Enums\RubriqueType;
use App\Http\Requests\RubriqueRequest;
use App\Models\Centre;
use App\Models\Rubrique;
use App\Services\Rubriques\RubriqueService;
use App\Services\Rubriques\Type\HistoireService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class HistoireController extends Controller
{
    private $rubriqueService;
    private $rubrique;
    private $type = RubriqueType::HISTOIRE;

    /**
     * HistoireController constructor.
     */
    public function __construct()
    {
        $this->rubriqueService = new RubriqueService();
        $this->rubrique = new Rubrique();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $centres = Centre::getListCentre(false);
        $thead = RubriqueService::getTableHeader();
        return view("histoire", compact("centres", 'thead'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getAll(Request $request)
    {
        return (new RubriqueService())->getRubrique(new HistoireService($request));
    }

    /**
     * @param RubriqueRequest $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $id = $request->get("id");
        if (Str::of($id)->isEmpty()) {
            $data = $this->rubriqueService->insertRubrique($request, RubriqueType::HISTOIRE);
        } else {
            $data = $this->rubriqueService->updateRubrique($id, $request, RubriqueType::HISTOIRE);
        }
        return $data>0 ? saveSucces() : saveError();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function edit($id)
    {
        $aData = Rubrique::findOrFail($id);
        return Response()->json($aData);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        return $this->rubriqueService->deleteRubrique($id, $this->type);
    }

    /**
     * @OA\Get(
     *      path="/api/{centreId}/histoire",
     *      operationId="getCentreHistoires",
     *      tags={"Centres"},

     *      summary="liste",
     *     @OA\Parameter(
     *          name="centreId",
     *          description="ID du centre",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     * @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *  )
     */
    public function getCentreList($centreId) {
        $mReturn = Rubrique::getCentre($centreId, RubriqueType::HISTOIRE);
        return is_string($mReturn) ? responseError($mReturn) : responseSuccess($mReturn);
    }

    /**
     * @return JsonResponse
     */
    public function getList() {
        $mReturn = Rubrique::getRubrique(RubriqueType::HISTOIRE);
        return is_string($mReturn) ? responseError($mReturn) : responseSuccess($mReturn);
    }
}
