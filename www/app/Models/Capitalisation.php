<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Capitalisation extends Model
{
    use HasFactory;
    protected $table = 'capitalisations';
    protected $fillable = array("fichier");

    private static $colID     = "id";
    public static $colFichier = "fichier";
    private static $storage   = "capitalisations";

    /**
     * capitalisation constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * @param bool $bAll
     * @return mixed
     */
    public static function getListCapitalisation()
    {
        $aCol = self::columnData(true, true);
        $query = Capitalisation::select($aCol);
        $query->addSelect(DB::raw( "CONCAT('" . Storage::url(self::$storage . '/'). "', ". self::$colFichier .") AS lien"));
        $aData = $query->paginate(Config('constant.SELECT_NBR_LIMIT'))->toArray();
        return Arr::only($aData, getKeyForPagination());
    }

    /**
     * @param bool $bGet
     * @param bool $bAll
     * @return array|string[]
     */
    private static function columnData($bGet = false, $bAll = false)
    {
        $aCol = [self::$colFichier];
        if ($bGet || $bAll) {
            $aCol[] = self::$colID;
        }

        return $aCol;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public static function getCapitalisation(int $id)
    {
        $aCol = self::columnData(true);
        $aWhere = array('id' => $id);
        $query = Capitalisation::select($aCol);
        $query->where($aWhere);
        $aData = $query->first();

        return $aData;
    }

    /**
     * @param $aData
     * @return mixed
     */
    public static function insertData($aData)
    {
        $aColumn = self::columnData();

        $filename = time() . '-' . $aData->file(self::$colFichier)->getClientOriginalName();
        if (!$aData->file(self::$colFichier)->storeAs(self::$storage, $filename)) {
            return "Erreur lors de la sauvegarde du fichier";
        }
        $aData = $aData->toArray();
        $aData = Arr::except($aData, self::$colFichier);
        $aData[self::$colFichier] = $filename;

        $aData  = Arr::only($aData, $aColumn);
        $create = Capitalisation::create($aData);
        return $create->save();
    }

    /**
     * @param     $aData
     * @param int $iID
     * @return bool
     */
    public static function updateData($aData, int $iID)
    {
        $aColumn = self::columnData();
        $filename = false;
        if (!empty($aData->file(self::$colFichier))) {
            // Delete file
            self::deleteRelatedFile($iID);

            // Upload new file
            $filename = time() . '-' . $aData->file(self::$colFichier)->getClientOriginalName();
            if (!$aData->file(self::$colFichier)->storeAs(self::$storage, $filename)) {
                return "Erreur lors de la sauvegarde du fichier";
            }
        }

        $aData = $aData->toArray();
        if ($filename) {
            $aData = Arr::except($aData, self::$colFichier);
            $aData[self::$colFichier] = $filename;
        }

        $aData = Arr::only($aData, $aColumn);
        Capitalisation::where('id', $iID)
            ->update($aData);
        return true;
    }

    /**
     * @param int $iID
     */
    private static function deleteRelatedFile(int $iID)
    {
        $sFile = Capitalisation::query()->where(self::$colID, '=', $iID)->first();
        Storage::delete(self::$storage ."/".$sFile[self::$colFichier]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function deleteData(int $id)
    {
        // Delete related file
        self::deleteRelatedFile($id);
        $capitalisation = Capitalisation::where('id', $id)->delete();
        return Response()->json($capitalisation);
    }
}
