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
                                    {{ $penganggaran->AngJalan->panjang }} Meter
                                </td>
                            </tr>
                            <tr>
                                <td>Patok Awal {{ ucwords($penganggaran->tujuan) }}</td>
                                <td><span class="mr-5">:</span>
                                    {{ $penganggaran->AngJalan->patok_awal }} Meter
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid #e4e7ed;">
                                <td>Patok Akhir {{ ucwords($penganggaran->tujuan) }}</td>
                                <td><span class="mr-5">:</span>
                                    {{ $penganggaran->AngJalan->patok_akhir }} Meter
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
                    <table class="table">
                        <tbody>
                            <tr>
                                <th colspan="3" class="font-weight-bold">Dokumen</th>
                            </tr>
                            @if($dokumen->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center">Dokumen Tidak Ditemukan</td>
                            </tr>
                            @else
                                @php $i = 1; @endphp
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
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@push('scripts')
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/0.10.0/lodash.min.js"></script>
<script>
</script>
{!! $map['js'] !!}
@endpush
