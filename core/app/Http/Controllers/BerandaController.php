<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Jalan;
use App\Models\Jembatan;
use App\Models\Penganggaran;
use Illuminate\Http\Request;
use App\Charts\ChartPenganggaran;
use Illuminate\Support\Facades\DB;
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

        // $posts = Penganggaran::whereBetween('created_at', [now()->startOfMonth(), now()])
        // ->groupBy( 'date' )
        // ->orderBy( 'date' )
        // ->get( [
        //     DB::raw( 'MONTH(created_at) as date' ),
        //     DB::raw( 'COUNT( * ) as "count"' )
        // ])
        // ->pluck('count', 'date');
        $users = Penganggaran::select('id', 'created_at')
        ->get()
        ->groupBy(function($date) {
            //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
            return Carbon::parse($date->created_at)->format('m'); // grouping by months
        });
        // dd($users);
        $usermcount = [];
        $userArr = collect([]);

        foreach ($users as $key => $value) {
            $usermcount[(int)$key] = count($value);
        }
        // dd($usermcount);
        $no = 0;
        for($i = 1; $i <= 12; $i++){
            if(!empty($usermcount[$i])){
                $userArr[$no++] = $usermcount[$i];
            }else{
                $userArr[$no++] = 0;
            }
        }
        // dd($userArr);
        $chart = new ChartPenganggaran;
        $chart->labels(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'])
        ->displayAxes('yAxes');
        $chart->dataset('Penganggaran', 'line', $userArr)
        ->backgroundColor('rgba(66,165,245,.25)')
        ->color('rgba(66,165,245,1)')
        ->fill(TRUE);


        return view('beranda', compact('jalan', 'jembatan', 'penganggaran', 'chart'));
    }
}
