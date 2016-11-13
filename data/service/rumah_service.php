<?
include 'base_service.php';

function all() {
	$all = array();
	$stmt = getConnection()->prepare('
            SELECT latitude, longitude FROM rumah
        ');
        $stmt->execute();

        // $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        print_r(json_encode($result));
        // print_r($result);
        // for($i = 0; $i < count($result);$i++) {
        // 	print_r($result[$i]);
        // 	$latlng = array();
        // 		$latlng[] = $result[$i][0];
        // 		$latlng[] = $result[$i][0];
        // 		$all[] = $latlng;
        // }
        // if (isset($result)) {
        	// while ($row = $result) {
        	// 	$latlng = array();
        	// 	$latlng[] = $row['latitude'];
        	// 	$latlng[] = $row['longitude'];
        	// 	$all[] = $latlng;
        	// }	

        	// print_r($all);
        // } else {
        // 	echo false;
        // }
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
        // $stmt->execute();
        
        if ($stmt->execute()) {	
        	echo true;
       	} else {
        	print_r($stmt->errorInfo());
        }
}

if (isset($_POST['nama'])) {
	save();
} else {
	all();
}
?>