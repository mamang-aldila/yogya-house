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
	$stmt = getConnection()->prepare('INSERT INTO `rumah`(`nama`, `alamat`, `latitude`, `longitude`, `no_telp`, `keterangan`, `harga`) VALUES (:nama, :alamat, :latitude, :longitude, :no_telp, :keterangan, :harga)');
        $stmt->bindParam(':nama', $_POST['nama']);
        $stmt->bindParam(':alamat', $_POST['alamat']);
        $stmt->bindParam(':latitude', $_POST['latitude']);
        $stmt->bindParam(':longitude', $_POST['longitude']);
        $stmt->bindParam(':no_telp', $_POST['no_telp']);
        $stmt->bindParam(':keterangan', $_POST['keterangan']);
        $stmt->bindParam(':harga', $_POST['harga']);
        
        if ($stmt->execute()) {	
        	echo true;
       	} else {
        	print_r($stmt->errorInfo());
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