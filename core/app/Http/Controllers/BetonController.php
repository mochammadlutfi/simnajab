<?php

namespace App\Http\Controllers;

use App\Models\Jalan;
use App\Models\User;
use App\Models\Beton;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use FarhanWazir\GoogleMaps\GMaps;
class BetonController extends Controller
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
        $jalan = Jalan::where('jalan_id', $jalan_id)->latest()->get();
        if ($request->ajax()) {
            $data = Beton::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('panjang', function($row){
                    return $row->panjang. ' Meter';
                })
                ->addColumn('kondisi', function($row){
                    return ucwords($row->kondisi);
                })
                ->addColumn('tgl', function($row){
                    return date('d-m-y', strtotime($row->updated_at));
                })
                ->addColumn('action', function($row){

                    $btn = '<center><div class="btn-group" role="group">
                            <button type="button" class="btn btn-secondary dropdown-toggle" id="btnGroupVerticalDrop3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Aksi</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 34px, 0px);">
                                <a class="dropdown-item" href="javascript:void(0)" onClick="edit('.$row->beton_id.')">
                                    <i class="si si-note mr-5"></i>Edit Data Beton
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)" onClick="hapus('.$row->beton_id.')">
                                    <i class="si si-trash mr-5"></i>Hapus Data Beton
                                </a>
                            </div>
                        </div></center>';

                    return $btn;
                })
            ->rawColumns(['jalan', 'beton', 'batu', 'action', 'tgl', 'posisi'])
            ->make(true);
        }
        // return view('beton', compact('jalan'));
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

        return view('beton.tambah', compact('jalan', 'map'));
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
            'kondisi' => 'required',
        ];

        $pesan = [
            'panjang.required' => 'Panjang Flat Beton Wajib Diisi!',
            'kondisi.required' => 'Kondisi Drainase Wajib Diisi!',
        ];

        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            return response()->json([
                'fail' => true,
                'errors' => $validator->errors()
            ]);
        }else{

            $data = new Beton();
            $data->jalan_id = $request->jalan_id;
            $data->kondisi = $request->kondisi;
            $data->panjang = $request->panjang;
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

            $data = Beton::find($request->beton_id);
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

        $data = Beton::find($id);
        if($data){

            $d = collect([
                'beton_id' => $data->beton_id,
                'jalan_id' => $data->jalan_id,
                'kondisi' => $data->kondisi,
            ]);

            return response()->json($d);
        }
    }

    public function hapus($id)
    {
        $data = Beton::destroy($id);
        if($data){
            return response()->json([
                'fail' => false,
            ]);
        }
    }

}
