<?php

namespace App\Http\Controllers;

use App\Models\Jalan;
use App\Models\NJOP;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
class NJOPController extends Controller
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
            $data = NJOP::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('jalan', function($row){
                        return $row->jalan->nama;
                })
                ->addColumn('tgl', function($row){
                    return date('d-m-Y', strtotime($row->tgl));
                })
                ->addColumn('anggaran', function($row){
                    return 'Rp.'. number_format($row->jml_anggaran,0,",",".");
                })
                ->addColumn('action', function($row){

                    $btn = '<center><div class="btn-group" role="group">
                            <button type="button" class="btn btn-secondary dropdown-toggle" id="btnGroupVerticalDrop3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Aksi</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 34px, 0px);">
                                <a class="dropdown-item" href="javascript:void(0)" onClick="edit('.$row->id.')">
                                    <i class="si si-note mr-5"></i>Edit Data NJOP
                                </a>
                                <a class="dropdown-item" href="javascript:void(0)" onClick="hapus('.$row->id.')">
                                    <i class="si si-trash mr-5"></i>Hapus Data NJOP
                                </a>
                            </div>
                        </div></center>';

                    return $btn;
                })
                ->rawColumns(['jalan', 'action', 'anggaran', 'tgl'])
                ->make(true);
        }
        return view('njop', compact('jalan'));
    }

    public function detail($id)
    {

    }

    public function simpan(Request $request)
    {
        $rules = [
            'jalan_id' => 'required',
            'jml_anggaran' => 'required',
            'tgl' => 'required',
        ];

        $pesan = [
            'jalan_id.required' => 'Ruas Jalan Wajib Diisi!',
            'jml_anggaran.required' => 'Jumlah Anggaran NJOP Jalan Wajib Diisi!',
            'tgl.required' => 'Tanggal Wajib Diisi!',
        ];

        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            return response()->json([
                'fail' => true,
                'errors' => $validator->errors()
            ]);
        }else{

            $data = new NJOP();
            $data->jalan_id = $request->jalan_id;
            $data->jml_anggaran = $request->jml_anggaran;
            $data->tgl = date('Y-m-d', strtotime($request->tgl));
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
            'jml_anggaran' => 'required',
            'tgl' => 'required',
        ];

        $pesan = [
            'jalan_id.required' => 'Ruas Jalan Wajib Diisi!',
            'jml_anggaran.required' => 'Jumlah Anggaran NJOP Jalan Wajib Diisi!',
            'tgl.required' => 'Tanggal Wajib Diisi!',
        ];

        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            return response()->json([
                'fail' => true,
                'errors' => $validator->errors()
            ]);
        }else{

            $data = NJOP::find($request->njop_id);
            $data->jalan_id = $request->jalan_id;
            $data->jml_anggaran = $request->jml_anggaran;
            $data->tgl = date('Y-m-d', strtotime($request->tgl));
            if($data->save())
            {
                return response()->json([
                    'fail' => false,
                ]);
            }
        }
    }

    public function edit($id){

        $data = NJOP::find($id);
        if($data){

            $d = collect([
                'njop_id' => $data->id,
                'jalan_id' => $data->jalan_id,
                'jml_anggaran' => $data->jml_anggaran,
                'tgl' => date('d-m-Y', strtotime($data->tgl)),
            ]);

            return response()->json($d);
        }
    }

    public function hapus($id)
    {
        $data = NJOP::destroy($id);
        if($data){
            return response()->json([
                'fail' => false,
            ]);
        }
    }

}
