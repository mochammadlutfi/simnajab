<?php

namespace App\Helpers;

use FarhanWazir\GoogleMaps\GMaps;
use App\Models\Jalan;
use App\Models\TPT;
use Carbon\Carbon;
class MapTPT
{
	public static function penganggaran($jalan_id, $tpt_id)
	{
        $tpt = TPT::find($tpt_id);
        // dd($tpt);
        $jalan = Jalan::find($jalan_id);
        $config['center'] = $jalan->lat_awal.', '.$jalan->lng_awal;
        $config['zoom'] = '13';
        $config['map_height'] = '630px';
        $config['map_type'] = 'SATELLITE';
        $config['map_types_available'] = array('ROADMAP', 'SATELLITE');
        $config['places'] = TRUE;
        $config['stylesAsMapTypes'] = true;
        $config['stylesAsMapTypesDefault'] = "Black Roads";

        $config['directions'] = TRUE;
        $config['directionsDraggable'] = TRUE;
        $config['directionsAvoidHighways'] = TRUE;
        $config['directionsChanged'] = 'longlat1.value = directionsDisplay.directions.routes[0].legs[0].start_location.lat() + \', \' + directionsDisplay.directions.routes[0].legs[0].start_location.lng();
        longlat2.value = directionsDisplay.directions.routes[0].legs[0].end_location.lat() + \', \' + directionsDisplay.directions.routes[0].legs[0].end_location.lng();
        lat_awal.value = directionsDisplay.directions.routes[0].legs[0].start_location.lat();
        long_awal.value = directionsDisplay.directions.routes[0].legs[0].start_location.lng();
        lat_akhir.value = directionsDisplay.directions.routes[0].legs[0].end_location.lat();
        long_akhir.value = directionsDisplay.directions.routes[0].legs[0].end_location.lng();
        computeTotalDistance(directionsDisplay.getDirections());
        start_patok =  new google.maps.LatLng(directionsDisplay.directions.routes[0].legs[0].start_location.lat(), directionsDisplay.directions.routes[0].legs[0].start_location.lng());
        end_patok =  new google.maps.LatLng(directionsDisplay.directions.routes[0].legs[0].end_location.lat(), directionsDisplay.directions.routes[0].legs[0].end_location.lng());
        patok_awal.value = hitung_jarak(start_jalan, start_patok);
        patok_akhir.value = hitung_jarak(start_jalan, end_patok);
        ';

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

        $polyline = array();
        $c = str_replace('(', '', $tpt->polyline);
        $c = str_replace('),', '|', $c);
        $c = str_replace(')', '|', $c);
        $array = explode('|',$c);
        $polyline['points'] = array_filter($array);
        $polyline['strokeWeight'] = 4;
        $polyline['strokeColor'] = 'yellow';
        $gmap->add_polyline($polyline);

        $marker = array();
        $marker['position'] = $array[0];
        $marker['draggable'] = true;
        $marker['ondragend'] = 'marker_0.setPosition(find_closest_point_on_path(event.latLng,polyline_1.getPath().getArray()));
        marker_1.setVisible(true);
        longlat1.value = event.latLng.lat() + \', \' + event.latLng.lng();
        patok_awal.value = hitung_jarak(start_jalan, event.latLng)';
        $marker['ondrag'] = 'marker_0.setPosition(find_closest_point_on_path(event.latLng,polyline_1.getPath().getArray()));';
        $marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|EA4335|FFFFFF';
        $marker['infowindow_content'] = 'Titik Awal TPT';
        $gmap->add_marker($marker);

        $marker = array();
        $marker['position'] = $tpt->lat_akhir.', '.$tpt->lng_akhir;
        $marker['draggable'] = true;
        $marker['visible'] = FALSE;
        $marker['ondragend'] = 'marker_1.setPosition(find_closest_point_on_path(event.latLng,polyline_1.getPath().getArray()));
        longlat2.value = event.latLng.lat() + \', \' + event.latLng.lng();
        tampilRute(longlat1.value, event.latLng, directionsService, directionsDisplay);';
        // $marker['ondrag'] = 'tampilRute(event.latLng.lat(), event.latLng.lng(), directionsService, directionsDisplay);';
        $marker['ondrag'] = 'marker_1.setPosition(find_closest_point_on_path(event.latLng,polyline_1.getPath().getArray()));';
        $marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=B|EA4335|FFFFFF';
        $marker['infowindow_content'] = 'Titik Akhir TPT';
        $gmap->add_marker($marker);

        return $gmap->create_map();
    }


    public static function peningkatan($jalan_id)
	{

    }


    public static function pembangunan($jalan_id)
    {
        $jalan = Jalan::find($jalan_id);
        $config['center'] = $jalan->lat_awal.', '.$jalan->lng_awal;
        $config['zoom'] = '13';
        $config['map_height'] = '630px';
        $config['map_type'] = 'ROADMAP';
        $config['map_types_available'] = array('ROADMAP');
        $config['places'] = TRUE;
        $config['styles'] = array(
        array("name"=>"Tanpa Label", "definition"=>array(
            array("featureType"=>"poi.business", "elementType"=>"labels", "stylers"=>array(array("visibility"=>"off")))
        ))
        );
        $config['stylesAsMapTypes'] = true;
        $config['stylesAsMapTypesDefault'] = "Black Roads";

        $config['directions'] = TRUE;
        $config['directionsDraggable'] = TRUE;
        $config['directionsAvoidHighways'] = TRUE;
        $config['directionsChanged'] = 'longlat1.value = directionsDisplay.directions.routes[0].legs[0].start_location.lat() + \', \' + directionsDisplay.directions.routes[0].legs[0].start_location.lng();
        longlat2.value = directionsDisplay.directions.routes[0].legs[0].end_location.lat() + \', \' + directionsDisplay.directions.routes[0].legs[0].end_location.lng();
        lat_awal.value = directionsDisplay.directions.routes[0].legs[0].start_location.lat();
        long_awal.value = directionsDisplay.directions.routes[0].legs[0].start_location.lng();
        lat_akhir.value = directionsDisplay.directions.routes[0].legs[0].end_location.lat();
        long_akhir.value = directionsDisplay.directions.routes[0].legs[0].end_location.lng();
        computeTotalDistance(directionsDisplay.getDirections());
        start_patok =  new google.maps.LatLng(directionsDisplay.directions.routes[0].legs[0].start_location.lat(), directionsDisplay.directions.routes[0].legs[0].start_location.lng());
        end_patok =  new google.maps.LatLng(directionsDisplay.directions.routes[0].legs[0].end_location.lat(), directionsDisplay.directions.routes[0].legs[0].end_location.lng());
        patok_awal.value = hitung_jarak(start_jalan, start_patok);
        patok_akhir.value = hitung_jarak(start_jalan, end_patok);
        ';

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

        $marker = array();
        $marker['position'] = $array[0];
        $marker['draggable'] = true;
        $marker['ondragend'] = 'marker_0.setPosition(find_closest_point_on_path(event.latLng,polyline_0.getPath().getArray()));
        marker_1.setVisible(true);
        longlat1.value = event.latLng.lat() + \', \' + event.latLng.lng();
        patok_awal.value = hitung_jarak(start_jalan, event.latLng)';
        $marker['ondrag'] = 'marker_0.setPosition(find_closest_point_on_path(event.latLng,polyline_0.getPath().getArray()));';
        $marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=A|EA4335|FFFFFF';
        $marker['infowindow_content'] = 'Titik Awal TPT';
        $gmap->add_marker($marker);

        $marker = array();
        $marker['position'] = $jalan->lat_akhir.', '.$jalan->lng_akhir;
        $marker['draggable'] = true;
        $marker['visible'] = FALSE;
        $marker['ondragend'] = 'marker_1.setPosition(find_closest_point_on_path(event.latLng,polyline_0.getPath().getArray()));
        longlat2.value = event.latLng.lat() + \', \' + event.latLng.lng();
        tampilRute(longlat1.value, event.latLng, directionsService, directionsDisplay);';
        // $marker['ondrag'] = 'tampilRute(event.latLng.lat(), event.latLng.lng(), directionsService, directionsDisplay);';
        $marker['ondrag'] = 'marker_1.setPosition(find_closest_point_on_path(event.latLng,polyline_0.getPath().getArray()));';
        $marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=B|EA4335|FFFFFF';
        $marker['infowindow_content'] = 'Titik Akhir TPT';
        $gmap->add_marker($marker);

        return $gmap->create_map();
    }
}
