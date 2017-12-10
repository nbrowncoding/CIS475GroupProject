<?php

session_start();

// Ensure customer is logged in
if(isset($_SESSION['customerID'])) {

    // Ensure the cart has at least one item
    if(isset($_SESSION['cartSize'])) {

        $cartSize = $_SESSION['cartSize'];

        if($cartSize>0) {

            // Initialize String to store items from cart
            $itemsString = "";

            // Build string of items ordered
            for($i=1; $i<=$cartSize; $i++) {

                $itemsString .= $_SESSION['item_'.$i] . ":";
            }

            // Get customer ID
            $custID = $_SESSION['customerID'];

            // Get DB info
            require_once 'db_info.php';

            // Connect to database
            $conn = new mysqli($hn, $user, $pass, $db);

            // Return error if unable to connect
            if($conn->error) die("Unable to connect to database");

            // Store Items in ordered into DB with customer ID
            $query = "INSERT INTO orders VALUES ('', '$custID', '$itemsString')";

            // Execute query
            $result = $conn->query($query);

            if(!$result) die($conn->error);

            // Get query status
            $status = $conn->affected_rows;

            if ($status == 0)
            {
                // Display error there is an error while trying to insert the order
                $errorMsg = "Unable to place order. Please try again.";
                header("location:cart.php?msgr=$errorMsg");
                echo $errorMsg;
                die;
            }
            else
            {
                // Store order status and reroute user to order page
                $_SESSION['order_status'] = "success";
                header("location:order.php");
                die;
            }
        }
        else {

            // Display error if the cart is empty
            $errorMsg = "Your cart is empty.";
            header("location:cart.php?msg=$errorMsg");
            echo $errorMsg;
            die;
        }
    }
    else {

        // Display error if the cart is empty
        $errorMsg = "Your cart is empty.";
        header("location:cart.php?msg=$errorMsg");
        echo $errorMsg;
        die;
    }
}
else {

    // Display error if user is not logged in
    $errorMsg = "You must be logged in to place order.";
    header("location:cart.php?msg=$errorMsg");
    echo $errorMsg;
    die;
}

?>