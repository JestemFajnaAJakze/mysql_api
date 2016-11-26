<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['email']) && isset($_POST['password'])) {
 
    // receiving the post params
    $email = $_POST['email'];
    $password = $_POST['password'];
 
    // get the users by email and password
    $users = $db->getUserByEmailAndPassword($email, $password);
 
    if ($users != false) {
        // use is found
        $response["error"] = FALSE;
        //$response["uid"] = $users["unique_id"];
		$response["users"]["_id"] = $users["name"];
        $response["users"]["name"] = $users["name"];
        $response["users"]["email"] = $users["email"];
        $response["users"]["password"] = $users["password"];
        //$response["users"]["updated_at"] = $users["updated_at"];
        echo json_encode($response);
    } else {
        // users is not found with the credentials
        $response["error"] = TRUE;
        $response["error_msg"] = "Login credentials are wrong. Please try again!";
        echo json_encode($response);
    }
} else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters email or password is missing!";
    echo json_encode($response);
}
?>