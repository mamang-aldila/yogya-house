<?

$host = "localhost";
$db = "jual-beli-rumah";
$username = "root";
$password = "";

function getConnection() {
	return new PDO('mysql:host=localhost;dbname=jual-beli-rumah', 'root', '');
}

?>