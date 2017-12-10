<?php

session_start();

if(isset($_POST['productID'])) {

    // Creates or defines the cart size for next index
    if(isset($_SESSION['cartSize'])) {

        $cartSize = $_SESSION['cartSize'];
        $cartSize++;
    }
    else {

        $cartSize = 0;
        $cartSize++;
    }

    // Store product in cart
    $_SESSION['item_'. $cartSize] = $_POST['productID'];

    // Store new cart size
    $_SESSION['cartSize'] = $cartSize;

    // Fetch the calling url
    $url = emptyMsgParam($_SERVER['HTTP_REFERER'], "msg");

    $query = parse_url($url, PHP_URL_QUERY);

    // Returns a string if the URL has parameters or NULL if not
    // and returns user to calling page
    if ($query) {
        header("location:" . $url . "&msg=Item Added to Cart!");
        die;
    }
    else {
        header("location:" . $url . "?msg=Item Added to Cart!");
        die;
    }
}
else echo "NO DATA RECEIVED";

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