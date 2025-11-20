<?php

namespace App\Models;

use App\Traits\GetPrevNextElementTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Rubrique extends Model
{
    use HasFactory, GetPrevNextElementTrait;

    protected $table = 'rubrique';
    protected $fillable = array('centre_id', "type", "titre", "image", "fichier", "lien", "resume", "description", 'slug', 'created_by');

    private static $colID      = "id";
    public static $colCentreId = "centre_id";
    public static $centre = "centre";
    public static $colLink     = "lien";
    private static $colFile    = "fichier";

    private $colFichier    = "fichier";
    private $colImage    = "image";
    private static $storage    = "lecons";

    public function centre(){
        return $this->belongsTo(Centre::class, 'centre_id', 'id');
    }

    /**
     * @return mixed
     */
    public function getDataDataTable($type = null)
    {
        $query = self::latest('rubrique.id');
        $query->select([
            "type", "image", "resume", "description", "titre", "lien",
            "rubrique." . self::$colID,
            self::$colFile,
            self::$colCentreId,
            'c.' . Centre::$colNom . ' AS ' . self::$centre
        ]);

        if (!is_null($type)) {
            $query->where('type', '=', $type);
        }
        $query->leftJoin('centres AS c', 'c.' . Centre::$colID, 'rubrique.' . self::$colCentreId);
        $aData = $query->get();

        return $aData;
    }

    public function getCentre($centreId, $type = null)
    {
        $aCol = [
            "titre",
            "resume",
            "fichier",
            "lien",
            "slug",
            "type",
            "description",
        ];
        $query = self::select($aCol);
        $query->addSelect(DB::raw( "CONCAT('" . Storage::url($type . '/image/'). "', image) AS image"));
        if (!empty($type)) {
            $query->where('type', '=', $type);
        }

        return $query->where('centre_id', '=', $centreId)
            ->paginate();
    }

    public function getRubrique($type)
    {
        $aCol = ["id", "titre", "resume", "fichier", "lien", "description", "slug", "type"];
        return self::select($aCol)
            ->addSelect(DB::raw( "CONCAT('" . Storage::url($type . '/image/'). "', image) AS image"))
            ->where('type', '=', $type)
            ->latest()
            ->paginate(12);
    }

    public function getInfo($slug)
    {
        $aCol = ["id", "type", "titre", "resume", "lien", "description", "image", "fichier", "created_at"];
        $info = self::select($aCol)
            ->where('slug', '=', $slug)
            ->first();

        if (!empty($info)) {
            $currentId = $info["id"];
            $type = $info['type'];

            if (!empty($info['image'])) {
                $info['image'] = Storage::url($type . '/image/') . $info['image'];
            }
            if (!empty($info['fichier'])) {
                $info['fichier'] = Storage::url($type . '/fichier/') . $info['fichier'];
            }
            
            $info['date_creation'] = (new \DateTime($info['created_at'] ?? ''))->format('d/m/Y H:i');
            unset($info['created_at']);
            $data['infos'] = $info;
            unset($info['id']);

            $query = self::baseQuery($type);
            $data['prev'] = self::getPrev($query, $currentId);
            $query = self::baseQuery($type);
            $data['next'] = self::getNext($query, $currentId);
        }
        return $data;
    }

    /**
     * @return mixed
     */
    private function baseQuery($type)
    {
        $aCol = ['slug', 'titre'];
        $query = self::select($aCol);
        return $query->where('type', '=', $type);
    }

    public function getActualites($centreId = null)
    {
        $cols = ['titre', 'type', 'centre_id', 'resume', 'slug', 'image'];
        $query = Rubrique::select($cols)
            ->with('centre:id,nom');
        if (!empty($centreId)) {
            $query->where('centre_id', '=', $centreId);
        }
//            ->with(['centre' => function($query) {
//              $query->select('id', 'nom');
//            }])
            $data = $query->paginate(12)->toArray();

        foreach ($data['data'] as &$temp) {

            if (!empty($temp['image'])) {
                $type = $temp['type'];
                $temp['image'] = Storage::url($type . '/image/') . $temp['image'];
            }

        }
        return $data;
    }

    public function getLatest()
    {
        $cols = ['titre', 'type', 'centre_id', 'resume', 'slug', 'image'];
        $query = Rubrique::select($cols)
            ->with('centre:id,nom');
        $data = $query->limit(4)->latest()->get()->toArray();

        foreach ($data as &$temp) {

            if (!empty($temp['image'])) {
                $type = $temp['type'];
                $temp['image'] = Storage::url($type . '/image/') . $temp['image'];
            }

        }
        return $data;
    }

}
