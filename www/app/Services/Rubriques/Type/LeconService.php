<?php

namespace App\Services\Rubriques\Type;

use App\Contracts\RubriqueData;
use App\Enums\RubriqueType;


class LeconService extends RubriqueData
{
    public function getData()
    {
        $this->setType(RubriqueType::LECON);
        $this->setEditUrl("lecon.edit");
        $this->setDeleteUrl("lecon.destroy");
        $this->setTitle("lecon");
        return $this->build();
    }
}
