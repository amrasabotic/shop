<?php
session_start();
unset($_SESSION['username']);
session_destroy();

include "config.php";

// Prepare and execute query
$query = $conn->prepare('SELECT * FROM cart');
$query->execute();
$result = $query->get_result();

// Check if there are any results
if ($result->num_rows > 0) {
    // There are records in the table, so delete them
    $query = $conn->prepare('DELETE FROM cart');
    $query->execute();
}

// Close connection
$conn->close();

header("Location: login.php");

?>