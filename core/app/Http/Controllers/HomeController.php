<?php

namespace App\Http\Controllers;

use App\Models\Penganggaran;
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
        $posts = Penganggaran::whereBetween('created_at', [now()->startOfMonth(), now()])
            ->groupBy( 'date' )
            ->orderBy( 'date' )
            ->get( [
                DB::raw( 'MONTH(created_at) as date' ),
                DB::raw( 'COUNT( * ) as "count"' )
            ] )
            ->pluck('count', 'date');
            dd($posts);
        // $posts = $posts->union($hari);
        // $items =  $posts->all();
        // ksort($items);
        // $items = collect($items);
        // $coba = collect([]);
        // $coba = $coba->merge($items);

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
