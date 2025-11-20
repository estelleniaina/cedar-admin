<?php


namespace App\Enums;


class PartenaireType
{
    public const FINANCEMENT = 'financement';
    public const DEVELOPPEMENT = 'developpement';
    public const GOUVERNEMENT = 'gouvernement';
    public const AUTRE_ORGANISME = 'autre_organisme';

    public static function getValuesWithLabels()
    {
        return [
            self::FINANCEMENT => 'Financement',
            self::DEVELOPPEMENT => 'Développement, Techniques agro-écologiques et environnementales',
            self::GOUVERNEMENT => 'Gouvernement',
            self::AUTRE_ORGANISME => 'Autres organismes'
        ];
    }
}
