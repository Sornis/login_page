



<?php

// Function for checking if input matches a user in the database
// This needs to return an error message if the username is taken or the e-mail has been used
// Outputs: emailErr or usernameErr

// function for checking 

function checkIfUserInDatabase($dbConnection, $table, $username = "", $email = "") {

    // check if username matches
    

    
    $stmt = $dbConnection -> prepare("SELECT `Username`, `Email` FROM $table WHERE `Username` = ?");
    $stmt -> bind_param("s", $value);
    $stmt -> execute();
    $stmt -> bind_result($username);
    $stmt -> fetch();
}



session_start();

if (isset($_SESSION["userData"])) {         // unsafe

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "testDB";
    $table = "UserSettings";
    $userId = $_SESSION["userData"]["userId"];

    $headlineInput = $_POST["headlineInput"];
    $textInput = $_POST["textInput"];
    $colour = $_POST["colourSelect"];

    // initiate database connection
    $dbConnect = new mysqli($servername, $username, $password, $database);

    // ensures data has been submitted before code is run
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // check if the user is in the database
        $userCheck = $dbConnect -> query("SELECT `UserId` FROM $table
                                        WHERE `UserId` = '$userId'");
        
        // if the user already exists in the database, update the columns if the data input is different from what is already stored (MySQL checks this automatically)
        if(mysqli_num_rows($userCheck) != 0) {
            $dbConnect -> query("UPDATE $table
                                SET `Headline` = '$headlineInput', `TextContent` = '$textInput', `Colour` = '$colourSelect'
                                WHERE `UserId` = '$userId'");
                                
            header("Location: ../page.php");
        }
        // else insert the data **(is this necessary)**
        else {
            $dbConnect -> query("INSERT INTO $table (`UserId`, `Headline`, `TextContent`, `Colour`)
                                VALUES ('$userId', '$headlineInput', '$textInput', '$colourSelect') "); 

            header("Location: ../page.php");
        }
    }

    $dbConnect -> close();
}

// if user isn't logged in, but temporary guestcookie is set:
else {

    // set post values to session cookie, but don't save it

    $userSettings = array(
        "headline" => $headline,
        "textInput" => $textInput,
        "colour" => $colour
    );

    setcookie("guestSession", json_encode($userSettings), time()+60);

    // content of the cookie (array) is encoded to JSON format, here it's decoded back to array format

    $decodedCookie = json_decode($_COOKIE["guestSession"], true);
    // if I am to check if it's changed, I have to do so before data is submitted(?)

    if (isset($_COOKIE["guestSession"]) && !empty($_COOKIE["guestSession"])) {
        echo $decodedCookie["headline"];
    }

    elseif (!isset($_COOKIE["guestSession"]) /* || or any of the contents of cookie has changed (compare original cookie with values in POST): */) {
        header("Refresh:0");
    }

    //eader("Location: ../page.php");
}

?>