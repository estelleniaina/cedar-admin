<?php

namespace App\Models;

use App\Services\FileUploadService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Centre extends Model
{
    use HasFactory;
    protected $table = 'centres';
    protected $fillable = array('nom', "localisation", "surface", "objectif", "latitude", "longitude", "vision", "photo");

    public static $colID           = "id";
    public static $colNom          = "nom";
    public static $colLocal        = "localisation";
    private static $colSurface      = "surface";
    private static $colObjectif     = "objectif";
    private static $colVision       = "vision";
    private static $colLatitude     = "latitude";
    private static $colLongitude    = "longitude";
    private static $colPhoto        = "photo";

    private static $storage       = "centre";
    private $fileUpload;

    /**
     * Centre constructor.
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
    public static function getListCentre($bAll = true)
    {
        if ($bAll) {
            $aCol = self::columnData($bAll, true);
            $query = self::select($aCol);
            $query->addSelect(DB::raw( "CONCAT('" . Storage::url(self::$storage . '/'). "', ". self::$colPhoto .") AS lien"));
            $query->addSelect(DB::raw( "IF(LENGTH(".  self::$colPhoto .") = 0, '', CONCAT('" . self::$storage . "', '/', ". self::$colPhoto .")) AS lien_photo"));

            return $query->get();
        } else {
            return self::query()->pluck('nom', 'id');
        }
    }

    /**
     * @param bool $bGet
     * @param bool $bAll
     * @return array|string[]
     */
    private static function columnData($bAll = true, $bGet = false)
    {
        $aCol = [self::$colNom];
        if ($bAll) {
            $aCol = array_merge($aCol, array(
                self::$colLocal,
                self::$colSurface,
                self::$colObjectif,
                self::$colVision,
                self::$colLatitude,
                self::$colLongitude,
                self::$colPhoto,
            ));
        }


        if ($bGet || $bAll) {
            $aCol[] = self::$colID;
        }

        return $aCol;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public static function getCentre(int $id)
    {
        $aCol = self::columnData();
        $query = Centre::select($aCol);
        $query->addSelect(DB::raw( "CONCAT('" . Storage::url(self::$storage . '/'). "', ". self::$colPhoto .") AS lien"));
        $query->addSelect(DB::raw( "IF(LENGTH(".  self::$colPhoto .") = 0, '', CONCAT('" . self::$storage . "', '/', ". self::$colPhoto .")) AS lien_photo"));

        if (!is_null($id)) {
            $query->where(self::$colID, '=', $id);
        }
        return $query->first();
    }

    /**
     * @param $request
     * @return mixed
     */
    public function insertData($request)
    {
        $aData = $request->only([
            self::$colNom, self::$colLocal, self::$colSurface,
            self::$colObjectif, self::$colVision,
            self::$colLatitude, self::$colLongitude,
        ]);
        if ($request->has(self::$colPhoto)) {
            $filename = $this->fileUpload->uploadFile($request, self::$storage, self::$colPhoto);

            if ($filename) {
                $aData[self::$colPhoto] = $filename;
            }
        }

        $create = self::create($aData);
        return $create->save();
    }

    /**
     * @param $request
     * @param int $iId
     * @return mixed
     */
    public function updateData($request, int $iId)
    {
        $aData = $request->only([
            self::$colNom, self::$colLocal, self::$colSurface,
            self::$colObjectif, self::$colVision,
            self::$colLongitude, self::$colLatitude
        ]);
        if ($request->has(self::$colPhoto)) {
            $filename = $this->fileUpload->uploadFile($request, self::$storage, self::$colPhoto, $iId, 'Centre');

            if ($filename) {
                $aData[self::$colPhoto] = $filename;
            }
        }

        $update = self::where('id', $iId)->update($aData);
        return $update;
    }
}
