function getLocation(){
    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    }else{ 
        alert("Unable to get location.");
    }
}

function showPosition(position) {
    document.getElementById("lat").value = position.coords.latitude;
    document.getElementById("lon").value = position.coords.longitude;
    var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
    marker.setPosition(latlng);
    marker.setVisible(true);
    map.setCenter(latlng);
    map.setZoom(15);
    geocodeLatLng(position.coords.latitude, position.coords.longitude);
}

function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            alert("Location permission denied!");
            break;
        case error.POSITION_UNAVAILABLE:
            alert("Location unavailbale.");
            break;
        case error.TIMEOUT:
            alert("Location request timeout!");
            break;
        case error.UNKNOWN_ERROR:
            alert("An error occured while getting location");
            break;
    }
}