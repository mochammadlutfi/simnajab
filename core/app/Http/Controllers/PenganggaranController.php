<?php

namespace App\Http\Controllers;

use App\Models\Jalan;
use App\Models\Jembatan;
use App\Models\Penganggaran;
use App\Models\Dokumen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Beton;
use App\Models\Drainase;
use App\Models\TPT;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use FarhanWazir\GoogleMaps\GMaps;
use App\Helpers\MapDrainase;
use App\Helpers\MapJembatan;
use App\Helpers\MapTPT;
use App\Helpers\MapBeton;
use App\Helpers\PenganggaranHelp;
use App\Helpers\GeneralHelp;
use Illuminate\Support\Facades\Storage;
class PenganggaranController extends Controller
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
    public function index(Request $request)
    {
        $jalan = Jalan::latest()->get();
        if ($request->ajax()) {
            $data = Penganggaran::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->setRowAttr([
                    'onClick' => function($row) {
                        return "detail(".$row->id.")";
                    },
                    'style' => 'cursor:pointer',
                ])
                ->addColumn('jalan', function($row){
                        return $row->jalan->nama;
                })
                ->addColumn('jenis', function($row){
                        return ucwords($row->jenis);
                })
                ->addColumn('tujuan', function($row){
                    return ucwords($row->tujuan);
                })
                ->addColumn('sumber', function($row){
                    return ucwords($row->sumber);
                })
                ->addColumn('tanggal', function($row){
                    return GeneralHelp::tgl_indo($row->tgl);
                })
                ->addColumn('anggaran', function($row){
                    return 'Rp.'. number_format($row->jml_anggaran,0,",",".");
                })
                ->rawColumns(['jenis', 'action', 'jabatan', 'tgl', 'sumber'])
                ->make(true);
        }
        return view('penganggaran.index', compact('jalan'));
    }

    public function data($jalan_id, Request $request)
    {
        if ($request->ajax()) {
            $data = Penganggaran::where('rute_id', $jalan_id)->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->setRowAttr([
                    'onClick' => function($row) {
                        return "detail_penganggaran(".$row->id.")";
                    },
                    'style' => 'cursor:pointer',
                ])
                ->addColumn('jenis', function($row){
                        return ucwords($row->jenis);
                })
                ->addColumn('tujuan', function($row){
                    return ucwords($row->tujuan);
                })
                ->addColumn('anggaran', function($row){
                    return 'Rp.'. number_format($row->jml_anggaran,0,",",".");
                })
                ->rawColumns(['img', 'action', 'jabatan', 'tgl'])
                ->make(true);
        }
        return view('penganggaran.index', compact('jalan'));
    }

    public function step1($jalan_id, Request $request)
    {
        if($request->isMethod('get'))
        {
            // if(empty($request->session()->get('penganggaran')))
            // {
                if($request->session()->has('penganggaran'))
                {
                    $request->session()->forget('penganggaran');
                }
                $jalan = Jalan::find($jalan_id);
                return view('penganggaran.tambah', compact('jalan'));
            // }else{
            //     return redirect()->route('penganggaran.step2', $jalan_id);
            // }
        }else{
            $rules = [
                'tujuan' => 'required',
                'jenis' => 'required',
                'perusahaan' => 'required',
                'nomor_bast' => 'required',
                'jml_anggaran' => 'required',
            ];

            $pesan = [
                'tujuan.required' => 'Tujuan Penganggaran Jalan Wajib Diisi!',
                'jenis.required' => 'Jenis Penganggaran Jalan Wajib Diisi!',
                'perusahaan.required' => 'Nama Perusahaan Wajib Diisi!',
                'nomor_bast.required' => 'No. BAST Jalan Wajib Diisi!',
                'jml_anggaran.required' => 'Jumlah Penganggaran Jalan Wajib Diisi!',
            ];

            $validator = Validator::make($request->all(), $rules, $pesan);
            if ($validator->fails()){
                return response()->json([
                    'fail' => true,
                    'errors' => $validator->errors()
                ]);
            }else{
                if($request->jenis == 'Jembatan')
                {
                    if($request->tujuan !== 'Pembangunan')
                    {
                        $jembatan =  Jembatan::where('jalan_id', $request->jalan_id)->latest()->get();
                        if($jembatan->count() == 0)
                        {
                            return response()->json([
                                'fail' => true,
                                'jembatan' => false,
                            ]);
                        }
                    }
                }

                if($request->jenis == 'TPT')
                {
                    if($request->tujuan !== 'Pembangunan')
                    {
                        $tpt =  TPT::where('jalan_id', $request->jalan_id)->latest()->get();
                        if($tpt->count() == 0)
                        {
                            return response()->json([
                                'fail' => true,
                                'tpt' => false,
                            ]);
                        }
                    }
                }

                if($request->jenis == 'Drainase')
                {
                    if($request->tujuan !== 'Pembangunan')
                    {
                        $drainase =  Drainase::where('jalan_id', $request->jalan_id)->latest()->get();
                        if($drainase->count() == 0)
                        {
                            return response()->json([
                                'fail' => true,
                                'drainase' => false,
                            ]);
                        }
                    }
                }
                $request->session()->put('penganggaran', $request->all());

                return response()->json([
                    'fail' => false,
                    'step2' => route('penganggaran.step2', $request->jalan_id)
                ]);
            }

        }
    }

    public function step2($jalan_id, Request $request)
    {
        if($request->isMethod('get'))
        {
            $jalan = Jalan::find($jalan_id);
            $step2 = $request->session()->get('penganggaran');
            // dd($step2);
            if($step2['jenis'] == 'Jalan')
            {
                $map = $this->pemeliharaan($jalan->jalan_id);
                return view('penganggaran.jalan.tambah', compact('jalan', 'map', 'step2'));
            }else if($step2['jenis'] == 'Jembatan')
            {
                if($step2['tujuan'] == 'Pembangunan')
                {
                    $map = MapJembatan::pembangunan($jalan->jalan_id);
                    return view('penganggaran.jembatan.pembangunan', compact('jalan', 'map', 'step2'));
                }else{
                    $jembatan = Jembatan::find($step2['penganggaran']);
                    $map = MapJembatan::penganggaran($jalan->jalan_id, $step2['penganggaran']);
                    return view('penganggaran.jembatan.penganggaran', compact('jalan', 'map', 'step2'));
                }

            }else if($step2['jenis'] == 'Drainase')
            {
                if($step2['tujuan'] == 'Pembangunan')
                {
                    $map = MapDrainase::pembangunan($jalan->jalan_id);
                    return view('penganggaran.drainase.pembangunan', compact('jalan', 'map', 'step2'));
                }else{
                    $drainase = Drainase::find($step2['penganggaran']);
                    $map = MapDrainase::pemeliharaan($jalan->jalan_id, $step2['penganggaran']);
                    return view('penganggaran.drainase.pemeliharaan', compact('jalan', 'map', 'step2', 'drainase'));
                }
            }else if($step2['jenis'] == 'TPT')
            {
                if($step2['tujuan'] == 'Pembangunan')
                {
                    $map = MapTPT::pembangunan($jalan->jalan_id);
                    return view('penganggaran.tpt.pembangunan', compact('jalan', 'map', 'step2'));
                }else{
                    $tpt = TPT::find($step2['penganggaran']);
                    $map = MapTPT::penganggaran($jalan->jalan_id, $step2['penganggaran']);
                    return view('penganggaran.tpt.penganggaran', compact('jalan', 'map', 'step2', 'tpt'));
                }
            }else if($step2['jenis'] == 'Beton')
            {
                if($step2['tujuan'] == 'Pembangunan')
                {
                    $map = MapBeton::pembangunan($jalan->jalan_id);
                    return view('penganggaran.beton.pembangunan', compact('jalan', 'map', 'step2'));
                }else{
                    $beton = TPT::find($step2['penganggaran']);
                    $map = MapBeton::penganggaran($jalan->jalan_id, $step2['penganggaran']);
                    return view('penganggaran.beton.penganggaran', compact('jalan', 'map', 'step2', 'beton'));
                }
            }
        }
    }

    public function detail($id)
    {
        $penganggaran = Penganggaran::find($id);
        $dokumen = Dokumen::where('penganggaran_id', $penganggaran->id)->OrderBy('created_at', 'DESC')->get();
        $jalan = Jalan::find($penganggaran->rute_id);
        $prev_berk = array();
        $berkas = array();
        foreach($dokumen as $d)
        {
            $berkas[] = array(
                'caption' => $d->nama,
                'key' => $d->id,
                'url' => route('penganggaran.hapus_file'),
            );
            $prev_berk[] = asset($d->path);
        }
        $berkas = json_encode($berkas);
        $prev_berk = json_encode($prev_berk);
        if($penganggaran->jenis == 'jalan')
        {
            $map = PenganggaranHelp::jalan($penganggaran->id);
            return view('penganggaran.jalan.detail', compact('jalan', 'map', 'penganggaran', 'dokumen', 'berkas', 'prev_berk'));

        }else if($penganggaran->jenis == 'drainase')
        {
            $map = PenganggaranHelp::drainase($penganggaran->id);
            return view('penganggaran.drainase.detail', compact('jalan', 'map', 'penganggaran', 'dokumen', 'dokumen', 'berkas', 'prev_berk'));

        }else if($penganggaran->jenis == 'jembatan')
        {
            $map = PenganggaranHelp::jembatan($penganggaran->id);
            return view('penganggaran.jembatan.detail', compact('jalan', 'map', 'penganggaran', 'dokumen', 'dokumen', 'berkas', 'prev_berk'));

        }else if($penganggaran->jenis == 'tpt')
        {
            $map = PenganggaranHelp::tpt($penganggaran->id);
            return view('penganggaran.tpt.detail', compact('jalan', 'map', 'penganggaran', 'dokumen', 'dokumen', 'berkas', 'prev_berk'));

        }else if($penganggaran->jenis == 'beton')
        {
            $map = PenganggaranHelp::beton($penganggaran->id);
            return view('penganggaran.beton.detail', compact('jalan', 'map', 'penganggaran', 'dokumen', 'dokumen', 'berkas', 'prev_berk'));
        }
    }

    public function pemeliharaan($jalan_id)
    {
        $jalan = Jalan::find($jalan_id);
        $config['center'] = $jalan->lat_awal.', '.$jalan->lng_awal;
        $config['zoom'] = '13';
        $config['map_height'] = '630px';
        $config['map_type'] = 'ROADMAP';
        $config['map_types_available'] = array('ROADMAP');
        $config['places'] = TRUE;
        $config['styles'] = array(
        array("name"=>"Tanpa Label", "definition"=>array(
            array("featureType"=>"poi.business", "elementType"=>"labels", "stylers"=>array(array("visibility"=>"off")))
        ))
        );
        $config['stylesAsMapTypes'] = true;
        $config['stylesAsMapTypesDefault'] = "Black Roads";

        $config['directions'] = TRUE;
        $config['directionsDraggable'] = TRUE;
        $config['directionsAvoidHighways'] = TRUE;
        $config['directionsChanged'] = 'longlat1.value = directionsDisplay.directions.routes[0].legs[0].start_location.lat() + \', \' + directionsDisplay.directions.routes[0].legs[0].start_location.lng();
        longlat2.value = directionsDisplay.directions.routes[0].legs[0].end_location.lat() + \', \' + directionsDisplay.directions.routes[0].legs[0].end_location.lng();
        lat_awal.value = directionsDisplay.directions.routes[0].legs[0].start_location.lat();
        long_awal.value = directionsDisplay.directions.routes[0].legs[0].start_location.lng();
        lat_akhir.value = directionsDisplay.directions.routes[0].legs[0].end_location.lat();
        long_akhir.value = directionsDisplay.directions.routes[0].legs[0].end_location.lng();
        computeTotalDistance(directionsDisplay.getDirections());
        start_patok =  new google.maps.LatLng(directionsDisplay.directions.routes[0].legs[0].start_location.lat(), directionsDisplay.directions.routes[0].legs[0].start_location.lng());
        end_patok =  new google.maps.LatLng(directionsDisplay.directions.routes[0].legs[0].end_location.lat(), directionsDisplay.directions.routes[0].legs[0].end_location.lng());
        patok_awal.value = hitung_jarak(start_jalan, start_patok);
        patok_akhir.value = hitung_jarak(start_jalan, end_patok);
        ';

        $gmap = new GMaps();
        $gmap->initialize($config);

        // Inisialisasi Jalan Awal
        $polyline = array();
        $c = str_replace('(', '', $jalan->polyline);
        $c = str_replace('),', '|', $c);
        $c = str_replace(')', '|', $c);
        $array = explode('|',$c);
        $polyline['points'] = array_filter($array);
        $polyline['strokeWeight'] = 5;
        $polyline['strokeColor'] = 'blue';
        $gmap->add_polyline($polyline);

        $marker = array();
        $marker['position'] = $array[0];
        $marker['draggable'] = true;
        $marker['ondragend'] = 'marker_0.setPosition(find_closest_point_on_path(event.latLng,polyline_0.getPath().getArray()));
        marker_1.setVisible(true);
        longlat1.value = event.latLng.lat() + \', \' + event.latLng.lng();
        patok_awal.value = hitung_jarak(start_jalan, event.latLng)';
        $marker['ondrag'] = 'marker_0.setPosition(find_closest_point_on_path(event.latLng,polyline_0.getPath().getArray()));';
        $marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|EA4335|FFFFFF';
        $marker['infowindow_content'] = 'Titik Awal TPT';
        $gmap->add_marker($marker);

        $marker = array();
        $marker['position'] = $jalan->lat_akhir.', '.$jalan->lng_akhir;
        $marker['draggable'] = true;
        $marker['visible'] = FALSE;
        $marker['ondragend'] = 'marker_1.setPosition(find_closest_point_on_path(event.latLng,polyline_0.getPath().getArray()));
        longlat2.value = event.latLng.lat() + \', \' + event.latLng.lng();
        tampilRute(longlat1.value, event.latLng, directionsService, directionsDisplay);';
        // $marker['ondrag'] = 'tampilRute(event.latLng.lat(), event.latLng.lng(), directionsService, directionsDisplay);';
        $marker['ondrag'] = 'marker_1.setPosition(find_closest_point_on_path(event.latLng,polyline_0.getPath().getArray()));';
        $marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=B|EA4335|FFFFFF';
        $marker['infowindow_content'] = 'Titik Akhir TPT';
        $gmap->add_marker($marker);

        return $gmap->create_map();
    }

    public function jembatan($jalan_id)
    {
        $jalan = Jalan::find($jalan_id);
        $jembatan = Jembatan::where('jalan_id', $jalan->jalan_id)->latest()->get();
        $config['center'] = $jalan->lat_awal.', '.$jalan->lng_awal;
        $config['zoom'] = '13';
        $config['map_height'] = '630px';
        $config['map_type'] = 'ROADMAP';
        $config['map_types_available'] = array('ROADMAP');
        $config['places'] = TRUE;
        $config['styles'] = array(
        array("name"=>"Tanpa Label", "definition"=>array(
            array("featureType"=>"poi.business", "elementType"=>"labels", "stylers"=>array(array("visibility"=>"off")))
        ))
        );
        $config['stylesAsMapTypes'] = true;
        $config['stylesAsMapTypesDefault'] = "Black Roads";

        $gmap = new GMaps();
        $gmap->initialize($config);

        // Inisialisasi Jalan Awal
        $polyline = array();
        $c = str_replace('(', '', $jalan->polyline);
        $c = str_replace('),', '|', $c);
        $c = str_replace(')', '|', $c);
        $array = explode('|',$c);
        $polyline['points'] = array_filter($array);
        $polyline['strokeWeight'] = 5;
        $polyline['strokeColor'] = 'blue';
        $gmap->add_polyline($polyline);

        if($jembatan->count() > 0)
        {
            $no_marker = 0;
            foreach($jembatan as $j)
            {
                $marker = array();
                $marker['position'] = $j->lat.', '.$j->lng;
                $marker['infowindow_content'] = ''. $j->nama.'';
                $marker['onclick'] = 'marker_'. $no_marker++ .'.setAnimation(google.maps.Animation.BOUNCE)';
                $marker['ondrag'] = 'marker_'. $no_marker++ .'.setPosition(find_closest_point_on_path(event.latLng,polyline_0.getPath().getArray()));';
                $marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=J|EA4335|FFFFFF';
                $gmap->add_marker($marker);
            }
        }

        return $gmap->create_map();
    }

    public function json($jalan_id, Request $request)
    {
        if($request->jenis == 'Drainase')
        {
            $data = Drainase::where('jalan_id', $jalan_id)->latest()->get();
            $output = '<option value="">Pilih Drainase</option>';
            foreach($data as $row)
            {
                $output .= '<option value="'.$row->drainase_id.'">Titik '. $row->patok_awal .' Meter - Titik'. $row->patok_akhir .' Meter </option>';
            }
            echo $output;
        }else if($request->jenis == 'TPT')
        {
            $data = TPT::where('jalan_id', $jalan_id)->latest()->get();
            $output = '<option value="">Pilih TPT</option>';
            foreach($data as $row)
            {
                $output .= '<option value="'.$row->tpt_id.'">Titik '. $row->patok_awal .' Meter - Titik '. $row->patok_akhir .' Meter </option>';
            }
            echo $output;
        }else if($request->jenis == 'Jembatan')
        {
            $data = Jembatan::where('jalan_id', $jalan_id)->latest()->get();
            $output = '<option value="">Pilih Jembatan</option>';
            foreach($data as $row)
            {
                $output .= '<option value="'.$row->jembatan_id.'">'. $row->nama .'</option>';
            }
            echo $output;
        }else if($request->jenis == 'Beton')
        {
            $data = Beton::where('jalan_id', $jalan_id)->latest()->get();
            $output = '<option value="">Pilih Flat Beton</option>';
            foreach($data as $row)
            {
                $output .= '<option value="'.$row->beton_id.'">Titik '. $row->patok_awal .' Meter - Titik '. $row->patok_akhir .' Meter </option>';
            }
            echo $output;
        }
    }

    public function edit($penganggaran_id)
    {
        $a = Penganggaran::find($penganggaran_id);
        $jalan = Jalan::find($a->rute_id);
        $dokumen = Dokumen::where('penganggaran_id',$penganggaran_id)->latest()->get();

        $prev_berk = array();
        $berkas = array();
        foreach($dokumen as $d)
        {
            $berkas[] = array(
                'caption' => $d->nama,
                'key' => $d->id,
                'url' => route('penganggaran.hapus_file'),
            );
            $prev_berk[] = asset($d->path);
        }
        $berkas = json_encode($berkas);
        $prev_berk = json_encode($prev_berk);

        // dd(json_encode($berkas));

        return view('penganggaran.edit', compact('a', 'jalan', 'berkas', 'prev_berk'));
    }

    public function update(Request $request)
    {
        $rules = [
            'perusahaan' => 'required',
            'nomor_bast' => 'required',
            'jml_anggaran' => 'required',
        ];

        $pesan = [
            'perusahaan.required' => 'Nama Perusahaan Wajib Diisi!',
            'nomor_bast.required' => 'No. BAST Jalan Wajib Diisi!',
            'jml_anggaran.required' => 'Jumlah Penganggaran Jalan Wajib Diisi!',
        ];

        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            return response()->json([
                'fail' => true,
                'errors' => $validator->errors()
            ]);
        }else{

            $data = Penganggaran::find($request->penganggaran_id);
            $data->tgl = date('Y-m-d', strtotime($request->tgl));
            $data->perusahaan = $request->perusahaan;
            $data->nomor_bast = $request->nomor_bast;
            $data->sumber = $request->sumber;
            $data->jml_anggaran = $request->jml_anggaran;
            $data->keterangan = $request->keterangan;
            if($data->save())
            {
                return response()->json([
                    'fail' => false,
                    'url' => route('penganggaran.detail', $data->id)
                ]);
            }
        }
    }

    public function file_upload(Request $request)
    {
        // dd($request->all());
        if($request->hasfile('files'))
        {
            foreach($request->file('files') as $f)
            {
                $name= $f->getClientOriginalName();
                $f->move(public_path().'/uploads/dokumen/'.$request->penganggaran_id.'', $name);
                $file = array(
                    'penganggaran_id' => $request->penganggaran_id,
                    'nama' => $name,
                    'path' => '/uploads/dokumen/'.$request->penganggaran_id.'/'.$name,
                );
                Dokumen::insert($file);
            }
            return response()->json([
                'nothing' => true,
            ]);
        }
    }

    public function hapus_file(Request $request)
    {
        // dd($request->all());
        $dokumen = Dokumen::find($request->key);
        $file = public_path().$dokumen->path;
        if (is_file($file)){
            $hapus_file = unlink($file);
            if($hapus_file)
            {
                $hapus_db = Dokumen::destroy($dokumen->id);
                if($hapus_db)
                {
                    return response()->json([
                        'nothing' => true,
                    ]);
                }
            }
        }
    }

}
