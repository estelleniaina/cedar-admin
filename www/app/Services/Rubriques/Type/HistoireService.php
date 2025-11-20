<?php

namespace App\Services\Rubriques\Type;

use App\Contracts\RubriqueData;
use App\Enums\RubriqueType;


class HistoireService extends RubriqueData
{
    public function getData()
    {
        $this->setType(RubriqueType::HISTOIRE);
        $this->setEditUrl("histoire.edit");
        $this->setDeleteUrl("histoire.destroy");
        $this->setTitle("histoire");
        return $this->build();
    }
}
