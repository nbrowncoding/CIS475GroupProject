<?php

if($_SERVER['REQUEST_METHOD']=="POST") {

    // Get DB info
    require_once 'db_info.php';

    // Validate input
    if($_POST['username']=="") {

        $statusMsg = "You must enter your username!";

        // Get the calling url and sanitize it
        $url = emptyMsgParam($_SERVER['HTTP_REFERER'], "msg");

        $query = parse_url($url, PHP_URL_QUERY);

        // Returns a string if the URL has parameters or NULL if not
        // and returns user to calling page
        if ($query) {
            header("location:" . $url . "&msg=$statusMsg");
            die;
        }
        else {
            header("location:" . $url . "?msg=$statusMsg");
            die;
        }
    }
    else if($_POST['password']=="") {

        $statusMsg = "You must enter your password!";

        // Get the calling url and sanitize it
        $url = emptyMsgParam($_SERVER['HTTP_REFERER'], "msg");

        $query = parse_url($url, PHP_URL_QUERY);

        // Returns a string if the URL has parameters or NULL if not
        // and returns user to calling page
        if ($query) {
            header("location:" . $url . "&msg=$statusMsg");
            die;
        }
        else {
            header("location:" . $url . "?msg=$statusMsg");
            die;
        }
    }
    else {

        // Get input and sanitize
        $username = sanitize($_POST['username']);
        $password = sanitize($_POST['password']);

        // Hash password using salt
        $salt = '$aLt';
        $pwhash= hash('md5', "$salt$password$salt");

        // Connect to database
        $conn = new mysqli($hn, $user, $pass, $db);

        // Throw error if connection fails
        if($conn->error) die("Cannot access server");

        // Create query
        $query = "SELECT * FROM users WHERE username='$username'";

        // Execute query
        $result = $conn->query($query);

        // Return error if query fails
        if(!$result) die("Internal Server Error");

        $rows = $result->num_rows;

        if($rows==0) {

            $statusMsg =  "Username or password is incorrect!";

            // Get the calling url and sanitize it
            $url = emptyMsgParam($_SERVER['HTTP_REFERER'], "msg");

            $query = parse_url($url, PHP_URL_QUERY);

            // Returns a string if the URL has parameters or NULL if not
            // and returns user to calling page
            if ($query) {
                header("location:" . $url . "&msg=$statusMsg");
                die;
            }
            else {
                header("location:" . $url . "?msg=$statusMsg");
                die;
            }
        }
        else {

            $result->data_seek(0);
            $row = $result->fetch_array(MYSQLI_ASSOC);

            if($row['password']==$pwhash) {

                $customerID = $row['customerID'];
                $name = $row['name'];
                $email = $row['email'];

                session_start();

                // Store the user's information in a session for use on other pages
                $_SESSION['customerID'] = $customerID;
                $_SESSION['cust_name'] = $name;
                $_SESSION['cust_email'] = $email;

                // Get the calling url and sanitize it
                $url = emptyMsgParam($_SERVER['HTTP_REFERER'], "msg");

                header("Location:$url");
            }
            else {

                $statusMsg = "Username or password is incorrect!";

                // Get the calling url and sanitize it
                $url = emptyMsgParam($_SERVER['HTTP_REFERER'], "msg");

                $query = parse_url($url, PHP_URL_QUERY);

                // Returns a string if the URL has parameters or NULL if not
                // and returns user to calling page
                if ($query) {
                    header("location:" . $url . "&msg=$statusMsg");
                    die;
                }
                else {
                    header("location:" . $url . "?msg=$statusMsg");
                    die;
                }
            }
        }

        $result->close();
        $conn->close();
    }
}
else {

    // If page is being access without posted data i.e. from an unauthorized party
    // reroute to index page
    header("location:index.php");
    exit;
}

/**
 * Sanitize input for security
 * @param $input String to be sanitized
 * @return string sanitized input
 */
function sanitize($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

/**
 * Parse url and remove excess msg variables
 */
function emptyMsgParam($url, $varname) {

    // Fetch the query part of the url
    $query = parse_url($url, PHP_URL_QUERY);

    parse_str($query, $params);

    // Remove msg variable from query
    unset($params[$varname]);

    // Remove query from url
    $url = strtok($url, "?");

    // Rebuild query, add to url, and return url to caller
    if(http_build_query($params)=="") {

        return $url;
    }
    else {

        return $url . "?" .http_build_query($params);
    }
}

?>
