@extends('layouts.master')


@section('content')
<div class="content">
    <nav class="breadcrumb bg-white push">
        <a class="breadcrumb-item" href="{{ route('beranda') }}">Beranda</a>
        <span class="breadcrumb-item active">Jalan</span>
    </nav>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Tambah <small>Data Jalan</small></h3>
        </div>
        <div class="block-content pb-15">
            <div class="row">
                <div class="col-lg-4">
                    <form id="form-jalan" class="form-horizontal" onsubmit="return false;">
                        <input type="hidden" name="jalan_id" value="">
                        <input type="hidden" name="lat_awal" id="lat_awal" value="">
                        <input type="hidden" name="long_awal" id="long_awal" value="">
                        <input type="hidden" name="lat_akhir" id="lat_akhir" value="">
                        <input type="hidden" name="long_akhir" id="long_akhir" value="">
                        <input type="hidden" class="form-control" id="polypath" name="polypath">
                        <input type="hidden" class="form-control" name="longlat1" id="field-longlat1">
                        <input type="hidden" class="form-control" name="longlat2" id="field-longlat2">
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
                                        <option value="rusak parah">Rusak Parah</option>
                                    </select>
                                    <div id="error-kondisi" class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">NJOP Jalan</label>
                                    <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    Rp.
                                                </span>
                                            </div>
                                        <input type="number" class="form-control" id="field-jml_anggaran" name="jml_anggaran" placeholder="Masukan Jumlah Anggaran">
                                    </div>
                                    <div id="error-jml_anggaran" class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Keterangan Tambahan</label>
                                    <textarea class="form-control" name="keterangan" rows="4"></textarea>
                                    <div id="error-keterangan" class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">

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
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="map-canvas" style="height: 500px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@push('scripts')
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCeQBvgWWU9QI4ca0E8vB3XEPr11rOGv7k&libraries=places&callback=initmaps"></script>
<script src="{{ asset('assets/js/jalan_tambah.js') }}"></script>
<script>
jQuery(document).ready(function () {

    $("#form-jalan").submit(function (e) {
        e.preventDefault();
        var formData = new FormData($('#form-jalan')[0]);

        $.ajax({
            url: "{{ route('jalan.tambah') }}",
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
                        text: "Berhasil data Berhasil Disimpan",
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
