<?php

namespace App\Http\Controllers;

use App\Http\Requests\RapportRequest;
use App\Models\Rapport;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class RapportController extends Controller
{
    private $rapport;

    public function __construct()
    {
        $this->rapport = new Rapport();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Rapport::select('*'))
                ->addColumn('action', 'rapport.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        $thead = array(
            'ID',
            'Titre',
            'Description',
            'Action'
        );
        return view("rapport.index", compact('thead'));
    }

    /**
     * @param RapportRequest $request
     * @return JsonResponse
     */
    public function store(RapportRequest $request)
    {
        $id = $request->get("id");
        if (Str::of($id)->isEmpty()) {
            $rapport = $this->rapport->insertData($request);
        } else {
            $rapport = $this->rapport->updateData($request, $id);
        }
        return Response()->json($rapport);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function edit($id)
    {
        $aData = Rapport::findOrFail($id);
        return Response()->json($aData);
    }

    /**
     * @param $id
     * @return bool
     */
    public function destroy($id)
    {
        $rapport = $this->rapport->deleteData($id);
        return $rapport;

    }

    /**
     * @OA\Get(
     *      path="/api/v1/rapport",
     *      operationId="getAllRapport",
     *      tags={"Rapports"},

     *      summary="Prendre la liste des rapports",
     *      description="Retourner la liste des rapports",
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
        $mReturn = Rapport::getListRapport();
        return is_string($mReturn) ? responseError($mReturn) : responseSuccess($mReturn);
    }

    /**
     * @param $slug
     * @return JsonResponse
     */
    public function getInfo($slug)
    {
        $mReturn = Rapport::getInfo($slug);
        return is_string($mReturn) ? responseError($mReturn) : responseSuccess($mReturn);
    }
}
