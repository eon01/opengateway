<?php

//skrip untuk menghubungkan SMS Gateway lokal dengan hosting.. skrip ini dipasang untuk berhadapan dengan gammu.. Penggunaannya adalah:
//1. harus ada koneksi internet,
//2. database gammu

$urlhosting        =    "http://voucher.passionit.co.id/smsmod/receiver.php";
$dbname            =    'sms';
$dbuser            =    'root';
$dbpass            =    '';
$dbhost            =    'localhost';


if(mysql_connect($dbhost,$dbuser,$dbpass)){
    mysql_select_db($dbname);
}else{
    echo 'DB ne ra konek!!';
}

//bukak sms satu persatu

        $q        = "SELECT `SenderNumber`,`TextDecoded`,`UpdatedInDB`,`ID` FROM `inbox` WHERE `Processed`='false'";
        $mq        = mysql_query($q);
        $n        = mysql_query($q);
       
        while($r=mysql_fetch_array($mq)){
            $sms            = $r['TextDecoded'];
            $nohp            = $r['SenderNumber'];
            $time            = $r['UpdatedInDB'];
            $id              = $r['ID'];
            echo $url            = $urlhosting."?sms=".$sms."&nohp=".$nohp."&time=".$time;
            $hostingopen    = fopen($url,"r");
            echo $hostingread    = fread($hostingopen,100);
            //jika sukses mengantarkan URL
            if($hostingread=="OK"){
           
            echo $q2="UPDATE `inbox` SET `Processed`='true' WHERE `ID`='$id'";
            mysql_query($q2);
            }
        }
       

       



?>
