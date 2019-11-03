<?php

namespace App\Helpers;

use App\Models\AngDrainase;
use App\Models\AngTPT;
use App\Models\AngBeton;
use App\Models\AngJembatan;
use Carbon\Carbon;
use App\Models\Jalan;
use App\Models\Jembatan;
use App\Models\Penganggaran;
use App\Models\Drainase;
use App\Models\Beton;
use App\Models\TPT;
use FarhanWazir\GoogleMaps\GMaps;
class PenganggaranHelp
{
	public static function jalan($penganggaran_id)
	{
        $penganggaran = Penganggaran::find($penganggaran_id);
        $jalan = Jalan::find($penganggaran->rute_id);
        $config['center'] = $jalan->lat_awal.', '.$jalan->lng_awal;
        $config['zoom'] = '13';
        $config['map_height'] = '630px';
        $config['map_type'] = 'SATELLITE';
        $config['map_types_available'] = array('ROADMAP', 'SATELLITE');
        $config['places'] = TRUE;
        $config['stylesAsMapTypes'] = true;
        $config['stylesAsMapTypesDefault'] = "Black Roads";
        $gmap = new GMaps();
        $gmap->initialize($config);

         // Inisialisasi Jalan Awal
         $polyline = array();
         $c = str_replace('(', '', $jalan->polyline);
         $c = str_replace('),', '|', $c);
         $c = str_replace(')', '|', $c);
         $array = explode('|',$c);
         $polyline['points'] = array_filter($array);
         $polyline['strokeWeight'] = 5;
         $polyline['strokeColor'] = 'blue';
         $gmap->add_polyline($polyline);

        if($penganggaran->tujuan == 'Pemeliharaan')
        {
            $warna = 'yellow';
        }elseif($penganggaran->tujuan == 'Peningkatan')
        {
            $warna = 'red';
        }

        $polyline = array();
        $c = str_replace('(', '', $penganggaran->AngJalan->polypath);
        $c = str_replace('),', '|', $c);
        $c = str_replace(')', '|', $c);
        $array = explode('|',$c);
        $polyline['points'] = array_filter($array);
        $polyline['strokeWeight'] = 4;
        $polyline['strokeColor'] = $warna;
        $gmap->add_polyline($polyline);

        return $gmap->create_map();
    }

    public static function tpt($penganggaran_id)
    {
        $penganggaran = Penganggaran::find($penganggaran_id);
        $jalan = Jalan::find($penganggaran->rute_id);
        $config['center'] = $jalan->lat_awal.', '.$jalan->lng_awal;
        $config['zoom'] = '13';
        $config['map_height'] = '630px';
        $config['map_type'] = 'SATELLITE';
        $config['map_types_available'] = array('ROADMAP', 'SATELLITE');
        $config['places'] = TRUE;
        $config['stylesAsMapTypes'] = true;
        $config['stylesAsMapTypesDefault'] = "Black Roads";
        $gmap = new GMaps();
        $gmap->initialize($config);

        // Inisialisasi Jalan Awal
        $polyline = array();
        $c = str_replace('(', '', $jalan->polyline);
        $c = str_replace('),', '|', $c);
        $c = str_replace(')', '|', $c);
        $array = explode('|',$c);
        $polyline['points'] = array_filter($array);
        $polyline['strokeWeight'] = 5;
        $polyline['strokeColor'] = 'blue';
        $gmap->add_polyline($polyline);

        if($penganggaran->tujuan == 'Pemeliharaan')
        {
            $tpt = AngTPT::where('penganggaran_id', $penganggaran->id)->first();
            $warna = '#1dff0e';
        }elseif($penganggaran->tujuan == 'Peningkatan')
        {
            $tpt = AngTPT::where('penganggaran_id', $penganggaran->id)->first();
            $warna = 'orange';
        }else{
            $warna = 'red';
            $tpt = TPT::where('penganggaran_id', $penganggaran->id)->first();
        }

        // dd($tpt);
        $polyline = array();
        $c = str_replace('(', '', $tpt->polyline);
        $c = str_replace('),', '|', $c);
        $c = str_replace(')', '|', $c);
        $array = explode('|',$c);
        $polyline['points'] = array_filter($array);
        $polyline['strokeWeight'] = 4;
        $polyline['strokeColor'] = $warna;
        $gmap->add_polyline($polyline);

        return $gmap->create_map();
    }

    public static function jembatan($penganggaran_id)
    {
        $penganggaran = Penganggaran::find($penganggaran_id);
        $jalan = Jalan::find($penganggaran->rute_id);
        $config['center'] = $jalan->lat_awal.', '.$jalan->lng_awal;
        $config['zoom'] = '13';
        $config['map_height'] = '630px';
        $config['map_type'] = 'SATELLITE';
        $config['map_types_available'] = array('ROADMAP', 'SATELLITE');
        $config['places'] = TRUE;
        $config['stylesAsMapTypes'] = true;
        $config['stylesAsMapTypesDefault'] = "Black Roads";
        $gmap = new GMaps();
        $gmap->initialize($config);

         // Inisialisasi Jalan Awal
         $polyline = array();
         $c = str_replace('(', '', $jalan->polyline);
         $c = str_replace('),', '|', $c);
         $c = str_replace(')', '|', $c);
         $array = explode('|',$c);
         $polyline['points'] = array_filter($array);
         $polyline['strokeWeight'] = 5;
         $polyline['strokeColor'] = 'blue';
         $gmap->add_polyline($polyline);


        if($penganggaran->tujuan == 'Pembangunan')
        {
            $jembatan = Jembatan::where('penganggaran_id', $penganggaran->id)->first();
            $jem_lat = $jembatan->lat;
            $jem_lng = $jembatan->lng;
        }else{
            $jembatan = AngJembatan::where('penganggaran_id', $penganggaran->id)->first();
            $jem_lat = $jembatan->jembatan->lat;
            $jem_lng = $jembatan->jembatan->lng;
        }

         $marker = array();
         $marker['position'] = $jem_lat.', '.$jem_lng;
         $marker['ondrag'] = 'marker_0.setPosition(find_closest_point_on_path(event.latLng,polyline_0.getPath().getArray()));';
         $marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=J|EA4335|FFFFFF';
         $marker['infowindow_content'] = $jembatan->nama;
         $gmap->add_marker($marker);

        return $gmap->create_map();
    }

    public static function drainase($penganggaran_id)
    {
        $penganggaran = Penganggaran::find($penganggaran_id);
        $jalan = Jalan::find($penganggaran->rute_id);
        $config['center'] = $jalan->lat_awal.', '.$jalan->lng_awal;
        $config['zoom'] = '13';
        $config['map_height'] = '630px';
        $config['map_type'] = 'SATELLITE';
        $config['map_types_available'] = array('ROADMAP', 'SATELLITE');
        $config['places'] = TRUE;
        $config['stylesAsMapTypes'] = true;
        $config['stylesAsMapTypesDefault'] = "Black Roads";
        $gmap = new GMaps();
        $gmap->initialize($config);

         // Inisialisasi Jalan Awal
         $polyline = array();
         $c = str_replace('(', '', $jalan->polyline);
         $c = str_replace('),', '|', $c);
         $c = str_replace(')', '|', $c);
         $array = explode('|',$c);
         $polyline['points'] = array_filter($array);
         $polyline['strokeWeight'] = 5;
         $polyline['strokeColor'] = 'blue';
         $gmap->add_polyline($polyline);

        if($penganggaran->tujuan == 'Pemeliharaan')
        {
            $drainase = AngDrainase::where('penganggaran_id', $penganggaran->id)->first();
            $warna = '#1dff0e';
        }elseif($penganggaran->tujuan == 'Peningkatan')
        {
            $drainase = AngDrainase::where('penganggaran_id', $penganggaran->id)->first();
            $warna = 'orange';
        }else{
            $warna = 'red';
            $drainase = Drainase::where('penganggaran_id', $penganggaran->id)->first();
        }
        $polyline = array();
        $c = str_replace('(', '', $drainase->polyline);
        $c = str_replace('),', '|', $c);
        $c = str_replace(')', '|', $c);
        $array = explode('|',$c);
        $polyline['points'] = array_filter($array);
        $polyline['strokeWeight'] = 4;
        $polyline['strokeColor'] = $warna;
        $gmap->add_polyline($polyline);
        return $gmap->create_map();
    }

    public static function beton($penganggaran_id)
    {
        $penganggaran = Penganggaran::find($penganggaran_id);
        $jalan = Jalan::find($penganggaran->rute_id);
        $config['center'] = $jalan->lat_awal.', '.$jalan->lng_awal;
        $config['zoom'] = '13';
        $config['map_height'] = '630px';
        $config['map_type'] = 'SATELLITE';
        $config['map_types_available'] = array('ROADMAP', 'SATELLITE');
        $config['places'] = TRUE;
        $config['stylesAsMapTypes'] = true;
        $config['stylesAsMapTypesDefault'] = "Black Roads";
        $gmap = new GMaps();
        $gmap->initialize($config);

         // Inisialisasi Jalan Awal
         $polyline = array();
         $c = str_replace('(', '', $jalan->polyline);
         $c = str_replace('),', '|', $c);
         $c = str_replace(')', '|', $c);
         $array = explode('|',$c);
         $polyline['points'] = array_filter($array);
         $polyline['strokeWeight'] = 5;
         $polyline['strokeColor'] = 'blue';
         $gmap->add_polyline($polyline);

        if($penganggaran->tujuan == 'Pemeliharaan')
        {
            $beton = AngBeton::where('penganggaran_id', $penganggaran->id)->first();
            $warna = '#1dff0e';
        }elseif($penganggaran->tujuan == 'Peningkatan')
        {
            $beton = AngBeton::where('penganggaran_id', $penganggaran->id)->first();
            $warna = 'orange';
        }else{
            $warna = 'red';
            $beton = Beton::where('penganggaran_id', $penganggaran->id)->first();
        }

        // dd($beton);
        $polyline = array();
        $c = str_replace('(', '', $beton->polyline);
        $c = str_replace('),', '|', $c);
        $c = str_replace(')', '|', $c);
        $array = explode('|',$c);
        $polyline['points'] = array_filter($array);
        $polyline['strokeWeight'] = 4;
        $polyline['strokeColor'] = $warna;
        $gmap->add_polyline($polyline);
        return $gmap->create_map();
    }
}
