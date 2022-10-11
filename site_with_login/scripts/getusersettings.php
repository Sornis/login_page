



<?php

session_start();

// runs if there's a user logged in. Else display the default 
// checks that all mandatory data is set in the cookie. ttly anti-hax -- also check if all the set data matches an entry in the database
if (isset($_SESSION["userData"]["email"]) && isset($_SESSION["userData"]["username"]) && isset($_SESSION["userData"]["userId"])) { // may need to change this

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "testDB";
    $table = "UserSettings";
    $userId = $_SESSION["userData"]["userId"];

    $dbConnect = new mysqli($servername, $username, $password, $database);

    // check if the email, username, password of [userid] matches the row in the database (have yet to encrypt password)

    // Create table with userId from UserData, headline content & textcontent (long strings of text might not be ideal
    // for storing in a table - not ideal at all - figure out how to store a local path to the file or smth idk)

    $dbConnect -> query("CREATE TABLE IF NOT EXISTS $table (
        `UserId` int NOT NULL UNIQUE,
        `Headline` varchar(255),
        `TextContent` varchar(255),
        `Colour` varchar(20),
        FOREIGN KEY (UserId) REFERENCES UserData (UserId)
        )
    ");

    // get user settings data on page load
    $userSettingsQuery = $dbConnect -> query("SELECT `Headline`, `TextContent`, `Colour` from $table
                                            WHERE `UserId` = '$userId'");

    $data = $userSettingsQuery -> fetch_assoc();
    $userSettings = array(
        "headline" => $data["Headline"],
        "textContent" => $data["TextContent"],
        "colour" => $data["Colour"]
    );
    
    $_SESSION["userSettings"] = $userSettings;
    
    $dbConnect -> close();
}   
// setting of guest session - temporary cookie (here 60 seconds) is set when page loads if user data isn't initialized (user hasn't logged in or doesn't have an account).
// when a guest refreshes the page within the duration of the session, session duration is refreshed and data is re-stored
else {

    $testArray = array(
        "a" => 1,
        "b" => 2,
        "c" => 3
    );

    $encodedTestArray = json_encode($testArray);
    setcookie("test", "some value"); 

    if (isset($_COOKIE["test"])) {
        setcookie("test", $encodedTestArray);
    }

    /* if (!isset($_COOKIE["guestSession"])) {
        session_destroy();
        // $userSettings uninitialized, give default value:
        setcookie("guestSession", "hi", time()+10);
    }
    // if the guest cookie is set and its value isn't empty, draw out the value and re-initialize the cookie with the value  
    elseif (isset($_COOKIE["guestSession"]) && !empty($_COOKIE["guestSession"])) {
        $guestSettings = json_decode($_COOKIE["guestSession"]);
        setcookie("guestSession", json_encode($guestSettings), time()+10);
    } */
}
?>
