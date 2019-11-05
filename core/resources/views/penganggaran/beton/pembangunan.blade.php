@extends('layouts.master')


@section('content')
<div class="content">
    <nav class="breadcrumb bg-white push">
        <a class="breadcrumb-item" href="{{ route('beranda') }}">Beranda</a>
        <a class="breadcrumb-item" href="{{ route('jalan') }}">Rute Jalan</a>
        <a class="breadcrumb-item" href="{{ route('jalan.detail', $jalan->jalan_id) }}">{{ $jalan->nama }}</a>
        <span class="breadcrumb-item active">Tambah Data Flat Beton</span>
    </nav>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Tambah Data Flat Beton <small>{{ $jalan->nama }}</small></h3>
        </div>
        <div class="block-content pb-15">
            <form id="form-beton" class="form-horizontal" onsubmit="return false;">
                <input type="hidden" name="jalan_id" value="{{ $jalan->jalan_id }}">
                <input type="hidden" name="lat_awal" id="lat_awal" value="">
                <input type="hidden" name="long_awal" id="long_awal" value="">
                <input type="hidden" name="lat_akhir" id="lat_akhir" value="">
                <input type="hidden" name="long_akhir" id="long_akhir" value="">
                <input type="hidden" class="form-control" name="longlat1" id="field-longlat1">
                <input type="hidden" class="form-control" name="longlat2" id="field-longlat2">
                <input type="hidden" class="form-control" id="polypath" name="polypath">
                @csrf
                <div class="row">
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-form-label">Kondisi Flat Beton</label>
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
                                    <label class="col-form-label">Keterangan Tambahan (Jika Ada)</label>
                                    <textarea class="form-control" name="keterangan" placeholder="Masukan Keterangan Tambahan" rows="10"></textarea>
                                    <div id="error-longlat2" class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Upload Dokumen</label>
                                    <input id="field-berkas" name="files[]" type="file" class="file" data-preview-file-type="text" multiple>
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
                    </div>
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="col-form-label">Panjang Flat Beton</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="field-panjang" name="panjang" placeholder="Panjang Flat Beton" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                Meter
                                            </span>
                                        </div>
                                    </div>
                                    <div id="error-panjang" class="text-danger font-size-sm"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="col-form-label">Patok Awal Flat Beton</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="field-patok_awal" name="patok_awal" placeholder="Patok Awal Flat Beton" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                Meter
                                            </span>
                                        </div>
                                    </div>
                                    <div id="error-patok_awal" class="text-danger font-size-sm"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="col-form-label">Patok Akhir Flat Beton</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="field-patok_akhir" name="patok_akhir" placeholder="Patok Awal Flat Beton" readonly>
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                Meter
                                            </span>
                                        </div>
                                    </div>
                                    <div id="error-patok_akhir" class="text-danger font-size-sm"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                {!! $map['html'] !!}
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
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/0.10.0/lodash.min.js"></script>
<script src="https://underscorejs.org/underscore-min.js"></script>
<script>
jQuery(document).ready(function () {

    $("#form-beton").submit(function (e) {
        e.preventDefault();
        var formData = new FormData($('#form-beton')[0]);

        $.ajax({
            url: "{{ route('beton.simpan') }}",
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
                        text: "Data Flat Beton Berhasil Disimpan",
                        timer: 3000,
                        buttons: false,
                        icon: 'success'
                    });
                    window.setTimeout(function () {
                        window.location = response.url;
                    }, 100);
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
longlat2 = document.querySelector('#field-longlat2');
polypath = document.querySelector('#polypath');
lat_awal = document.querySelector('#lat_awal');
long_awal = document.querySelector('#long_awal');
lat_akhir = document.querySelector('#lat_akhir');
long_akhir = document.querySelector('#long_akhir');
pj_jalan = document.querySelector('#field-panjang');
patok_awal =  document.querySelector('#field-patok_awal');
patok_akhir = document.querySelector('#field-patok_akhir');
function find_closest_point_on_path(drop_pt,path_pts)
{
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
    return (typeof [distance_keys[_.min(distances)]+1] === 'undefined')?path_pts[distance_keys[_.min(distances)]]:path_pts[distance_keys[_.min(distances)]+1];
    if (typeof(Number.prototype.toRad) === "undefined") {
      Number.prototype.toRad = function() {
        return this * Math.PI / 180;
      }
    }
}
function tampilRute(origin, destination, service, display) {
    // alert(origin);
    directionsDisplay.setOptions({
      polylineOptions: {
        strokeColor: '#2cfd2c'
      }
    });
    service.route({
        origin: origin,
        destination: destination,
        travelMode: google.maps.TravelMode.DRIVING,
    }, function(response, status) {
        if (status === 'OK') {
        marker_0.setVisible(false);
        marker_1.setVisible(false);

        directionsDisplay.setDirections(response);
        } else {
        alert('Could not display directions due to: ' + status);
        }
    });
    // alert('asoo');
}


function convert_rad(datanya)
{
    return datanya * Math.PI / 180;
}

function hitung_jarak(p1, p2)
{
    var R = 6378137;
    var dLat = convert_rad(p2.lat() - p1.lat());
    var dLong = convert_rad(p2.lng() - p1.lng());
    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(convert_rad(p1.lat())) * Math.cos(convert_rad(p2.lat())) *
        Math.sin(dLong / 2) * Math.sin(dLong / 2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    var d = R * c;
    // patok_awal.value = d.toFixed();
    return d.toFixed();
    if (typeof(Number.prototype.toRad) === "undefined") {
      Number.prototype.toRad = function() {
        return this * Math.PI / 180;
      }
    }
}

function computeTotalDistance(result) {
    var total = 0;
    var polyline = new google.maps.Polyline({
        path: [],
        strokeColor: '#F2262E',
        strokeWeight: 0,
    });
    var bounds = new google.maps.LatLngBounds();

    var myroute = result.routes[0];
    for (var i = 0; i < myroute.legs.length; i++) {
        total += myroute.legs[i].distance.value;
        // coba = myroute.legs[0].start_location;
        var steps = myroute.legs[i].steps;
        for (j = 0; j < steps.length; j++) {
            var nextSegment = steps[j].path;
            for (k = 0; k < nextSegment.length; k++) {
                polyline.getPath().push(nextSegment[k]);
                bounds.extend(nextSegment[k]);
            }
        }
    }
    pj_jalan.value = total;
    polyline.setMap(map);
    polypath.value = polyline.getPath().getArray().toString();
}
</script>
{!! $map['js'] !!}
<script>
    var start_jalan = new google.maps.LatLng('{{ $jalan->lat_awal }}', '{{ $jalan->lng_awal }}');
</script>
@endpush
