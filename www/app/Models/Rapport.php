<?php

namespace App\Models;

use App\Services\FileUploadService;
use App\Traits\GetPrevNextElementTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Rapport extends Model
{
    use HasFactory, GetPrevNextElementTrait;
    protected $table = 'rapports';
    protected $fillable = array('titre', "description", "fichier", "slug");

    private static $colID     = "id";
    public static $colTitre   = "titre";
    public static $colDesc    = "description";
    public static $colFichier = "fichier";
    private static $storage   = "rapports";

    private $fileUpload;

    /**
     * rapport constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fileUpload = new FileUploadService();
    }

    /**
     * @param bool $bAll
     * @return mixed
     */
    public static function getListRapport()
    {
        $aCol = [self::$colTitre, self::$colDesc, 'slug'];
        $query = self::select($aCol);
        $query->addSelect(DB::raw( "IF(LENGTH(".  self::$colFichier .") = 0, '', CONCAT('" . Storage::url(self::$storage . '/'). "', ". self::$colFichier .")) AS ". self::$colFichier));
        $aData = $query->paginate(Config('constant.SELECT_NBR_LIMIT'))->toArray();
        return Arr::only($aData, getKeyForPagination());
    }

    /**
     * @param $request
     * @return mixed
     */
    public function insertData($request)
    {
        $aData = $request->only([self::$colTitre, self::$colDesc]);
        if ($request->has(self::$colFichier)) {
            $filename = $this->fileUpload->uploadFile($request, self::$storage, self::$colFichier);

            if ($filename) {
                $aData[self::$colFichier] = $filename;
            }
        }

        $aData['slug'] = Str::slug($aData[self::$colTitre], '-').'-'.time();
        $create = self::create($aData);
        return $create->save();
    }

    /**
     * @param     $aData
     * @param int $iID
     * @return bool
     */
    public function updateData($request, int $iID)
    {
        $aData = $request->only([self::$colTitre, self::$colDesc]);
        if ($request->has(self::$colFichier)) {
            $filename = $this->fileUpload->uploadFile($request, self::$storage, self::$colFichier, $iID, 'BaseConnaissance');

            if ($filename) {
                $aData[self::$colFichier] = $filename;
            }
        }

        $update = self::where('id', $iID)->update($aData);
        return $update;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteData(int $id)
    {
        $this->fileUpload->deleteRelatedFile($id, self::$colFichier,self::$storage, 'BaseConnaissance');
        self::destroy($id);
        return true;
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function getInfo($slug)
    {
        $aCol = ["id", "titre", "description", "fichier"];
        $info = self::select($aCol)
            ->addSelect(DB::raw( "IF(LENGTH(".  self::$colFichier .") = 0, '',  CONCAT('" . Storage::url(self::$storage . '/'). "', ". self::$colFichier .")) AS ". self::$colFichier))
            ->where('slug', '=', $slug)
            ->first();

        if (!empty($info)) {
            $currentId = $info["id"];
            $data['infos'] = $info;

            $query = self::baseQuery();
            $data['prev'] = self::getPrev($query, $currentId);
            $query = self::baseQuery();
            $data['next'] = self::getNext($query, $currentId);
        }
        return $data;
    }

    /**
     * @return mixed
     */
    private function baseQuery()
    {
        $aCol = ['slug', 'titre'];
        return self::select($aCol);
    }
}
