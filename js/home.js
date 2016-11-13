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
    zoom: 17,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }

  // if (rumahArray == null) {
    allData();
    if (rumahArray != null && rumahArray.length > 0) {
      for (var i = 0; i < rumahArray.length; i++) {
        console.log("latitude : " + rumahArray[i] + ", longitude : " + rumahArray[i]);
        var myLatLng = new google.maps.LatLng(rumahArray[i][0], rumahArray[i][1]);
        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map
          });
        console.log("marker is " + marker);
      }
    }
  // }

  map = new google.maps.Map(mapCanvas, mapOptions);
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
  console.log("nama " + nama + ", alamat" + alamat + ", latitude" + lat + ", longitude" + lng + ", no_telp" + telp + ", keterangan" + ket +", harga" + harga);
  $.ajax({
    type: 'POST',
    url: "data/service/rumah_service.php", 
    data: { 'nama' : nama, 'alamat' : alamat, 'latitude' : lat, 'longitude' : lng, 'no_telp' : telp, 'keterangan' : ket, 'harga' : harga },
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
      // console.log("result all rumah  : " + result);
      rumahArray = JSON.parse(result);
      // for(var i = 0;i < resultRumahs.length;i++) {
      //   rumah = new Array();
      //   rumah
      //   rumahArray[i] 
      // }
      // console.log("result all rumah  : " + rumahArray[1][0]);
      // rumahArray = new Array(<?php echo implode(',', $day); ?>);
      console.log("result rumahArray  : " + rumahArray[0][0]);
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

