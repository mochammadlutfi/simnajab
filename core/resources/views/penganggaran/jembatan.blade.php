@extends('layouts.master')


@section('content')
<div class="content">
    <nav class="breadcrumb bg-white push">
        <a class="breadcrumb-item" href="{{ route('beranda') }}">Beranda</a>
        <a class="breadcrumb-item" href="{{ route('jalan') }}">Rute Jalan</a>
        <a class="breadcrumb-item" href="{{ route('jalan.detail', $jalan->jalan_id) }}">{{ $jalan->nama }}</a>
        <span class="breadcrumb-item active">Tambah Data Jembatan</span>
    </nav>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Tambah Data Jembatan <small>{{ $jalan->nama }}</small></h3>
        </div>
        <div class="block-content pb-15">
            <div class="row">
                <div class="col-lg-4">
                    <form id="form-jembatan" class="form-horizontal" onsubmit="return false;">
                        <input type="hidden" name="jalan_id" value="{{ $jalan->jalan_id }}">
                        <input type="hidden" name="lat_awal" id="lat_awal" value="">
                        <input type="hidden" name="long_awal" id="long_awal" value="">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-form-label">Nama Jalan</label>
                                    <input type="text" class="form-control" name="nama" id="field-nama" placeholder="Masukan Nama Jembatan">
                                    <div id="error-nama" class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Panjang Jembatan</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="field-panjang" name="panjang" placeholder="Panjang Jembatan">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                Meter
                                            </span>
                                        </div>
                                    </div>
                                    <div id="error-panjang" class="text-danger font-size-sm"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Koordinat Jembatan</label>
                                    <input type="text" class="form-control" name="longlat1" id="field-longlat1" readonly>
                                    <div id="error-longlat2" class="invalid-feedback"></div>
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
                            {!! $map['html'] !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@push('scripts')
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/0.10.0/lodash.min.js"></script>
<script src="https://underscorejs.org/underscore-min.js"></script>
<script>
jQuery(document).ready(function () {

    $("#form-jembatan").submit(function (e) {
        e.preventDefault();
        var formData = new FormData($('#form-jembatan')[0]);

        $.ajax({
            url: "{{ route('jembatan.simpan') }}",
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
                        text: "Data Jembatan Berhasil Disimpan",
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

longlat1 = document.querySelector('#field-longlat1');
lat_awal = document.querySelector('#lat_awal');
long_awal = document.querySelector('#long_awal');
function find_closest_point_on_path(drop_pt,path_pts){
    var distances = new Array();
    var distance_keys = new Array();

    //For each point on the path
    $.each(path_pts,function(key, path_pt){
        //Find the distance in a linear crows-flight line between the marker point and the current path point
        var R = 6371; // km
        var dLat1 = (path_pt.lat()-drop_pt.lat());
        var dLon1 = (path_pt.lng()-drop_pt.lng());
        var dLat = convert_rad(dLat1);
        var dLon = convert_rad(dLon1);
        var lat1 = convert_rad(drop_pt.lat());
        var lat2 = convert_rad(path_pt.lat());

        var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        var d = R * c;
        //Store the distances and the key of the pt that matches that distance
        distances[key] = d;
        distance_keys[d] = key;
        // console.log(distances);
    });
    //Return the latLng obj of the second closest point to the markers drag origin. If this point doesn't exist snap it to the actual closest point as this should always exist
    return (typeof path_pts[distance_keys[_.min(distances)]+1] === 'undefined')?path_pts[distance_keys[_.min(distances)]]:path_pts[distance_keys[_.min(distances)]+1];
    if (typeof(Number.prototype.toRad) === "undefined") {
      Number.prototype.toRad = function() {
        return this * Math.PI / 180;
      }
    }
    function convert_rad(datanya)
    {
        return datanya * Math.PI / 180;
    }
}
</script>
{!! $map['js'] !!}
@endpush
