<?php

namespace App\Http\Controllers;

use App\Http\Requests\OpportuniteRequest;
use App\Models\Categorie;
use App\Models\Opportunite;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class OpportuniteController extends Controller
{
    private $opportunite;

    public function __construct()
    {
        $this->opportunite = new Opportunite();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Opportunite::select('*'))
                ->addColumn('action', 'opportunite.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        $thead = array(
            'Titre',
            'Description',
            'Action'
        );

        $categories = Categorie::getSelectCategorie();
        return view("opportunite.index", compact('thead', 'categories'));
    }

    /**
     * @param OpportuniteRequest $request
     * @return JsonResponse
     */
    public function store(OpportuniteRequest $request)
    {
        $id = $request->get("id");
        if (Str::of($id)->isEmpty()) {
            $opportunite = $this->opportunite->insertData($request);
        } else {
            $opportunite = $this->opportunite->updateData($request, $id);
        }
        return Response()->json($opportunite);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function edit($id)
    {
        $aData = Opportunite::findOrFail($id);
        return Response()->json($aData);
    }

    /**
     * @param $id
     * @return bool
     */
    public function destroy($id)
    {
        $opportunite = $this->opportunite->deleteData($id);
        return $opportunite;

    }

    /**
     * @OA\Get(
     *      path="/api/v1/get-opportunite/{categorie}",
     *      operationId="getAllOpportunite",
     *      tags={"Opportunites"},

     *      summary="Prendre la liste des opportunites",
     *      description="Retourner la liste des opportunites",
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
    public function getList($categId) {
        $mReturn = Opportunite::getListOpportunite($categId);
        $category = Categorie::getCategorie($categId);
        if ($category) {
            $mReturn['titre'] = $category[Categorie::$colTitle] ?? 'Aucun titre';
        }

        return is_string($mReturn) ? responseError($mReturn) : responseSuccess($mReturn);
    }

    /**
     * @param $slug
     * @return JsonResponse
     */
    public function getInfo($slug)
    {
        $mReturn = Opportunite::getInfo($slug);
        return is_string($mReturn) ? responseError($mReturn) : responseSuccess($mReturn);
    }
}
