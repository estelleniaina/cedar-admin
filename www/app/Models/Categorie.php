<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Categorie extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = array('titre', "slug");

    private static $colID   = "id";
    public static $colTitle = "titre";
    public static $colSlug = "slug";

    /**
     * Categorie constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public static function getCategorie(int $id)
    {
        $aCol = [self::$colTitle, self::$colSlug];
        $query = Categorie::select("*");

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
        $aData = $request->only([self::$colTitle]);
        $aData[self::$colSlug] = Str::slug($aData[self::$colTitle], '-').'-'.time();
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
        $aData = $request->only([self::$colTitle]);

        return self::where('id', $iId)->update($aData);
    }

    public function getSelectCategorie()
    {
        return self::query()->pluck('titre', 'id');
    }
}
