<?php

namespace App\Http\Controllers;

use App\Models\Jalan;
use App\Models\Jembatan;
use App\Models\Penganggaran;
use Illuminate\Http\Request;
use App\Charts\ChartPenganggaran;

class BerandaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $jalan = Jalan::latest()->get();
        $jembatan = Jembatan::latest()->get();
        $penganggaran = Penganggaran::whereYear('tgl', date('Y'))->latest()->get();


        $chart = new ChartPenganggaran;
        $chart->labels(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'])
        ->displayAxes('yAxes');
        // $chart->dataset('Permohonan', 'line')
        // ->backgroundColor('rgba(66,165,245,.25)')
        // ->color('rgba(66,165,245,1)')
        // ->fill(TRUE);


        return view('beranda', compact('jalan', 'jembatan', 'penganggaran'));
    }
}
