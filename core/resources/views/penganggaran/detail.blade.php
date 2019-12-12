@extends('layouts.master')


@section('content')
<div class="content">
    <nav class="breadcrumb bg-white push">
        <a class="breadcrumb-item" href="{{ route('beranda') }}">Beranda</a>
        <a class="breadcrumb-item" href="{{ route('jalan') }}">Rute Jalan</a>
        <a class="breadcrumb-item" href="{{ route('jalan.detail', $jalan->jalan_id) }}">{{ $jalan->nama }}</a>
        <span class="breadcrumb-item active">Detail Penganggaran</span>
    </nav>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Detail Penganggaran <small>{{ $jalan->nama }}</small></h3>
            <a href="{{ route('penganggaran.edit',$penganggaran->id) }}" class="btn btn-alt-secondary float-right">
                <i class="si si-note mr-5"></i>
                Edit Data Penganggaran
            </a>
        </div>
        <div class="block-content pb-15">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            {!! $map['html'] !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <label class="col-4">Rute Jalan</label>
                        <label class="col-8">: {{ $jalan->nama }}</label>
                    </div>
                    <div class="row">
                        <label class="col-4">Jenis</label>
                        <label class="col-8">: {{ ucwords($penganggaran->jenis) }}</label>
                    </div>
                    <div class="row">
                        <label class="col-4">Tujuan</label>
                        <label class="col-8">: {{ ucwords($penganggaran->tujuan) }}</label>
                    </div>
                    <div class="row">
                        <label class="col-4">Perusahaan</label>
                        <label class="col-8">: {{ $penganggaran->perusahaan }}</label>
                    </div>
                    <div class="row">
                        <label class="col-4">No. BAST</label>
                        <label class="col-8">: {{ $penganggaran->nomor_bast }}</label>
                    </div>
                    <div class="row">
                        <label class="col-4">Jumlah</label>
                        <label class="col-8">: Rp. {{ number_format($penganggaran->jml_anggaran,0,",",".") }}</label>
                    </div>
                    <div class="row">
                        <label class="col-4">Panjang</label>
                        <label class="col-8">: {{ $penganggaran->AngJalan->panjang }} Meter</label>
                    </div>
                    <div class="row">
                        <label class="col-4">Patok Awal</label>
                        <label class="col-8">: {{ $penganggaran->AngJalan->patok_awal }} Meter</label>
                    </div>
                    <div class="row">
                        <label class="col-4">Patok Akhir</label>
                        <label class="col-8">: {{ $penganggaran->AngJalan->patok_akhir }} Meter</label>
                    </div>
                    @if($penganggaran->keterangan <> null)
                        <div class="row">
                            <label class="col-12">Keterangan : </label>
                        </div>
                        <div class="row">
                            <label class="col-12">{{ $penganggaran->keterangan }}</label>
                        </div>
                    @endif
                    <div class="row">
                        <label class="col-12">Dokumen</label>
                        <input type="file" id="dokumen" name="dokumen" readonly>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table">
                                <tr>
                                    <td></td>
                                </tr>
                            </table>
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
<script>
    $("#dokumen").fileinput({
        theme: 'fa',
        uploadUrl: "{{ route('penganggaran.file_upload') }}",
        uploadAsync: true,
        showBrowse: false,
        showUpload: false,
        showCaption: false,
        showCancel: false,
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
</script>
{!! $map['js'] !!}
@endpush
