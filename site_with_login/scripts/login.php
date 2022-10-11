



<?php

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "testDB";
$table = "UserData";
$wrongCredMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $userPassword = $_POST['password'];

    $dbSession = new mysqli($servername, $username, $password, $database);

    $userDataQuery = $dbSession -> query("SELECT `UserId`, `Username`, `Email`
                                        FROM $table 
                                        WHERE Email = '$email' AND `Password` = '$userPassword'");

    if(mysqli_num_rows($userDataQuery) > 0) {

        $data = $userDataQuery -> fetch_assoc();
        $userData = array(
            "userId" => $data["UserId"],
            "username" => $data["Username"],
            "email" => $data["Email"]
        );

        $_SESSION["userData"] = $userData;
        
        $_POST = [];
        header("Location: ../page.php");
    }
    else {
        $wrongCredMessage = "The e-mail or password is wrong";
    }
    $dbSession -> close();
}

?>
