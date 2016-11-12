<?

class BaseService {

	private static final $host = "localhost";
	private static final $db = "jual-beli-rumah";
	private static final $username = "root";
	private static final $password = "";

	private static $baseService = null;

	public static getInstance() {
		try {
			if ($baseService == null) {
	    		$baseService = new PDO('mysql:host=' + $host + ';dbname=' + $db, $user, $password);
	    	}

	      	return $baseService;
	    } catch(PDOException $e) {
	      	die($e->getMessage());
	    }	
	}
}

?>