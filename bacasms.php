<?php
// koneksi ke mysql di server localhost
mysql_connect('localhost', 'root', '');
// nama database Gammu yang ada di localhost
mysql_select_db('sms');

// baca data XML dari server hosting yang digenerate oleh data.php
$dataxml = simplexml_load_file('http://voucher.passionit.co.id/smsmod/data.php');
foreach($dataxml->data as $data)
{
   // baca field ID
   $id = $data->id;
   // baca nomor tujuan
   $destination = $data->destination;
   // baca isi sms
   $sms = $data->sms;

   // mengirim SMS via Gammu dengan insert data ke tabel outbox Gammu
   $query = "INSERT INTO outbox (DestinationNumber, TextDecoded) VALUES ('$destination', '$sms')";
   mysql_query($query);   

   // hapus data SMS di server hosting yang sudah terbaca berdasarkan ID
   $curlHandle = curl_init();
   curl_setopt($curlHandle, CURLOPT_URL, 'http://voucher.passionit.co.id/smsmod/hapus.php');
   curl_setopt($curlHandle, CURLOPT_POSTFIELDS, 'id='.$id);
   curl_setopt($curlHandle, CURLOPT_HEADER, 0);
   curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);
   curl_setopt($curlHandle, CURLOPT_POST, 1);
   curl_exec($curlHandle);
   curl_close($curlHandle);
}
?>
