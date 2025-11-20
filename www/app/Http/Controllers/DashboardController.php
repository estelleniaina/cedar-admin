<?php

namespace App\Http\Controllers;

use App\Enums\RubriqueType;
use App\Models\BaseConnaissance;
use App\Models\Centre;
use App\Models\Gallery;
use App\Models\Rapport;
use App\Models\Rubrique;

class DashboardController extends Controller
{
    public function index()
    {
        // Centre
        $cards[] = [
            'color' => 'bg-info',
            'icon'  => 'far fa-map',
            'total' => Centre::count(),
            'title' => 'Centre',
            'link'  => 'centre.index',
        ];

        // Lecon
        $cards[] = [
            'color' => 'bg-success',
            'icon'  => 'fas fa-book',
            'total' => Rubrique::where('type', RubriqueType::LECON)->count(),
            'title' => 'Lecons',
            'link'  => 'lecon.index',
        ];

        // Histoire
        $cards[] = [
            'color' => 'bg-danger',
            'icon'  => 'fas fa-book-open',
            'total' => Rubrique::where('type', RubriqueType::HISTOIRE)->count(),
            'title' => 'Histoire',
            'link'  => 'histoire.index',
        ];


        // Innovation
        $cards[] = [
            'color' => 'bg-warning',
            'icon'  => 'fas fa-check-square',
            'total' => Rubrique::where('type', RubriqueType::INNOVATION)->count(),
            'title' => 'Innovation',
            'link'  => 'innovation.index',
        ];

        // Photos
        $cards[] = [
            'color' => 'bg-success',
            'icon'  => 'fas fa-image',
            'total' => Gallery::count(),
            'title' => 'Photos',
            'link'  => 'gallery.index',
        ];

        // Rapport
        $cards[] = [
            'color' => 'bg-warning',
            'icon'  => 'fas fa-newspaper',
            'total' => Rapport::count(),
            'title' => 'Rapports',
            'link'  => 'rapport.index',
        ];

        // Base de connaissance
        $cards[] = [
            'color' => 'bg-danger',
            'icon'  => 'fas fa-folder-open',
            'total' => BaseConnaissance::count(),
            'title' => 'Base de connaissances',
            'link'  => 'connaissance.index',
        ];
        return view('dashboard', compact('cards'));
    }
}
