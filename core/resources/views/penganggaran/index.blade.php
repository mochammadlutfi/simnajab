@extends('layouts.master')


@section('content')
<div class="content">
    <nav class="breadcrumb bg-white push">
        <a class="breadcrumb-item" href="{{ route('beranda') }}">Beranda</a>
        <span class="breadcrumb-item active">Penganggaran</span>
    </nav>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Kelola <small>Data Penganggaran</small></h3>
            @role('admin')
                <button id="btn_tambah" type="button" class="btn btn-secondary mr-5 mb-5 float-right btn-rounded">
                    <i class="si si-plus mr-5"></i>
                    Tambah Penganggaran Baru
                </button>
            @endrole
        </div>
        <div class="block-content">
            <table class="table table-hover table-striped" id="list-jalan">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Ruas Jalan</th>
                        <th>Tujuan</th>
                        <th>Perusahaan</th>
                        <th>No. BAST</th>
                        <th>Anggaran</th>
                        <th>Tgl</th>
                        {{-- <th></th> --}}
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="block block-rounded mb-0">
                <div class="block-header bg-alt-secondary">
                    <h3 class="block-title" id="modal_title">Form Title</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content pt-0">
                    <form id="form-penganggaran" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="penganggaran_id" value="">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-form-label">Nama Jalan</label>
                                    <select class="js-select2 form-control" id="field-jalan_id" name="jalan_id" style="width: 100%;" data-placeholder="Pilih Ruas Jalan..">
                                        <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                        @foreach ($jalan as $j)
                                            <option value="{{ $j->jalan_id }}">{{ $j->nama }}</option>
                                        @endforeach
                                    </select>
                                    <div id="error-jalan_id" class="text-danger font-size-sm"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Tujuan Penganggaran</label>
                                    <select class="form-control" name="tujuan" id="field-tujuan">
                                        <option value="">Pilih</option>
                                        <option value="jalan">Jalan</option>
                                        <option value="jembatan">Jembatan</option>
                                        <option value="TPT">TPT</option>
                                        <option value="drainase">Drainase</option>
                                    </select>
                                    <div id="error-tujuan" class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Perusahaan</label>
                                    <input type="text" class="form-control" id="field-perusahaan" name="perusahaan" placeholder="Masukan Nama Perusahaan">
                                    <div id="error-perusahaan" class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Nomor BAST (Berita Acara Serah Terima)</label>
                                    <input type="text" class="form-control" id="field-nomor_bast" name="nomor_bast" placeholder="Masukan Nomor BAST">
                                    <div id="error-nomor_bast" class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Jumlah Anggaran</label>
                                    <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    Rp.
                                                </span>
                                            </div>
                                        <input type="number" class="form-control" id="field-jml_anggaran" name="jml_anggaran" placeholder="Masukan Jumlah Anggaran">
                                    </div>
                                    <div id="error-jml_anggaran" class="text-danger font-size-sm"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Tanggal Penganggaran</label>
                                    <input type="text" class="form-control" id="field-tgl" name="tgl" placeholder="Masukan Tanggal Penganggaran" autocomplete="off">
                                    <div id="error-tgl" class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-alt-primary btn-block"><i class="si si-check mr-5"></i>Simpan</button>
                                </div>
                            </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
@push('scripts')
<script>
$(function () {
    $('#list-jalan').DataTable({
        processing: true,
        serverSide: true,
        ajax: "<?= route('penganggaran'); ?>",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'jalan',
                name: 'jalan'
            },
            {
                data: 'tujuan',
                name: 'tujuan'
            },
            {
                data: 'perusahaan',
                name: 'perusahaan'
            },
            {
                data: 'nomor_bast',
                name: 'nomor_bast'
            },
            {
                data: 'anggaran',
                name: 'anggaran'
            },
            {
                data: 'tgl',
                name: 'tgl'
            },
            // {
            //     data: 'action',
            //     name: 'action',
            //     orderable: false,
            //     searchable: false
            // },
        ]
    });
});
jQuery(document).ready(function () {

    $('#field-tgl').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        language: 'id',
        showMonthAfterYear: true
    });

    $(document).on('click', '#btn_tambah', function () {
        save_method = 'tambah';
        $('#form-penganggaran')[0].reset();
        $('#modal_title').text('Tambah Penganggaran Baru');
        $('#modal_form').modal({
            backdrop: 'static',
            keyboard: false
        })
    });

    $("#form-penganggaran").submit(function (e) {
        e.preventDefault();
        var formData = new FormData($('#form-penganggaran')[0]);

        var link;
        var pesan;
        if (save_method == 'tambah') {
            link = "<?= route('penganggaran.simpan'); ?>";
            pesan = "Data Jalan Baru Berhasil Ditambahkan";
        } else {
            link = laroute.route('penganggaran.update');
            pesan = "Data Jalan Berhasil Diperbaharui";
        }

        $.ajax({
            url: link,
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                $('.is-invalid').removeClass('is-invalid');
                if (response.fail == false) {
                    $('#modal_embed').modal('hide');
                    swal({
                        title: "Berhasil",
                        text: pesan,
                        timer: 3000,
                        buttons: false,
                        icon: 'success'
                    });
                    window.setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    for (control in response.errors) {
                        $('#field-' + control).addClass('is-invalid');
                        $('#error-' + control).html(response.errors[control]);
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
                $('#btnSimpan').text('Simpan');
                $('#btnSimpan').attr('disabled', false);

            }
        });
    });
});
function edit(id){
    save_method = 'update';
    $('#form-edit_pengguna')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();

    $.ajax({
        url : laroute.route('pengguna.edit', {id : id}),
        type: "GET",
        dataType: "JSON",
        success: function(response)
        {
            $('[name="edit_user_id"]').val(response.id);
            $('[name="edit_nip"]').val(response.nip);
            $('[name="edit_username"]').val(response.username);
            $('[name="edit_nama"]').val(response.nama);
            $('[name="edit_email"]').val(response.email);
            $('[name="edit_jabatan"]').val(response.jabatan);
            if(response.jabatan == 'admin-uptd')
            {
                $("#kol-edit_pasar").show();
                $("#field-edit_pasar").val(JSON.parse("["+response.pasar+"]")).trigger('change');
            }else{
                $("#kol-edit_pasar").hide();
            }
            $('#modal_edit').modal({
                backdrop: 'static',
                keyboard: false
            })
        },
        error: function (jqXHR, textStatus, errorThrown){
            alert('Error get data from ajax');
        }
    });
}
function hapus(id) {
    swal({
        title: "Anda Yakin?",
        text: "Data Yang Dihapus Tidak Akan Bisa Dikembalikan",
        icon: "warning",
        buttons: ["Batal", "Hapus"],
        dangerMode: true,
        closeOnClickOutside: false
    })
    .then((willDelete) => {
        if (willDelete) {
        $.ajax({
            url: laroute.route('pengguna.hapus', { id: id }),
            type: "get",
            dataType: "JSON",
            success: function(data) {
                swal({
                    title: "Berhasil",
                    text: "Data Pasar Berhasil Dihapus",
                    timer: 3000,
                    buttons: false,
                    icon: 'success',
                    allowOutsideClick: false
                });
                window.setTimeout(function(){
                    location.reload();
                } ,1500);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error deleting data');
            }
        });
        } else {
            window.setTimeout(function(){
                location.reload();
            } ,1500);
        }
    });
}
</script>
@endpush
