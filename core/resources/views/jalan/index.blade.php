@extends('layouts.master')


@section('content')
<div class="content">
    <nav class="breadcrumb bg-white push">
        <a class="breadcrumb-item" href="{{ route('beranda') }}">Beranda</a>
        <span class="breadcrumb-item active">Data Jalan</span>
    </nav>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Kelola <small>Data Jalan</small></h3>
            @role('admin')
                <a href="{{ route('jalan.tambah') }}" class="btn btn-secondary mr-5 mb-5 float-right btn-rounded">
                    <i class="si si-plus mr-5"></i>
                    Tambah Jalan Baru
                </a>
            @endrole
        </div>
        <div class="block-content">
            <table class="table table-hover table-striped" id="list-jalan">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Ruas Jalan</th>
                        <th>Panjang</th>
                        <th>Lebar</th>
                        <th>Kondisi</th>
                        <th></th>
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
            <div class="block block-transparent mb-0">
                <div class="block-header bg-alt-secondary">
                    <h3 class="block-title" id="modal_title">Form Title</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <form id="form-jalan" class="form-horizontal">
                        <input type="hidden" name="jalan_id" value="">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-form-label">Nama Jalan</label>
                                    <input type="text" class="form-control" name="nama" id="field-nama" placeholder="Masukan Nama Ruas Jalan">
                                    <div id="error-nama" class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Panjang</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="field-panjang" name="panjang" placeholder="Masukan Panjang Jalan">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                Meter
                                            </span>
                                        </div>
                                    </div>
                                    <div id="error-panjang" class="text-danger font-size-sm"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Lebar</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="field-lebar" name="lebar" placeholder="Masukan Lebar Jalan">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                Meter
                                            </span>
                                        </div>
                                    </div>
                                    <div id="error-lebar" class="text-danger font-size-sm"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Kondisi Jalan</label>
                                    <select class="form-control" name="kondisi" id="field-kondisi">
                                        <option value="">Pilih</option>
                                        <option value="baik">Baik</option>
                                        <option value="sedang">Sedang</option>
                                        <option value="rusak ringan">Rusak Ringan</option>
                                        <option value="rusak parah">Rusak Ringan</option>
                                    </select>
                                    <div id="error-kondisi" class="invalid-feedback"></div>
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
        ajax: "<?= route('jalan'); ?>",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'nama',
                name: 'nama'
            },
            {
                data: 'panjang',
                name: 'panjang'
            },
            {
                data: 'lebar',
                name: 'lebar'
            },
            {
                data: 'kondisi',
                name: 'kondisi'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });
});
jQuery(document).ready(function () {

    $(document).on('click', '#btn_tambah', function () {
        save_method = 'tambah';
        $('#form-jalan')[0].reset();
        $('#modal_title').text('Tambah Data Jalan Baru');
        $('#modal_form').modal({
            backdrop: 'static',
            keyboard: false
        })
    });

    $("#form-jalan").submit(function (e) {
        e.preventDefault();
        var formData = new FormData($('#form-jalan')[0]);

        var link;
        var pesan;
        if (save_method == 'tambah') {
            link = "<?= route('jalan.simpan'); ?>";
            pesan = "Data Jalan Baru Berhasil Ditambahkan";
        } else {
            link = laroute.route('jalan.update');
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
    $('#form-jalan')[0].reset();
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();

    $.ajax({
        url : laroute.route('jalan.edit', {id : id}),
        type: "GET",
        dataType: "JSON",
        success: function(response)
        {
            $('[name="jalan_id"]').val(response.jalan_id);
            $('[name="nama"]').val(response.nama);
            $('[name="panjang"]').val(response.panjang);
            $('[name="lebar"]').val(response.lebar);
            $('[name="kondisi"]').val(response.kondisi);
            $('#modal_title').text('Perbaharui Data Jalan');
            $('#modal_form').modal({
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
            url: laroute.route('jalan.hapus', { id: id }),
            type: "get",
            dataType: "JSON",
            success: function(data) {
                swal({
                    title: "Berhasil",
                    text: "Data Jalan Berhasil Dihapus",
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
