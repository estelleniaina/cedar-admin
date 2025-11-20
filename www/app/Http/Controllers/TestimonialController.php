<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class TestimonialController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view("testimonial.list");
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getAll()
    {
        return datatables()->of(Testimonial::select('*'))
            ->addColumn('action', function($row){
                $sRouteEdit = "edit.testimonial";
                $sRouteDelete = "delete.testimonial";
                return datatableAction($row, $sRouteEdit, $sRouteDelete, "testimonial");
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
            $testimonial = Testimonial::insertData($requestAll);
        } else {
            $testimonial = Testimonial::updateData($requestAll, $id);
        }
        return Response()->json($testimonial);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function edit($id)
    {
        $aData = Testimonial::getTestimonial($id);
        return Response()->json($aData);
    }

    /**
     * @param Request $request
     * @param         $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::updateData($request->all(), $id);
        return Response()->json($testimonial);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $testimonial = Testimonial::deleteData($id);
        return $testimonial;

    }

    /**
     * @return JsonResponse
     */
    public function getList()
    {
        $mReturn = Testimonial::getAllTestimonial(true);
        return is_string($mReturn) ? responseError($mReturn) : responseSuccess($mReturn);
    }

    /**
     * @return JsonResponse
     */
    public function getAllList()
    {
        $mReturn = Testimonial::getAllTestimonial();
        return is_string($mReturn) ? responseError($mReturn) : responseSuccess($mReturn);
    }

}
