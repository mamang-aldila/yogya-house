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
	$stmt = getConnection()->prepare('SELECT * FROM rumah WHERE latitude = :lat OR longitude = :lng');
	$stmt->bindParam(':lat', $_POST['latitude']);
	$stmt->bindParam(':lng', $_POST['longitude']);
	$stmt->execute();

	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	print_r(json_encode($result));
}

function save() {
	// $imagesFolder = "/Applications/XAMPP/htdocs/house-aldi/images/";
	$imagesFolder = "http://rumah-yogya.esy.es/images/";
	// $imagesFolder = "/public_html/images/";
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

	// $image_location = "http://localhost/house-aldi/images/".$_FILES["gambar"]["name"];
	$image_location = "http://rumah-yogya.esy.es/images/".$_FILES["gambar"]["name"];

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
	$stmt = getConnection()->prepare('SELECT r.nama, r.latitude, r.longitude, r.alamat, r.harga, l.nama AS nama_kabupaten FROM rumah r INNER JOIN lokasi l ON r.id_location = l.id WHERE l.nama LIKE :name');
	$stmt->bindParam(':name', $query);
	$stmt->execute();

	$result = $stmt->fetchAll();
	print_r(json_encode($result));
}

if (!isset($_POST['nama']) && isset($_POST['latitude'])) {
	find();
} else if (isset($_POST['nama'])) {
	save();
} else if (isset($_POST['q'])) {
	findByKabupaten();
} else {
	all();
}
?>
