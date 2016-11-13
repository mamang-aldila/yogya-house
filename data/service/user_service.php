<?

session_start();

include 'base_service.php';

function login() {
	$stmt = getConnection()->prepare('
            SELECT * FROM user 
             WHERE email = :email
             AND password = :password
        ');
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':password', $_POST['password']);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (isset($result)) {
        	if (isset($result['id'])) {
        		$_SESSION['user_id'] = $result['id'];
        		echo true;
        	} else {
        		echo false;
        	}	
        }
}

if (isset($_SESSION['user_id'])) {
	$_SESSION['user_id'] = null;
} else {
	login();
}
?>