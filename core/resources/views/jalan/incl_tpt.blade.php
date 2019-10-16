<div class="tab-pane" id="tpt_jalan" role="tabpanel">
    <div class="row">
        <div class="col-lg-6">

        </div>
        <div class="col-lg-6">
            <a href="{{ route('tpt.tambah', $jalan->jalan_id) }}" class="btn btn-secondary mr-5 mb-5 float-right btn-rounded"><i class="si si-plus mr-5"></i>Tambah Data TPT</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-hover table-striped" id="list-tpt" style="width:100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Panjang</th>
                        <th>Batu</th>
                        <th>Beton</th>
                        <th>Kondisi</th>
                        <th>Posisi</th>
                        <th>Diperbaharui</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
