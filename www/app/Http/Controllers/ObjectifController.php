<?php

namespace App\Http\Controllers;

use App\Models\Histoire;
use App\Models\Innovation;
use App\Models\Objectif;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ObjectifController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Objectif::select('id', 'cle', 'contenu'))
                ->addColumn('action', 'objectif.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        $thead = array(
            'ID',
            'Clé',
            'Valeur',
            'Action'
        );
        return view("objectif.index", compact('thead'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $id = $request->id;
        $data =   Objectif::updateOrCreate(['id' => $id], ['contenu' => $request->contenu]);
        return Response()->json($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $where = array('id' => $id);
        $data  = Objectif::where($where)->first();

        return Response()->json($data);
    }

    /**
     * @return JsonResponse
     */
    public function getList()
    {
        $mReturn = Objectif::select('cle', 'contenu')->pluck('contenu', 'cle');
        return is_string($mReturn) ? responseError($mReturn) : responseSuccess($mReturn);
    }

}
