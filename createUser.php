<?php

// Get DB info
require_once 'db_info.php';

// Connect to database
$conn = new mysqli($hn, $user, $pass, $db);

// Return error if unable to connect
if($conn->error) die("Unable to connect to database");

// Verify that user inputs are not empty
if  ($_POST['name'] == '')
{
    $errorMsg = "Please enter your name.";
    header("location:register.php?error=$errorMsg");
    die;
}
else if  ($_POST['email'] == '')
{
    $errorMsg = "Please enter your email address.";
    header("location:register.php?error=$errorMsg");
    die;
}
else if  ($_POST['username'] == '')
{
    $errorMsg = "Please enter a username.";
    header("location:register.php?error=$errorMsg");
    die;
}
else if  ($_POST['password'] == '')
{
    $errorMsg = "Please enter a password.";
    header("location:register.php?error=$errorMsg");
    die;
}

if ($_POST['password2'] == '')
{
    $errorMsg = "Please enter a password.";
    header("location:register.php?error=$errorMsg");
    die;
}
// If data has been entered into all fields
else {

    // Store User input
    $name = sanitizeString($_POST['name']);
    $email = sanitizeString($_POST['email']);
    $username = sanitizeString($_POST['username']);
    $password = sanitizeString($_POST['password']);
    $password2 = sanitizeString($_POST['password2']);

    // Check username
    $query = "SELECT username FROM users WHERE username = '$username'";

    $result = $conn->query($query);
    $rows=$result->num_rows;

    // Search the database to make sure the username is not already taken
    if ($rows!=0)
    {
        // Return error stating the user name is unavailable.
        $errorMsg = "The Username $username is unavailable. Please choose a different Username.";
        header("location:register.php?error=$errorMsg");
        die;
    }
    else {

        // Verify that password & password 2 match
        if ($password == $password2)
        {
            // Add the information to the database
            $salt1 = '$aLt';
            $token = hash('md5',"$salt1$password$salt1");

            $query = "INSERT INTO users VALUES ('', '$username', '$name', '$email', '$token')";

            $result = $conn->query($query);
            if(!$result) die($conn->error);

            $status = $conn->affected_rows;

            // If not able to add data to the table for any given reason
            if ($status == 0)
            {
                // Throw Error
                $errorMsg = "Unable to add user to the database. Please try again.";
                header("location:register.php?error=$errorMsg");
                die;
            }
            else
            {
                // If user was create, return to the index and display success message to the user
                $successMsg = "Account has been created successfully";
                header("location:index.php?msg=$successMsg");
                die;
            }
        }
        else {

            // If passwords do not match, return error
            $errorMsg = "Password do not match.";
            header("location:register.php?error=$errorMsg");
            die;
        }
    }
}

// sanitize the user input
function sanitizeString($string)
{
    $output = stripslashes($string);
    $output = strip_tags($output);
    $output = htmlentities($output);
    return $output;
}

?>