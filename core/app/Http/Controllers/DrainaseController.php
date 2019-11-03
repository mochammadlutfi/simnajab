<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Jalan;
use App\Models\Penganggaran;
use App\Models\Drainase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AngDrainase;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use FarhanWazir\GoogleMaps\GMaps;
use App\Helpers\GeneralHelp;
class DrainaseController extends Controller
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
    public function index($jalan_id, Request $request)
    {
        $jalan = Jalan::latest()->get();
        if ($request->ajax()) {
            $data = Drainase::where('jalan_id', $jalan_id)->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('panjang', function($row){
                    return $row->panjang.' Meter';
                })
                ->addColumn('batu', function($row){
                    if($row->pasang_batu)
                    {
                        return 'Ya';
                    }else{
                        return 'Tidak';
                    }
                })
                ->addColumn('beton', function($row){
                    if($row->beton)
                    {
                        return 'Ya';
                    }else{
                        return 'Tidak';
                    }
                })
                ->addColumn('kondisi', function($row){
                    return ucwords($row->kondisi);
                })
                ->addColumn('posisi', function($row){
                    return ucwords($row->posisi);
                })
                ->addColumn('tgl', function($row){
                    $anggaran = AngDrainase::where('drainase_id', $row->drainase_id)->orderBy('created_at', 'desc')->first();
                    if($anggaran === null)
                    {
                        return GeneralHelp::tgl_indo($row->penganggaran->tgl);
                    }else{
                        return GeneralHelp::tgl_indo($anggaran->penganggaran->tgl);
                    }
                })
                ->addColumn('action', function($row){

                    $btn = '<center><div class="btn-group" role="group">
                            <button type="button" class="btn btn-secondary dropdown-toggle" id="btnGroupVerticalDrop3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Aksi</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 34px, 0px);">
                                <a class="dropdown-item" href="javascript:void(0)" onClick="edit('.$row->drainase_id.')">
                                    <i class="si si-note mr-5"></i>Edit Data Drainase
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)" onClick="hapus('.$row->drainase_id.')">
                                    <i class="si si-trash mr-5"></i>Hapus Data Drainase
                                </a>
                            </div>
                        </div></center>';

                    return $btn;
                })
            ->rawColumns(['panjang', 'beton', 'batu', 'action', 'tgl', 'posisi'])
            ->make(true);
        }
        // return view('drainase', compact('jalan'));
    }

    public function tambah($jalan_id)
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

        // $c = str_replace('(', '{lat: ', $jalan->polyline);
        // $c = str_replace('),', '}|', $c);
        // $c = str_replace(', ', ', lng: ', $c);
        // $c = str_replace(')', '|', $c);
        // $array = array_filter(explode('|',$c));
        // dd($array);

        // // Buat Polyline Rute
        $polyline = array();
        $c = str_replace('(', '', $jalan->polyline);
        $c = str_replace('),', '|', $c);
        $c = str_replace(')', '|', $c);
        $array = explode('|',$c);
        $polyline['points'] = array_filter($array);
        // $polyline['onclick'] = 'info_jalan("kUONTOl")';
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

        $map = $gmap->create_map();

        return view('drainase.tambah', compact('jalan', 'map'));
    }

    public function detail($id)
    {
        $jalan = Jalan::find($id);

        return view('jalan.detail', compact('jalan'));
    }

    public function simpan(Request $request)
    {
        $rules = [
            'panjang' => 'required',
            'pasang_batu' => 'required',
            'beton' => 'required',
            'kondisi' => 'required',
            'posisi' => 'required',
        ];

        $pesan = [
            'panjang.required' => 'Panjang Drainase Wajib Diisi!',
            'pasang_batu.required' => 'Pasang Batu Drainase Wajib Diisi!',
            'beton.required' => 'Beton Drainase Wajib Diisi!',
            'kondisi.required' => 'Kondisi Drainase Wajib Diisi!',
            'posisi.required' => 'Posisi Drainase Wajib Diisi!',
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
            $data = new Penganggaran();
            $data->rute_id = $step1['jalan_id'];
            $data->jenis =  $step1['jenis'];
            $data->tujuan =  $step1['tujuan'];
            $data->perusahaan =  $step1['perusahaan'];
            $data->nomor_bast =  $step1['nomor_bast'];
            $data->tgl = date('Y-m-d', strtotime($step1['tgl']));
            $data->jml_anggaran = $step1['jml_anggaran'];
            $data->keterangan = $request->keterangan;
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

                $drainase = new Drainase();
                $drainase->jalan_id = $request->jalan_id;
                $drainase->penganggaran_id = $data->id;
                $drainase->pasang_batu = $request->pasang_batu;
                $drainase->beton = $request->beton;
                $drainase->kondisi = $request->kondisi;
                $drainase->posisi = $request->posisi;
                $drainase->panjang = $request->panjang;
                $drainase->patok_awal = $request->patok_awal;
                $drainase->patok_akhir = $request->patok_akhir;
                $drainase->lat_awal = $request->lat_awal;
                $drainase->lng_awal = $request->long_awal;
                $drainase->lat_akhir = $request->lat_akhir;
                $drainase->lng_akhir = $request->long_akhir;
                $drainase->polyline = $request->polypath;
                if($drainase->save())
                {
                    $request->session()->forget('penganggaran');
                    return response()->json([
                        'fail' => false,
                    ]);
                }
            }
        }
    }

    public function pemeliharaan(Request $request)
    {

        $rules = [
            'panjang' => 'required',
        ];

        $pesan = [
            'panjang.required' => 'Panjang Drainase Wajib Diisi!',
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
            // dd($step1['penganggaran']);
            $data = new Penganggaran();
            $data->rute_id = $step1['jalan_id'];
            $data->jenis =  $step1['jenis'];
            $data->tujuan =  $step1['tujuan'];
            $data->perusahaan =  $step1['perusahaan'];
            $data->nomor_bast =  $step1['nomor_bast'];
            $data->tgl = date('Y-m-d', strtotime($step1['tgl']));
            $data->jml_anggaran = $step1['jml_anggaran'];
            $data->keterangan = $request->keterangan;
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

                $drainase = new AngDrainase();
                $drainase->drainase_id = $step1['penganggaran'];
                $drainase->penganggaran_id = $data->id;
                $drainase->panjang = $request->panjang;
                $drainase->patok_awal = $request->patok_awal;
                $drainase->patok_akhir = $request->patok_akhir;
                $drainase->lat_awal = $request->lat_awal;
                $drainase->lng_awal = $request->long_awal;
                $drainase->lat_akhir = $request->lat_akhir;
                $drainase->lng_akhir = $request->long_akhir;
                $drainase->polyline = $request->polypath;
                if($drainase->save())
                {
                    $request->session()->forget('penganggaran');
                    return response()->json([
                        'fail' => false,
                        'url' => route('penganggaran.detail', $data->id)
                    ]);
                }
            }
        }
    }

    public function update(Request $request)
    {
        $rules = [
            'jalan_id' => 'required',
            'pasang_batu' => 'required',
            'beton' => 'required',
            'kondisi' => 'required',
            'posisi' => 'required',
        ];

        $pesan = [
            'jalan_id.required' => 'Ruas Jalan Wajib Diisi!',
            'pasang_batu.required' => 'Pasang Batu Drainase Wajib Diisi!',
            'beton.required' => 'Beton Drainase Wajib Diisi!',
            'kondisi.required' => 'Kondisi Drainase Wajib Diisi!',
            'posisi.required' => 'Posisi Drainase Wajib Diisi!',
        ];

        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            return response()->json([
                'fail' => true,
                'errors' => $validator->errors()
            ]);
        }else{

            $data = Drainase::find($request->drainase_id);
            $data->jalan_id = $request->jalan_id;
            $data->pasang_batu = $request->pasang_batu;
            $data->beton = $request->beton;
            $data->kondisi = $request->kondisi;
            $data->posisi = $request->posisi;
            if($data->save())
            {
                return response()->json([
                    'fail' => false,
                ]);
            }
        }
    }

    public function edit($id){

        $data = Drainase::find($id);
        if($data){
            $d = collect([
                'drainase_id' => $data->drainase_id,
                'jalan_id' => $data->jalan_id,
                'pasang_batu' => $data->pasang_batu,
                'beton' => $data->beton,
                'kondisi' => $data->kondisi,
                'posisi' => $data->posisi,
            ]);

            return response()->json($d);
        }
    }

    public function hapus($id)
    {
        $data = Drainase::destroy($id);
        if($data){
            return response()->json([
                'fail' => false,
            ]);
        }
    }

}
