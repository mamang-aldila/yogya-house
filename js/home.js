var map;
var rumahArray;
function houseMap(lat, lng) {
  var mapCanvas = document.getElementById('map');
  var positionFirst;

  if (lat != null && lng != null) {
    positionFirst = new google.maps.LatLng(lat, lng);
  } else {
    positionFirst = new google.maps.LatLng(-7.8032491, 110.3398252)
  }

  var mapOptions = {
    center: positionFirst,
    zoom: 12,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }

  map = new google.maps.Map(mapCanvas, mapOptions);
  allData();

  google.maps.event.addListener(map,'click',function(event) {
    var latForm = $('#lat');
    var lngForm = $('#lng');
    if (latForm !=  null) {
      latForm.val(event.latLng.lat());
    }

    if (lngForm !=  null) {
      lngForm.val(event.latLng.lng());
    }
  });

  // if (rumahArray == null) {

  // }
}

function distance(lat1, lon1, lat2, lon2) {
  var radlat1 = Math.PI * lat1/180
  var radlat2 = Math.PI * lat2/180
  var theta = lon1-lon2
  var radtheta = Math.PI * theta/180
  var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
  dist = Math.acos(dist)
  dist = dist * 180/Math.PI
  dist = dist * 60 * 1.1515
  dist = dist * 1.609344
  // if (unit=="K") { dist = dist * 1.609344 }
  // if (unit=="N") { dist = dist * 0.8684 }
  return dist
}

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition, showError);
  } else {
    console.log("Geolocation is not supported by this browser.");
  }
}

function showPosition(position) {
  houseMap(position.coords.latitude, position.coords.longitudes);
  // console.log("Latitude: " + position.coords.latitude +", Longitude: " + position.coords.longitude);
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

function addData() {
  $.ajax({
    url: "input.php",
    success: function(result){
      $("#detail").html(result);
      $("#detail").css("width", "40%");
      $("#map").css("width", "60%");
    }
  });
}

function loginPage() {
  $.ajax({
    url: "login.php",
    success: function(result){
      $("#detail").html(result);
      $("#detail").css("width", "40%");
      $("#map").css("width", "60%");
    }
  });
}

function searchPage() {
  // console.log("search query : " + $('input:text[name=q]').val());
  $.ajax({
    type: 'POST',
    url: "data/service/rumah_service.php",
    data: { 'q' :  $('input:text[name=q]').val() },
    success: function( result ){
      $.post( "search.php", { search_results : result })
      .done(function(data) {
        $("#detail").html(data);
        $("#detail").css("width", "40%");
        $("#map").css("width", "60%");
      });
    }
  });
}

function cancel() {
  $("#detail").css("width", "0%");
  $("#map").css("width", "100%");
}

function saveData() {
  var nama = $('input:text[name=nama]').val();
  var alamat = $('input:text[name=alamat]').val();
  var lat = $('input:text[name=latitude]').val();
  var lng = $('input:text[name=longitude]').val();
  var telp = $('input:text[name=telepon]').val();
  var ket = $('input:text[name=keterangan]').val();
  var harga = $('input:text[name=harga]').val();
  var kabupaten = $('#kabupaten-selector').val();
  var image = document.getElementById('image_file');

  var formData = new FormData();
  formData.append('nama', nama);
  formData.append('alamat', alamat);
  formData.append('latitude', lat);
  formData.append('longitude', lng);
  formData.append('no_telp', telp);
  formData.append('keterangan', ket);
  formData.append('harga', harga);
  formData.append('gambar', image.files[0], image.files[0].name);
  formData.append('kabupaten', kabupaten);

  // console.log("nama " + nama + ", alamat" + alamat + ", latitude" + lat + ", longitude" + lng + ", no_telp" + telp + ", keterangan" + ket +", harga" + harga + ", kabupaten : " + kabupaten);
  $.ajax({
    url: "data/service/rumah_service.php",
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function(result){
      if (result == true) {
        window.location.reload();
      } else {
        alert(result);
      }
    }
  });
}

function allData() {
  $.ajax({
    url: "data/service/rumah_service.php",
    success: function(result){
      // console.log("result all  : " + result);s
      rumahArray = JSON.parse(result);
      if (rumahArray != null && rumahArray.length > 0) {
        for (var i = 0; i < rumahArray.length; i++) {
          var myLatLng = new google.maps.LatLng(Number(rumahArray[i][1]), Number(rumahArray[i][2]));
          var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            id: rumahArray[i][0]});
            // console.log("id rumah  : " + rumahArray[i][0]);

            google.maps.event.addListener(marker, 'click', function(event) {
              var currentLatlng = new google.maps.LatLng(event.latLng.lat(), event.latLng.lng());
              map.setCenter(currentLatlng);
              detail(marker.id, event.latLng.lat(), event.latLng.lng());
            });
          }
        }
        // console.log("result rumahArray  : " + rumahArray.length);
      }
    });
  }

  function detail(id, lat, lng) {
    $.ajax({
      type: 'POST',
      url: "data/service/rumah_service.php",
      data: { 'id' : id, 'latitude' : lat, 'longitude' : lng },
      success: function(result){
        // console.log("result detail  : " + result);
        var jsonResult = JSON.parse(result);
        jsonResult.distance_jogja = Number(distance(-7.803249, 110.3398253, jsonResult.latitude, jsonResult.longitude)).toFixed(2);
        var markerClickLocation = {lat: Number(jsonResult.latitude), lng: Number(jsonResult.longitude)};
        var service = new google.maps.places.PlacesService(map);
        service.nearbySearch({
          location: markerClickLocation,
          radius: 500,
          type: ['hospital']
        }, function(results, status) {
          if (status === google.maps.places.PlacesServiceStatus.OK) {
            jsonResult.nearby_hospitals = results;
            $.post( "detail.php", { detail: JSON.stringify(jsonResult) })
            .done(function( data ) {
              $("#detail").html(data);
              $("#detail").css("width", "40%");
              $("#map").css("width", "60%");
            });
          }
        });
      }
    });
  }

  function login() {
    var email = $('input:text[name=email]').val();
    var password = $('input:password[name=password]').val();
    $.ajax({
      type: 'POST',
      url: "data/service/user_service.php",
      data: { 'email' : email, 'password' : password },
      success: function(result){
        if (result == true) {
          window.location.reload();
        } else {
          alert("Login salah!");
        }
      }
    });
  }

  function logout() {
    $.ajax({
      url: "data/service/user_service.php",
      success: function(result){
        window.location.reload();
      }
    });
  }

  getLocation();
