<?php

namespace App\Models;

use App\Services\FileUploadService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Partenaire extends Model
{
    use HasFactory;

    protected $table = 'partenaires';

    protected $fillable = array('nom', 'logo');

    protected static $colID = 'id';
    public static $colNom   = 'nom';
    public static $colLogo  = 'logo';

    private static $storage = "partenaires";
    private $fileUpload;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fileUpload = new FileUploadService();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public static function getPartenaire(int $id)
    {
        $aCol = self::columnData(true);
        $query = Partenaire::select($aCol);
        $query->addSelect(DB::raw( "CONCAT('" . Storage::url(self::$storage . '/'). "', ". self::$colLogo .") AS lien"));
        $query->addSelect(DB::raw( "IF(LENGTH(".  self::$colLogo .") = 0, '', CONCAT('" . self::$storage . "', '/', ". self::$colLogo .")) AS lien_photo"));

        if (!is_null($id)) {
            $query->where(self::$colID, '=', $id);
        }
        $aData = $query->first();

        return  $aData;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function insertData($request)
    {
        $aData = $request->only(['nom']);
        if ($request->has('logo')) {
            $filename = $this->fileUpload->uploadFile($request, self::$storage, 'logo');

            if ($filename) {
                $aData['logo'] = $filename;
            }
        }

        $create = self::create($aData);
        return $create->save();
    }

    /**
     * @param bool $bGet
     * @return array
     */
    public static function columnData($bGet = false)
    {
        $aCols = array(self::$colNom, self::$colLogo);
        if ($bGet) {
            $aCols[] = "id";
        }

        return $aCols;
    }

    /**
     * @param int $iId
     * @param     $request
     * @return mixed
     */
    public function updateData(int $iId, $request)
    {
        $aData = $request->only(['nom']);
        if ($request->has(self::$colLogo)) {
            $filename = $this->fileUpload->uploadFile($request, self::$storage, self::$colLogo, $iId, 'Partenaire');

            if ($filename) {
                $aData[self::$colLogo] = $filename;
            }
        }

        $update = self::where('id', $iId)->update($aData);
        return $update;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteData(int $id)
    {
        $this->fileUpload->deleteRelatedFile($id, self::$colLogo,self::$storage, 'Partenaire');
        self::destroy($id);
        return true;
    }

    /**
     * @return Partenaire[]|Collection
     */
    public static function getAllPartenaire()
    {
        $aCol = [self::$colNom];
        $query = Partenaire::select($aCol);
        $query->addSelect(DB::raw( "CONCAT('" . Storage::url(self::$storage . '/'). "', ". self::$colLogo .") AS ". self::$colLogo));
        return $query->get();
    }

    public static function getListPartenaire()
    {
        $aCol = [self::$colNom];
        $query = Partenaire::select($aCol);
        $query->addSelect(DB::raw( "CONCAT('" . Storage::url(self::$storage . '/'). "', ". self::$colLogo .") AS ". self::$colLogo));
        return $query->get();
    }
}
