@extends('layouts.master')


@section('content')
<div class="content">
    <div class="row invisible" data-toggle="appear">
        <!-- Row #1 -->
        <div class="col-6 col-xl-4">
            <a class="block block-link-shadow text-right" href="javascript:void(0)">
                <div class="block-content block-content-full clearfix">
                    <div class="float-left mt-10 d-none d-sm-block">
                        <i class="si si-map fa-3x text-body-bg-dark"></i>
                    </div>
                    <div class="font-size-h3 font-w600" data-toggle="countTo" data-speed="1000" data-to="{{ $jalan->count() }}">0</div>
                    <div class="font-size-sm font-w600 text-uppercase text-muted">Total Ruas Jalan</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-xl-4">
            <a class="block block-link-shadow text-right" href="javascript:void(0)">
                <div class="block-content block-content-full clearfix">
                    <div class="float-left mt-10 d-none d-sm-block">
                        <i class="si si-anchor fa-3x text-body-bg-dark"></i>
                    </div>
                    <div class="font-size-h3 font-w600" data-toggle="countTo" data-speed="1000" data-to="{{ $jembatan->count() }}">0</div>
                    <div class="font-size-sm font-w600 text-uppercase text-muted">Total Jembatan</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-xl-4">
            <a class="block block-link-shadow text-right" href="javascript:void(0)">
                <div class="block-content block-content-full clearfix">
                    <div class="float-left mt-10 d-none d-sm-block">
                        <i class="si si-briefcase fa-3x text-body-bg-dark"></i>
                    </div>
                    <div class="font-size-h3 font-w600" data-toggle="countTo" data-speed="1000" data-to="{{ $penganggaran->count() }}">0</div>
                    <div class="font-size-sm font-w600 text-uppercase text-muted">Penganggaran Tahun Ini</div>
                </div>
            </a>
        </div>
        <!-- END Row #1 -->
    </div>
    <div class="row invisible" data-toggle="appear">
        <!-- Row #2 -->
        <div class="col-md-12">
            <div class="block">
                <div class="block-header">
                    <h3 class="block-title">
                        Statistik Penganggaran <small>Tahun Ini</small>
                    </h3>
                    <div class="block-options">
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <div class="pull-all">
                            {!! $chart->container() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- END Row #2 -->
    </div>
</div>
@stop
@push('scripts')
{!! $chart->script() !!}
@endpush
