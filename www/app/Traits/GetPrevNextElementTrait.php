<?php
namespace App\Traits;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait GetPrevNextElementTrait {

    /**
     * @param Builder $query
     * @param int $iId
     * @return Builder|Model|object|null
     */
    protected function getPrev(Builder $query, int $iId)
    {
        $query->where(self::$colID, '<', $iId);
        $query->orderBy('id','desc');

        $aData = $query->limit(1)->first();

        return $aData;

    }


    /**
     * @param $baseQuery
     * @param int $iId
     * @return mixed
     */
    protected function getNext($baseQuery, int $iId)
    {
        $query = $baseQuery;
        $query->where(self::$colID, '>', $iId);
        $aData = $query->limit(1)->first();

        return $aData;

    }
}
