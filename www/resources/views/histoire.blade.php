@extends("layout/rubrique", [
    "type_rubrique" => App\Enums\RubriqueType::HISTOIRE,
    "get_url" =>  route('histoire.list'),
    "save_url" =>  route('histoire.store'),
    "title" => "histoire"
])
