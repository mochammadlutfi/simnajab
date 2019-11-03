@extends('layouts.master')


@section('content')
<div class="content">
    <nav class="breadcrumb bg-white push">
        <a class="breadcrumb-item" href="javascript:void(0)">Beranda</a>
        <a class="breadcrumb-item" href="javascript:void(0)">Jalan</a>
        <span class="breadcrumb-item active">{{ $jalan->nama }}</span>
    </nav>
    <div class="block">
        <ul class="nav nav-tabs nav-tabs-alt" data-toggle="tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" href="#detail_jalan"><i class="si si-map mr-5"></i>Informasi Jalan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#tpt_jalan"><i class="si si-drawer mr-5"></i>TPT</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#drainase_jalan"><i class="si si-drop mr-5"></i>Drainase</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#beton_jalan"><i class="si si-layers mr-5"></i>Flat Beton</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#jembatan_jalan"><i class="si si-anchor mr-5"></i>Jembatan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#penganggaran_jalan"><i class="si si-briefcase mr-5"></i>Penganggaran</a>
            </li>
        </ul>
        <div class="block-content tab-content">
            <div class="tab-pane active" id="detail_jalan" role="tabpanel">
                <div class="row py-10 px-0">
                    <div class="col-6 col-md-4">
                        <p>
                            <i class="si si-graph text-muted mr-5"></i> <strong>Panjang Jalan </strong> {{ $jalan->panjang }} <small>Meter</small>
                        </p>
                    </div>
                    <div class="col-6 col-md-4">
                        <p>
                            <i class="fa fa-fw fa-arrows-alt text-muted mr-5"></i> <strong>Lebar Jalan</strong> {{ $jalan->lebar }} <small>Meter</small>
                        </p>
                    </div>
                    <div class="col-6 col-md-4">
                        <p>
                            <i class="si si-anchor text-muted mr-5"></i> <strong> {{ $jembatan->count() }} Jembatan</strong>
                        </p>
                    </div>
                    <div class="col-6 col-md-4">
                        <p>
                            <i class="si si-layers text-muted mr-5"></i> <strong>{{ $beton->count() }} Flat Beton</strong>
                        </p>
                    </div>
                    <div class="col-6 col-md-4">
                        <p>
                            <i class="si si-drop text-muted mr-5"></i> <strong>{{ $drainase->count() }} Drainase</strong>
                        </p>
                    </div>
                    <div class="col-6 col-md-4">
                        <p>
                            <i class="si si-briefcase text-muted mr-5"></i> <strong>{{ $penganggaran->count() }} Penganggaran</strong>
                        </p>
                    </div>
                    <div class="col-6 col-md-4">
                        <p>
                            <i class="si si-drawer text-muted mr-5"></i> <strong>{{ $tpt->count() }} TPT</strong>
                        </p>
                    </div>
                    <div class="col-6 col-md-4">
                        <p>
                            <i class="si si-drop text-muted mr-5"></i> <strong>NJOP Rp. 21 / meter</strong>
                        </p>
                    </div>
                    <div class="col-6 col-md-4">
                        <p>
                            <i class="si si-briefcase text-muted mr-5"></i> <strong>Penganggaran Terakhir <small> {{ $penganggaran_last->tgl }} </small></strong>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        {!! $map['html'] !!}
                    </div>
                    <div class="col-lg-4"></div>
                </div>
            </div>
            {{-- Data TPT Jalan --}}
            @include('jalan.include.tpt')
            {{-- END Data TPT Jalan --}}

            {{-- Data TPT Jalan --}}
            @include('jalan.include.drainase')
            {{-- END Data TPT Jalan --}}

            {{-- Data Flat Beton Jalan --}}
            @include('jalan.include.beton')
            {{-- END Data Flat Beton Jalan --}}

            {{-- Data Jembatan Jalan --}}
            @include('jalan.include.jembatan')
            {{-- END Data Jembatan Jalan --}}

            {{-- Data Jembatan Jalan --}}
            @include('jalan.include.penganggaran')
            {{-- END Data Jembatan Jalan --}}
        </div>
    </div>
</div>
@stop
@push('scripts')
<script>
$(function () {
    $('#list-tpt').DataTable({
        processing: true,
        serverSide: true,
        ajax: "<?= route('tpt', ['jalan_id' => $jalan->jalan_id]); ?>",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'panjang',
                name: 'panjang'
            },
            {
                data: 'batu',
                name: 'batu'
            },
            {
                data: 'beton',
                name: 'beton'
            },
            {
                data: 'kondisi',
                name: 'kondisi'
            },
            {
                data: 'posisi',
                name: 'posisi'
            },
            {
                data: 'tgl',
                name: 'tgl'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });

    $('#list-drainase').DataTable({
        processing: true,
        serverSide: true,
        ajax: "<?= route('drainase', ['jalan_id' => $jalan->jalan_id]); ?>",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'panjang',
                name: 'panjang'
            },
            {
                data: 'batu',
                name: 'batu'
            },
            {
                data: 'beton',
                name: 'beton'
            },
            {
                data: 'kondisi',
                name: 'kondisi'
            },
            {
                data: 'posisi',
                name: 'posisi'
            },
            {
                data: 'tgl',
                name: 'tgl'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });

    $('#list-beton').DataTable({
        processing: true,
        serverSide: true,
        ajax: "<?= route('beton', ['jalan_id' => $jalan->jalan_id]); ?>",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'panjang',
                name: 'panjang'
            },
            {
                data: 'kondisi',
                name: 'kondisi'
            },
            {
                data: 'tgl',
                name: 'tgl'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });

    $('#list-jembatan').DataTable({
        processing: true,
        serverSide: true,
        ajax: "<?= route('jembatan', ['jalan_id' => $jalan->jalan_id]); ?>",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'nama',
                name: 'nama'
            },
            {
                data: 'panjang',
                name: 'panjang'
            },
            {
                data: 'kondisi',
                name: 'kondisi'
            },
            {
                data: 'tgl',
                name: 'tgl'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });

    $('#list-penganggaran').DataTable({
        processing: true,
        serverSide: true,
        ajax: "<?= route('penganggaran.data', $jalan->jalan_id); ?>",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'jenis',
                name: 'jenis'
            },
            {
                data: 'tujuan',
                name: 'tujuan'
            },
            {
                data: 'perusahaan',
                name: 'perusahaan'
            },
            {
                data: 'nomor_bast',
                name: 'nomor_bast'
            },
            {
                data: 'anggaran',
                name: 'anggaran'
            },
            {
                data: 'tgl',
                name: 'tgl'
            },
        ]
    });
});
function detail_penganggaran(id) {
    var url = '{{ route("penganggaran.detail", ":id") }}';
    url = url.replace(':id', id);
    document.location.href=url;
}
</script>
{!! $map['js'] !!}
{{-- <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=AIzaSyCeQBvgWWU9QI4ca0E8vB3XEPr11rOGv7k&libraries=drawing,places"></script> --}}
@endpush
