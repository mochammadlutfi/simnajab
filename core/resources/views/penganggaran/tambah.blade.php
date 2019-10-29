@extends('layouts.master')


@section('content')
<div class="content">
    <nav class="breadcrumb bg-white push">
        <a class="breadcrumb-item" href="{{ route('beranda') }}">Beranda</a>
        <a class="breadcrumb-item" href="{{ route('jalan') }}">Rute Jalan</a>
        <a class="breadcrumb-item" href="{{ route('jalan.detail', $jalan->jalan_id) }}">{{ $jalan->nama }}</a>
        <span class="breadcrumb-item active">Tambah Penganggaran</span>
    </nav>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Tambah <small>Data Penganggaran</small></h3>
        </div>
        <div class="block-content pb-15">
            <form id="form-penganggaran" class="form-horizontal">
                @csrf
                <input type="hidden" name="jalan_id" value="{{ $jalan->jalan_id }}">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Jenis</label>
                            <div class="col-9">
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="jenis" id="jenis_jalan" value="Jalan">
                                    <label class="custom-control-label" for="jenis_jalan">Jalan</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="jenis" id="jenis_jembatan" value="Jembatan">
                                    <label class="custom-control-label" for="jenis_jembatan">Jembatan</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="jenis" id="jenis_drainase" value="Drainase">
                                    <label class="custom-control-label" for="jenis_drainase">Drainase</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="jenis" id="jenis_tpt" value="TPT">
                                    <label class="custom-control-label" for="jenis_tpt">TPT</label>
                                </div>
                                <div id="error-jenis" class="text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group row" id="field-tujuan">
                            <label class="col-lg-3 col-form-label">Tujuan</label>
                            <div class="col-9">
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="tujuan" id="example-inline-radio1" value="Pemeliharaan">
                                    <label class="custom-control-label" for="example-inline-radio1">Pemeliharaan</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="tujuan" id="example-inline-radio2" value="Peningkatan">
                                    <label class="custom-control-label" for="example-inline-radio2">Peningkatan</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="tujuan" id="example-inline-radio3" value="Pembangunan">
                                    <label class="custom-control-label" for="example-inline-radio3">Pembangunan</label>
                                </div>
                                <div id="error-tujuan" class="text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Perusahaan</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="field-perusahaan" name="perusahaan" placeholder="Masukan Nama Perusahaan">
                                <div id="error-perusahaan" class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Nomor BAST (Berita Acara Serah Terima)</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="field-nomor_bast" name="nomor_bast" placeholder="Masukan Nomor BAST">
                                <div id="error-nomor_bast" class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Jumlah Anggaran</label>
                            <div class="col-lg-9">
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
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Tanggal Penganggaran</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" id="field-tgl" name="tgl" placeholder="Masukan Tanggal Penganggaran" autocomplete="off">
                                <div id="error-tgl" class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="form-group row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-alt-primary btn-block">
                                <i class="si si-check mr-5"></i>
                                Simpan & Lanjutkan
                            </button>
                        </div>
                    </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
@push('scripts')
<script>
jQuery(document).ready(function () {
    $("#input-ficons-5").fileinput();
    $('#field-tgl').datepicker({
        format: 'dd-mm-yyyy',
        startDate: 'today'
    });


    $("#form-penganggaran").submit(function (e) {
        e.preventDefault();
        var formData = new FormData($('#form-penganggaran')[0]);

        $.ajax({
            url: "{{ route('penganggaran.tambah', ['jalan_id', $jalan->jalan_id]) }}",
            type: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                $('.is-invalid').removeClass('is-invalid');
                if (response.fail == false) {
                    $('#modal_embed').modal('hide');
                    // swal({
                    //     title: "Berhasil",
                    //     text: "Berhasil data Berhasil Disimpan",
                    //     timer: 3000,
                    //     buttons: false,
                    //     icon: 'success'
                    // });
                    window.setTimeout(function(){
                        window.location = response.step2;
                    });
                } else {
                    if(response.jembatan == false)
                    {
                        swal({
                            title: "Jembatan Tidak Ditemukan",
                            text: "Silahkan Tambahkan Data Jembatan Terlebih Dahulu",
                            timer: 3000,
                            buttons: false,
                            icon: 'warning'
                        });
                    }

                    if(response.tpt == false)
                    {
                        swal({
                            title: "TPT Tidak Ditemukan",
                            text: "Silahkan Tambahkan Data Jembatan Terlebih Dahulu",
                            timer: 3000,
                            buttons: false,
                            icon: 'warning'
                        });
                    }

                    if(response.drainase == false)
                    {
                        swal({
                            title: "Drainase Tidak Ditemukan",
                            text: "Silahkan Tambahkan Data Drainase Terlebih Dahulu",
                            timer: 3000,
                            buttons: false,
                            icon: 'warning'
                        });
                    }
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
