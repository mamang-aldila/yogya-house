<?
include 'base_service.php';

function all() {
	$all = array();
	$stmt = getConnection()->prepare('SELECT latitude, longitude FROM rumah');
	$stmt->execute();

	$result = $stmt->fetchAll();
	print_r(json_encode($result));
}

function find() {
	$all = array();
	$stmt = getConnection()->prepare('SELECT * FROM rumah WHERE latitude = :lat AND longitude = :lng');
	$stmt->bindParam(':lat', $_POST['latitude']);
	$stmt->bindParam(':lng', $_POST['longitude']);
	$stmt->execute();

	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	print_r(json_encode($result));
}

function save() {
	//    $imagesFolder = "web_dev/api-nanang/images/";
	// $imagesFolder = "/Applications/XAMPP/htdocs/house-aldi/images/";
	$imagesFolder = "http://rumah-yogya.esy.es/images/";
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
				$stmt = getConnection()->prepare('INSERT INTO `rumah`(`nama`, `alamat`, `latitude`, `longitude`, `no_telp`, `keterangan`, `harga`, `image`) VALUES (:nama, :alamat, :latitude, :longitude, :no_telp, :keterangan, :harga, :image)');
				$stmt->bindParam(':nama', $_POST['nama']);
				$stmt->bindParam(':alamat', $_POST['alamat']);
				$stmt->bindParam(':latitude', $_POST['latitude']);
				$stmt->bindParam(':longitude', $_POST['longitude']);
				$stmt->bindParam(':no_telp', $_POST['no_telp']);
				$stmt->bindParam(':keterangan', $_POST['keterangan']);
				$stmt->bindParam(':harga', $_POST['harga']);
				$stmt->bindParam(':image', $image_location);

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

if (!isset($_POST['nama']) && isset($_POST['latitude'])) {
	find();
} else if (isset($_POST['nama'])) {
	save();
} else {
	all();
}
?>
