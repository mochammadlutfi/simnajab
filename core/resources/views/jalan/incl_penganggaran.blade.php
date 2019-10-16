<div class="tab-pane" id="penganggaran_jalan" role="tabpanel">
    <div class="row">
        <div class="col-lg-6">

        </div>
        <div class="col-lg-6">
            <a href="{{ route('penganggaran.tambah', $jalan->jalan_id) }}" class="btn btn-secondary mr-5 mb-5 float-right btn-rounded">
                <i class="si si-plus mr-5"></i>
                Tambah Data Penganggaran
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-hover table-striped" id="list-penganggaran" style="width:100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis</th>
                        <th>Tujuan</th>
                        <th>Perusahaan</th>
                        <th>No. BAST</th>
                        <th>Anggaran</th>
                        <th>Tgl</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
