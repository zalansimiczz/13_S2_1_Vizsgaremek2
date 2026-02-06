<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PartnerSettingsController extends Controller
{
    public function updateProfile(Request $request) {
        // TODO validate + mentés
        return back()->with('success', 'Profil mentve.');
    }

    public function updateCompany(Request $request) {
        // TODO validate + mentés
        return back()->with('success', 'Cégadatok mentve.');
    }

    public function storeApiKey(Request $request) {
        // TODO create key
        return back()->with('success', 'API kulcs létrehozva.');
    }

    public function regenApiKey($id) {
        // TODO regenerate
        return back()->with('success', 'API kulcs újragenerálva.');
    }

    public function destroyApiKey($id) {
        // TODO delete
        return back()->with('success', 'API kulcs törölve.');
    }
}
