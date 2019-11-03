<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelp;
use App\Models\Jalan;
use App\Models\Penganggaran;
use App\Models\Jembatan;
use App\Models\Dokumen;
use App\Models\AngJembatan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use FarhanWazir\GoogleMaps\GMaps;
class JembatanController extends Controller
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
            $data = Jembatan::where('jalan_id', $jalan_id)->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('nama', function($row){
                    return ucwords($row->nama);
                })
                ->addColumn('panjang', function($row){
                    return $row->panjang. ' Meter';
                })
                ->addColumn('kondisi', function($row){
                    return ucwords($row->kondisi);
                })
                ->addColumn('pembangunan', function($row){
                    return GeneralHelp::tgl_indo($row->penganggaran->tgl);
                })
                ->addColumn('tgl', function($row){
                    $ang_jbt = AngJembatan::where('jembatan_id', $row->jembatan_id)->orderBy('created_at', 'desc')->first();
                    if($ang_jbt === null)
                    {
                        return GeneralHelp::tgl_indo($row->penganggaran->tgl);
                    }else{
                        return GeneralHelp::tgl_indo($ang_jbt->penganggaran->tgl);
                    }
                })
                ->addColumn('action', function($row){
                    $btn = '<center><div class="btn-group" role="group">
                            <button type="button" class="btn btn-secondary dropdown-toggle" id="btnGroupVerticalDrop3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Aksi</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 34px, 0px);">
                                <a class="dropdown-item" href="javascript:void(0)" onClick="edit('.$row->jembatan_id.')">
                                    <i class="si si-note mr-5"></i>Edit Data Jembatan
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)" onClick="hapus('.$row->jembatan_id.')">
                                    <i class="si si-trash mr-5"></i>Hapus Data Jembatan
                                </a>
                            </div>
                        </div></center>';

                    return $btn;
                })
            ->rawColumns(['nama', 'beton', 'batu', 'action', 'tgl', 'posisi', 'pembangunan'])
            ->make(true);
        }
        // return view('jembatan', compact('jalan'));
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
        $marker['ondragend'] = 'marker_0.setPosition(find_closest_point_on_path(event.latLng,polyline_0.getPath().getArray()));
        longlat1.value = event.latLng.lat() + \', \' + event.latLng.lng();
        lat_awal.value = event.latLng.lat();
        long_awal.value = event.latLng.lng();
        ';
        $marker['ondrag'] = 'marker_0.setPosition(find_closest_point_on_path(event.latLng,polyline_0.getPath().getArray()));';
        $marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=J|EA4335|FFFFFF';
        $marker['infowindow_content'] = 'Jembatan';
        $gmap->add_marker($marker);

        $map = $gmap->create_map();

        return view('jembatan.tambah', compact('jalan', 'map'));
    }

    public function detail($id)
    {
        $jalan = Jalan::find($id);

        return view('jalan.detail', compact('jalan'));
    }

    public function simpan(Request $request)
    {
        $rules = [
            'nama' => 'required',
            'panjang' => 'required',
        ];

        $pesan = [
            'nama.required' => 'Nama Jembatan Wajib Diisi!',
            'panjang.required' => 'Panjang Jembatan Wajib Diisi!',
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
            // $data->jml_anggaran = 123123;
            if($data->save())
            {
                if($step1['jenis'] = 'jembatan')
                {
                    $jembatan = new Jembatan();
                    $jembatan->jalan_id = $request->jalan_id;
                    $jembatan->penganggaran_id = $data->id;
                    $jembatan->nama = $request->nama;
                    $jembatan->lat = $request->lat_awal;
                    $jembatan->lng = $request->long_awal;
                    $jembatan->panjang = $request->panjang;
                    $jembatan->kondisi = $request->kondisi;
                    if($jembatan->save())
                    {
                        $request->session()->forget('penganggaran');
                        return response()->json([
                            'fail' => false,
                        ]);
                    }
                }
            }
        }
    }

    public function penganggaran(Request $request)
    {

        $rules = [
            'keterangan' => 'required',
        ];

        $pesan = [
            'keterangan.required' => 'Keterangan Drainase Wajib Diisi!',
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

                $jembatan = new AngJembatan();
                $jembatan->jembatan_id = $step1['penganggaran'];
                $jembatan->penganggaran_id = $data->id;
                if($jembatan->save())
                {
                    $request->session()->forget('penganggaran');
                    return response()->json([
                        'fail' => false,
                        'text' => $data->tujuan .' Jembatan Berhasil Disimpan',
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
            'kondisi' => 'required',
        ];

        $pesan = [
            'jalan_id.required' => 'Ruas Jalan Wajib Diisi!',
            'kondisi.required' => 'Kondisi Drainase Wajib Diisi!',
        ];

        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            return response()->json([
                'fail' => true,
                'errors' => $validator->errors()
            ]);
        }else{

            $data = Jembatan::find($request->jembatan_id);
            $data->jalan_id = $request->jalan_id;
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

        $data = Jembatan::find($id);
        if($data){

            $d = collect([
                'jembatan_id' => $data->jembatan_id,
                'jalan_id' => $data->jalan_id,
                'kondisi' => $data->kondisi,
            ]);

            return response()->json($d);
        }
    }

    public function hapus($id)
    {
        $data = Jembatan::destroy($id);
        if($data){
            return response()->json([
                'fail' => false,
            ]);
        }
    }

}
