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
            <table class="table table-hover table-striped" id="list-jalan" style="font-size:12px">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Ruas Jalan</th>
                        <th>Panjang</th>
                        <th>Lebar</th>
                        <th>Penganggaran Tahun Ini</th>
                        <th>Penganggaran Terakhir</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
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
                data: 'ang_tahun',
                name: 'ang_tahun'
            },
            {
                data: 'ang_last',
                name: 'ang_last'
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
    var url = '{{ route("jalan.hapus", ":id") }}';
    url = url.replace(':id', id);
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
            url: url,
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
