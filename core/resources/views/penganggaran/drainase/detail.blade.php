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
        </div>
        <div class="block-content pb-15">
            <div class="row">
                <div class="col-lg-4">
                    <div class="row">
                        <label class="col-12">Informasi Penganggaran</label>
                    </div>
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
                        <label class="col-8">:
                            @if($penganggaran->tujuan == 'Pembangunan')
                            {{ $penganggaran->drainase->panjang }} Meter
                            @else
                            {{ $penganggaran->AngDrainase->panjang }} Meter
                            @endif
                        </label>
                    </div>
                    <div class="row">
                        <label class="col-4">Patok Awal</label>
                        <label class="col-8">:
                            @if($penganggaran->tujuan == 'Pembangunan')
                            {{ $penganggaran->drainase->patok_awal }} Meter
                            @else
                            {{ $penganggaran->AngDrainase->patok_awal }} Meter
                            @endif
                        </label>
                    </div>
                    <div class="row">
                        <label class="col-4">Patok Akhir</label>
                        <label class="col-8">:
                            @if($penganggaran->tujuan == 'Pembangunan')
                            {{ $penganggaran->drainase->patok_akhir }} Meter
                            @else
                            {{ $penganggaran->AngDrainase->patok_akhir }} Meter
                            @endif
                        </label>
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
<script>
</script>
{!! $map['js'] !!}
@endpush
