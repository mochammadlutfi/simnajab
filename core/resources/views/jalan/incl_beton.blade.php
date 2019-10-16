<div class="tab-pane" id="beton_jalan" role="tabpanel">
    <div class="row">
        <div class="col-lg-6">

        </div>
        <div class="col-lg-6">
            <a href="{{ route('beton.tambah', $jalan->jalan_id) }}" class="btn btn-secondary mr-5 mb-5 float-right btn-rounded">
                <i class="si si-plus mr-5"></i>
                Tambah Data Flat Beton
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-hover table-striped" id="list-beton" style="width:100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Panjang Flat Beton</th>
                        <th>Kondisi Flat Beton</th>
                        <th>Terakhir Diperbaharui</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
