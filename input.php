<div class="col-lg-12">
	<label>Nama</label><br>
	<input type="text" name="nama" class="form-control" required="true">
	<label>Alamat</label><br>
	<input type="text" name="alamat" class="form-control" required="true">
	<label>Kabupaten</label><br>
	<select class="form-control" id="kabupaten-selector">
		<?
		include 'data/service/base_service.php';

		$stmt = getConnection()->prepare('SELECT * FROM lokasi ORDER BY nama ASC');
		$stmt->execute();

		$result = $stmt->fetchAll();

		foreach ($result as $row) {
			echo '<option value="'. $row["id"] .'">'. $row["nama"] .'</option>';
		}
		?>
	</select><br>
	<label>Latitude</label><br>
	<input id="lat" type="text" name="latitude" class="form-control" required="true">
	<label>Longitude</label><br>
	<input id="lng" type="text" name="longitude" class="form-control" required="true">
	<label>Nomor Telepon</label><br>
	<input type="text" name="telepon" class="form-control" required="true">
	<label>Keterangan</label><br>
	<input type="text" name="keterangan" class="form-control" required="true">
	<label>Harga</label><br>
	<input type="text" name="harga" class="form-control" required="true"><br>
	<label>Gambar </label><br>
	<input class="form-control" type="file" placeholder="File Gambar" name="gambar" id="image_file"/><br>
	<button class="btn btn-success" onclick="saveData()">Simpan</button>
	<button class="btn btn-danger" onclick="cancel()">Batal</button>
</div>
