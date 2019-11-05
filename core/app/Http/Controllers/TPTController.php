<?php

namespace App\Http\Controllers;

use App\Models\AngTPT;
use App\Models\Dokumen;
use App\Models\Jalan;
use App\Models\Penganggaran;
use App\Models\TPT;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use FarhanWazir\GoogleMaps\GMaps;
use App\Helpers\GeneralHelp;
class TPTController extends Controller
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
            $data = TPT::where('jalan_id', $jalan_id)->latest()->get();
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
                    $anggaran = AngTPT::where('tpt_id', $row->tpt_id)->orderBy('created_at', 'desc')->first();
                    if($anggaran == null)
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
                                <a class="dropdown-item" href="javascript:void(0)" onClick="edit('.$row->tpt_id.')">
                                    <i class="si si-note mr-5"></i>Edit Data TPT
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)" onClick="hapus('.$row->tpt_id.')">
                                    <i class="si si-trash mr-5"></i>Hapus Data TPT
                                </a>
                            </div>
                        </div></center>';

                    return $btn;
                })
                ->rawColumns(['panjang', 'beton', 'batu', 'action', 'tgl'])
                ->make(true);
        }
    }


    public function tambah($jalan_id, Request $request)
    {
        if($request->isMethod('get'))
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
            $marker['infowindow_content'] = 'Titik Awal TPT';
            $gmap->add_marker($marker);

            $marker = array();
            $marker['position'] = $jalan->lat_akhir.', '.$jalan->lng_akhir;
            $marker['draggable'] = true;
            $marker['visible'] = FALSE;
            $marker['ondragend'] = 'marker_1.setPosition(find_closest_point_on_path(event.latLng,polyline_0.getPath().getArray())); longlat2.value = event.latLng.lat() + \', \' + event.latLng.lng(); tampilRute(longlat1.value, event.latLng, directionsService, directionsDisplay);; tampilRute(event.latLng.lat(), event.latLng.lng(), directionsService, directionsDisplay);';
            // $marker['ondrag'] = 'tampilRute(event.latLng.lat(), event.latLng.lng(), directionsService, directionsDisplay);';
            $marker['ondrag'] = 'marker_1.setPosition(find_closest_point_on_path(event.latLng,polyline_0.getPath().getArray()));';
            $marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=E|EA4335|FFFFFF';
            $marker['infowindow_content'] = 'Titik Akhir TPT';
            $gmap->add_marker($marker);

            $map = $gmap->create_map();

            return view('tpt.tambah', compact('jalan', 'map'));
        }else{
            $rules = [
                'jalan_id' => 'required',
                'pasang_batu' => 'required',
                'beton' => 'required',
                'kondisi' => 'required',
                'posisi' => 'required',
            ];

            $pesan = [
                'panjang.required' => 'Panjang TPT Wajib Diisi!',
                'pasang_batu.required' => 'Pasang Batu TPT Wajib Diisi!',
                'beton.required' => 'Beton TPT Wajib Diisi!',
                'kondisi.required' => 'Kondisi TPT Wajib Diisi!',
                'posisi.required' => 'Posisi TPT Wajib Diisi!',
            ];

            $validator = Validator::make($request->all(), $rules, $pesan);
            if ($validator->fails()){
                return response()->json([
                    'fail' => true,
                    'errors' => $validator->errors()
                ]);
            }else{

                $data = new TPT();
                $data->jalan_id = $request->jalan_id;
                $data->panjang = $request->panjang;
                $data->pasang_batu = $request->pasang_batu;
                $data->beton = $request->beton;
                $data->kondisi = $request->kondisi;
                $data->posisi = $request->posisi;
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
            'panjang.required' => 'Panjang TPT Wajib Diisi!',
            'pasang_batu.required' => 'Pasang Batu TPT Wajib Diisi!',
            'beton.required' => 'Beton TPT Wajib Diisi!',
            'kondisi.required' => 'Kondisi TPT Wajib Diisi!',
            'posisi.required' => 'Posisi TPT Wajib Diisi!',
        ];

        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            return response()->json([
                'fail' => true,
                'errors' => $validator->errors()
            ]);
        }else{

            $step1 = $request->session()->get('penganggaran');
            $data = new Penganggaran();
            $data->rute_id = $step1['jalan_id'];
            $data->jenis =  $step1['jenis'];
            $data->tujuan =  $step1['tujuan'];
            $data->perusahaan =  $step1['perusahaan'];
            $data->nomor_bast =  $step1['nomor_bast'];
            $data->tgl = date('Y-m-d', strtotime($step1['tgl']));
            $data->jml_anggaran = $step1['jml_anggaran'];
            $data->sumber = $step1['sumber'];
            if($data->save())
            {
                if($request->hasfile('files'))
                {
                    foreach($request->file('files') as $f)
                    {

                        $name= $f->getClientOriginalName();
                        $f->move(public_path().'/uploads/dokumen/'.$data->id.'', $name);
                        $file = array(
                            'penganggaran_id' => $data->id,
                            'nama' => $name,
                            'path' => '/uploads/dokumen/'.$data->id.'/'.$name,
                        );
                        Dokumen::insert($file);
                    }
                }

                $tpt = new TPT();
                $tpt->penganggaran_id = $data->id;
                $tpt->jalan_id = $request->jalan_id;
                $tpt->panjang = $request->panjang;
                $tpt->patok_awal = $request->patok_awal;
                $tpt->patok_akhir = $request->patok_akhir;
                $tpt->pasang_batu = $request->pasang_batu;
                $tpt->beton = $request->beton;
                $tpt->kondisi = $request->kondisi;
                $tpt->posisi = $request->posisi;
                $tpt->lat_awal = $request->lat_awal;
                $tpt->lng_awal = $request->long_awal;
                $tpt->lat_akhir = $request->lat_akhir;
                $tpt->lng_akhir = $request->long_akhir;
                $tpt->polyline = $request->polypath;
                if($tpt->save())
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

    public function penganggaran(Request $request)
    {
        $step1 = $request->session()->get('penganggaran');
        $rules = [
            'panjang' => 'required',
            'patok_awal' => 'required',
            'patok_akhir' => 'required',
        ];

        $pesan = [
            'panjang.required' => 'Panjang '. $step1['tujuan'] .' TPT Wajib Diisi!',
            'patok_awal.required' => 'Patok Awal '. $step1['tujuan'] .' TPT Wajib Diisi!',
            'patok_akhir.required' => 'Patok Akhir '. $step1['tujuan'] .' TPT Wajib Diisi!',
        ];

        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            return response()->json([
                'fail' => true,
                'errors' => $validator->errors()
            ]);
        }else{
            // dd($request->all());
            // dd($step1['penganggaran']);
            $data = new Penganggaran();
            $data->rute_id = $step1['jalan_id'];
            $data->jenis =  $step1['jenis'];
            $data->tujuan =  $step1['tujuan'];
            $data->perusahaan =  $step1['perusahaan'];
            $data->nomor_bast =  $step1['nomor_bast'];
            $data->tgl = date('Y-m-d', strtotime($step1['tgl']));
            $data->jml_anggaran = $step1['jml_anggaran'];
            $data->sumber = $step1['sumber'];
            $data->keterangan = $request->keterangan;
            if($data->save())
            {
                if($request->hasfile('files'))
                {
                    foreach($request->file('files') as $f)
                    {

                        $name= $f->getClientOriginalName();
                        $f->move(public_path().'/uploads/dokumen/'.$data->id.'', $name);
                        $file = array(
                            'penganggaran_id' => $data->id,
                            'nama' => $name,
                            'path' => '/uploads/dokumen/'.$data->id.'/'.$name,
                        );
                        Dokumen::insert($file);
                    }
                }

                $tpt = new AngTPT();
                $tpt->tpt_id = $step1['penganggaran'];
                $tpt->penganggaran_id = $data->id;
                $tpt->panjang = $request->panjang;
                $tpt->patok_awal = $request->patok_awal;
                $tpt->patok_akhir = $request->patok_akhir;
                $tpt->lat_awal = $request->lat_awal;
                $tpt->lng_awal = $request->long_awal;
                $tpt->lat_akhir = $request->lat_akhir;
                $tpt->lng_akhir = $request->long_akhir;
                $tpt->polyline = $request->polypath;
                if($tpt->save())
                {
                    $request->session()->forget('penganggaran');
                    return response()->json([
                        'fail' => false,
                        'text' => 'Penganggaran '. $step1['tujuan'] .' TPT Berhasil Disimpan',
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
            'pasang_batu.required' => 'Pasang Batu TPT Wajib Diisi!',
            'beton.required' => 'Beton TPT Wajib Diisi!',
            'kondisi.required' => 'Kondisi TPT Wajib Diisi!',
            'posisi.required' => 'Posisi TPT Wajib Diisi!',
        ];

        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            return response()->json([
                'fail' => true,
                'errors' => $validator->errors()
            ]);
        }else{

            $data = TPT::find($request->tpt_id);
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

        $data = TPT::find($id);
        if($data){
            $d = collect([
                'tpt_id' => $data->tpt_id,
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
        $data = TPT::destroy($id);
        if($data){
            return response()->json([
                'fail' => false,
            ]);
        }
    }

}
