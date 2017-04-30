      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
      var map;
      var marker;
      var infowindow;
      var plot_loading = false;


      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 23.8103, lng: 90.4125},
          zoom: 4,
          minZoom: 3, maxZoom: 9
        });
        //var card = document.getElementById('pac-card');
        var input = document.getElementById('pac-input');
        var types = document.getElementById('type-selector');
        var strictBounds = document.getElementById('strict-bounds-selector');

        //map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

        var autocomplete = new google.maps.places.Autocomplete(input);

        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
        autocomplete.bindTo('bounds', map);

        infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);
        marker = new google.maps.Marker({
          map: map,
          anchorPoint: new google.maps.Point(0, -29)
        });

        autocomplete.addListener('place_changed', function() {
			if(plot_loading == true){
				alert("Please Wait Before Requesting Another Location.");
				return;
            }

            infowindow.close();
            marker.setVisible(false);
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }

            // If the place has a geometry, then present it on a map.
            if(place.geometry.viewport){
                map.fitBounds(place.geometry.viewport);
            }else{
                map.setCenter(place.geometry.location);
                map.setZoom(17);  // Why 17? Because it looks good.
            }
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

            var address = '';
            if(place.address_components){
                address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }

            infowindowContent.children['place-icon'].src = place.icon;
            infowindowContent.children['place-name'].textContent = place.name;
            infowindowContent.children['place-address'].textContent = address;
            infowindow.open(map, marker);
            document.getElementById("lat").value = marker.getPosition().lat();
            document.getElementById("long").value = marker.getPosition().lng();
            AskInfo(marker.getPosition().lat(), marker.getPosition().lng());
            
        });

        // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.
        function setupClickListener(id, types) {
            var radioButton = document.getElementById(id);
            radioButton.addEventListener('click', function() {
                autocomplete.setTypes(types);
            });
        }

        setupClickListener('changetype-all', []);
        setupClickListener('changetype-address', ['address']);
        setupClickListener('changetype-establishment', ['establishment']);
        setupClickListener('changetype-geocode', ['geocode']);

        document.getElementById('use-strict-bounds').addEventListener('click', function() {
              console.log('Checkbox clicked! New state=' + this.checked);
              autocomplete.setOptions({strictBounds: this.checked});
        });

        google.maps.event.addListener(map, 'click', function (event) {
                if(plot_loading == true){
                  alert("Please Wait Before Requesting Another Location.");
                  return;
                }
                document.getElementById("lat").value = event.latLng.lat();
                document.getElementById("long").value = event.latLng.lng();
                marker.setPosition(event.latLng);
                AskInfo(event.latLng.lat(), event.latLng.lng());
                infowindow.close();
        });
    }

        function AskInfo(lat, lon){
            

            plot_loading = true;
            document.getElementById('result').innerHTML = '<br><br><br><center><img src="dist/img/gears.gif" width="150"></center>';
            $.ajax({
                url: "forecast/forecast.php?lat="+lat+"&lon="+lon,
                context: document.body
            }).done(function(html) {
                document.getElementById('result').innerHTML = html;
                plot_loading = false;
            }).fail(function() {
                document.getElementById('result').innerHTML = "<br><b>Network Connectivity Issue.</b><br>";
                plot_loading = false;
            }).always(function() {
                plot_loading = false;
            });
        }