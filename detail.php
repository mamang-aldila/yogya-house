<div class="col-lg-12">
	<?
		$json_detail = json_decode($_POST['detail']);
	?>
	<img src="<? echo $json_detail->image ?>" height="200px"/><br>
	<label>Nama</label><br>
	<p><? echo $json_detail->nama ?></p>
	<label>Alamat</label><br>
	<p><? echo $json_detail->alamat ?></p>
	<label>Latitude</label><br>
	<p><? echo $json_detail->latitude ?></p>
	<label>Longitude</label><br>
	<p><? echo $json_detail->longitude ?></p>
	<label>Nomor Telepon</label><br>
	<p><? echo $json_detail->no_telp ?></p>
	<label>Keterangan</label><br>
	<p><? echo $json_detail->keterangan ?></p>
	<label>Harga</label><br>
	<p><? echo $json_detail->harga ?></p>
	<label>Jarak Lokasi ke Kota Yogyakarta</label><br>
	<p><? echo $json_detail->distance_jogja . " KM" ?></p>
	<label>Rumah Sakit Terdekat</label><br>
	<ul>
		<?
		foreach ($json_detail->nearby_hospitals as $value) {
			echo '<li>'. $value->name .'</li>';
		}
		?>
	</ul>
	<button class="btn btn-warning" onclick="cancel()">Selesai</button>
</div>
