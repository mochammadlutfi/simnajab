@extends('layouts.master')

@section('content')
<div class="content">
    <nav class="breadcrumb bg-white push">
        <a class="breadcrumb-item" href="{{ route('beranda') }}">Beranda</a>
        <span class="breadcrumb-item active">Pengaturan</span>
    </nav>
    <div class="row">
        <div class="col-lg-12">
            <div class="block">
                <ul class="nav nav-tabs nav-tabs-alt" data-toggle="tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#info-umum">Informasi Umum</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#ubah-kata-sandi">Ubah Kata Sandi</a>
                    </li>
                </ul>
                <div class="block-content tab-content pb-30">
                    <div class="tab-pane active" id="info-umum" role="tabpanel">
                        <div class="row justify-content-center">
                            <div class="col-lg-10">
                                <form id="form-pengaturan" method="post" onsubmit="return false;">
                                    <input type="hidden" name="user_id" value="">
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" >NIP</label>
                                        <div class="col-lg-8">
                                            <input type="text" id="field-nip" name="nip" class="form-control" placeholder="Masukan NIP" value="{{ Auth::user()->nip }}">
                                            <span id="error-nip" class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" >Nama Lengkap</label>
                                        <div class="col-lg-8">
                                            <input type="text" id="field-nama" name="nama" class="form-control" placeholder="Masukan Nama Lengkap" value="{{ Auth::user()->nama }}">
                                            <span id="error-nama" class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" >Username</label>
                                        <div class="col-lg-8">
                                            <input type="text" id="field-username" name="username" class="form-control" placeholder="Masukan Username" value="{{ Auth::user()->username }}">
                                            <span id="error-username" class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                     <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" >Alamat Email</label>
                                        <div class="col-lg-8">
                                            <input type="email" id="field-email" name="email" class="form-control" name="email" value="{{ Auth::user()->email }}"  placeholder="Alamat Email">
                                            <span id="error-email" class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-lg-10">
                                            <button type="submit" class="btn bg-gd-sea text-white btn-block">Simpan Perubahan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="ubah-kata-sandi" role="tabpanel">
                        <div class="row justify-content-center">
                            <div class="col-lg-10">
                                <form id="form-ubah_pw" method="post" onsubmit="return false;">
                                  <input hidden type="email" name="email" value="">
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" >Kata Sandi Lama</label>
                                        <div class="col-lg-8">
                                            <input type="password" id="field-pw_lama" class="form-control" name="pw_lama"  placeholder="Kata Sandi Lama">
                                            <span id="error-pw_lama" class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                     <div class="form-group row">
                                        <label class="col-lg-4 col-form-label">Kata Sandi Baru</label>
                                        <div class="col-lg-8">
                                            <input type="password" id="field-pw_baru" class="form-control" name="pw_baru" placeholder="Kata Sandi Baru">
                                            <span id="error-pw_baru" class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label">Konfirmasi Kata Sandi Baru</label>
                                        <div class="col-lg-8">
                                            <input type="password" id="field-konf_pw_baru" class="form-control" name="konf_pw_baru" placeholder="Konfirmasi Kata Sandi Baru">
                                            <span id="error-konf_pw_baru" class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-lg-10">
                                            <button type="submit" class="btn bg-gd-sea text-white btn-block">Simpan Perubahan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@push('scripts')
<script>
var url = document.location.toString();
if (url.match('#')) {
    $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
}

// Change hash for page-reload
$('.nav-tabs a').on('shown.bs.tab', function (e) {
    window.location.hash = e.target.hash;
})
jQuery(document).ready(function () {
    $("#form-pengaturan").submit(function (e) {
        e.preventDefault();
        var formData = new FormData($('#form-pengaturan')[0]);
        $.ajax({
            url: "<?= route('pengaturan'); ?>",
            type: 'POST',
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
                        text: "Profil Berhasil Diperbaharui",
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

    $("#form-ubah_pw").submit(function (e) {
        e.preventDefault();
        var formData = new FormData($('#form-ubah_pw')[0]);
        $.ajax({
            url: "<?= route('ubah_pw'); ?>",
            type: 'POST',
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
                        text: "Profil Berhasil Diperbaharui",
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
</script>
@endpush
