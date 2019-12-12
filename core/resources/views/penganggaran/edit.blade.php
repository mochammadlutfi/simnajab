@extends('layouts.master')


@section('content')
<div class="content">
    <nav class="breadcrumb bg-white push">
        <a class="breadcrumb-item" href="{{ route('beranda') }}">Beranda</a>
        <a class="breadcrumb-item" href="{{ route('jalan') }}">Rute Jalan</a>
        <a class="breadcrumb-item" href="{{ route('jalan.detail', $jalan->jalan_id) }}">{{ $jalan->nama }}</a>
        <span class="breadcrumb-item active">Perbaharui Data Penganggaran</span>
    </nav>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Perbaharui <small>Data Penganggaran</small></h3>
        </div>
        <div class="block-content pb-15">
            <form id="form-penganggaran" class="form-horizontal">
                @csrf
                <input type="hidden" name="jalan_id" value="{{ $jalan->jalan_id }}">
                <input type="hidden" name="penganggaran_id" value="{{ $a->id }}">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label class="col-form-label">Perusahaan</label>
                                <input type="text" class="form-control" id="field-perusahaan" name="perusahaan" placeholder="Masukan Nama Perusahaan" value="{{ $a->perusahaan }}">
                                <div id="error-perusahaan" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Nomor BAST (Berita Acara Serah Terima)</label>
                                <input type="text" class="form-control" id="field-nomor_bast" name="nomor_bast" placeholder="Masukan Nomor BAST" value="{{ $a->nomor_bast }}">
                                <div id="error-nomor_bast" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Jumlah Anggaran</label>
                            <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            Rp.
                                        </span>
                                    </div>
                                <input type="number" class="form-control" id="field-jml_anggaran" name="jml_anggaran" placeholder="Masukan Jumlah Anggaran" value="{{ $a->jml_anggaran }}">
                            </div>
                            <div id="error-jml_anggaran" class="text-danger font-size-sm"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Sumber Anggaran</label>
                            <select class="form-control" name="sumber" id="field-sumber">
                                <option value="">Pilih</option>
                                <option <?php if($a->sumber == 'APBD Kabupaten'){ echo 'selected="selected"'; } ?> value="APBD Kabupaten">APBD Kabupaten</option>
                                <option <?php if($a->sumber == 'APBD Provinsi'){ echo 'selected="selected"'; } ?>  value="APBD Provinsi">APBD Provinsi</option>
                                <option <?php if($a->sumber == 'DAK'){ echo 'selected="selected"'; } ?> value="DAK">DAK (Dana Alokasi Khusus)</option>
                                <option <?php if($a->sumber == 'CSR'){ echo 'selected="selected"'; } ?> value="CSR">CSR (Corporate Sosial Responsibility)</option>
                            </select>
                            <div id="error-sumber" class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label class="col-form-label">Tanggal Penganggaran</label>
                            <input type="text" class="form-control" id="field-tgl" name="tgl" placeholder="Masukan Tanggal Penganggaran" autocomplete="off" value="{{ date('d-m-Y', strtotime($a->tgl)) }}">
                            <div id="error-tgl" class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Keterangan Tambahan (Jika Ada)</label>
                            <textarea class="form-control" name="keterangan" placeholder="Masukan Keterangan Tambahan" rows="10">{{ $a->keterangan }}</textarea>
                            <div id="error-longlat2" class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="form-group">
                            <label class="col-form-label">Upload Dokumen</label>
                            <input id="update-berkas" name="files[]" type="file" multiple>
                            <div id="error-longlat2" class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="form-group row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-alt-primary btn-block">
                                <i class="si si-check mr-5"></i>
                                Simpan Data
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

    $("#update-berkas").fileinput({
        theme: 'fa',
        uploadUrl: "{{ route('penganggaran.file_upload') }}",
        uploadAsync: true,
        // showBrowse: false,
        // showUpload: false,
        // showCaption: false,
        // showCancel: false,
        previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
        overwriteInitial: false,
        initialPreviewAsData: true,
        initialPreview: <?= $prev_berk; ?>,
        initialPreviewConfig: <?= $berkas; ?>,
        preferIconicPreview: true, // this will force thumbnails to display icons for following file extensions
        previewFileIconSettings: { // configure your icon file extensions
            'doc': '<i class="fa fa-file-word text-primary"></i>',
            'xls': '<i class="fa fa-file-excel text-success"></i>',
            'ppt': '<i class="fa fa-file-powerpoint text-danger"></i>',
            'pdf': '<i class="fa fa-file-pdf text-danger"></i>',
            'zip': '<i class="fa fa-file-archive text-muted"></i>',
            'htm': '<i class="fa fa-file-code text-info"></i>',
            'txt': '<i class="fa fa-file-alt text-info"></i>',
            'mov': '<i class="fa fa-file-video text-warning"></i>',
            'mp3': '<i class="fa fa-file-audio text-warning"></i>',
            // note for these file types below no extension determination logic
            // has been configured (the keys itself will be used as extensions)
            'jpg': '<i class="fa fa-file-image text-danger"></i>',
            'gif': '<i class="fa fa-file-image text-muted"></i>',
            'png': '<i class="fa fa-file-image text-primary"></i>'
        },
        previewFileExtSettings: { // configure the logic for determining icon file extensions
            'doc': function(ext) {
                return ext.match(/(doc|docx)$/i);
            },
            'xls': function(ext) {
                return ext.match(/(xls|xlsx)$/i);
            },
            'ppt': function(ext) {
                return ext.match(/(ppt|pptx)$/i);
            },
            'zip': function(ext) {
                return ext.match(/(zip|rar|tar|gzip|gz|7z)$/i);
            },
            'htm': function(ext) {
                return ext.match(/(htm|html)$/i);
            },
            'txt': function(ext) {
                return ext.match(/(txt|ini|csv|java|php|js|css)$/i);
            },
            'mov': function(ext) {
                return ext.match(/(avi|mpg|mkv|mov|mp4|3gp|webm|wmv)$/i);
            },
            'mp3': function(ext) {
                return ext.match(/(mp3|wav)$/i);
            }
        },
        uploadExtraData: {
            penganggaran_id: "{{ $a->id }}",
        }
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
            url: "{{ route('penganggaran.update') }}",
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
                        text: "Data Penganggaran Berhasil Diperbaharui",
                        timer: 3000,
                        buttons: false,
                        icon: 'success'
                    });
                    window.setTimeout(function(){
                        window.location = response.url;
                    });
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
