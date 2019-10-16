<script>
function initmaps() {
    //  Inisialisasi Google Maps
    var mapOptions, map, marker1, marker2,
        infoWindow = '',
        polypath = document.querySelector( '#polypath' ),
        element = document.getElementById('map-canvas'),
        pj_jalan = document.querySelector('#field-panjang'),
        longlat1 = document.querySelector('#field-longlat1'),
        longlat2 = document.querySelector('#field-longlat2'),
        lat_awal = document.querySelector('#lat_awal'),
        long_awal = document.querySelector('#long_awal'),
        lat_akhir = document.querySelector('#lat_akhir'),
        long_akhir = document.querySelector('#long_akhir'),
        mapOptions = {
            zoom: 13,
            center: new google.maps.LatLng('{{ $jalan->lat_awal }}', '{{ $jalan->lng_awal}}'),
            disableDefaultUI: false,
            scrollWheel: true,
            draggable: true,
        };
    map = new google.maps.Map(element, mapOptions);

    var latLng = new google.maps.LatLng('{{ $jalan->lat_awal }}', '{{ $jalan->lng_awal }}');
    var marker = new google.maps.Marker({
        position: latLng,
        map: map,
        draggable: true,
        // icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=S|9999FF|000000';
    });
    // Menyimpan array
    var padded_points = new Array();
    // var array_of_points_to_pad = new Array('{{ $c }}');
    var array_of_points_to_pad = new Array(
            new google.maps.LatLng(-36.8656740244478, 174.72489793784916),
            new google.maps.LatLng(-36.86582762282342, 174.72503422759473),
            new google.maps.LatLng(-36.865929337218404, 174.72529197111726),
            new google.maps.LatLng(-36.86608469579369, 174.72548073157668),
            new google.maps.LatLng(-36.866103052161634, 174.72563814371824),
            new google.maps.LatLng(-36.8661513319239, 174.7257921192795),
            new google.maps.LatLng(-36.86634725891054, 174.72605866380036),
            new google.maps.LatLng(-36.86636704020202, 174.72634574398398),
            new google.maps.LatLng(-36.86640760861337, 174.72647675313056),
            new google.maps.LatLng(-36.866334015503526, 174.7267128713429),
            new google.maps.LatLng(-36.86633242294192, 174.72689299844205)
        );
    console.log(array_of_points_to_pad);

    $.each(array_of_points_to_pad, function(key, pt) {
        var current_point = pt;
        var next_point = array_of_points_to_pad[key + 1];

        //Check if we're on the last point
        if (typeof next_point !== 'undefined') {

            //Get a 10th of the difference in latitude
            var lat_incr = (next_point.lat() - current_point.lat()) / 10;

            //Get a 10th of the difference in longitude
            var lng_incr = (next_point.lng() - current_point.lng()) / 10;

            //Add the current point to the new padded_points array
            padded_points.push(current_point);

            //Now add 10 points at lat_incr & lng_incr intervals between current and next points
            //We add this to the new padded_points array
            for (var i = 1; i <= 10; i++) {
                var new_pt = new google.maps.LatLng(current_point.lat() + (i * lat_incr), current_point.lng() + (i * lng_incr));
                padded_points.push(new_pt);
            }
        }
    });


    var garis = new google.maps.Polyline({
        path: ['<?= $c; ?>'],
        strokeColor: '#ff0000',
        strokeOpacity: 1.0,
        strokeWeight: 2
    });
    garis.setMap(map);

}

    // var padded_points = new Array(); //To store the padded array of points
    // var map;
    // function initmaps() {
    //     var mapDiv = document.getElementById('map-canvas');
    //     map = new google.maps.Map(mapDiv, {
    //         center: new google.maps.LatLng('{{ $jalan->lat_awal }}', '{{ $jalan->lng_awal }}'),
    //         zoom: 16,
    //         mapTypeId: google.maps.MapTypeId.ROADMAP
    //     });

    //     var latLng = new google.maps.LatLng('{{ $jalan->lat_awal }}', '{{ $jalan->lng_awal }}');
    //     var marker = new google.maps.Marker({
    //         position: latLng,
    //         map: map,
    //         draggable: true
    //     });

    //     google.maps.event.addDomListener(marker, 'dragend', function(e) {
    //         marker.setPosition(find_closest_point_on_path(e.latLng,padded_points));
    //     });

    //     google.maps.event.addDomListener(marker, 'drag', function(e) {
    //         marker.setPosition(find_closest_point_on_path(e.latLng,padded_points));
    //     });
    // }

    // $(function() {
    //     initmaps();

    //     //I grab these points from a GPX file but have used dummy points here
    //     var array_of_points_to_pad = new Array('{{ $c }};');

    //     //Pad the points array
    //     $.each(array_of_points_to_pad, function(key, pt) {
    //         var current_point = pt;
    //         var next_point = array_of_points_to_pad[key + 1];

    //         //Check if we're on the last point
    //         if (typeof next_point !== 'undefined') {

    //             //Get a 10th of the difference in latitude
    //             var lat_incr = (next_point.lat() - current_point.lat()) / 10;

    //             //Get a 10th of the difference in longitude
    //             var lng_incr = (next_point.lng() - current_point.lng()) / 10;

    //             //Add the current point to the new padded_points array
    //             padded_points.push(current_point);

    //             //Now add 10 points at lat_incr & lng_incr intervals between current and next points
    //             //We add this to the new padded_points array
    //             for (var i = 1; i <= 10; i++) {
    //                 var new_pt = new google.maps.LatLng(current_point.lat() + (i * lat_incr), current_point.lng() + (i * lng_incr));
    //                 padded_points.push(new_pt);
    //             }
    //         }
    //     });

    //     //Plot the points array as a polyline
    //     console.log(padded_points);
    //     var line = new google.maps.Polyline({
    //         path: padded_points,
    //         strokeColor: '#ff0000',
    //         strokeOpacity: 1.0,
    //         strokeWeight: 2
    //     });

    //     line.setMap(map);

    // });

    // function find_closest_point_on_path(drop_pt,path_pts){
    //     distances = new Array();//Stores the distances of each pt on the path from the marker point
    //     distance_keys = new Array();//Stores the key of point on the path that corresponds to a distance

    //     //For each point on the path
    //     $.each(path_pts,function(key, path_pt){
    //         //Find the distance in a linear crows-flight line between the marker point and the current path point
    //         var R = 6371; // km
    //         var dLat = (path_pt.lat()-drop_pt.lat()).toRad();
    //         var dLon = (path_pt.lng()-drop_pt.lng()).toRad();
    //         var lat1 = drop_pt.lat().toRad();
    //         var lat2 = path_pt.lat().toRad();

    //         var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
    //                 Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2);
    //         var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    //         var d = R * c;
    //         //Store the distances and the key of the pt that matches that distance
    //         distances[key] = d;
    //         distance_keys[d] = key;

    //     });
    //     //Return the latLng obj of the second closest point to the markers drag origin. If this point doesn't exist snap it to the actual closest point as this should always exist
    //     return (typeof path_pts[distance_keys[_.min(distances)]+1] === 'undefined')?path_pts[distance_keys[_.min(distances)]]:path_pts[distance_keys[_.min(distances)]+1];
    // }

    // /** Converts numeric degrees to radians */
    // if (typeof(Number.prototype.toRad) === "undefined") {
    //   Number.prototype.toRad = function() {
    //     return this * Math.PI / 180;
    //   }
    // }

</script>
