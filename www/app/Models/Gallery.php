<?php

namespace App\Models;

use App\Services\FileUploadService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    use HasFactory;

    protected $table = 'galleries';

    protected $fillable = array('centre_id', 'photo');

    protected static $colID = 'id';
    public static $colCentreId  = 'centre_id';
    public static $centre  = 'centre';
    public static $colPhoto  = 'image';

    private static $storage = "gallery";
    protected $fileUpload;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fileUpload = new FileUploadService();
    }

    /**
     * @param $request
     * @return bool
     */
    public function uploadPhotos($request)
    {
        if ($request->has('image')) {
            $filename = $this->fileUpload->uploadMultipleFile($request, self::$storage, 'image');
            if ($filename) {
                $data = data_fill($filename, '*.centre_id', $request->get('centre_id'));
                $save = Gallery::upsert($data, ['image']);
                return $save;
            }
        }

        return false;
    }

    /**
     * @param array $ids
     * @return bool
     */
    public function deleteData(array $ids)
    {
        $this->fileUpload->deleteMultipleFile($ids, self::$colPhoto, self::$storage, 'Gallery');
        self::destroy($ids);
        return true;
    }

    /**
     * @param int $centreId
     * @return mixed
     */
    public static function getListGallery(int $centreId)
    {
        $query = Gallery::where(self::$colCentreId, '=', $centreId);
        $query->addSelect(DB::raw( "CONCAT('" . Storage::url(self::$storage . '/'). "', ". self::$colPhoto .") AS ". self::$colPhoto));

        $aData = $query->paginate(Config('constant.SELECT_NBR_LIMIT'))->toArray();
        return $aData;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getAllGallery($request)
    {
        $query = self::query();

        if (!empty($request->centre)) {
            $query->where('centre_id', '=', $request->centre);
        }

        return $query->paginate(20);
    }

    public function getRandomPhoto()
    {
        $query = Gallery::inRandomOrder();
        $query->selectRaw(DB::raw( "CONCAT('" . Storage::url(self::$storage . '/'). "', ". self::$colPhoto .") AS lien"));
        $aData = $query->limit(4)->pluck('lien');

        return $aData;
    }
}
