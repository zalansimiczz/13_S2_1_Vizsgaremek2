<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartnerReportController extends Controller
{
    public function index()
    {
        $cegId = (int) session('ceg_id');
        abort_if($cegId <= 0, 403);

        $trucks = DB::table('jarmuvek')
            ->where('ceg_id', $cegId)
            ->orderBy('rendszam')
            ->get();

        $drivers = DB::table('soforok')
            ->where('ceg_id', $cegId)
            ->orderBy('nev')
            ->get();

        return view('partner.reports', [
            'trucks' => $trucks,
            'drivers' => $drivers,
            'result' => null,
        ]);
    }

    public function generate(Request $request)
    {
        $cegId = (int) session('ceg_id');
        abort_if($cegId <= 0, 403);

        $data = $request->validate([
            'from' => ['required', 'date'],
            'to' => ['required', 'date', 'after_or_equal:from'],
            'jarmu_id' => ['nullable', 'integer', 'exists:jarmuvek,id'],
            'sofor_id' => ['nullable', 'integer', 'exists:soforok,id'],
        ]);

        //biztonsag
        if (!empty($data['jarmu_id'])) {
            $ok = DB::table('jarmuvek')->where('id', $data['jarmu_id'])->where('ceg_id', $cegId)->exists();
            abort_if(!$ok, 403);
        }
        if (!empty($data['sofor_id'])) {
            $ok = DB::table('soforok')->where('id', $data['sofor_id'])->where('ceg_id', $cegId)->exists();
            abort_if(!$ok, 403);
        }

        $result = [
            'filters' => [
                'from' => $data['from'],
                'to' => $data['to'],
                'jarmu_id' => $data['jarmu_id'] ?? null,
                'sofor_id' => $data['sofor_id'] ?? null,
            ],
            'by_truck' => collect(),
            'by_driver' => collect(),
            'totals' => [
                'km' => 0,
                'toll_cost' => 0,
                'work_minutes' => 0,
            ],
        ];

        $trucks = DB::table('jarmuvek')->where('ceg_id', $cegId)->orderBy('rendszam')->get();
        $drivers = DB::table('soforok')->where('ceg_id', $cegId)->orderBy('nev')->get();

        return view('partner.reports', [
            'trucks' => $trucks,
            'drivers' => $drivers,
            'result' => $result,
        ]);
    }
}
