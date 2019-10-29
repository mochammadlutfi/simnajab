<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Charts\ChartPenganggaran;
class HomeController extends Controller
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


        $chart = new ChartPermohonan;
        $chart->labels(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'])
        ->displayAxes('yAxes');
        // $chart->dataset('Permohonan', 'line')
        // ->backgroundColor('rgba(66,165,245,.25)')
        // ->color('rgba(66,165,245,1)')
        // ->fill(TRUE);

        return view('home', compact('chart', 'jalan', 'jembatan', 'anggaran'));
    }
}
