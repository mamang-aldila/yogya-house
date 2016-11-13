<?
//for development
$host = "localhost";
$db = "jual-beli-rumah";
$username = "root";
$password = "";

//for production
$host = "mysql.idhostinger.com";
$db = "u655896071_rumah";
$username = "u655896071_aldi";
$password = "qwerasdf";


function getConnection() {
	// try {
	// 	$conn = new PDO('mysql:host=localhost;dbname=jual-beli-rumah', 'root', '');
	// 	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// 	return $conn;
	// } catch (PDOException $e) {
	// 	print_r($e->getMessage())
	// }

	// return new PDO('mysql:host=localhost;dbname=jual-beli-rumah', 'root', '');
	return new PDO('mysql:host=mysql.idhostinger.com;dbname=u655896071_rumah', 'u655896071_aldi', 'qwerasdf');
}

?>