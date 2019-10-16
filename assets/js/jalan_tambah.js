function reset()
{
    initmaps();
}
function initmaps() {
    var lat_awal, lat_akhir, lang_awal, lang_akhir;

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
            center: new google.maps.LatLng(-6.835623, 107.576190),
            disableDefaultUI: false,
            scrollWheel: true,
            draggable: true,
        };
    map = new google.maps.Map(element, mapOptions);


    function CenterControl(controlDiv, map) {

        // Set CSS for the control border.
        var controlUI = document.createElement('div');
        controlUI.style.backgroundColor = '#fff';
        controlUI.style.border = '2px solid #fff';
        controlUI.style.borderRadius = '3px';
        controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
        controlUI.style.cursor = 'pointer';
        controlUI.style.marginBottom = '22px';
        controlUI.style.textAlign = 'center';
        controlUI.title = 'Klik Untuk Mereset Map';
        controlDiv.appendChild(controlUI);

        // Set CSS for the control interior.
        var controlText = document.createElement('div');
        controlText.style.color = 'rgb(25,25,25)';
        controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
        controlText.style.fontSize = '16px';
        controlText.style.lineHeight = '38px';
        controlText.style.paddingLeft = '5px';
        controlText.style.paddingRight = '5px';
        controlText.innerHTML = 'Reset Map';
        controlUI.appendChild(controlText);

        // Setup the click event listeners: simply set the map to Chicago.
        controlUI.addEventListener('click', function() {
            reset();
            // $('#form-jalan')[0].reset();
        });

    }

    var centerControlDiv = document.createElement('div');
    centerControlDiv.style.marginTop = '10px';
    var centerControl = new CenterControl(centerControlDiv, map);

    centerControlDiv.index = 1;
    map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv);
    // Buat Marker Awal
    marker1 = new google.maps.Marker({
        position: mapOptions.center,
        map: map,
        draggable: true
    });

    marker2 = new google.maps.Marker({
        position: mapOptions.center,
        map: map,
        draggable: true,
    });
    marker2.setVisible(false);

    google.maps.event.addListener(marker1, "dragend", function (event) {
        var lat, long;
        lat = marker1.getPosition().lat();
        long = marker1.getPosition().lng();
        var geocoder = new google.maps.Geocoder();
		geocoder.geocode( { latLng: marker1.getPosition() }, function ( result, status ) {
			if ( 'OK' === status ) {
				address = result[0].formatted_address;
				resultArray =  result[0].address_components;

				// Get the city and set the city input value to the one selected
				for( var i = 0; i < resultArray.length; i++ ) {
					if ( resultArray[ i ].types[0] && 'administrative_area_level_2' === resultArray[ i ].types[0] ) {
						citi = resultArray[ i ].long_name;
					}
				}
                if(citi == 'Kabupaten Bandung Barat')
                {
                    longlat1.value = lat + ' , ' + long;
                    lat_awal.value = lat;
                    long_awal.value = long;
                    marker2.setVisible(true);
                }else{

                }

			} else {
				console.log( 'Geocode was not successful for the following reason: ' + status );
			}
		});

    });

    var directionsService = new google.maps.DirectionsService;
    var directionsDisplay = new google.maps.DirectionsRenderer({
        map: map,
    });

    google.maps.event.addListener(marker2, "dragend", function (event) {
        var lat, long;
        lat = marker2.getPosition().lat();
        long = marker2.getPosition().lng();
        longlat2.value = lat + ' , ' + long;
        lat_akhir.value = lat;
        long_akhir.value = long;

        tampilRute(longlat1.value, longlat2.value, directionsService, directionsDisplay);
        // calculateAndDisplayRoute(directionsService, directionsDisplay, longlat1.value, longlat2.value);
    });

    directionsDisplay.addListener('directions_changed', function() {
        computeTotalDistance(directionsDisplay.getDirections());
    });

    function tampilRute(origin, destination, service, display) {
        service.route({
          origin: origin,
          destination: destination,
          travelMode: google.maps.TravelMode.DRIVING,
        }, function(response, status) {
          if (status === 'OK') {
            marker1.setVisible(false);
            marker2.setVisible(false);
            display.setDirections(response);
          } else {
            alert('Could not display directions due to: ' + status);
          }
        });
    }

    function computeTotalDistance(result) {
        var total = 0;
        var polyline = new google.maps.Polyline({
            path: [],
            strokeColor: '#F2262E',
            strokeWeight: 3
        });
        var bounds = new google.maps.LatLngBounds();

        var myroute = result.routes[0];
        for (var i = 0; i < myroute.legs.length; i++) {
          total += myroute.legs[i].distance.value;
          coba = myroute.legs[0].start_location;
          var steps = myroute.legs[i].steps;
            for (j = 0; j < steps.length; j++) {
                var nextSegment = steps[j].path;
                for (k = 0; k < nextSegment.length; k++) {
                    polyline.getPath().push(nextSegment[k]);
                    bounds.extend(nextSegment[k]);
                }
            }
        }
        // total = total / 1000;
        // console.log(coba);
        pj_jalan.value = total;
        polyline.setMap(map);
        polypath.value = polyline.getPath().getArray().toString();
    }

    function calculateAndDisplayRoute(result) {
        directionsService.route({
            origin: pointA,
            destination: pointB,
            travelMode: google.maps.TravelMode.DRIVING
        }, function (response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
                marker1.setVisible(false);
                marker2.setVisible(false);

                var panjang_jalan = 0;
                var myroute = response.routes[0];
                console.log(myroute);
                for (var i = 0; i < myroute.legs.length; i++) {
                    panjang_jalan += myroute.legs[i].distance.value;
                    lat_akhir = myroute.legs[i].start_location.lat;
                }
                pj_jalan.value = panjang_jalan;
                // alert(lat_akhir)
                // total = total / 1000;
                // alert(total + ' km');
                // Membuat Polyline dari direction
                // var polyline = new google.maps.Polyline({
                //     path: [],
                //     strokeColor: '#F2262E',
                //     strokeWeight: 3
                // });
                // var bounds = new google.maps.LatLngBounds();


                // var legs = response.routes[0].legs;
                // for (i = 0; i < legs.length; i++) {
                //     var steps = legs[i].steps;
                //     for (j = 0; j < steps.length; j++) {
                //         var nextSegment = steps[j].path;
                //         for (k = 0; k < nextSegment.length; k++) {
                //             polyline.getPath().push(nextSegment[k]);
                //             bounds.extend(nextSegment[k]);
                //         }
                //     }
                // }
                // polyline.setMap(map);
                // polypath.value = polyline.getPath().getArray().toString();
            } else {
                window.alert('Directions request failed due to ' + status);
            }
        });
    }
}
