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

  console.log("nama " + nama + ", alamat" + alamat + ", latitude" + lat + ", longitude" + lng + ", no_telp" + telp + ", keterangan" + ket +", harga" + harga);
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
      console.log("result all  : " + result);
      rumahArray = JSON.parse(result);
      if (rumahArray != null && rumahArray.length > 0) {
        for (var i = 0; i < rumahArray.length; i++) {
          var myLatLng = new google.maps.LatLng(Number(rumahArray[i][0]), Number(rumahArray[i][1]));
          var marker = new google.maps.Marker({
            position: myLatLng,
            map: map });

            google.maps.event.addListener(marker, 'click', function(event) {
              console.log("marker lat  : " + event.latLng.lat() + ", marker lng : " + event.latLng.lng());
              detail(event.latLng.lat(), event.latLng.lng());
            });
          }
        }
        console.log("result rumahArray  : " + rumahArray.length);
      }
    });
  }

  function detail(lat, lng) {
    $.ajax({
      type: 'POST',
      url: "data/service/rumah_service.php",
      data: { 'latitude' : lat, 'longitude' : lng },
      success: function(result){
        // console.log("result detail  : " + result);
        $.post( "detail.php", { detail: result })
        .done(function( data ) {
          $("#detail").html(data);
          $("#detail").css("width", "40%");
          $("#map").css("width", "60%");
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
