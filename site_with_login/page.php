



<!DOCTYPE html>

<html>
    <head>
        <link rel = "stylesheet" href = "styles/landing_page.css">
    </head>
    <body>

        <?php
        // function for checking whether a variable isset?
        // How do I check for data??

        // find out if user data is set
        function isSetUserData() {
            return isset($_SESSION["userData"]["username"]) ? true : false;
        }                                                                           // validate if a token is correct 

                                                                                    // function for creating / updating cookie when it's not set, is set, and is set and not empty
        function setGuestCookie() {

            isset($_COOKIE["guest"]) ? $cookie = $_COOKIE["guest"] : $cookie = "";  // assign guest cookie to variable if it exists 

            if(empty($cookie) && isset($cookie) || !isset($cookie)) {                                  // if $cookie exists and is empty -
                setcookie("guest", json_encode(""));                                // create cookie with value ""                                            
            }

            elseif(!empty($cookie) && isset($cookie)) {                             // if $cookie exists and isn't empty (its values have been changed) -
                $jsonDecodedCookie = json_decode($cookie, true);                    // decode $cookie (since it's encoded in json format upon creation) -
                setcookie("guest", json_encode($jsonDecodedCookie));                // re-create- and initialize guest cookie with its values                     
            }                                                                       // {{ not sure when to refresh site to avoid infinite loop. Have to refresh after changing / re-initializing cookie}}
        }                                                                           // maybe append a state to the cookie to check for (like $_COOKIE["justInitialized"] = true),
                                                                                    // then run an 'if' checking for that state, and change it to 'false'
        function updateGuestCookie($cookie) {                                       // Do this after sanitizing the input. sanitizeInput() function returns an array - take that array and use it in updateGuestCookie()

            $postValues = array(                                                    // so this is just going to be a parameter
                "headline" => $_POST["headline"],
                "textContent" => $_POST["textContent"],
                "colour" => $_POST["colourSelect"]
            );

            $jsonEncodedPostValues = json_encode($postValues);
            setcookie("guest", $jsonEncodedPostValues);
        }                                                                           // so take the array, json encode it, stick it in the cookie, set the cookie
        

        function getCookieVal($cookie) {                                            // general get-cookie-values (and I guess assign them to array and return it??)
            $cookieValues = json_decode($cookie, true);
            return $cookieValues;
        }

        function refreshIfCookieNotSet($cookie) {                                   // is this fkn silly - kind of feel like this should be an if ... else in the program?
            if(!isset($cookie)) {                                                   // feel like I integrate this with cookie creation
                header("Refresh: 0");
            }
        }

        function sanitizeInput($inputValueArray) {

        }
                                                                                    
        

        if(isSetUserData()) {
            
        }

        elseif(!isSetUserData()) {
            initGuestCookie();
            refreshIfParamCookieNotSet($_COOKIE["guest"]);

            if($_SERVER["REQUEST_METHOD"] == "POST") {
                
            }

            
        }

        // can I safely make a check for user data?
        ?>
        <div>

            <!-- navigation bar -->
            <div id = "navbar" style='display: flex; justify-content: flex-end;'>
                <p id = "loginBtn">Login</p>
                <p id = "signupBtn">Sign up</p>
                <p id = "logoutBtn">Logout</p>
                <img src = "images/default_image.jpg">
            </div>

            <!-- login window, appears on clicking the 'Login' button -->
            <div id = "loginWindow">
                <form method = "POST" action = "scripts/login.php">
                    <label for = "email">E-mail:</label><br>
                    <input type = "email" name = "email" value = "<?php echo isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : ""; ?>"><br>
                    <label for = "loginPassword">Password:</label><br>
                    <input type = "password" name = "password" value = ""><br>
                    <label for = "rememberLogin">Remember me</label>
                    <input type = "checkbox" name = "rememberLogin"><br>
                    <input type = "submit" value = "Login"><br>
                </form>
            </div>

            <!-- sign up window, appears on clicking the 'Sign up' button -->
            <div id = "signupWindow">
                <form method = "post" action = >
                    <label for = "name">Name:</label><br>
                    <input type = "text" name = "name" value = "<?php echo !empty($name) ? htmlspecialchars($name) : ""; ?>" ><br><span> <?php echo isset($nameErr) ? $nameErr : ""; ?></span><br>
                    <label for = "email">E-mail:</label><br>
                    <input type = "email" name = "email" value = "<?php echo !empty($email) ? htmlspecialchars($email) : ""; ?>"><br><span> <?php echo isset($emailErr) ? $emailErr : ""; ?></span><br>
                    <label for = "password">Password:</label><br>
                    <input type = "password" name = "password"><br><span> <?php echo isset($passwordErr) ? $passwordErr : ""; ?></span><br>
                    <input type = "submit" name = "submit" value = "Sign up">
                </form>
            </div>

            <!-- user info & menu, appears on clicking user image/image icon -->
            <div id = "userMenu">
                <div id = "userInfo">
                    <p>username:</p>
                    <p id = "username"><?php echo isset($userData["username"]) ? $userData["username"] : ""; ?></p>
                    <p>e-mail:</p>
                    <p id = "email"><?php echo isset($userData["email"]) ? $userData["email"] : ""; ?></p>
                </div>
                <p id = "editButton">Edit page</p>
            </div>
            
            <!-- edit window, appears on pressing the edit button -->
            <div id = "userOptions">
                <div id = "exitDiv">
                    <img id = "exitImage" src = "images/x_image.jpg">
                </div>

                <form method = "POST" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input id = "headlineInput" name = "headlineInput" type = "text" placeholder = "Type your headline" value = <?php echo !empty($userSettings["headline"]) ? $userSettings["headline"] : ""; ?>><br>
                    <input id = "textInput" name = "textInput" type = "text" placeholder = "Type your text" value = <?php echo !empty($userSettings["textContent"]) ? $userSettings["textContent"] : ""; ?>><br>
                    <input id = "colourSelect" name = "colourSelect" type = "color" value = "<?php echo !empty($userSettings["colour"]) ? $userSettings["colour"] : "#FFFFFF"; ?>"><br>
                    <input id = "submitButton" type = "submit" value = "Submit changes">
                </form>
            </div>
            <div id = "pageContent">
                <h1 id = "headline">Welcome to your page!</h1>
                <p id = "textContent">It's yours to do what you want with!</p>
            </div>
        </div>

        <?php  ?>
        
        <script src = "scripts/page.js"></script>
        <script>

            let isSetGuestSettings = <?php echo isset($_COOKIE["guestSession"]) ? "true" : "false"; ?>;
            let isSetUserSettings = <?php echo isset($userSettings) ? "true" : "false";  ?>;
            let isSetCookie = <?php echo isset($_COOKIE["testCookie"]) ? "true" : "false"; ?>;
            
            if (isSetGuestSettings || isSetUserSettings) {
                let guestSettings;

                if (isSetGuestSettings) {
                    guestSettings = "<?php if (isset($_COOKIE["guestSession"])) { echo json_decode($_COOKIE["guestSession"], true); } ?>";
                    console.log(guestSettings);
                }

                document.querySelector("#headline").innerHTML = "<?php 
                if(isset($userSettings["headline"])) echo $userSettings["headline"]; 
                elseif(isset($guestSettings["headline"]) && !empty($guestSettings["headline"])) echo $guestSettings["headline"]; 
                else echo "Welcome to your page!";
                ?>";

                document.querySelector("#textContent").innerHTML = "<?php 
                if(isset($userSettings["textContent"])) echo $userSettings["textContent"]; 
                elseif(isset($guestSettings["textContent"]) && !empty($guestSettings["textContent"])) echo $guestSettings["textContent"];
                else echo "It's yours to do what you want with!";
                ?>";

                document.querySelector("body").style.backgroundColor = "<?php 
                if(isset($userSettings["colour"])) echo $userSettings["colour"]; 
                elseif(isset($guestSettings["colour"]) && !empty($guestSettings["colour"])) echo $guestSettings["colour"] ?>";
            }

            // checks if there is user data in the session cookie, essentially checking if there's a user logged in
            let userDataAvailable = <?php echo isset($_SESSION["userData"]) ? "true" : "false"; ?>

            // if user is logged in on page load, hide login & signup buttons and insert their data on the page
            if(userDataAvailable) {
                document.querySelector("#loginBtn").style.display = "none";
                document.querySelector("#signupBtn").style.display = "none";
            }
            // if user isn't logged in, hide user info (username, e-mail) and the logout button
            else {
                document.querySelector("#userInfo").style.display = "none";
                document.querySelector("#logoutBtn").style.display = "none";
            }

            document.querySelector("#logoutBtn").addEventListener("click", () => {
                location.href = "scripts/logout.php";
            });

        </script>

    </body>
</html>