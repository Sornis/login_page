



<?php

// create the database & table if they don't exist (bit useless)
$servername = "localhost";
$username = "root";
$password = "";
$database = "testDB";
$table = "UserData";
$emailErr = $nameErr = $passwordErr = "";

$dbCreation = new mysqli($servername, $username); 
$dbCreation -> query("CREATE DATABASE IF NOT EXISTS $database");
$dbCreation -> close();

$tableCreation = new mysqli($servername, $username, $password, $database);
$tableCreation -> query("CREATE TABLE IF NOT EXISTS $table (
    `UserID` int NOT NULL AUTO_INCREMENT,
    `Username` varchar(40),
    `Email` varchar(40) NOT NULL,
    `Password` varchar(40) NOT NULL,
    PRIMARY KEY(UserID)
    )
");

$tableCreation -> close();  

// queries the database & checks form data from HTML when submitted 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = $_POST["name"];
    $email = $_POST["email"];
    $userPassword = $_POST["password"];

    // checks if any of the forms' input fields are empty - if they are, produce message variable for empty fields only
    if (empty($name) || empty($email) || empty($userPassword)) {
        if (empty($name)) {
            $nameErr = "Name is required*";
        }
        if (empty($email)) {
            $emailErr = "Email is required*";
        }
        if (empty($userPassword)) {
            $passwordErr = "Password is required*";
        }
    }
    
    // if the form is filled and the user doesn't already exist in the database, insert the data into the table and direct the user to the "landing_page"
    elseif (!empty($name) && !empty($email) && !empty($userPassword)) {
        $dbConnect = new mysqli($servername, $username, "", $database);

        $unameQueryResult = $dbConnect -> query("SELECT Username FROM $table WHERE Username = '$name'");
        $emailQueryResult = $dbConnect -> query("SELECT Email FROM $table WHERE Email = '$email'");

        // if username is used, or if e-mail has been used, write message
        if (mysqli_num_rows($emailQueryResult) > 0) echo "That user is already in the database";
        elseif (mysqli_num_rows($unameQueryResult) > 0) echo "That username is taken";
        else {

            // enter user info into database
            $dbConnect -> query("INSERT INTO $table (`Username`, `Email`, `Password`) VALUES ('$name', '$email', '$userPassword');");

            // get user's ID from row where 'Email' == $email
            $data = $dbConnect -> query("SELECT `UserId` FROM $table WHERE `Email` = '$email'");
            $data = $data -> fetch_assoc();
            $userId = $data["UserId"];

            // enter user into 'UserSettings' table 
            $dbConnect -> query("INSERT INTO UserSettings (`UserId`, `Headline`, `TextContent`, `Colour`) VALUES ('$userId', 'Welcome to your page!', 'It''s yours to do what you want with!', '#FFFFFF')");
            
            $userData = array(
                "userId" => $userId,
                "username" => $name,
                "email" => $email,
                "password" => $userPassword
            );
            

            session_start();
            $_SESSION["userData"] = $userData;
            header("Location: landing_page.php");
        }

        $dbConnect -> close();
    }
}

// make checks on the web pages for whether the e-mail & username & password combination matches any user in the database (maybe not password, since that'd require me to add password to $_SESSION. This MAY not be an issue if I one-way encrypt the password straight away with 

?>