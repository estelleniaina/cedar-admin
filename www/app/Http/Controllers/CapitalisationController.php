<?php

namespace App\Http\Controllers;

use App\Http\Requests\CapitalisationRequest;
use App\Models\Capitalisation;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class CapitalisationController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view("capitalisation.list");
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getAll()
    {
        return datatables()->of(Capitalisation::select('*'))
            ->addColumn('action', function($row){
                $sRouteEdit = 'edit.capitalisation';
                $sRouteDelete = 'delete.capitalisation';
                return datatableAction($row, $sRouteEdit, $sRouteDelete, "capitalisation");
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }

    /**
     * @param CapitalisationRequest $request
     * @return JsonResponse
     */
    public function store(CapitalisationRequest $request)
    {
        $id = $request->get("id");
        if (Str::of($id)->isEmpty()) {
            $capitalisation = Capitalisation::insertData($request);
        } else {
            $capitalisation = Capitalisation::updateData($request, $id);
        }
        return Response()->json($capitalisation);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function edit($id)
    {
        $aData = Capitalisation::getCapitalisation($id);
        return Response()->json($aData);
    }

    /**
     * @param Request $request
     * @param         $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $capitalisation = Capitalisation::updateData($request->all(), $id);
        return Response()->json($capitalisation);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $capitalisation = Capitalisation::deleteData($id);
        return $capitalisation;

    }

    /**
     * @OA\Get(
     *      path="/api/capitalisation",
     *      operationId="getAllCapitalisation",
     *      tags={"Capitalisations"},

     *      summary="Prendre la liste des capitalisations",
     *      description="Retourner la liste des capitalisations",
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
        $mReturn = Capitalisation::getListCapitalisation();
        return is_string($mReturn) ? responseError($mReturn) : responseSuccess($mReturn);
    }
}

