<?php
 
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password'])) {
 
    // receiving the post params
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
 
    // check if users is already existed with the same email
    if ($db->isUserExisted($email)) {
        // users already existed
        $response["error"] = TRUE;
        $response["error_msg"] = "users already existed with " . $email;
        echo json_encode($response);
    } else {
        // create a new users
        $users = $db->storeUser($email, $name, $password);
        if ($users) {
            // users stored successfully
            $response["error"] = FALSE;
            //$response["uid"] = $users["unique_id"];
            $response["users"]["name"] = $users["name"];
            $response["users"]["email"] = $users["email"];
			$response["users"]["password"] = $users["password"];
           // $response["users"]["created_at"] = $users["created_at"];
            //$response["users"]["updated_at"] = $users["updated_at"];
            echo json_encode($response);
        } else {
            // users failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "Unknown error occurred in registration!";
            echo json_encode($response);
        }
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (name, email or password) is missing!";
    echo json_encode($response);
}
?>