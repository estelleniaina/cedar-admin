<?php

namespace App\Http\Controllers;

use App\Models\Actualite;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use DataTables;

class ActualiteController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view("actualite.list");
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getAll(Request $request)
    {
        $data = Actualite::latest()->get();
        return DataTables::of($data)
            ->filter(function ($instance) use ($request) {
                if ($request->has('titre') && $request->filled('titre')) {
                    $sFilterTitre = Str::lower($request->get('titre'));
                    $instance->collection = $instance->collection->filter(function ($row) use ($sFilterTitre) {
                        return Str::contains( Str::lower($row['titre']), $sFilterTitre) ? true : false;
                    });
                }
            })
            ->addColumn('action', function($row){
                $sRouteEdit = "edit.actualite";
                $sRouteDelete = "delete.actualite";
                return datatableAction($row, $sRouteEdit, $sRouteDelete, "actualite");
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
        $requestAll = $request->all();
        $id = $request->get("id");
        if (Str::of($id)->isEmpty()) {
            $actualite = Actualite::insertData($requestAll);
        } else {
            $actualite = Actualite::updateData($requestAll, $id);
        }
        return Response()->json($actualite);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function edit($id)
    {
        $aData = Actualite::getActualite($id);
        return Response()->json($aData);
    }

    /**
     * @param Request $request
     * @param         $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $actualite = Actualite::updateData($request->all(), $id);
        return Response()->json($actualite);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $actualite = Actualite::deleteData($id);
        return $actualite;

    }

    /**
     * @OA\Get(
     *      path="/api/actualite",
     *      operationId="getAllActualite",
     *      tags={"Actualités"},

     *      summary="Prendre la liste des actualités",
     *      description="Retourner la liste des actualités",
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
        $mReturn = Actualite::getAllActualite();
        return is_string($mReturn) ? responseError($mReturn) : responseSuccess($mReturn);
    }

    /**
     * @OA\Get(
     *      path="/api/actualite/{slug}",
     *      operationId="getInfosActualite",
     *      tags={"Actualités"},

     *      summary="Prendre l'infos de l'actualité",
     *      description="Retourner les informations de l'actualité",
     *     @OA\Parameter(
     *          name="slug",
     *          description="Slug de l'article",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
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
    public function infosActualite($slug)
    {
        $mReturn = Actualite::getActualite(null, $slug);
        if (is_string($mReturn)) {
            return responseError($mReturn);
        }

        $data['infos'] = $mReturn;

        if (!empty($mReturn)) {
            $currentId = $mReturn["id"];
            $data['next'] = Actualite::getPrevNextActualite($currentId, true);
            $data['prev'] = Actualite::getPrevNextActualite($currentId);
        }

        return responseSuccess($data);

    }
}
