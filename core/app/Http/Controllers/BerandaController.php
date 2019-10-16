<?php

namespace App\Http\Controllers;

use App\Models\Jalan;
use App\Models\Jembatan;
use App\Models\Penganggaran;
use Illuminate\Http\Request;

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
        $penganggaran = Penganggaran::latest()->get();

        return view('beranda', compact('jalan', 'jembatan', 'penganggaran'));
    }
}
