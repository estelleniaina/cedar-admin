@extends("layout/rubrique", [
    "type_rubrique" => App\Enums\RubriqueType::INNOVATION,
    "get_url" =>  route('innovation.list'),
    "save_url" =>  route('innovation.store'),
    "title" => "innovation"
])
