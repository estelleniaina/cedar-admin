<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhotoRequest;
use App\Models\Centre;
use App\Models\Gallery;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use DataTables;

class GalleryController extends Controller
{
    private $gallery;

    /**
     * GalleryController constructor.
     */
    public function __construct()
    {
        $this->gallery = new Gallery();
    }

    /**
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $gallery = Gallery::getAllGallery($request);
        if ($request->ajax()) {
            return view('gallery.images', compact('gallery'));
        }

        $centres = Centre::getListCentre(false);
        return view("gallery.index", compact("centres", 'gallery'));
    }


    /**
     * @param PhotoRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PhotoRequest $request)
    {
        $gallery = $this->gallery->uploadPhotos($request);
        return redirect()->back()->with('success', 'Ajouter avec succés');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        $idImages = $request->get('image', []);
//        dd($idImages);
        $gallery = $this->gallery->deleteData($idImages);
        return $gallery>0 ? deleteSucces() : deleteError();

    }

    /**
     * @OA\Get(
     *      path="/api/centre/{centreId}/gallery",
     *      operationId="getCentreGalleries",
     *      tags={"Centres"},

     *      summary="Prendre les photos du centre",
     *     @OA\Parameter(
     *          name="centreId",
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
    public function getList($centreID) {
        $mReturn = Gallery::getListGallery($centreID);
        return is_string($mReturn) ? responseError($mReturn) : responseSuccess($mReturn);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRandomPhoto()
    {
        $mReturn = $this->gallery->getRandomPhoto();
        return is_string($mReturn) ? responseError($mReturn) : responseSuccess($mReturn);
    }
}
