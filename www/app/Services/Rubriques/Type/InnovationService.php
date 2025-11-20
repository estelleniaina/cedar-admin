<?php


namespace App\Services\Rubriques\Type;


use App\Contracts\RubriqueData;
use App\Enums\RubriqueType;

class InnovationService extends RubriqueData
{

    public function getData()
    {
        $this->setType(RubriqueType::INNOVATION);
        $this->setEditUrl("innovation.edit");
        $this->setDeleteUrl("innovation.destroy");
        $this->setTitle("innovation");
        return $this->build();
    }
}
