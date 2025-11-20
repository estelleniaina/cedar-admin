@extends("layout/rubrique", [
    "type_rubrique" => App\Enums\RubriqueType::LECON,
    "get_url" =>  route('lecon.list'),
    "save_url" =>  route('lecon.store'),
    "title" => "leçon"
])
