<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelp;
use App\Models\Penganggaran;
use App\Models\AngJalan;
use App\Models\TPT;
use App\Models\Jalan;
use App\Models\Jembatan;
use App\Models\Drainase;
use App\Models\Dokumen;
use App\Models\Beton;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use FarhanWazir\GoogleMaps\GMaps;
class JalanController extends Controller
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
        if ($request->ajax()) {
            $data = Jalan::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('panjang', function($row){
                        return $row->panjang.' Meter';
                })
                ->addColumn('lebar', function($row){
                    return $row->lebar.' Meter';
                })
                ->addColumn('ang_tahun', function($row){
                    $ang = Penganggaran::where('rute_id', $row->jalan_id)->whereYear('tgl', date('Y'))->latest()->get();
                    return $ang->count(). ' Penganggaran';
                })
                ->addColumn('ang_last', function($row){
                    $ang = Penganggaran::where('rute_id', $row->jalan_id)->first();
                    if($ang === null)
                    {
                        return 'Tidak Ada';
                    }else{
                        return GeneralHelp::tgl_indo($ang->tgl);
                    }
                    return 'Tidak Ada';
                })
                ->addColumn('action', function($row){

                    $btn = '<center><div class="btn-group" role="group">
                            <button type="button" class="btn btn-secondary dropdown-toggle" id="btnGroupVerticalDrop3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Aksi</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 34px, 0px);">
                                <a class="dropdown-item" href="'. route('jalan.detail', $row->jalan_id) .'">
                                    <i class="si si-note mr-5"></i>Detail Jalan
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)" onClick="edit('.$row->jalan_id.')">
                                    <i class="si si-note mr-5"></i>Edit Data Jalan
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)" onClick="hapus('.$row->jalan_id.')">
                                    <i class="si si-trash mr-5"></i>Hapus Data Jalan
                                </a>
                            </div>
                        </div></center>';

                    return $btn;
                })
                ->rawColumns(['panjang', 'lebar', 'ang_tahun', 'ang_last', 'action'])
                ->make(true);
        }
        return view('jalan.index');
    }

    public function tambah(Request $request)
    {
        if($request->isMethod('get'))
        {
            $config['center'] = '-6.897002, 107.421230';
            $config['zoom'] = 'auto';
            $config['map_height'] = '600';
            $config['map_type'] = 'ROADMAP';
            $config['map_types_available'] = array('ROADMAP', 'SATELLITE');
            $config['places'] = TRUE;
            $config['styles'] = array(
            array("name"=>"Tanpa Label", "definition"=>array(
                array("featureType"=>"poi.business", "elementType"=>"labels", "stylers"=>array(array("visibility"=>"off")))
            ))
            );
            $config['kmlLayerPreserveViewport'] = TRUE;
            $config['kmlLayerURL'] = 'https://www.dropbox.com/s/m64e170tumyev60/BandungBarat.kmz?dl=0';
            $config['stylesAsMapTypes'] = true;
            $config['stylesAsMapTypesDefault'] = "Black Roads";
            $config['onrightclick'] = 'show_marker(event.latLng, event.latLng.lat(), event.latLng.lng()); cek_marker += 1;';
            $config['placesAutocompleteInputID'] = 'cari_alamat';
            $config['placesAutocompleteBoundsMap'] = TRUE;
            $config['placesAutocompleteOnChange'] = "reset_alamat();";

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


            // Marker Awal
            $marker = array();
            $marker['draggable'] = true;
            $marker['visible'] = FALSE;
            $marker['ondragend'] = 'marker_0.setPosition(event.latLng); longlat1.value = event.latLng.lat() + \', \' + event.latLng.lng();';
            $marker['ondrag'] = 'marker_0.setPosition(event.latLng);';
            $marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=S|EA4335|FFFFFF';
            $marker['infowindow_content'] = 'Titik Awal Rute Jalan';
            $gmap->add_marker($marker);


            // Marker Akhir
            $marker = array();
            $marker['draggable'] = true;
            $marker['visible'] = FALSE;
            $marker['ondragend'] = 'marker_1.setPosition(event.latLng); longlat2.value = event.latLng.lat() + \', \' + event.latLng.lng(); tampilRute(longlat1.value, event.latLng, directionsService, directionsDisplay); tampilRute(event.latLng.lat(), event.latLng.lng(), directionsService, directionsDisplay);';
            // $marker['ondrag'] = '';
            $marker['ondrag'] = 'marker_1.setPosition(event.latLng);';
            $marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=E|EA4335|FFFFFF';
            $marker['infowindow_content'] = 'Titik Rute Akhir Jalan';
            $gmap->add_marker($marker);

            $map = $gmap->create_map();
            return view('jalan.tambah1', compact('map'));
        }else{
            $rules = [
                'nama' => 'required',
                'panjang' => 'required',
                'lebar' => 'required',
                'kondisi' => 'required',
            ];

            $pesan = [
                'nama.required' => 'Nama Ruas Jalan Wajib Diisi!',
                'panjang.required' => 'Panjang Jalan Wajib Diisi!',
                'lebar.required' => 'Lebar Jalan Wajib Diisi!',
                'kondisi.required' => 'Kondisi Jalan Wajib Diisi!',
            ];

            $validator = Validator::make($request->all(), $rules, $pesan);
            if ($validator->fails()){
                return response()->json([
                    'fail' => true,
                    'errors' => $validator->errors()
                ]);
            }else{
                $data = new Jalan();
                $data->nama = $request->nama;
                $data->panjang = $request->panjang;
                $data->lebar = $request->lebar;
                $data->kondisi = $request->kondisi;
                $data->lat_awal = $request->lat_awal;
                $data->lng_awal = $request->long_awal;
                $data->lat_akhir = $request->lat_akhir;
                $data->lng_akhir = $request->long_akhir;
                $data->polyline = $request->polypath;
                if($data->save())
                {
                    return response()->json([
                        'fail' => false,
                        'url' => route('jalan.detail', $data->jalan_id)
                    ]);
                }
            }
        }
    }

    public function detail($id)
    {
        $jalan = Jalan::find($id);
        $jembatan = Jembatan::where('jalan_id', $jalan->jalan_id)->latest()->get();
        $tpt = TPT::where('jalan_id', $jalan->jalan_id)->latest()->get();
        $drainase = Drainase::where('jalan_id', $jalan->jalan_id)->latest()->get();
        $beton = Beton::where('jalan_id', $jalan->jalan_id)->latest()->get();
        $penganggaran = Penganggaran::where('rute_id', $jalan->jalan_id)->latest()->get();
        $penganggaran_last = Penganggaran::where('rute_id', $jalan->jalan_id)->orderBy('created_at', 'desc')->first();
        $anggaran = AngJalan::where('jalan_id', $jalan->jalan_id)->latest()->get();
        $config['center'] = $jalan->lat_akhir.', '.$jalan->lng_akhir;
        $config['zoom'] = '13';
        $config['map_height'] = '630px';
        $config['map_type'] = 'SATELLITE';
        $config['map_types_available'] = array('ROADMAP', 'SATELLITE');
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

        $polyline = array();
        $c = str_replace('(', '', $jalan->polyline);
        $c = str_replace('),', '|', $c);
        $c = str_replace(')', '|', $c);
        $array = array_filter(explode('|',$c));
        $polyline['points'] = $array;
        $polyline['infowindow_content'] = '1 - Hello World!';
        $polyline['strokeWeight'] = 6;
        $polyline['strokeColor'] = 'blue';
        $gmap->add_polyline($polyline);

        if($jembatan->count() > 0)
        {
            foreach($jembatan as $j)
            {
                $marker = array();
                $marker['position'] = $j->lat.', '.$j->lng;
                $marker['ondrag'] = 'marker_0.setPosition(find_closest_point_on_path(event.latLng,polyline_0.getPath().getArray()));';
                $marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=J|EA4335|FFFFFF';
                $marker['infowindow_content'] = $j->nama;
                $gmap->add_marker($marker);
            }
        }

        if($anggaran->count() > 0)
        {
            foreach($anggaran as $a)
            {
                if($a->penganggaran->tujuan == 'Pemeliharaan')
                {
                    $warna = 'Green';
                }else{
                    $warna = 'Orange';
                }
                $polyline = array();
                $c = str_replace('(', '', $a->polypath);
                $c = str_replace('),', '|', $c);
                $c = str_replace(')', '|', $c);
                $array = array_filter(explode('|',$c));
                $polyline['points'] = $array;
                // $polyline['infowindow_content'] = ''. $a->penganggaran->tujuan.'';
                $polyline['strokeWeight'] = 5;
                $polyline['strokeColor'] = $warna;
                $gmap->add_polyline($polyline);
            }
        }

        if($tpt->count() > 0)
        {
            foreach($tpt as $t)
            {
                $coba = array();
                $c = str_replace('(', '', $t->polyline);
                $c = str_replace('),', '|', $c);
                $c = str_replace(')', '|', $c);
                $array = array_filter(explode('|',$c));
                $coba['points'] = $array;
                $coba['infowindow_content'] = '1 - Hello World!';
                $coba['strokeWeight'] = 5;
                $coba['strokeColor'] = 'red';
                $gmap->add_polyline($coba);
            }
        }

        $map = $gmap->create_map();
        return view('jalan.detail', compact('jalan', 'map', 'jembatan', 'drainase', 'tpt', 'beton', 'penganggaran', 'penganggaran_last'));
    }

    public function simpan(Request $request)
    {
        $rules = [
            'nama' => 'required',
            'panjang' => 'required',
            'lebar' => 'required',
            'kondisi' => 'required',
        ];

        $pesan = [
            'nama.required' => 'Nama Ruas Jalan Wajib Diisi!',
            'panjang.required' => 'Panjang Jalan Wajib Diisi!',
            'lebar.required' => 'Lebar Jalan Wajib Diisi!',
            'kondisi.required' => 'Kondisi Jalan Wajib Diisi!',
        ];

        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            return response()->json([
                'fail' => true,
                'errors' => $validator->errors()
            ]);
        }else{

            $data = new Jalan();
            $data->nama = $request->nama;
            $data->panjang = $request->panjang;
            $data->lebar = $request->lebar;
            $data->kondisi = $request->kondisi;
            $data->lat_awal = $request->lat_awal;
            $data->lng_awal = $request->long_awal;
            $data->lat_akhir = $request->lat_akhir;
            $data->lng_akhir = $request->long_akhir;
            $data->polyline = $request->polypath;
            if($data->save())
            {
                return response()->json([
                    'fail' => false,
                ]);
            }
        }
    }

    public function penganggaran(Request $request)
    {
        $step1 = $request->session()->get('penganggaran');
        $rules = [
            'panjang' => 'required',
            'patok_awal' => 'required',
            'patok_akhir' => 'required',
        ];
        $pesan = [
            'panjang.required' => 'Panjang '. $step1['tujuan'] .' Wajib Diisi!',
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
            // dd($step1['jalan_id']);
            $data = new Penganggaran();
            $data->rute_id = $step1['jalan_id'];
            $data->jenis =  $step1['jenis'];
            $data->tujuan =  $step1['tujuan'];
            $data->perusahaan =  $step1['perusahaan'];
            $data->nomor_bast =  $step1['nomor_bast'];
            $data->tgl = date('Y-m-d', strtotime($step1['tgl']));
            $data->jml_anggaran = $step1['jml_anggaran'];
            if($data->save())
            {
                if($request->hasfile('files'))
                {
                    foreach($request->file('files') as $f)
                    {

                        $ext = $f->getClientOriginalExtension();
                        $nama_file = md5($step1['nomor_bast']).'.'.$ext;
                        $f->move(public_path().'/uploads/dokumen/'.$step1['nomor_bast'], $nama_file);

                        $file = array(
                            'penganggaran_id' => $data->id,
                            'path' => '/uploads/dokumen/'.$step1['nomor_bast'].'/'.$nama_file,
                        );
                        Dokumen::insert($file);
                    }
                }
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

    public function update(Request $request)
    {
        // dd($request->all());

        $rules = [
            'nama' => 'required',
            'panjang' => 'required',
            'lebar' => 'required',
            'kondisi' => 'required',
        ];

        $pesan = [
            'nama.required' => 'Nama Ruas Jalan Wajib Diisi!',
            'panjang.required' => 'Panjang Jalan Wajib Diisi!',
            'lebar.required' => 'Lebar Jalan Wajib Diisi!',
            'kondisi.required' => 'Kondisi Jalan Wajib Diisi!',
        ];

        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            return response()->json([
                'fail' => true,
                'errors' => $validator->errors()
            ]);
        }else{

            $data = Jalan::find($request->jalan_id);
            $data->nama = $request->nama;
            $data->panjang = $request->panjang;
            $data->lebar = $request->lebar;
            $data->kondisi = $request->kondisi;
            if($data->save())
            {
                return response()->json([
                    'fail' => false,
                ]);
            }
        }
    }

    public function edit($id){

        $data = Jalan::find($id);
        if($data){

            $user = collect([
                'jalan_id' => $data->jalan_id,
                'nama' => $data->nama,
                'panjang' => $data->panjang,
                'lebar' => $data->lebar,
                'kondisi' => $data->kondisi,
            ]);

            return response()->json($user);
        }
    }

    public function hapus($id)
    {
        $data = Jalan::destroy($id);
        if($data){
            return response()->json([
                'fail' => false,
            ]);
        }
    }

}
