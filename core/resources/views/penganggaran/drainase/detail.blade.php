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
            <a href="{{ route('penganggaran.edit',$penganggaran->id) }}" class="btn btn-secondary mr-5 mb-5 float-right btn-rounded">
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
            <div class="row mt-15">
                <div class="col-lg-6">
                    <table class="table font-weight-bold">
                        <tbody>
                            <tr>
                                <td width="40%">Ruas Jalan</td>
                                <td><span class="mr-5">:</span>{{ $jalan->nama }}</td>
                            </tr>
                            <tr>
                                <td>Jenis Penganggaran</td>
                                <td><span class="mr-5">:</span>{{ ucwords($penganggaran->jenis) }}</td>
                            </tr>
                            <tr>
                                <td>Tujuan Penganggaran</td>
                                <td><span class="mr-5">:</span>{{ ucwords($penganggaran->tujuan) }}</td>
                            </tr>
                            <tr>
                                <td>Jumlah Anggaran</td>
                                <td><span class="mr-5">:</span>Rp. {{ number_format($penganggaran->jml_anggaran,0,",",".") }}</td>
                            </tr>
                            <tr>
                                <td>Sumber Dana</td>
                                <td><span class="mr-5">:</span>{{ ucwords($penganggaran->sumber) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-6">
                    <table class="table font-weight-bold">
                        <tbody>
                            <tr>
                                <td width="40%">No. BAST</td>
                                <td><span class="mr-5">:</span>{{ $penganggaran->nomor_bast }}</td>
                            </tr>
                            <tr>
                                <td>Panjang {{ ucwords($penganggaran->tujuan) }}</td>
                                <td><span class="mr-5">:</span>
                                    @if($penganggaran->tujuan == 'Pembangunan')
                                        {{ $penganggaran->drainase->panjang }} Meter
                                    @else
                                        {{ $penganggaran->AngDrainase->panjang }} Meter
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Patok Awal {{ ucwords($penganggaran->tujuan) }}</td>
                                <td><span class="mr-5">:</span>
                                    @if($penganggaran->tujuan == 'Pembangunan')
                                    {{ $penganggaran->drainase->patok_awal }} Meter
                                    @else
                                    {{ $penganggaran->AngDrainase->patok_awal }} Meter
                                    @endif
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid #e4e7ed;">
                                <td>Patok Akhir {{ ucwords($penganggaran->tujuan) }}</td>
                                <td><span class="mr-5">:</span>
                                    @if($penganggaran->tujuan == 'Pembangunan')
                                    {{ $penganggaran->drainase->patok_akhir }} Meter
                                    @else
                                    {{ $penganggaran->AngDrainase->patok_akhir }} Meter
                                    @endif
                                </td>
                            </tr>
                            <tr >
                                <td>Tanggal Penganggaran</td>
                                <td><span class="mr-5">:</span>
                                    {{ GeneralHelp::tgl_indo($penganggaran->tgl) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td width="40%" class="font-weight-bold">Keterangan :</td>
                            </tr>
                            @if($penganggaran->keterangan <> null || $penganggaran->keterangan <> '')
                                <tr>
                                    <td>{{ $penganggaran->keterangan }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td>Tidak Ada Keterangan Tambahan</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    @if($dokumen->isEmpty())
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th colspan="3" class="font-weight-bold">Dokumen</th>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-center">Dokumen Tidak Ditemukan</td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        <div class="form-group">
                            <label class="col-form-label">Dokumen</label>
                            <input type="file" id="dokumen" name="dokumen">
                            <div id="error-longlat2" class="invalid-feedback"></div>
                        </div>
                        {{-- @php $i = 1; @endphp
                        @foreach($dokumen as $d)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $d->nama }}</td>
                                <td>
                                    <a href="{{ url($d->path) }}" class="btn btn-sm btn-secondary" target="_blank" data-toggle="tooltip" title="Download">
                                        <i class="fa fa-download"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach --}}
                    @endif
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
        showRemove: false,
        layoutTemplates: {
            actionDelete: '',
            actionDrag: '',
        },
        initialPreviewShowDelete: false,
        previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
        overwriteInitial: false,
        initialPreviewAsData: true,
        initialPreview: <?= $prev_berk; ?>,
        initialPreviewConfig: <?= $berkas; ?>,
        initialPreviewDownloadUrl: true,
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
            penganggaran_id: "{{ $penganggaran->id }}",
        }
    });
</script>
{!! $map['js'] !!}
@endpush
