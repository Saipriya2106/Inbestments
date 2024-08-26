<?php 
$hostname = 'localhost'; // or '127.0.0.1' or an IP address or hostname

$server = "10.0.12.116";
$userName = "root";
$password = "Newteam@6";
$port = 3306; // Default MySQL port
$socket = ''; // Typically empty unless you're using a Unix socket
$client_flags = 0; // Default flags, or use MYSQLI_CLIENT_SSL if needed

$this->_mysqli = new mysqli();

if ($this->_mysqli->real_connect($hostname, $username, $password, $database, $port, $socket, $client_flags)) {
    echo "Connection successful!";
} else {
    echo "Connection failed: " . $this->_mysqli->connect_error;
}