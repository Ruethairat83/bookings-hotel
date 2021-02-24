<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "hotel-bookings";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
$conn->set_charset("utf8mb4");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

