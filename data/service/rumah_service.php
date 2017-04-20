<?
include 'base_service.php';

function all() {
	$all = array();
	$stmt = getConnection()->prepare('SELECT id, latitude, longitude FROM rumah');
	$stmt->execute();

	$result = $stmt->fetchAll();
	print_r(json_encode($result));
}

function find() {
	$all = array();
	$stmt = getConnection()->prepare('SELECT * FROM rumah WHERE id = :id_detail');
	$stmt->bindParam(':id_detail', $_POST['id']);
	// $stmt->bindParam(':lat', $_POST['latitude']);
	// $stmt->bindParam(':lng', $_POST['longitude']);
	$stmt->execute();

	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	print_r(json_encode($result));
}

function save() {
	$imagesFolder = "/Applications/XAMPP/htdocs/house-aldi/images/";
	// $imagesFolder = "http://rumah-yogya.esy.es/images/";
	// $imagesFolder = "/home/u655896071/public_html/images/";
	$target_file = $imagesFolder . basename($_FILES["gambar"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

	$check = getimagesize($_FILES["gambar"]["tmp_name"]);
	if ($check !== false) {
		// echo "File is an image - " . $check["mime"] . ".";
		$uploadOk = 1;
	} else {
		// echo "File is not an image.";
		$uploadOk = 0;
	}

	$image_location = "http://localhost/house-aldi/images/".$_FILES["gambar"]["name"];
	// $image_location = "http://rumah-yogya.esy.es/images/".$_FILES["gambar"]["name"];

	if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
	} else {
		try {
			if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
				$stmt = getConnection()->prepare('INSERT INTO `rumah`(`nama`, `alamat`, `latitude`, `longitude`, `no_telp`, `keterangan`, `harga`, `image`, `id_location`) VALUES (:nama, :alamat, :latitude, :longitude, :no_telp, :keterangan, :harga, :image, :id_location)');
				$stmt->bindParam(':nama', $_POST['nama']);
				$stmt->bindParam(':alamat', $_POST['alamat']);
				$stmt->bindParam(':latitude', $_POST['latitude']);
				$stmt->bindParam(':longitude', $_POST['longitude']);
				$stmt->bindParam(':no_telp', $_POST['no_telp']);
				$stmt->bindParam(':keterangan', $_POST['keterangan']);
				$stmt->bindParam(':harga', $_POST['harga']);
				$stmt->bindParam(':image', $image_location);
				$stmt->bindParam(':id_location', $_POST['kabupaten']);

				if ($stmt->execute()) {
					echo true;
				} else {
					print_r($stmt->errorInfo());
				}
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		} catch (Exception $e) {
			echo 'error upload : ' . $e->getMessage();
		}
	}
}

function update() {
	// echo 'nama : ' . $_POST['nama'] . ', alamat : ' . $_POST['alamat'] .
	// ', latitude : ' . $_POST['latitude'] . ', longitude : ' . $_POST['longitude'] .
	// ', No Telepon : ' . $_POST['no_telp'] . ', Keterangan : ' . $_POST['keterangan'] .
	// ', Harga : ' . $_POST['harga'] . ', Id Kabupaten : ' . $_POST['kabupaten'] . ', Id Rumah : ' . $_POST['id_rumah'];
	$idRumah = (int) $_POST['id_rumah'];
	if (isset($_FILES["gambar"])) {
		$imagesFolder = "/Applications/XAMPP/htdocs/house-aldi/images/";
		// $imagesFolder = "http://rumah-yogya.esy.es/images/";
		// $imagesFolder = "/home/u655896071/public_html/images/";
		$target_file = $imagesFolder . basename($_FILES["gambar"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

		$check = getimagesize($_FILES["gambar"]["tmp_name"]);
		if ($check !== false) {
			$uploadOk = 1;
		} else {
			$uploadOk = 0;
		}

		$image_location = "http://localhost/house-aldi/images/".$_FILES["gambar"]["name"];
		// $image_location = "http://rumah-yogya.esy.es/images/".$_FILES["gambar"]["name"];

		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
		} else {

			try {
				if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
					$stmtImage = getConnection()->prepare('UPDATE `rumah` SET `image`= :image WHERE `id` = :id_rumah');
					$stmtImage->bindParam(':image', $image_location);
					$stmtImage->bindParam(':id_rumah', $_POST['id_rumah']);
					$stmtImage->execute();
				} else {
					echo "Sorry, there was an error uploading your file.";
				}
			} catch (Exception $e) {
				echo 'error upload : ' . $e->getMessage();
			}
		}
	}

	$stmtUpdate = getConnection()->prepare('UPDATE `rumah` SET `nama`= :nama, `alamat`= :alamat,`latitude`= :latitude,`longitude`= :longitude,`no_telp`= :no_telp,`keterangan`= :keterangan,`harga`= :harga, `id_location`= :kabupaten WHERE `id` = :id_rumah');
	$stmtUpdate->bindParam(':nama', $_POST['nama']);
	$stmtUpdate->bindParam(':alamat', $_POST['alamat']);
	$stmtUpdate->bindParam(':latitude', $_POST['latitude']);
	$stmtUpdate->bindParam(':longitude', $_POST['longitude']);
	$stmtUpdate->bindParam(':no_telp', $_POST['no_telp']);
	$stmtUpdate->bindParam(':keterangan', $_POST['keterangan']);
	$stmtUpdate->bindParam(':harga', $_POST['harga']);
	$stmtUpdate->bindParam(':kabupaten', $_POST['kabupaten']);
	$stmtUpdate->bindParam(':id_rumah', $_POST['id_rumah']);
	if ($stmtUpdate->execute()) {
		echo true;
	} else {
		print_r($stmtUpdate->errorInfo());
	}
}

function distance($lat1, $lon1, $lat2, $lon2, $unit) {
	$theta = $lon1 - $lon2;
	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	$dist = acos($dist);
	$dist = rad2deg($dist);
	$miles = $dist * 60 * 1.1515;
	$unit = strtoupper($unit);

	// if ($unit == "K") {
	return ($miles * 1.609344);
	// } else if ($unit == "N") {
	// 	return ($miles * 0.8684);
	// } else {
	// 	return $miles;
	// }
}

function findByKabupaten() {
	$query = '%' . $_POST['q'] . '%';
	$stmt = getConnection()->prepare('SELECT r.id, r.nama, r.latitude, r.longitude, r.image, r.alamat, r.harga, l.nama AS nama_kabupaten FROM rumah r INNER JOIN lokasi l ON r.id_location = l.id WHERE l.nama LIKE :name');
	$stmt->bindParam(':name', $query);
	$stmt->execute();

	$result = $stmt->fetchAll();
	print_r(json_encode($result));
}

function hapus() {
	$stmt = getConnection()->prepare('DELETE FROM `rumah` WHERE id = :id_hapus');
	$stmt->bindParam(':id_hapus', $_POST['id_hapus']);
	if ($stmt->execute()) {
		echo true;
	} else {
		print_r($stmt->errorInfo());
	}
}

if (!isset($_POST['nama']) && isset($_POST['latitude'])) {
	find();
} else if (!isset($_POST['id_rumah']) && isset($_POST['nama'])) {
	save();
} else if (isset($_POST['q'])) {
	findByKabupaten();
} else if (isset($_POST['edit']) && isset($_POST['id'])) {
	find();
} else if (isset($_POST['id_rumah'])) {
	update();
} else if (isset($_POST['id_hapus'])) {
	hapus();
} else {
	all();
}
?>
