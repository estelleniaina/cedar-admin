<?php

namespace App\Http\Controllers;

use App\Http\Requests\RapportRequest;
use App\Models\BaseConnaissance;
use App\Models\Rubrique;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class BaseConnaissanceController extends Controller
{
    private $connaissance;

    public function __construct()
    {
        $this->connaissance = new BaseConnaissance();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(BaseConnaissance::select('*'))
                ->addColumn('action', 'connaissance.action')
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
        return view("connaissance.index", compact('thead'));
    }

    /**
     * @param RapportRequest $request
     * @return JsonResponse
     */
    public function store(RapportRequest $request)
    {
        $id = $request->get("id");
        if (Str::of($id)->isEmpty()) {
            $rapport = $this->connaissance->insertData($request);
        } else {
            $rapport = $this->connaissance->updateData($request, $id);
        }
        return Response()->json($rapport);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function edit($id)
    {
        $aData = BaseConnaissance::findOrFail($id);
        return Response()->json($aData);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $this->connaissance->deleteData($id);
        return Response()->json(['message'=>'Suppression effectué avec succés']);

    }

    /**
     * @OA\Get(
     *      path="/api/rapport",
     *      operationId="getAllConnaissance",
     *      tags={"Connaissance"},

     *      summary="Prendre la liste des rapports",
     *      description="Retourner la liste des base de connaissances",
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
    public function getApiList() {
        $mReturn = BaseConnaissance::getListConnaissance();

//        is_string($mReturn) ? dd($mReturn) : dd('no');
        // Prendre les videos et fichiers des centres
//        $mediaCentre = Rubrique::getConnaissance();
        return is_string($mReturn) ? responseError($mReturn) : responseSuccess($mReturn);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInfo($slug)
    {
        $mReturn = BaseConnaissance::getInfo($slug);
        return is_string($mReturn) ? responseError($mReturn) : responseSuccess($mReturn);
    }
}
