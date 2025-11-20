<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function index()
    {
        $configuration = Configuration::first();
        $facebook = $configuration->facebook;
        $instagram = $configuration->instagram;
        return view("configuration", compact('facebook', 'instagram'));
    }

    public function save(Request $request): RedirectResponse
    {
        // Validate the form data
        $validated = $request->validate([
            'facebook' => 'url',
            'instagram' => 'url',
        ]);

        $configuration = Configuration::first();
        $configuration->facebook = $validated['facebook'];
        $configuration->instagram = $validated['instagram'];
        $configuration->save();
        return redirect()->route('configuration.index')->with('success', 'Configuration mis à jour avec succés');
    }

    public function getConfig(): JsonResponse
    {
        $return = Configuration::first()->select('facebook', 'instagram')->get();
        return $return && !$return->isEmpty() ? responseSuccess($return[0]) : responseError($return);
    }
}
