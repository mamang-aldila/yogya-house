<div class="col-lg-12">
	<?
		if (session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}

		$json_detail = json_decode($_POST['detail']);
	?>
	<p id="id_detail" hidden><? echo $json_detail->id ?> </p>
	<img src="<? echo $json_detail->image ?>" height="200px"/><br>
	<label>Nama</label><br>
	<p><? echo $json_detail->nama ?></p>
	<label>Alamat</label><br>
	<p><? echo $json_detail->alamat ?></p>
	<label>Latitude</label><br>
	<p id="latitude-detail"><? echo $json_detail->latitude ?></p>
	<label>Longitude</label><br>
	<p id="longitude-detail"><? echo $json_detail->longitude ?></p>
	<label>Nomor Telepon</label><br>
	<p><? echo $json_detail->no_telp ?></p>
	<label>Keterangan</label><br>
	<p><? echo $json_detail->keterangan ?></p>
	<label>Harga</label><br>
	<p><? echo $json_detail->harga ?></p>
	<label>Jarak Lokasi ke Kota Yogyakarta</label><br>
	<p><? echo $json_detail->distance_jogja . " KM" ?></p>
	<?
	if (isset($json_detail->nearby_hospitals)) {
		echo '<label>Rumah Sakit Terdekat</label><br>
		<ul>';
			foreach ($json_detail->nearby_hospitals as $value) {
				echo '<li>'. $value->name .'</li>';
			}
		echo '</ul>';
	} else {
		echo '<label>Tidak ada rumah sakit terdekat</label><br>';
	}
	?>

	<button class="btn btn-warning" onclick="cancel()">Selesai</button>
	<?
	if (isset($_SESSION['user_id'])) {
		echo '<button class="btn btn-warning" onclick="edit()">Edit</button>&nbsp<button class="btn btn-danger" onclick="hapus()">Hapus</button>';
	}
	?>

</div>
