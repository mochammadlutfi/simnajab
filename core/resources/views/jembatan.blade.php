@extends('layouts.master')


@section('content')
<div class="content">
    <nav class="breadcrumb bg-white push">
        <a class="breadcrumb-item" href="{{ route('beranda') }}">Beranda</a>
        <span class="breadcrumb-item active">Jembatan</span>
    </nav>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Kelola <small>Data Jembatan</small></h3>
            @role('admin')
                <button id="btn_tambah" type="button" class="btn btn-secondary mr-5 mb-5 float-right btn-rounded">
                    <i class="si si-plus mr-5"></i>
                    Tambah Jembatan Baru
                </button>
            @endrole
        </div>
        <div class="block-content">
            <table class="table table-hover table-striped" id="list-jembatan">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Ruas Jalan</th>
                        <th>Kondisi</th>
                        <th>Terakhir Diperbaharui</th>
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
                    <form id="form-jembatan" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="jembatan_id" value="">
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
                                    <label class="col-form-label">Kondisi Jalan</label>
                                    <select class="form-control" name="kondisi" id="field-kondisi">
                                        <option value="">Pilih</option>
                                        <option value="baik">Baik</option>
                                        <option value="sedang">Sedang</option>
                                        <option value="rusak ringan">Rusak Ringan</option>
                                        <option value="rusak parah">Rusak Parah</option>
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
    $('#list-jembatan').DataTable({
        processing: true,
        serverSide: true,
        ajax: "<?= route('jembatan'); ?>",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'jalan',
                name: 'jalan'
            },
            {
                data: 'kondisi',
                name: 'kondisi'
            },
            {
                data: 'tgl',
                name: 'tgl'
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
        $('#form-jembatan')[0].reset();
        $('#modal_title').text('Tambah Data Jembatan Baru');
        $('#modal_form').modal({
            backdrop: 'static',
            keyboard: false
        })
    });

    $("#form-jembatan").submit(function (e) {
        e.preventDefault();
        var formData = new FormData($('#form-jembatan')[0]);

        var link;
        var pesan;
        if (save_method == 'tambah') {
            link = "<?= route('jembatan.simpan'); ?>";
            pesan = "Data Jembatan Baru Berhasil Ditambahkan";
        } else {
            link = laroute.route('jembatan.update');
            pesan = "Data Jembatan Berhasil Diperbaharui";
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
    $('#form-jembatan')[0].reset();
    $('.form-group').removeClass('is-invalid');
    $('.help-block').empty();

    $.ajax({
        url : laroute.route('jembatan.edit', {id : id}),
        type: "GET",
        dataType: "JSON",
        success: function(response)
        {
            $('[name="jembatan_id"]').val(response.jembatan_id);
            $('#field-jalan_id').val(response.jalan_id).trigger('change');
            $('[name="kondisi"]').val(response.kondisi);
            $('#modal_title').text('Perbaharui Data Jembatan');
            $('#modal_form').modal({
                backdrop: 'static',
                keyboard: false
            });
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
            url: laroute.route('jembatan.hapus', { id: id }),
            type: "get",
            dataType: "JSON",
            success: function(data) {
                swal({
                    title: "Berhasil",
                    text: "Data Jembatan Berhasil Dihapus",
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
