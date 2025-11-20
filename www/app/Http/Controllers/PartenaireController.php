<?php

namespace App\Http\Controllers;

use App\Models\Partenaire;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class PartenaireController extends Controller
{
    private $partenaire;

    public function __construct()
    {
        $this->partenaire = new Partenaire();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $thead = ["ID", "Nom", "Action"];
        return view("partenaire", compact('thead'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getAll()
    {
        return datatables()->of(Partenaire::select('*'))
            ->addColumn('action', function($row){
                $sRouteEdit = 'partenaire.edit';
                $sRouteDelete = 'partenaire.destroy';
                return datatableAction($row, $sRouteEdit, $sRouteDelete, "partenaire");
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
            $rapport = $this->partenaire->insertData($request);
        } else {
            $rapport = $this->partenaire->updateData($id, $request);
        }
        return Response()->json($rapport);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function edit($id)
    {
        $aData = Partenaire::getPartenaire($id);
        return Response()->json($aData);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $partenaire = $this->partenaire->deleteData($id);
        return $partenaire>0 ? deleteSucces() : deleteError();
    }

    /**
     * @OA\Get(
     *      path="/api/partenaire",
     *      operationId="getAllPartenaire",
     *      tags={"Partenaires"},

     *      summary="Prendre la liste des partenaires",
     *      description="Retourner la liste des partenaires",
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
        $mReturn = $this->partenaire->getListPartenaire();
        return is_string($mReturn) ? responseError($mReturn) : responseSuccess($mReturn);
    }
}
