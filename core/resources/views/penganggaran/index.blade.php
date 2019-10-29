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
        </div>
        <div class="block-content">
            <table class="table table-hover table-striped" id="list-jalan">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Ruas Jalan</th>
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
                data: 'jenis',
                name: 'jenis'
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
function detail(id) {
    var url = '{{ route("penganggaran.detail", ":id") }}';
    url = url.replace(':id', id);
    document.location.href=url;
}
</script>
@endpush
