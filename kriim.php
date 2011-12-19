<?php

// koneksi ke mysql
mysql_connect('dbhost', 'dbuser', 'dbpass');
mysql_select_db('dbname');

// membaca ketiga data dari parameter CURL
$data1 = $_POST['nilai1'];
$data2 = $_POST['nilai2'];
$data3 = $_POST['nilai3'];

// query insert data ke mysql
$query = "INSERT INTO contoh (data1, data2, data3) VALUES ('$data1', '$data2', '$data3')";
mysql_query($query);

?>