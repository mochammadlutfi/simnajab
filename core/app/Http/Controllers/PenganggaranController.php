<?php

namespace App\Http\Controllers;

use App\Models\Jalan;
use App\Models\User;
use App\Models\Penganggaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
                ->addColumn('jalan', function($row){
                        return $row->jalan->nama;
                })
                ->addColumn('tujuan', function($row){
                    return ucwords($row->kondisi);
                })
                ->addColumn('anggaran', function($row){
                    return 'Rp.'. number_format($row->jml_anggaran,0,",",".");
                })
                ->addColumn('action', function($row){

                    $btn = '<center><div class="btn-group" role="group">
                            <button type="button" class="btn btn-secondary dropdown-toggle" id="btnGroupVerticalDrop3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Aksi</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 34px, 0px);">
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

                $request->session()->put('penganggaran', $request->all());

                return response()->json([
                    'fail' => false,
                    'step2' => route('penganggaran.step2', $request->jalan_id)
                ]);

                // $data = new Penganggaran();
                // $data->jalan_id = $request->jalan_id;
                // $data->jenis = $request->jenis;
                // $data->tujuan = $request->tujuan;
                // $data->perusahaan = $request->perusahaan;
                // $data->nomor_bast = $request->nomor_bast;
                // $data->tgl = date('Y-m-d', strtotime($request->tgl));
                // $data->nomor_bast = $request->nomor_bast;
                // $data->jml_anggaran = $request->jml_anggaran;
                // if($data->save())
                // {
                //     return response()->json([
                //         'fail' => false,
                //     ]);
                // }
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



            $gmap = new GMaps();
            $gmap->initialize($this->peta($jalan->jalan_id));

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
            return view('penganggaran.step_2', compact('jalan', 'map', 'step2'));
        }
    }

    public function step3($jalan_id, Request $request)
    {

    }

    public function detail($id)
    {
        $jalan = Jalan::find($id);

        return view('jalan.detail', compact('jalan'));
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

    function peta($jalan_id)
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

        return $config;
    }

}
