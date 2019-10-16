<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jalan;
use App\Models\Jembatan;
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
                ->addColumn('kondisi', function($row){
                    return ucwords($row->kondisi);
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
                ->rawColumns(['img', 'action', 'jabatan', 'tgl'])
                ->make(true);
        }
        return view('jalan.index');
    }

    public function tambah(Request $request)
    {
        if($request->isMethod('get'))
        {
            // $config['center'] = '-6.835623,107.576190';
            // $config['zoom'] = 'auto';
            // $config['map_height'] = '600';
            // $config['map_type'] = 'ROADMAP';
            // $config['map_types_available'] = array('ROADMAP');
            // $config['places'] = TRUE;
            // $config['styles'] = array(
            // array("name"=>"Tanpa Label", "definition"=>array(
            //     array("featureType"=>"poi.business", "elementType"=>"labels", "stylers"=>array(array("visibility"=>"off")))
            // ))
            // );
            // $config['stylesAsMapTypes'] = true;
            // $config['stylesAsMapTypesDefault'] = "Black Roads";

            // $config['directions'] = true;
            // $config['directionsStart'] = '-6.859971, 107.565603';
            // $config['directionsEnd'] = '-6.802795, 107.579122';
            // // $config['directionsDivID'] =  'directionsDiv';
            // $gmap = new GMaps();
            // $gmap->initialize($config);

            // $map = $gmap->create_map();
            return view('jalan.tambah', compact('map'));
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
                    ]);
                }
            }
        }
    }

    public function detail($id)
    {
        $jalan = Jalan::find($id);
        $jembatan = Jembatan::where('jalan_id', $jalan->jalan_id)->latest()->get();

        $config['center'] = $jalan->lat_akhir.', '.$jalan->lng_akhir;
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

        $polyline = array();
        $c = str_replace('(', '', $jalan->polyline);
        $c = str_replace('),', '|', $c);
        $c = str_replace(')', '|', $c);
        $array = explode('|',$c);
        $polyline['points'] = array_filter($array);
        $polyline['infowindow_content'] = '1 - Hello World!';
        $polyline['strokeWeight'] = 5;
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

        $map = $gmap->create_map();
        return view('jalan.detail', compact('jalan', 'map'));
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
