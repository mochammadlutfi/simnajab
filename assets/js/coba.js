
            var map; // Global declaration of the map
            var lat_longs_map = new Array();
            var markers_map = new Array();
            var iw_map;
            var geocoder; // Global declaration of geocoder for reverser location from latLng
            var placesService;
            function initialize_map() {

                var styles_0 = [{"featureType":"poi.business","elementType":"labels","stylers":[{"visibility":"off"}]}];
                var styles_0 = new google.maps.StyledMapType(styles_0, {name:"Tanpa Label"});
                var myLatlng = new google.maps.LatLng(-6.8475537319535045,107.4908742956543);
            iw_map = new google.maps.InfoWindow();

                 
                var myOptions = {
                    zoom: 13,
                    center: myLatlng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    mapTypeControlOptions: {mapTypeIds: [google.maps.MapTypeId.ROADMAP, "style0"]}};map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);geocoder = new google.maps.Geocoder;
                      map.mapTypes.set("style0", styles_0);
                
                google.maps.event.addListener(map, "click", function(event) {
                createMarker_map({ map: map, position:event.latLng });
            });
            var myLatlng = new google.maps.LatLng(-6.8472100000000005, 107.49114000000002);
                var marker_icon = {
                    url: "http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=S|9999FF|000000"};
            
            var markerOptions = {
                map: map,
                position: myLatlng,
                draggable: true,
                icon: marker_icon
            };
            marker_0 = createMarker_map(markerOptions);
            marker_0.id = marker_0;
            
            marker_0.set("content", "Titik Awal TPT");

            google.maps.event.addListener(marker_0, "click", function(event) {
                iw_map.setContent(this.get("content"));
                iw_map.open(map, this);
            
            });
            
                google.maps.event.addListener(marker_0, "dragend", function(event) {
                    marker.setPosition(find_closest_point_on_path(event.latLng,polyline_plan_0));
                });
                var myLatlng = new google.maps.LatLng(-6.857480000000001, 107.45356000000001);
                var marker_icon = {
                    url: "http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=E|9999FF|000000"};
            
            var markerOptions = {
                map: map,
                position: myLatlng,
                icon: marker_icon
            };
            marker_1 = createMarker_map(markerOptions);
            marker_1.id = marker_1;
            
            marker_1.set("content", "Titik Akhir TPT");

            google.maps.event.addListener(marker_1, "click", function(event) {
                iw_map.setContent(this.get("content"));
                iw_map.open(map, this);
            
            });
            
                var polyline_plan_0 = [
                    new google.maps.LatLng(-6.8472100000000005, 107.49114000000002)
                    ,
                    new google.maps.LatLng(-6.847090000000001, 107.49098000000001)
                    ,
                    new google.maps.LatLng(-6.84691, 107.49074)
                    ,
                    new google.maps.LatLng(-6.846620000000001, 107.49032000000001)
                    ,
                    new google.maps.LatLng(-6.846470000000001, 107.49012)
                    ,
                    new google.maps.LatLng(-6.84623, 107.48979000000001)
                    ,
                    new google.maps.LatLng(-6.8459900000000005, 107.48945)
                    ,
                    new google.maps.LatLng(-6.845940000000001, 107.48938000000001)
                    ,
                    new google.maps.LatLng(-6.8457300000000005, 107.48907000000001)
                    ,
                    new google.maps.LatLng(-6.84569, 107.48901000000001)
                    ,
                    new google.maps.LatLng(-6.84562, 107.48893000000001)
                    ,
                    new google.maps.LatLng(-6.845540000000001, 107.48881000000002)
                    ,
                    new google.maps.LatLng(-6.845390000000001, 107.48859)
                    ,
                    new google.maps.LatLng(-6.845370000000001, 107.48858000000001)
                    ,
                    new google.maps.LatLng(-6.845350000000001, 107.48854000000001)
                    ,
                    new google.maps.LatLng(-6.845250000000001, 107.48840000000001)
                    ,
                    new google.maps.LatLng(-6.845020000000001, 107.48808000000001)
                    ,
                    new google.maps.LatLng(-6.84499, 107.48804000000001)
                    ,
                    new google.maps.LatLng(-6.8449800000000005, 107.48802)
                    ,
                    new google.maps.LatLng(-6.84487, 107.48787000000002)
                    ,
                    new google.maps.LatLng(-6.8447700000000005, 107.48771)
                    ,
                    new google.maps.LatLng(-6.84438, 107.48715000000001)
                    ,
                    new google.maps.LatLng(-6.84421, 107.48691000000001)
                    ,
                    new google.maps.LatLng(-6.844060000000001, 107.48669000000001)
                    ,
                    new google.maps.LatLng(-6.844, 107.48662)
                    ,
                    new google.maps.LatLng(-6.843940000000001, 107.48653)
                    ,
                    new google.maps.LatLng(-6.84393, 107.48652000000001)
                    ,
                    new google.maps.LatLng(-6.843890000000001, 107.48646000000001)
                    ,
                    new google.maps.LatLng(-6.84386, 107.48642000000001)
                    ,
                    new google.maps.LatLng(-6.843560000000001, 107.48597000000001)
                    ,
                    new google.maps.LatLng(-6.843330000000001, 107.48562000000001)
                    ,
                    new google.maps.LatLng(-6.843210000000001, 107.48545000000001)
                    ,
                    new google.maps.LatLng(-6.843030000000001, 107.48519)
                    ,
                    new google.maps.LatLng(-6.84299, 107.48512000000001)
                    ,
                    new google.maps.LatLng(-6.842950000000001, 107.48505000000002)
                    ,
                    new google.maps.LatLng(-6.842860000000001, 107.48488)
                    ,
                    new google.maps.LatLng(-6.84273, 107.48457)
                    ,
                    new google.maps.LatLng(-6.842560000000001, 107.48423000000001)
                    ,
                    new google.maps.LatLng(-6.842510000000001, 107.48412)
                    ,
                    new google.maps.LatLng(-6.84248, 107.48406000000001)
                    ,
                    new google.maps.LatLng(-6.84245, 107.48399)
                    ,
                    new google.maps.LatLng(-6.84236, 107.4838)
                    ,
                    new google.maps.LatLng(-6.842340000000001, 107.48375000000001)
                    ,
                    new google.maps.LatLng(-6.842270000000001, 107.48360000000001)
                    ,
                    new google.maps.LatLng(-6.84219, 107.4834)
                    ,
                    new google.maps.LatLng(-6.84212, 107.48326000000002)
                    ,
                    new google.maps.LatLng(-6.842090000000001, 107.48321000000001)
                    ,
                    new google.maps.LatLng(-6.84182, 107.48266000000001)
                    ,
                    new google.maps.LatLng(-6.841640000000001, 107.48227000000001)
                    ,
                    new google.maps.LatLng(-6.8414600000000005, 107.48187000000001)
                    ,
                    new google.maps.LatLng(-6.841310000000001, 107.48155000000001)
                    ,
                    new google.maps.LatLng(-6.841290000000001, 107.48151000000001)
                    ,
                    new google.maps.LatLng(-6.841290000000001, 107.48151000000001)
                    ,
                    new google.maps.LatLng(-6.84187, 107.48122000000001)
                    ,
                    new google.maps.LatLng(-6.84198, 107.48117)
                    ,
                    new google.maps.LatLng(-6.842040000000001, 107.48115000000001)
                    ,
                    new google.maps.LatLng(-6.842280000000001, 107.48107)
                    ,
                    new google.maps.LatLng(-6.842320000000001, 107.48106000000001)
                    ,
                    new google.maps.LatLng(-6.84243, 107.48101000000001)
                    ,
                    new google.maps.LatLng(-6.84269, 107.48091000000001)
                    ,
                    new google.maps.LatLng(-6.842740000000001, 107.48089)
                    ,
                    new google.maps.LatLng(-6.842910000000001, 107.48082000000001)
                    ,
                    new google.maps.LatLng(-6.84299, 107.48079000000001)
                    ,
                    new google.maps.LatLng(-6.84316, 107.48072)
                    ,
                    new google.maps.LatLng(-6.84339, 107.48062)
                    ,
                    new google.maps.LatLng(-6.843540000000001, 107.48055000000001)
                    ,
                    new google.maps.LatLng(-6.84367, 107.4805)
                    ,
                    new google.maps.LatLng(-6.8436900000000005, 107.48049)
                    ,
                    new google.maps.LatLng(-6.843730000000001, 107.48047000000001)
                    ,
                    new google.maps.LatLng(-6.844, 107.48037000000001)
                    ,
                    new google.maps.LatLng(-6.844390000000001, 107.48021000000001)
                    ,
                    new google.maps.LatLng(-6.84447, 107.48018)
                    ,
                    new google.maps.LatLng(-6.84466, 107.48011000000001)
                    ,
                    new google.maps.LatLng(-6.84501, 107.47997000000001)
                    ,
                    new google.maps.LatLng(-6.845350000000001, 107.47984000000001)
                    ,
                    new google.maps.LatLng(-6.845460000000001, 107.47979000000001)
                    ,
                    new google.maps.LatLng(-6.845580000000001, 107.47974)
                    ,
                    new google.maps.LatLng(-6.84569, 107.47970000000001)
                    ,
                    new google.maps.LatLng(-6.84576, 107.47966000000001)
                    ,
                    new google.maps.LatLng(-6.845890000000001, 107.4796)
                    ,
                    new google.maps.LatLng(-6.84602, 107.47955)
                    ,
                    new google.maps.LatLng(-6.84609, 107.47951)
                    ,
                    new google.maps.LatLng(-6.846400000000001, 107.47937)
                    ,
                    new google.maps.LatLng(-6.846570000000001, 107.47928)
                    ,
                    new google.maps.LatLng(-6.8469500000000005, 107.47908000000001)
                    ,
                    new google.maps.LatLng(-6.847180000000001, 107.47898)
                    ,
                    new google.maps.LatLng(-6.84724, 107.47896000000001)
                    ,
                    new google.maps.LatLng(-6.847290000000001, 107.47894000000001)
                    ,
                    new google.maps.LatLng(-6.847320000000001, 107.47893)
                    ,
                    new google.maps.LatLng(-6.847580000000001, 107.47884)
                    ,
                    new google.maps.LatLng(-6.84778, 107.47877000000001)
                    ,
                    new google.maps.LatLng(-6.847790000000001, 107.47877000000001)
                    ,
                    new google.maps.LatLng(-6.848020000000001, 107.47869000000001)
                    ,
                    new google.maps.LatLng(-6.84806, 107.47867000000001)
                    ,
                    new google.maps.LatLng(-6.848260000000001, 107.47861)
                    ,
                    new google.maps.LatLng(-6.84841, 107.47856000000002)
                    ,
                    new google.maps.LatLng(-6.84846, 107.47854000000001)
                    ,
                    new google.maps.LatLng(-6.848590000000001, 107.47849000000001)
                    ,
                    new google.maps.LatLng(-6.8486400000000005, 107.47847000000002)
                    ,
                    new google.maps.LatLng(-6.84874, 107.47843)
                    ,
                    new google.maps.LatLng(-6.84876, 107.47843)
                    ,
                    new google.maps.LatLng(-6.84881, 107.47840000000001)
                    ,
                    new google.maps.LatLng(-6.848890000000001, 107.47836000000001)
                    ,
                    new google.maps.LatLng(-6.848980000000001, 107.47829000000002)
                    ,
                    new google.maps.LatLng(-6.848990000000001, 107.47829000000002)
                    ,
                    new google.maps.LatLng(-6.84909, 107.47822000000001)
                    ,
                    new google.maps.LatLng(-6.84956, 107.47786)
                    ,
                    new google.maps.LatLng(-6.849710000000001, 107.47776)
                    ,
                    new google.maps.LatLng(-6.8498600000000005, 107.47765000000001)
                    ,
                    new google.maps.LatLng(-6.84987, 107.47764000000001)
                    ,
                    new google.maps.LatLng(-6.849920000000001, 107.47760000000001)
                    ,
                    new google.maps.LatLng(-6.85012, 107.47749)
                    ,
                    new google.maps.LatLng(-6.85029, 107.4774)
                    ,
                    new google.maps.LatLng(-6.85031, 107.47738000000001)
                    ,
                    new google.maps.LatLng(-6.85036, 107.47736)
                    ,
                    new google.maps.LatLng(-6.850460000000001, 107.47730000000001)
                    ,
                    new google.maps.LatLng(-6.850700000000001, 107.47719000000001)
                    ,
                    new google.maps.LatLng(-6.850860000000001, 107.47712000000001)
                    ,
                    new google.maps.LatLng(-6.85104, 107.47705)
                    ,
                    new google.maps.LatLng(-6.85113, 107.47701)
                    ,
                    new google.maps.LatLng(-6.8512, 107.47696)
                    ,
                    new google.maps.LatLng(-6.851240000000001, 107.47693000000001)
                    ,
                    new google.maps.LatLng(-6.8512900000000005, 107.47686)
                    ,
                    new google.maps.LatLng(-6.851330000000001, 107.47681000000001)
                    ,
                    new google.maps.LatLng(-6.851430000000001, 107.47661000000001)
                    ,
                    new google.maps.LatLng(-6.851430000000001, 107.47661000000001)
                    ,
                    new google.maps.LatLng(-6.851400000000001, 107.47657000000001)
                    ,
                    new google.maps.LatLng(-6.851380000000001, 107.47654000000001)
                    ,
                    new google.maps.LatLng(-6.85134, 107.47647)
                    ,
                    new google.maps.LatLng(-6.851310000000001, 107.47642)
                    ,
                    new google.maps.LatLng(-6.851260000000001, 107.47636000000001)
                    ,
                    new google.maps.LatLng(-6.8512, 107.47629)
                    ,
                    new google.maps.LatLng(-6.851120000000001, 107.47621000000001)
                    ,
                    new google.maps.LatLng(-6.851070000000001, 107.47615)
                    ,
                    new google.maps.LatLng(-6.85106, 107.47614000000002)
                    ,
                    new google.maps.LatLng(-6.8510100000000005, 107.47609000000001)
                    ,
                    new google.maps.LatLng(-6.8509400000000005, 107.47601)
                    ,
                    new google.maps.LatLng(-6.850880000000001, 107.47593)
                    ,
                    new google.maps.LatLng(-6.85085, 107.47587000000001)
                    ,
                    new google.maps.LatLng(-6.85085, 107.47586000000001)
                    ,
                    new google.maps.LatLng(-6.850840000000001, 107.47582000000001)
                    ,
                    new google.maps.LatLng(-6.850840000000001, 107.4758)
                    ,
                    new google.maps.LatLng(-6.850840000000001, 107.47577000000001)
                    ,
                    new google.maps.LatLng(-6.850840000000001, 107.47572000000001)
                    ,
                    new google.maps.LatLng(-6.850840000000001, 107.47563000000001)
                    ,
                    new google.maps.LatLng(-6.850840000000001, 107.47551000000001)
                    ,
                    new google.maps.LatLng(-6.850840000000001, 107.47540000000001)
                    ,
                    new google.maps.LatLng(-6.850840000000001, 107.47539)
                    ,
                    new google.maps.LatLng(-6.850840000000001, 107.47536000000001)
                    ,
                    new google.maps.LatLng(-6.850840000000001, 107.47531000000001)
                    ,
                    new google.maps.LatLng(-6.850820000000001, 107.47526)
                    ,
                    new google.maps.LatLng(-6.850790000000001, 107.47516)
                    ,
                    new google.maps.LatLng(-6.850740000000001, 107.47499)
                    ,
                    new google.maps.LatLng(-6.85071, 107.47486)
                    ,
                    new google.maps.LatLng(-6.8506800000000005, 107.47470000000001)
                    ,
                    new google.maps.LatLng(-6.850670000000001, 107.47464000000001)
                    ,
                    new google.maps.LatLng(-6.85064, 107.47444000000002)
                    ,
                    new google.maps.LatLng(-6.850600000000001, 107.47415000000001)
                    ,
                    new google.maps.LatLng(-6.850580000000001, 107.47393000000001)
                    ,
                    new google.maps.LatLng(-6.850560000000001, 107.47372000000001)
                    ,
                    new google.maps.LatLng(-6.8505400000000005, 107.47348000000001)
                    ,
                    new google.maps.LatLng(-6.850460000000001, 107.47316000000001)
                    ,
                    new google.maps.LatLng(-6.850390000000001, 107.47287000000001)
                    ,
                    new google.maps.LatLng(-6.85038, 107.47279)
                    ,
                    new google.maps.LatLng(-6.850370000000001, 107.47269000000001)
                    ,
                    new google.maps.LatLng(-6.850370000000001, 107.47256000000002)
                    ,
                    new google.maps.LatLng(-6.850370000000001, 107.47247000000002)
                    ,
                    new google.maps.LatLng(-6.8504000000000005, 107.47235)
                    ,
                    new google.maps.LatLng(-6.85045, 107.47219000000001)
                    ,
                    new google.maps.LatLng(-6.85052, 107.47196000000001)
                    ,
                    new google.maps.LatLng(-6.850630000000001, 107.47161000000001)
                    ,
                    new google.maps.LatLng(-6.8506800000000005, 107.47147000000001)
                    ,
                    new google.maps.LatLng(-6.85073, 107.47134000000001)
                    ,
                    new google.maps.LatLng(-6.850810000000001, 107.47119)
                    ,
                    new google.maps.LatLng(-6.850880000000001, 107.4711)
                    ,
                    new google.maps.LatLng(-6.85097, 107.47096)
                    ,
                    new google.maps.LatLng(-6.851050000000001, 107.47082)
                    ,
                    new google.maps.LatLng(-6.851050000000001, 107.47082)
                    ,
                    new google.maps.LatLng(-6.85104, 107.47075000000001)
                    ,
                    new google.maps.LatLng(-6.851030000000001, 107.47071000000001)
                    ,
                    new google.maps.LatLng(-6.851030000000001, 107.47070000000001)
                    ,
                    new google.maps.LatLng(-6.851020000000001, 107.47065)
                    ,
                    new google.maps.LatLng(-6.8510100000000005, 107.47058000000001)
                    ,
                    new google.maps.LatLng(-6.851000000000001, 107.47055)
                    ,
                    new google.maps.LatLng(-6.851000000000001, 107.47051)
                    ,
                    new google.maps.LatLng(-6.851000000000001, 107.47046)
                    ,
                    new google.maps.LatLng(-6.851030000000001, 107.47035000000001)
                    ,
                    new google.maps.LatLng(-6.851050000000001, 107.47026000000001)
                    ,
                    new google.maps.LatLng(-6.851070000000001, 107.47019)
                    ,
                    new google.maps.LatLng(-6.851100000000001, 107.47008000000001)
                    ,
                    new google.maps.LatLng(-6.85111, 107.47004000000001)
                    ,
                    new google.maps.LatLng(-6.85116, 107.46981000000001)
                    ,
                    new google.maps.LatLng(-6.8512200000000005, 107.46956000000002)
                    ,
                    new google.maps.LatLng(-6.85127, 107.46933000000001)
                    ,
                    new google.maps.LatLng(-6.851280000000001, 107.46928000000001)
                    ,
                    new google.maps.LatLng(-6.851280000000001, 107.46926)
                    ,
                    new google.maps.LatLng(-6.851310000000001, 107.46917)
                    ,
                    new google.maps.LatLng(-6.85134, 107.46904)
                    ,
                    new google.maps.LatLng(-6.85158, 107.468)
                    ,
                    new google.maps.LatLng(-6.851590000000001, 107.46792)
                    ,
                    new google.maps.LatLng(-6.851630000000001, 107.46779000000001)
                    ,
                    new google.maps.LatLng(-6.85165, 107.46765)
                    ,
                    new google.maps.LatLng(-6.851660000000001, 107.46763000000001)
                    ,
                    new google.maps.LatLng(-6.85174, 107.46727000000001)
                    ,
                    new google.maps.LatLng(-6.851750000000001, 107.46727000000001)
                    ,
                    new google.maps.LatLng(-6.851870000000001, 107.46663000000001)
                    ,
                    new google.maps.LatLng(-6.8519000000000005, 107.46649000000001)
                    ,
                    new google.maps.LatLng(-6.85202, 107.46600000000001)
                    ,
                    new google.maps.LatLng(-6.852150000000001, 107.46544000000002)
                    ,
                    new google.maps.LatLng(-6.852180000000001, 107.46525000000001)
                    ,
                    new google.maps.LatLng(-6.8522300000000005, 107.4651)
                    ,
                    new google.maps.LatLng(-6.85226, 107.46501)
                    ,
                    new google.maps.LatLng(-6.85228, 107.46495)
                    ,
                    new google.maps.LatLng(-6.8523000000000005, 107.46491)
                    ,
                    new google.maps.LatLng(-6.852320000000001, 107.46484000000001)
                    ,
                    new google.maps.LatLng(-6.852320000000001, 107.46481000000001)
                    ,
                    new google.maps.LatLng(-6.852320000000001, 107.46478)
                    ,
                    new google.maps.LatLng(-6.85233, 107.46475000000001)
                    ,
                    new google.maps.LatLng(-6.85233, 107.46472000000001)
                    ,
                    new google.maps.LatLng(-6.852320000000001, 107.46469)
                    ,
                    new google.maps.LatLng(-6.85231, 107.46466000000001)
                    ,
                    new google.maps.LatLng(-6.852290000000001, 107.46462000000001)
                    ,
                    new google.maps.LatLng(-6.852270000000001, 107.4646)
                    ,
                    new google.maps.LatLng(-6.85226, 107.46459000000002)
                    ,
                    new google.maps.LatLng(-6.85219, 107.46455)
                    ,
                    new google.maps.LatLng(-6.85212, 107.46450000000002)
                    ,
                    new google.maps.LatLng(-6.852100000000001, 107.46449000000001)
                    ,
                    new google.maps.LatLng(-6.852080000000001, 107.46447)
                    ,
                    new google.maps.LatLng(-6.85207, 107.46445000000001)
                    ,
                    new google.maps.LatLng(-6.85205, 107.46444000000001)
                    ,
                    new google.maps.LatLng(-6.852040000000001, 107.46441000000002)
                    ,
                    new google.maps.LatLng(-6.852040000000001, 107.46438)
                    ,
                    new google.maps.LatLng(-6.852030000000001, 107.46436000000001)
                    ,
                    new google.maps.LatLng(-6.852030000000001, 107.46433)
                    ,
                    new google.maps.LatLng(-6.852030000000001, 107.46417000000001)
                    ,
                    new google.maps.LatLng(-6.852030000000001, 107.46402)
                    ,
                    new google.maps.LatLng(-6.852030000000001, 107.46398)
                    ,
                    new google.maps.LatLng(-6.852040000000001, 107.4638)
                    ,
                    new google.maps.LatLng(-6.852060000000001, 107.46356000000002)
                    ,
                    new google.maps.LatLng(-6.85207, 107.46349000000001)
                    ,
                    new google.maps.LatLng(-6.852080000000001, 107.46332000000001)
                    ,
                    new google.maps.LatLng(-6.8520900000000005, 107.46317)
                    ,
                    new google.maps.LatLng(-6.852100000000001, 107.46306000000001)
                    ,
                    new google.maps.LatLng(-6.852100000000001, 107.46281)
                    ,
                    new google.maps.LatLng(-6.852100000000001, 107.46281)
                    ,
                    new google.maps.LatLng(-6.852130000000001, 107.46257000000001)
                    ,
                    new google.maps.LatLng(-6.852130000000001, 107.46251000000001)
                    ,
                    new google.maps.LatLng(-6.85214, 107.46245)
                    ,
                    new google.maps.LatLng(-6.85214, 107.46242000000001)
                    ,
                    new google.maps.LatLng(-6.85214, 107.46241)
                    ,
                    new google.maps.LatLng(-6.852150000000001, 107.4624)
                    ,
                    new google.maps.LatLng(-6.8521600000000005, 107.46239000000001)
                    ,
                    new google.maps.LatLng(-6.852170000000001, 107.46238000000001)
                    ,
                    new google.maps.LatLng(-6.852180000000001, 107.46237)
                    ,
                    new google.maps.LatLng(-6.852200000000001, 107.46237)
                    ,
                    new google.maps.LatLng(-6.852220000000001, 107.46236)
                    ,
                    new google.maps.LatLng(-6.852250000000001, 107.46236)
                    ,
                    new google.maps.LatLng(-6.852270000000001, 107.46236)
                    ,
                    new google.maps.LatLng(-6.8523000000000005, 107.46236)
                    ,
                    new google.maps.LatLng(-6.8524, 107.46235000000001)
                    ,
                    new google.maps.LatLng(-6.85256, 107.46235000000001)
                    ,
                    new google.maps.LatLng(-6.852780000000001, 107.46233000000001)
                    ,
                    new google.maps.LatLng(-6.852790000000001, 107.46233000000001)
                    ,
                    new google.maps.LatLng(-6.852970000000001, 107.46233000000001)
                    ,
                    new google.maps.LatLng(-6.853350000000001, 107.46236)
                    ,
                    new google.maps.LatLng(-6.85355, 107.46239000000001)
                    ,
                    new google.maps.LatLng(-6.853650000000001, 107.4624)
                    ,
                    new google.maps.LatLng(-6.853910000000001, 107.46242000000001)
                    ,
                    new google.maps.LatLng(-6.85437, 107.46243000000001)
                    ,
                    new google.maps.LatLng(-6.854680000000001, 107.46243000000001)
                    ,
                    new google.maps.LatLng(-6.854920000000001, 107.46242000000001)
                    ,
                    new google.maps.LatLng(-6.855160000000001, 107.46237)
                    ,
                    new google.maps.LatLng(-6.855300000000001, 107.46233000000001)
                    ,
                    new google.maps.LatLng(-6.85536, 107.46229000000001)
                    ,
                    new google.maps.LatLng(-6.8554, 107.46227)
                    ,
                    new google.maps.LatLng(-6.855460000000001, 107.46222)
                    ,
                    new google.maps.LatLng(-6.855580000000001, 107.46213)
                    ,
                    new google.maps.LatLng(-6.855670000000001, 107.46203000000001)
                    ,
                    new google.maps.LatLng(-6.85571, 107.46198000000001)
                    ,
                    new google.maps.LatLng(-6.85578, 107.46188000000001)
                    ,
                    new google.maps.LatLng(-6.855790000000001, 107.46186000000002)
                    ,
                    new google.maps.LatLng(-6.85587, 107.46174)
                    ,
                    new google.maps.LatLng(-6.855980000000001, 107.46150000000002)
                    ,
                    new google.maps.LatLng(-6.856020000000001, 107.46139000000001)
                    ,
                    new google.maps.LatLng(-6.85611, 107.46113000000001)
                    ,
                    new google.maps.LatLng(-6.85615, 107.46097)
                    ,
                    new google.maps.LatLng(-6.8561700000000005, 107.46089)
                    ,
                    new google.maps.LatLng(-6.856190000000001, 107.4608)
                    ,
                    new google.maps.LatLng(-6.85625, 107.46044)
                    ,
                    new google.maps.LatLng(-6.85625, 107.46039)
                    ,
                    new google.maps.LatLng(-6.856300000000001, 107.45971000000002)
                    ,
                    new google.maps.LatLng(-6.85634, 107.45917000000001)
                    ,
                    new google.maps.LatLng(-6.856350000000001, 107.45905)
                    ,
                    new google.maps.LatLng(-6.8563600000000005, 107.45897000000001)
                    ,
                    new google.maps.LatLng(-6.856370000000001, 107.45874)
                    ,
                    new google.maps.LatLng(-6.856370000000001, 107.45872000000001)
                    ,
                    new google.maps.LatLng(-6.856380000000001, 107.45856)
                    ,
                    new google.maps.LatLng(-6.85639, 107.45842)
                    ,
                    new google.maps.LatLng(-6.85639, 107.45834)
                    ,
                    new google.maps.LatLng(-6.856400000000001, 107.45823000000001)
                    ,
                    new google.maps.LatLng(-6.856400000000001, 107.45814000000001)
                    ,
                    new google.maps.LatLng(-6.856400000000001, 107.45809000000001)
                    ,
                    new google.maps.LatLng(-6.85641, 107.45804000000001)
                    ,
                    new google.maps.LatLng(-6.856440000000001, 107.45774000000002)
                    ,
                    new google.maps.LatLng(-6.856450000000001, 107.45767000000001)
                    ,
                    new google.maps.LatLng(-6.856470000000001, 107.45741000000001)
                    ,
                    new google.maps.LatLng(-6.856520000000001, 107.45696000000001)
                    ,
                    new google.maps.LatLng(-6.856540000000001, 107.45681)
                    ,
                    new google.maps.LatLng(-6.856560000000001, 107.45660000000001)
                    ,
                    new google.maps.LatLng(-6.856560000000001, 107.45659)
                    ,
                    new google.maps.LatLng(-6.8565700000000005, 107.45652000000001)
                    ,
                    new google.maps.LatLng(-6.85658, 107.45646)
                    ,
                    new google.maps.LatLng(-6.85658, 107.45643000000001)
                    ,
                    new google.maps.LatLng(-6.85662, 107.45597000000001)
                    ,
                    new google.maps.LatLng(-6.856630000000001, 107.45584000000001)
                    ,
                    new google.maps.LatLng(-6.8566400000000005, 107.45572000000001)
                    ,
                    new google.maps.LatLng(-6.85665, 107.45556)
                    ,
                    new google.maps.LatLng(-6.85665, 107.45555)
                    ,
                    new google.maps.LatLng(-6.85665, 107.45533)
                    ,
                    new google.maps.LatLng(-6.85665, 107.45525)
                    ,
                    new google.maps.LatLng(-6.856660000000001, 107.45513000000001)
                    ,
                    new google.maps.LatLng(-6.85667, 107.45509000000001)
                    ,
                    new google.maps.LatLng(-6.85667, 107.45503000000001)
                    ,
                    new google.maps.LatLng(-6.85672, 107.45457)
                    ,
                    new google.maps.LatLng(-6.85672, 107.45444)
                    ,
                    new google.maps.LatLng(-6.85672, 107.45435)
                    ,
                    new google.maps.LatLng(-6.85672, 107.45434)
                    ,
                    new google.maps.LatLng(-6.85672, 107.4543)
                    ,
                    new google.maps.LatLng(-6.8567100000000005, 107.45412)
                    ,
                    new google.maps.LatLng(-6.8567100000000005, 107.45406000000001)
                    ,
                    new google.maps.LatLng(-6.8567100000000005, 107.45404)
                    ,
                    new google.maps.LatLng(-6.856700000000001, 107.45399)
                    ,
                    new google.maps.LatLng(-6.856700000000001, 107.45395)
                    ,
                    new google.maps.LatLng(-6.85669, 107.45392000000001)
                    ,
                    new google.maps.LatLng(-6.856680000000001, 107.4539)
                    ,
                    new google.maps.LatLng(-6.856680000000001, 107.45388000000001)
                    ,
                    new google.maps.LatLng(-6.85667, 107.45385)
                    ,
                    new google.maps.LatLng(-6.856660000000001, 107.45380000000002)
                    ,
                    new google.maps.LatLng(-6.85667, 107.45377)
                    ,
                    new google.maps.LatLng(-6.856680000000001, 107.45373000000001)
                    ,
                    new google.maps.LatLng(-6.856680000000001, 107.45372)
                    ,
                    new google.maps.LatLng(-6.85669, 107.45371000000002)
                    ,
                    new google.maps.LatLng(-6.856700000000001, 107.45370000000001)
                    ,
                    new google.maps.LatLng(-6.8567100000000005, 107.45368)
                    ,
                    new google.maps.LatLng(-6.85674, 107.45367)
                    ,
                    new google.maps.LatLng(-6.856890000000001, 107.45365000000001)
                    ,
                    new google.maps.LatLng(-6.857200000000001, 107.45360000000001)
                    ,
                    new google.maps.LatLng(-6.857220000000001, 107.45359)
                    ,
                    new google.maps.LatLng(-6.857240000000001, 107.45359)
                    ,
                    new google.maps.LatLng(-6.8573, 107.45358)
                    ,
                    new google.maps.LatLng(-6.857360000000001, 107.45355)
                    ,
                    new google.maps.LatLng(-6.8574, 107.45353000000001)
                    ,
                    new google.maps.LatLng(-6.857410000000001, 107.45352000000001)
                    ,
                    new google.maps.LatLng(-6.857410000000001, 107.45352000000001)
                    ,
                    new google.maps.LatLng(-6.857480000000001, 107.45356000000001)
                    ];
                    lat_longs_map.push(new google.maps.LatLng(-6.8472100000000005, 107.49114000000002));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.847090000000001, 107.49098000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84691, 107.49074));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.846620000000001, 107.49032000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.846470000000001, 107.49012));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84623, 107.48979000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8459900000000005, 107.48945));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.845940000000001, 107.48938000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8457300000000005, 107.48907000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84569, 107.48901000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84562, 107.48893000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.845540000000001, 107.48881000000002));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.845390000000001, 107.48859));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.845370000000001, 107.48858000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.845350000000001, 107.48854000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.845250000000001, 107.48840000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.845020000000001, 107.48808000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84499, 107.48804000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8449800000000005, 107.48802));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84487, 107.48787000000002));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8447700000000005, 107.48771));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84438, 107.48715000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84421, 107.48691000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.844060000000001, 107.48669000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.844, 107.48662));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.843940000000001, 107.48653));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84393, 107.48652000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.843890000000001, 107.48646000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84386, 107.48642000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.843560000000001, 107.48597000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.843330000000001, 107.48562000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.843210000000001, 107.48545000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.843030000000001, 107.48519));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84299, 107.48512000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.842950000000001, 107.48505000000002));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.842860000000001, 107.48488));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84273, 107.48457));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.842560000000001, 107.48423000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.842510000000001, 107.48412));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84248, 107.48406000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84245, 107.48399));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84236, 107.4838));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.842340000000001, 107.48375000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.842270000000001, 107.48360000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84219, 107.4834));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84212, 107.48326000000002));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.842090000000001, 107.48321000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84182, 107.48266000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.841640000000001, 107.48227000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8414600000000005, 107.48187000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.841310000000001, 107.48155000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.841290000000001, 107.48151000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.841290000000001, 107.48151000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84187, 107.48122000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84198, 107.48117));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.842040000000001, 107.48115000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.842280000000001, 107.48107));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.842320000000001, 107.48106000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84243, 107.48101000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84269, 107.48091000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.842740000000001, 107.48089));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.842910000000001, 107.48082000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84299, 107.48079000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84316, 107.48072));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84339, 107.48062));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.843540000000001, 107.48055000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84367, 107.4805));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8436900000000005, 107.48049));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.843730000000001, 107.48047000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.844, 107.48037000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.844390000000001, 107.48021000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84447, 107.48018));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84466, 107.48011000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84501, 107.47997000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.845350000000001, 107.47984000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.845460000000001, 107.47979000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.845580000000001, 107.47974));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84569, 107.47970000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84576, 107.47966000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.845890000000001, 107.4796));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84602, 107.47955));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84609, 107.47951));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.846400000000001, 107.47937));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.846570000000001, 107.47928));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8469500000000005, 107.47908000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.847180000000001, 107.47898));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84724, 107.47896000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.847290000000001, 107.47894000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.847320000000001, 107.47893));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.847580000000001, 107.47884));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84778, 107.47877000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.847790000000001, 107.47877000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.848020000000001, 107.47869000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84806, 107.47867000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.848260000000001, 107.47861));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84841, 107.47856000000002));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84846, 107.47854000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.848590000000001, 107.47849000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8486400000000005, 107.47847000000002));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84874, 107.47843));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84876, 107.47843));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84881, 107.47840000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.848890000000001, 107.47836000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.848980000000001, 107.47829000000002));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.848990000000001, 107.47829000000002));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84909, 107.47822000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84956, 107.47786));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.849710000000001, 107.47776));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8498600000000005, 107.47765000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.84987, 107.47764000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.849920000000001, 107.47760000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85012, 107.47749));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85029, 107.4774));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85031, 107.47738000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85036, 107.47736));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.850460000000001, 107.47730000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.850700000000001, 107.47719000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.850860000000001, 107.47712000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85104, 107.47705));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85113, 107.47701));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8512, 107.47696));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.851240000000001, 107.47693000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8512900000000005, 107.47686));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.851330000000001, 107.47681000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.851430000000001, 107.47661000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.851430000000001, 107.47661000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.851400000000001, 107.47657000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.851380000000001, 107.47654000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85134, 107.47647));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.851310000000001, 107.47642));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.851260000000001, 107.47636000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8512, 107.47629));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.851120000000001, 107.47621000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.851070000000001, 107.47615));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85106, 107.47614000000002));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8510100000000005, 107.47609000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8509400000000005, 107.47601));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.850880000000001, 107.47593));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85085, 107.47587000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85085, 107.47586000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.850840000000001, 107.47582000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.850840000000001, 107.4758));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.850840000000001, 107.47577000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.850840000000001, 107.47572000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.850840000000001, 107.47563000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.850840000000001, 107.47551000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.850840000000001, 107.47540000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.850840000000001, 107.47539));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.850840000000001, 107.47536000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.850840000000001, 107.47531000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.850820000000001, 107.47526));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.850790000000001, 107.47516));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.850740000000001, 107.47499));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85071, 107.47486));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8506800000000005, 107.47470000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.850670000000001, 107.47464000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85064, 107.47444000000002));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.850600000000001, 107.47415000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.850580000000001, 107.47393000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.850560000000001, 107.47372000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8505400000000005, 107.47348000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.850460000000001, 107.47316000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.850390000000001, 107.47287000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85038, 107.47279));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.850370000000001, 107.47269000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.850370000000001, 107.47256000000002));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.850370000000001, 107.47247000000002));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8504000000000005, 107.47235));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85045, 107.47219000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85052, 107.47196000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.850630000000001, 107.47161000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8506800000000005, 107.47147000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85073, 107.47134000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.850810000000001, 107.47119));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.850880000000001, 107.4711));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85097, 107.47096));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.851050000000001, 107.47082));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.851050000000001, 107.47082));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85104, 107.47075000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.851030000000001, 107.47071000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.851030000000001, 107.47070000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.851020000000001, 107.47065));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8510100000000005, 107.47058000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.851000000000001, 107.47055));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.851000000000001, 107.47051));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.851000000000001, 107.47046));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.851030000000001, 107.47035000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.851050000000001, 107.47026000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.851070000000001, 107.47019));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.851100000000001, 107.47008000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85111, 107.47004000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85116, 107.46981000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8512200000000005, 107.46956000000002));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85127, 107.46933000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.851280000000001, 107.46928000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.851280000000001, 107.46926));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.851310000000001, 107.46917));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85134, 107.46904));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85158, 107.468));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.851590000000001, 107.46792));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.851630000000001, 107.46779000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85165, 107.46765));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.851660000000001, 107.46763000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85174, 107.46727000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.851750000000001, 107.46727000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.851870000000001, 107.46663000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8519000000000005, 107.46649000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85202, 107.46600000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852150000000001, 107.46544000000002));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852180000000001, 107.46525000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8522300000000005, 107.4651));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85226, 107.46501));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85228, 107.46495));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8523000000000005, 107.46491));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852320000000001, 107.46484000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852320000000001, 107.46481000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852320000000001, 107.46478));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85233, 107.46475000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85233, 107.46472000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852320000000001, 107.46469));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85231, 107.46466000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852290000000001, 107.46462000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852270000000001, 107.4646));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85226, 107.46459000000002));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85219, 107.46455));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85212, 107.46450000000002));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852100000000001, 107.46449000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852080000000001, 107.46447));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85207, 107.46445000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85205, 107.46444000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852040000000001, 107.46441000000002));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852040000000001, 107.46438));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852030000000001, 107.46436000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852030000000001, 107.46433));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852030000000001, 107.46417000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852030000000001, 107.46402));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852030000000001, 107.46398));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852040000000001, 107.4638));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852060000000001, 107.46356000000002));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85207, 107.46349000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852080000000001, 107.46332000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8520900000000005, 107.46317));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852100000000001, 107.46306000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852100000000001, 107.46281));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852100000000001, 107.46281));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852130000000001, 107.46257000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852130000000001, 107.46251000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85214, 107.46245));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85214, 107.46242000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85214, 107.46241));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852150000000001, 107.4624));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8521600000000005, 107.46239000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852170000000001, 107.46238000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852180000000001, 107.46237));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852200000000001, 107.46237));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852220000000001, 107.46236));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852250000000001, 107.46236));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852270000000001, 107.46236));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8523000000000005, 107.46236));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8524, 107.46235000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85256, 107.46235000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852780000000001, 107.46233000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852790000000001, 107.46233000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.852970000000001, 107.46233000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.853350000000001, 107.46236));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85355, 107.46239000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.853650000000001, 107.4624));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.853910000000001, 107.46242000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85437, 107.46243000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.854680000000001, 107.46243000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.854920000000001, 107.46242000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.855160000000001, 107.46237));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.855300000000001, 107.46233000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85536, 107.46229000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8554, 107.46227));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.855460000000001, 107.46222));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.855580000000001, 107.46213));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.855670000000001, 107.46203000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85571, 107.46198000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85578, 107.46188000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.855790000000001, 107.46186000000002));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85587, 107.46174));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.855980000000001, 107.46150000000002));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.856020000000001, 107.46139000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85611, 107.46113000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85615, 107.46097));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8561700000000005, 107.46089));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.856190000000001, 107.4608));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85625, 107.46044));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85625, 107.46039));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.856300000000001, 107.45971000000002));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85634, 107.45917000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.856350000000001, 107.45905));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8563600000000005, 107.45897000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.856370000000001, 107.45874));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.856370000000001, 107.45872000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.856380000000001, 107.45856));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85639, 107.45842));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85639, 107.45834));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.856400000000001, 107.45823000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.856400000000001, 107.45814000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.856400000000001, 107.45809000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85641, 107.45804000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.856440000000001, 107.45774000000002));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.856450000000001, 107.45767000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.856470000000001, 107.45741000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.856520000000001, 107.45696000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.856540000000001, 107.45681));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.856560000000001, 107.45660000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.856560000000001, 107.45659));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8565700000000005, 107.45652000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85658, 107.45646));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85658, 107.45643000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85662, 107.45597000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.856630000000001, 107.45584000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8566400000000005, 107.45572000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85665, 107.45556));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85665, 107.45555));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85665, 107.45533));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85665, 107.45525));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.856660000000001, 107.45513000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85667, 107.45509000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85667, 107.45503000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85672, 107.45457));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85672, 107.45444));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85672, 107.45435));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85672, 107.45434));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85672, 107.4543));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8567100000000005, 107.45412));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8567100000000005, 107.45406000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8567100000000005, 107.45404));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.856700000000001, 107.45399));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.856700000000001, 107.45395));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85669, 107.45392000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.856680000000001, 107.4539));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.856680000000001, 107.45388000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85667, 107.45385));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.856660000000001, 107.45380000000002));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85667, 107.45377));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.856680000000001, 107.45373000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.856680000000001, 107.45372));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85669, 107.45371000000002));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.856700000000001, 107.45370000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8567100000000005, 107.45368));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.85674, 107.45367));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.856890000000001, 107.45365000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.857200000000001, 107.45360000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.857220000000001, 107.45359));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.857240000000001, 107.45359));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8573, 107.45358));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.857360000000001, 107.45355));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.8574, 107.45353000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.857410000000001, 107.45352000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.857410000000001, 107.45352000000001));
                
                    lat_longs_map.push(new google.maps.LatLng(-6.857480000000001, 107.45356000000001));
                
                var polyline_0 = new google.maps.Polyline({
                    path: polyline_plan_0,
                    strokeColor: "blue",
                    strokeOpacity: 1.0,
                    strokeWeight: 5
                });

                polyline_0.setMap(map);

            
                google.maps.event.addListener(polyline_0, "click", function() {
                    info_jalan("kUONTOl")
                });
                
            }

        
        function onstaged_map(){}
        
        function createMarker_map(markerOptions) {
            var marker = new google.maps.Marker(markerOptions);
            markers_map.push(marker);
            lat_longs_map.push(marker.getPosition());
            return marker;
        }
        function placesCallback(results, status) {
                if (status == google.maps.places.PlacesServiceStatus.OK) {
                    for (var i = 0; i < results.length; i++) {

                        var place = results[i];

                        var placeLoc = place.geometry.location;
                        var placePosition = new google.maps.LatLng(placeLoc.lat(), placeLoc.lng());
                        var markerOptions = {
                            map: map,
                            position: placePosition
                        };
                        var marker = createMarker_map(markerOptions);
                        marker.set("content", place.name);
                        google.maps.event.addListener(marker, "click", function() {
                            iw_map.setContent(this.get("content"));
                            iw_map.open(map, this);
                        });

                        lat_longs_map.push(placePosition);

                    }
                    
                }
            }
            
            google.maps.event.addDomListener(window, "load", initialize_map);
            
        function reverseGeocode(latlng, callback, obj) { //callback must be function
          //var latlng = {lat: parseFloat(latitude), lng: parseFloat(longitude)};
          geocoder.geocode({'location': latlng}, function(results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
              if (results[1]) {
                callback(200, results[1].formatted_address, obj );
              } else {
                callback(404, "Not found.", obj);
              }
            } else {
              callback(400, "Something wrong went.", obj );
            }
          });
        }
        