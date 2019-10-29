<?php

namespace App\Http\Controllers;

use App\Helpers\MapJembatan;
use App\Models\Jalan;
use App\Models\Jembatan;
use App\Models\Penganggaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AngJalan;
use App\Models\Drainase;
use App\Models\TPT;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use FarhanWazir\GoogleMaps\GMaps;
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
                ->addColumn('anggaran', function($row){
                    return 'Rp.'. number_format($row->jml_anggaran,0,",",".");
                })
                ->rawColumns(['jenis', 'action', 'jabatan', 'tgl'])
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
                if($step2['tujuan'] == 'Pemeliharaan')
                {
                    $map = $this->pemeliharaan($jalan->jalan_id);
                }else if($step2['tujuan'] == 'Peningkatan')
                {
                    $map = $this->pemeliharaan($jalan->jalan_id);
                }else{
                    $map = $this->pemeliharaan($jalan->jalan_id);
                }

                return view('penganggaran.step_2', compact('jalan', 'map', 'step2'));
            }else if($step2['jenis'] == 'Jembatan')
            {
                if($step2['tujuan'] == 'Pemeliharaan')
                {
                    $map = $this->jembatan($jalan->jalan_id);
                }else if($step2['tujuan'] == 'Peningkatan')
                {
                    $map = $this->jembatan($jalan->jalan_id);
                }else{
                    $map = MapJembatan::pembangunan($jalan->jalan_id);
                }
                return view('penganggaran.jembatan', compact('jalan', 'map', 'step2'));
            }else if($step2['jenis'] == 'Drainase')
            {
                if($step2['tujuan'] == 'Pemeliharaan')
                {
                    $map = $this->jembatan($jalan->jalan_id);
                }else if($step2['tujuan'] == 'Peningkatan')
                {
                    $map = $this->jembatan($jalan->jalan_id);
                }else{
                    $map = $this->drainase($jalan->jalan_id);
                }
                return view('penganggaran.drainase', compact('jalan', 'map', 'step2'));
            }else if($step2['jenis'] == 'TPT')
            {
                return view('penganggaran.tpt', compact('jalan', 'map', 'step2'));
            }
        }else{
            $rules = [
                'patok_awal' => 'required',
                'patok_akhir' => 'required',
            ];

            $pesan = [
                'patok_awal.required' => 'Patok Awal Wajib Diisi!',
                'patok_akhir.required' => 'Patok Akhir Wajib Diisi!',
            ];

            $validator = Validator::make($request->all(), $rules, $pesan);
            if ($validator->fails()){
                return response()->json([
                    'fail' => true,
                    'errors' => $validator->errors()
                ]);
            }else{
                // dd($request->all());
                $step1 = $request->session()->get('penganggaran');
                // dd($step1['jalan_id']);
                $data = new Penganggaran();
                $data->rute_id = $step1['jalan_id'];
                $data->jenis =  $step1['jenis'];
                $data->tujuan =  $step1['tujuan'];
                $data->perusahaan =  $step1['perusahaan'];
                $data->nomor_bast =  $step1['nomor_bast'];
                $data->tgl = date('Y-m-d', strtotime($step1['tgl']));
                // $data->jml_anggaran = $step1['jml_anggaran'];
                $data->jml_anggaran = 123123;
                if($data->save())
                {
                    if($step1['jenis'] = 'jalan')
                    {
                        $ang_jalan = new AngJalan();
                        $ang_jalan->jalan_id = $step1['jalan_id'];
                        $ang_jalan->penganggaran_id = $data->id;
                        $ang_jalan->panjang = 123;
                        $ang_jalan->patok_awal = $request->patok_awal;
                        $ang_jalan->patok_akhir = $request->patok_akhir;
                        $ang_jalan->lat_awal = $request->lat_awal;
                        $ang_jalan->lng_awal = $request->long_awal;
                        $ang_jalan->lat_akhir = $request->lat_akhir;
                        $ang_jalan->lng_akhir = $request->long_akhir;
                        $ang_jalan->polypath = $request->polypath;
                        if($ang_jalan->save())
                        {

                        }
                    }

                }
            }
        }
    }

    public function detail($id)
    {
        $penganggaran = Penganggaran::find($id);

        $jalan = Jalan::find($penganggaran->rute_id);
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

        if($penganggaran->tujuan == 'Pemeliharaan')
        {
            $warna = 'green';
        }elseif($penganggaran->tujuan == 'Peningkatan')
        {
            $warna = 'orange';
        }else{
            $warna = 'red';
        }

        $polyline = array();
        $c = str_replace('(', '', $penganggaran->AngJalan->polypath);
        $c = str_replace('),', '|', $c);
        $c = str_replace(')', '|', $c);
        $array = explode('|',$c);
        $polyline['points'] = array_filter($array);
        $polyline['strokeWeight'] = 4;
        $polyline['strokeColor'] = $warna;
        $gmap->add_polyline($polyline);

         $map = $gmap->create_map();
         return view('penganggaran.detail', compact('jalan', 'map', 'penganggaran'));
    }

    public function simpan(Request $request)
    {
        $rules = [
            'jalan_id' => 'required',
            'tujuan' => 'required',
            'jenis' => 'required',
            'perusahaan' => 'required',
            'nomor_bast' => 'required',
            'jml_anggaran' => 'required',
        ];

        $pesan = [
            'jalan_id.required' => 'Ruas Jalan Wajib Diisi!',
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

            $data = new Penganggaran();
            $data->jalan_id = $request->jalan_id;
            $data->tujuan = $request->tujuan;
            $data->perusahaan = $request->perusahaan;
            $data->nomor_bast = $request->nomor_bast;
            $data->tgl = date('Y-m-d', strtotime($request->tgl));
            $data->nomor_bast = $request->nomor_bast;
            $data->jml_anggaran = $request->jml_anggaran;
            if($data->save())
            {
                return response()->json([
                    'fail' => false,
                ]);
            }
        }
    }

    public function update(Request $request)
    {
        $rules = [
            'jalan_id' => 'required',
            'tujuan' => 'required',
            'perusahaan' => 'required',
            'nomor_bast' => 'required',
            'jml_anggaran' => 'required',
        ];

        $pesan = [
            'jalan_id.required' => 'Ruas Jalan Wajib Diisi!',
            'tujuan.required' => 'Tujuan Penganggaran Jalan Wajib Diisi!',
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

            $data = Penganggaran::find($request->pengaggaran_id);
            $data->jalan_id = $request->jalan_id;
            $data->tujuan = $request->tujuan;
            $data->perusahaan = $request->perusahaan;
            $data->nomor_bast = $request->nomor_bast;
            $data->tgl = date('Y-m-d', strtotime($request->tgl));
            $data->nomor_bast = $request->nomor_bast;
            $data->jml_anggaran = $request->jml_anggaran;
            if($data->save())
            {
                return response()->json([
                    'fail' => false,
                ]);
            }
        }
    }

    public function edit($id){

        $data = Penganggaran::find($id);
        if($data){

            $d = collect([
                'id' => $data->id,
                'jalan_id' => $data->jalan_id,
                'tujuan' => $data->tujuan,
                'perusahaan' => $data->perusahaan,
                'nomor_bast' => $data->nomor_bast,
                'tgl' => date('d-m-Y', strtotime($data->tgl)),
                'nomor_bast' => $data->nomor_bast,
            ]);

            return response()->json($d);
        }
    }

    public function hapus($id)
    {
        $data = Penganggaran::destroy($id);
        if($data){
            return response()->json([
                'fail' => false,
            ]);
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

    public function drainase($jalan_id)
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
        ';

        $gmap = new GMaps();
        $gmap->initialize($config);

        // // Buat Polyline Rute
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
        $marker['ondragend'] = 'marker_0.setPosition(find_closest_point_on_path(event.latLng,polyline_0.getPath().getArray())); marker_1.setVisible(true); longlat1.value = event.latLng.lat() + \', \' + event.latLng.lng();';
        $marker['ondrag'] = 'marker_0.setPosition(find_closest_point_on_path(event.latLng,polyline_0.getPath().getArray()));';
        $marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=S|EA4335|FFFFFF';
        $marker['infowindow_content'] = 'Titik Drainase TPT';
        $gmap->add_marker($marker);

        $marker = array();
        $marker['position'] = $jalan->lat_akhir.', '.$jalan->lng_akhir;
        $marker['draggable'] = true;
        $marker['visible'] = FALSE;
        $marker['ondragend'] = 'marker_1.setPosition(find_closest_point_on_path(event.latLng,polyline_0.getPath().getArray())); longlat2.value = event.latLng.lat() + \', \' + event.latLng.lng(); tampilRute(longlat1.value, event.latLng, directionsService, directionsDisplay);';
        // $marker['ondrag'] = 'tampilRute(event.latLng.lat(), event.latLng.lng(), directionsService, directionsDisplay);';
        $marker['ondrag'] = 'marker_1.setPosition(find_closest_point_on_path(event.latLng,polyline_0.getPath().getArray()));';
        $marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=E|EA4335|FFFFFF';
        $marker['infowindow_content'] = 'Titik Drainase TPT';
        $gmap->add_marker($marker);

        return $gmap->create_map();
    }

}
