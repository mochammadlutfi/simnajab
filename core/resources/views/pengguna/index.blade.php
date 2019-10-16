@extends('layouts.master')

@section('content')
<div class="content">
    <nav class="breadcrumb bg-white push">
        <a class="breadcrumb-item" href="{{ route('beranda') }}">Beranda</a>
        <span class="breadcrumb-item active">Pengguna</span>
    </nav>
    <div class="row">
        <div class="col-lg-12">
            <!-- Default Elements -->
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Kelola Data Pengguna</h3>
                    <button id="btn_tambah" type="button" class="btn btn-secondary mr-5 mb-5 float-right btn-rounded">
                        <i class="si si-plus mr-5"></i>
                        Tambah Pengguna Baru
                    </button>
                </div>
                <div class="block-content">
                    <table class="table table-hover table-striped" id="list_user">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIP</th>
                                <th>Nama Lengkap</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Jabatan</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <!-- END Default Elements -->
        </div>
    </div>
</div>
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
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
                    <form id="form_pengguna" class="form-horizontal">
                        @csrf
                        <input type="hidden" value="" name="user_id"/>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">NIP</label>
                                    <input type="text" class="form-control" name="nip" id="field-nip" placeholder="Masukan NIP">
                                    <span id="error-nip" class="invalid-feedback"></span>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama" id="field-nama" placeholder="Masukan Nama Lengkap">
                                    <span id="error-nama" class="invalid-feedback"></span>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Username</label>
                                    <input type="text" class="form-control" name="username" id="field-username" placeholder="Masukan Username">
                                    <span id="error-username" class="invalid-feedback"></span>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Alamat Email</label>
                                    <input type="email" class="form-control" name="email" id="field-email" placeholder="Masukan Alamat Email">
                                    <span id="error-email" class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Password</label>
                                    <input type="password" class="form-control" name="password" id="field-password" placeholder="Masukan Password">
                                    <span id="error-password" class="invalid-feedback"></span>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Konfirmasi Password</label>
                                    <input type="password" class="form-control" name="konf_password" id="field-konf_password" placeholder="Masukan Konfirmasi Password">
                                    <span id="error-konf_password" class="invalid-feedback"></span>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Jabatan</label>
                                    <select class="form-control" name="jabatan" id="field-jabatan">
                                        <option value="">Pilih</option>
                                        <option value="admin-uptd">Admin UPTD</option>
                                        <option value="admin-dinas">Admin Dinas</option>
                                        <option value="kepala-dinas">Kepala Dinas</option>
                                    </select>
                                    <span id="error-jabatan" class="invalid-feedback"></span>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Status</label>
                                    <select class="form-control" name="status" id="field-status">
                                        <option value="">Pilih</option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
                                    <span id="error-status" class="invalid-feedback"></span>
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
<div class="modal fade" id="modal_edit" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="block block-transparent mb-0">
                <div class="block-header bg-alt-secondary">
                    <h3 class="block-title">Perbaharui Pengguna</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <form id="form-edit_pengguna" class="form-horizontal">
                        @csrf
                        <input type="hidden" value="" name="edit_user_id"/>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">NIP</label>
                                    <input type="text" class="form-control" name="edit_nip" id="field-edit_nip" placeholder="Masukan NIP">
                                    <span id="error-edit_nip" class="invalid-feedback"></span>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="edit_nama" id="field-edit_nama" placeholder="Masukan Nama Lengkap">
                                    <span id="error-edit_nama" class="invalid-feedback"></span>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Username</label>
                                    <input type="text" class="form-control" name="edit_username" id="field-edit_username" placeholder="Masukan Username">
                                    <span id="error-edit_username" class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-form-label">Alamat Email</label>
                                    <input type="email" class="form-control" name="edit_email" id="field-edit_email" placeholder="Masukan Alamat Email">
                                    <span id="error-edit_email" class="invalid-feedback"></span>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Jabatan</label>
                                    <select class="form-control" name="edit_jabatan" id="field-edit_jabatan">
                                        <option value="">Pilih</option>
                                        <option value="admin">Super Admin</option>
                                        <option value="admin-uptd">Admin UPTD</option>
                                        <option value="admin-dinas">Admin Dinas</option>
                                        <option value="kepala-dinas">Kepala Dinas</option>
                                    </select>
                                    <span id="error-edit_jabatan" class="invalid-feedback"></span>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Status</label>
                                    <select class="form-control" name="edit_status" id="field-edit_status">
                                        <option value="">Pilih</option>
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
                                    <span id="error-edit_status" class="invalid-feedback"></span>
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
    $('#list_user').DataTable({
        processing: true,
        serverSide: true,
        ajax: "<?= route('pengguna'); ?>",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'nip',
                name: 'nip'
            },
            {
                data: 'nama',
                name: 'nama'
            },
            {
                data: 'username',
                name: 'username'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'jabatan',
                name: 'jabatan'
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
        $('#form_pengguna')[0].reset();
        $('#modal_title').text('Tambah Pengguna Baru');
        $('#modal_form').modal({
            backdrop: 'static',
            keyboard: false
        })
    });

    $("#form_pengguna").submit(function (e) {
        e.preventDefault();
        var formData = new FormData($('#form_pengguna')[0]);

        var link;
        var pesan;
        if (save_method == 'tambah') {
            link = "<?= route('pengguna.simpan'); ?>";
            pesan = "Pengguna Baru Berhasil Ditambahkan";
        } else {
            link = laroute.route('pengguna.update');
            pesan = "Pengguna Berhasil Diperbaharui";
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

    $("#form-edit_pengguna").submit(function (e) {
        e.preventDefault();
        var formData = new FormData($('#form-edit_pengguna')[0]);
        $.ajax({
            url: laroute.route('pengguna.update'),
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
                        text: "Pengguna Berhasil Diperbaharui",
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
