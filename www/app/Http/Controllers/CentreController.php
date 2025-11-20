<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Centre;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class CentreController extends Controller
{
    private $centre;

    public function __construct()
    {
        $this->centre = new Centre();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
//        var_dump(base64_decode("")); exit;
        $thead = ["ID", "Nom", "Localisation", "Action"];
//        return view("centre", compact('thead'));
      $centres = Centre::all();
        return view('content.centre.index', compact('centres'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getAll()
    {
        return datatables()->of(Centre::select('*'))
            ->addColumn('action', function($row){
                $sRouteEdit = 'centre.edit';
                $sRouteDelete = 'centre.destroy';
                return datatableAction($row, $sRouteEdit, $sRouteDelete, "centre");
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $id = $request->get("id");
        if (isset($request->objectif)) {
            $request['objectif'] = base64_decode($request->objectif);
        }
        if (isset($request->vision)) {
            $request['vision'] = base64_decode($request->vision);
        }

        if (Str::of($id)->isEmpty()) {
            $centre = $this->centre->insertData($request);
        } else {
            $centre = $this->centre->updateData($request, $id);
        }
        return $centre>0 ? saveSucces() : saveError();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function edit($id)
    {
        $aData = Centre::getCentre($id);
        return Response()->json($aData);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $centre = Centre::destroy($id);
        return $centre>0 ? deleteSucces() : deleteError();
    }

    /**
     * @OA\Get(
     *      path="/api/centre",
     *      operationId="getAllCentre",
     *      tags={"Centres"},

     *      summary="Prendre la liste des centres",
     *      description="Retourner la liste des centres",
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
    public function getList() {
        $mReturn = Centre::getListCentre();
        return is_string($mReturn) ? responseError($mReturn) : responseSuccess($mReturn);
    }


    /**
     * @OA\Get(
     *      path="/api/centre/info/{id}",
     *      operationId="getCentreInfos",
     *      tags={"Centres"},

     *      summary="Prendre les infos du centre",
     *     @OA\Parameter(
     *          name="id",
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
    public function getInfos($centreID) {
        $mReturn = Centre::getCentre($centreID);
        return is_string($mReturn) ? responseError($mReturn) : responseSuccess($mReturn);
    }

}
