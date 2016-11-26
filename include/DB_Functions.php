<?php
 
class DB_Functions {
 
    private $conn;
 
    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }
 
    // destructor
    function __destruct() {
         
    }
 
    /**
     * Storing new users
     * returns users details
     */
    public function storeUser($name, $email, $password) {
        
 
        $stmt = $this->conn->prepare("INSERT INTO users(name, email, password) VALUES(?, ?, ?)");
        $stmt->bind_param('sss', $name, $email, $password);
		//$stmt->bind_param($name, $email, $password);

        $result = $stmt->execute();
        $stmt->close();
 
        // check for successful store
		
		
		
		
        if ($result) {
            /*$stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $users = $stmt->get_result()->fetch_assoc();
            $stmt->close();
			
 */
			$users = $db->getUserByEmailAndPassword($email, $password);
 
            return $users;
        } else {
            return false;
        }
    }
 
    /**
     * Get users by email and password
     */
    public function getUserByEmailAndPassword($email, $password) {
 
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
 
        $stmt->bind_param('ss', $email, $password);
		
		
		if ($stmt->execute()) {
        
            // correct password log in 
            $users = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $users;
        } else {
            // invalid password warning
            $stmt->close();
            return NULL;
        }
    }
 
    /**
     * Check users is existed or not
     */
    public function isUserExisted($email) {
        $stmt = $this->conn->prepare("SELECT email from users WHERE email = ?");
 		
        $stmt->bind_param('s',$email);
 
        $stmt->execute();
 
        $stmt->store_result();
 
        if ($stmt->num_rows > 0) {
            // users existed 
            $stmt->close();
            return true;
        } else {
            // users not existed
            $stmt->close();
            return false;
        }
    }
}
 
?>