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
                        <div class="form-group row" id="jenis-penganggaran">
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
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="jenis" id="jenis_beton" value="Beton">
                                    <label class="custom-control-label" for="jenis_beton">Flat Beton</label>
                                </div>
                                <div id="error-jenis" class="text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group row" id="field-tujuan">
                            <label class="col-lg-3 col-form-label">Tujuan</label>
                            <div class="col-9">
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="tujuan" id="tujuan_pemeliharaan" value="Pemeliharaan">
                                    <label class="custom-control-label" for="tujuan_pemeliharaan">Pemeliharaan</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline mb-5">
                                    <input class="custom-control-input" type="radio" name="tujuan" id="tujuan_peningkatan" value="Peningkatan">
                                    <label class="custom-control-label" for="tujuan_peningkatan">Peningkatan</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline mb-5" id="field-pembangunan">
                                    <input class="custom-control-input" type="radio" name="tujuan" id="tujuan_pembangunan" value="Pembangunan">
                                    <label class="custom-control-label" for="tujuan_pembangunan">Pembangunan</label>
                                </div>
                                <div id="error-tujuan" class="text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group row" id="pilih_penganggaran" style="display:none;">
                            <label class="col-lg-3 col-form-label" id="label-penganggaran"></label>
                            <div class="col-lg-9">
                                <select class="form-control" name="penganggaran" id="field-penganggaran">
                                    <option value="">Pilih</option>
                                </select>
                                <div id="error-perusahaan" class="invalid-feedback"></div>
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
                            <label class="col-lg-3 col-form-label">Sumber Anggaran</label>
                            <div class="col-lg-9">
                                <select class="form-control" name="sumber" id="field-sumber">
                                    <option value="">Pilih</option>
                                    <option value="APBD Kabupaten">APBD Kabupaten</option>
                                    <option value="APBD Provinsi">APBD Provinsi</option>
                                    <option value="DAK">DAK (Dana Alokasi Khusus)</option>
                                    <option value="CSR">CSR (Corporate Sosial Responsibility)</option>
                                </select>
                                <div id="error-sumber" class="invalid-feedback"></div>
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
var jenis;
jQuery(document).ready(function () {
    $("#input-ficons-5").fileinput();
    $('#field-tgl').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
    });

    $('#jenis-penganggaran').change(function(){
        jenis = $("input[name='jenis']:checked").val();
        if(jenis === 'Jalan')
        {
            $('#field-pembangunan').hide();
        }else{
            $('#field-pembangunan').show();
        }
    });

    $('#field-tujuan').change(function(){
        var tujuan = $("input[name='tujuan']:checked").val();
        var _token = $('input[name="_token"]').val();
        if(jenis !== 'Jalan' && tujuan !== 'Pembangunan')
        {
            if(jenis === 'Jembatan')
            {
                $('#label-penganggaran').html('Pilih Jembatan');
                $.ajax({
                    url: "{{ route('penganggaran.json', $jalan->jalan_id) }}",
                    method: "POST",
                    data: {
                        tujuan: tujuan,
                        jenis: jenis,
                        _token: _token,
                    },
                    success: function (result) {
                        $('#pilih_penganggaran').show();
                        $('#field-penganggaran').html(result);
                    }
                })
            }else if(jenis === 'Drainase'){
                $('#label-penganggaran').html('Pilih Drainase');
                $.ajax({
                    url: "{{ route('penganggaran.json', $jalan->jalan_id) }}",
                    method: "POST",
                    data: {
                        tujuan: tujuan,
                        jenis: jenis,
                        _token: _token,
                    },
                    success: function (result) {
                        $('#pilih_penganggaran').show();
                        $('#field-penganggaran').html(result);
                    }
                })
            }else if(jenis === 'TPT'){
                $('#label-penganggaran').html('Pilih TPT');
                // $('#pilih_penganggaran').show();
                $.ajax({
                    url: "{{ route('penganggaran.json', $jalan->jalan_id) }}",
                    method: "POST",
                    data: {
                        tujuan: tujuan,
                        jenis: jenis,
                        _token: _token,
                    },
                    success: function (result) {
                        $('#pilih_penganggaran').show();
                        $('#field-penganggaran').html(result);
                    }
                })
            }else if(jenis === 'Beton'){
                $('#label-penganggaran').html('Pilih Beton');
            //     $('#pilih_penganggaran').show();
                $.ajax({
                    url: "{{ route('penganggaran.json', $jalan->jalan_id) }}",
                    method: "POST",
                    data: {
                        tujuan: tujuan,
                        jenis: jenis,
                        _token: _token,
                    },
                    success: function (result) {
                        $('#pilih_penganggaran').show();
                        $('#field-penganggaran').html(result);
                    }
                })
            }
        }else{
            $('#pilih_penganggaran').hide();
        }
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
