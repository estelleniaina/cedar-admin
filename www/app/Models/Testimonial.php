<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class Testimonial extends Model
{
    use HasFactory;

    protected $table = 'testimonials';

    protected $fillable = array('nom', 'fonction', 'temoignage');

    protected static $colNom = 'nom';
    protected static $colFonction = 'fonction';
    protected static $colTemoignage = 'temoignage';
    protected static $testimonialTitre = 'titre';

    public static $iLimitHome = 2;

    /**
     * @param int $id
     * @return mixed
     */
    public static function getTestimonial(int $id)
    {
        $aCol = array("id", self::$colNom, self::$colFonction, self::$colTemoignage);
        $aWhere = array('id' => $id);
        $query = Testimonial::select($aCol);
        $query->where($aWhere);
        return $query->first();
    }

    /**
     * @param array $aData
     * @return mixed
     */
    public static function insertData(array $aData)
    {
        $aColumn = self::columnData();
        $aData   = Arr::only($aData, $aColumn);
        $user = Testimonial::create($aData);
        return $user->save();
    }

    /**
     * @return array
     */
    public static function columnData()
    {
        return array(self::$colNom, self::$colFonction, self::$colTemoignage);
    }

    /**
     * @param array $aData
     * @param int   $iID
     * @return mixed
     */
    public static function updateData(array $aData, int $iID)
    {
        $aColumn = self::columnData();
        $aData   = Arr::only($aData, $aColumn);
        $mReturn = Testimonial::where('id', $iID)
            ->update($aData);
        return true;
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function deleteData(int $id)
    {
        $testimonial = Testimonial::where('id', $id)->delete();
        return Response()->json($testimonial);
    }

    /**
     * @param bool $bLimit
     * @return mixed
     */
    public static function getAllTestimonial($bLimit = false)
    {
        $aCol = [
            DB::raw("CONCAT('". self::$colNom ."','-','". self::$colFonction ."')  AS " . self::$testimonialTitre),
            self::$colTemoignage
        ];
        $query = Testimonial::select($aCol);
        if ($bLimit) {
            $query->limit(self::$iLimitHome);
        }
        return $query->get();
    }
}
