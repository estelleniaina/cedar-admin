<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class CategorieController extends Controller
{
    private $categorie;

    public function __construct()
    {
        $this->categorie = new Categorie();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $thead = ["Titre", "Action"];
        return view("categorie", compact('thead'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getAll()
    {
        return datatables()->of(Categorie::select('*'))
            ->addColumn('action', function($row){
                $sRouteEdit = 'categorie.edit';
                $sRouteDelete = 'categorie.destroy';
                return datatableAction($row, $sRouteEdit, $sRouteDelete, "categorie");
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

        if (Str::of($id)->isEmpty()) {
            $categorie = $this->categorie->insertData($request);
        } else {
            $categorie = $this->categorie->updateData($request, $id);
        }
        return $categorie>0 ? saveSucces() : saveError();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function edit($id)
    {
        $aData = Categorie::getCategorie($id);
        return Response()->json($aData);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $categorie = Categorie::destroy($id);
        return $categorie>0 ? deleteSucces() : deleteError();
    }

    /**
     * @OA\Get(
     *      path="/api/all-categorie",
     *      operationId="getAllCategory",
     *      tags={"Categories"},

     *      summary="Prendre la liste des catégories d'opportunités",
     *      description="Retourner la liste des catégories",
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
        $mReturn = Categorie::select(["id", Categorie::$colTitle, Categorie::$colSlug])->get();
        return is_string($mReturn) ? responseError($mReturn) : responseSuccess($mReturn);
    }
}
