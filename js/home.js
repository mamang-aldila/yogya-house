function houseMap(lat, lng) {
  var mapCanvas = document.getElementById('map');
  var position;
  if (lat != null && lng != null) {
    position = new google.maps.LatLng(lat, lng);
  } else {
    position = new google.maps.LatLng(-7.8032491, 110.3398252)
  }

  var mapOptions = {
    center: position,
    zoom: 17,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }

  var map = new google.maps.Map(mapCanvas, mapOptions);
}

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition, showError);
  } else {
    console.log("Geolocation is not supported by this browser.");
  }
}

function showPosition(position) {
  houseMap(position.coords.latitude, position.coords.longitude);
  console.log("Latitude: " + position.coords.latitude +", Longitude: " + position.coords.longitude);
}

function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            x.innerHTML = "User denied the request for Geolocation."
            break;
        case error.POSITION_UNAVAILABLE:
            x.innerHTML = "Location information is unavailable."
            break;
        case error.TIMEOUT:
            x.innerHTML = "The request to get user location timed out."
            break;
        case error.UNKNOWN_ERROR:
            x.innerHTML = "An unknown error occurred."
            break;
    }
}

function toDetail() {
  $.ajax({
    url: "detail.php", 
    success: function(result){
      $("#detail").html(result);
      $("#detail").css("width", "40%");
      $("#map").css("width", "60%");
    }
  });
}

getLocation();

