<?php 
$localhost = 'localhost';
$username = 'root';
$password = '';
$db_name = 'kasir';

$koneksi = new mysqli($localhost, $username, $password, $db_name);

if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}