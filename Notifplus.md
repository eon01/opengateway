#Cara Setting Notifplus.

# Introduction #

Ini merupakan konfigurasi client Notifplus.

# Instalasi #
```
apt-get install gammu-smsd curl wvdial
```

# File yang perlu dibuat/diedit #
  * Edit file /etc/gammu-smsdrc dan copy menjadi beberapa buah untuk lebih dari satu modem
```
# Configuration file for Gammu SMS Daemon

# Gammu library configuration, see gammurc(5)
[gammu]
# Please configure this!
port = /dev/ttyACM0
connection = at115200
# Debugging
#logformat = textall

# SMSD configuration, see gammu-smsdrc(5)
[smsd]
service = sql
phoneid = wavecom
driver = native_mysql
deliveryreport = sms
logfile = /home/user/pekat/syslog
PIN = 1234
user = ngapa
password = passngapa
pc = ngapa.com
database = ngapa
runonreceive = /home/user/pekat/services
maxretries = 100000
debuglevel = 0
```

  * Buat file /home/user/pekat/services
```
#!/bin/bash
wget --spider http://ngapa.com/index.php/replay
```

  * Edit file /etc/rc.local
```
#!/bin/sh -e
#
# rc.local
#
# This script is executed at the end of each multiuser runlevel.
# Make sure that the script will "exit 0" on success or any other
# value on error.
#
# In order to enable or disable this script just change the execution
# bits.
#
# By default this script does nothing.

service gammu-smsd start
gammu-smsd --daemon --user gammu -c /etc/gammu-smsdrc1 --pid /var/run/gammu-smsd1.pid
gammu-smsd --daemon --user gammu -c /etc/gammu-smsdrc2 --pid /var/run/gammu-smsd2.pid
gammu-smsd --daemon --user gammu -c /etc/gammu-smsdrc3 --pid /var/run/gammu-smsd3.pid

exit 0
```

# Crontab #
Tambahkan di crontab
```
* * * * * wget --spider http://ngapa.com/index.php/replay/remember &> /dev/null
* * * * * wget --spider http://ngapa.com/index.php/replay/peringatan &> /dev/null
* * * * * /etc/rc.local &> /dev/null
30 2 * * * /root/cekpulsa &> /dev/null
@reboot /etc/rc.local &> /dev/null
```

# Tools Pelengkap #
Untuk mengecek pulsa di mengirim dengan metode HTTP Get kita buat script :
```
#!/bin/bash
service gammu-smsd stop

format=`curl -s http://e-crmi.iqromedia.com/index.php/replay/format_slot1/`
sleep 7
rm /home/pray/pekat/syslog
gammu -c /etc/gammu-smsdrc getussd $format > /home/pray/pekat/pulsa_slot1
harga=`cat /home/pray/pekat/pulsa_slot1 | tail -n1 | cut -f2 -d\"`
echo $harga
harga=`echo $harga | sed 's/ /_/g'`
harga=`echo $harga | sed 's/\*/_/g'`
harga=`echo $harga | sed 's/\#/_/g'`
harga=`echo $harga | sed 's/\./_/g'`
harga=`echo $harga | sed 's/\,/_/g'`
harga=`echo $harga | sed 's/\&/dan/g'`
harga=`echo $harga | sed 's/\:/_/g'`
harga=`echo $harga | sed 's/\"/_/g'`
harga=`echo $harga | sed 's/\//_/g'`
harga=`echo $harga | sed 's/\?/_/g'`
harga=`echo $harga | sed 's/\!/_/g'`

echo $harga
curl -s http://e-crmi.iqromedia.com/index.php/replay/pulsa_slot1/$harga
sleep 7
service gammu-smsd start

###slot 2
serpisnya=`cat /var/run/gammu-smsd1.pid`
kill -9 $serpisnya

format=`curl -s http://e-crmi.iqromedia.com/index.php/replay/format_slot2/`
sleep 7
rm /home/pray/pekat/syslog1
gammu -c /etc/gammu-smsdrc1 getussd $format > /home/pray/pekat/pulsa_slot2
harga=`cat /home/pray/pekat/pulsa_slot2 | tail -n1 | cut -f2 -d\"`
echo $harga
harga=`echo $harga | sed 's/ /_/g'`
harga=`echo $harga | sed 's/\*/_/g'`
harga=`echo $harga | sed 's/\#/_/g'`
harga=`echo $harga | sed 's/\./_/g'`
harga=`echo $harga | sed 's/\,/_/g'`
harga=`echo $harga | sed 's/\&/dan/g'`
harga=`echo $harga | sed 's/\:/_/g'`
harga=`echo $harga | sed 's/\"/_/g'`
harga=`echo $harga | sed 's/\//_/g'`
harga=`echo $harga | sed 's/\?/_/g'`
harga=`echo $harga | sed 's/\!/_/g'`

echo $harga
curl -s http://e-crmi.iqromedia.com/index.php/replay/pulsa_slot2/$harga
sleep 7
gammu-smsd --daemon --user gammu -c /etc/gammu-smsdrc1 --pid /var/run/gammu-smsd1.pid


###slot 3
serpisnya=`cat /var/run/gammu-smsd2.pid`
kill -9 $serpisnya

format=`curl -s http://e-crmi.iqromedia.com/index.php/replay/format_slot3/`
sleep 7
rm /home/pray/pekat/syslog2
gammu -c /etc/gammu-smsdrc2 getussd $format > /home/pray/pekat/pulsa_slot3
harga=`cat /home/pray/pekat/pulsa_slot3 | tail -n1 | cut -f2 -d\"`
echo $harga
harga=`echo $harga | sed 's/ /_/g'`
harga=`echo $harga | sed 's/\*/_/g'`
harga=`echo $harga | sed 's/\#/_/g'`
harga=`echo $harga | sed 's/\./_/g'`
harga=`echo $harga | sed 's/\,/_/g'`
harga=`echo $harga | sed 's/\&/dan/g'`
harga=`echo $harga | sed 's/\:/_/g'`
harga=`echo $harga | sed 's/\"/_/g'`
harga=`echo $harga | sed 's/\//_/g'`
harga=`echo $harga | sed 's/\?/_/g'`
harga=`echo $harga | sed 's/\!/_/g'`

echo $harga
curl -s http://e-crmi.iqromedia.com/index.php/replay/pulsa_slot3/$harga
sleep 7
gammu-smsd --daemon --user gammu -c /etc/gammu-smsdrc2 --pid /var/run/gammu-smsd2.pid

###slot 4
serpisnya=`cat /var/run/gammu-smsd3.pid`
kill -9 $serpisnya

format=`curl -s http://e-crmi.iqromedia.com/index.php/replay/format_slot4/`
sleep 7
rm /home/pray/pekat/syslog3
gammu -c /etc/gammu-smsdrc3 getussd $format > /home/pray/pekat/pulsa_slot4
harga=`cat /home/pray/pekat/pulsa_slot4 | tail -n1 | cut -f2 -d\"`
echo $harga
harga=`echo $harga | sed 's/ /_/g'`
harga=`echo $harga | sed 's/\*/_/g'`
harga=`echo $harga | sed 's/\#/_/g'`
harga=`echo $harga | sed 's/\./_/g'`
harga=`echo $harga | sed 's/\,/_/g'`
harga=`echo $harga | sed 's/\&/dan/g'`
harga=`echo $harga | sed 's/\:/_/g'`
harga=`echo $harga | sed 's/\"/_/g'`
harga=`echo $harga | sed 's/\//_/g'`
harga=`echo $harga | sed 's/\?/_/g'`
harga=`echo $harga | sed 's/\!/_/g'`

echo $harga
curl -s http://e-crmi.iqromedia.com/index.php/replay/pulsa_slot4/$harga
sleep 7
gammu-smsd --daemon --user gammu -c /etc/gammu-smsdrc3 --pid /var/run/gammu-smsd3.pid

###slot 5
serpisnya=`cat /var/run/gammu-smsd4.pid`
kill -9 $serpisnya

format=`curl -s http://e-crmi.iqromedia.com/index.php/replay/format_slot5/`
sleep 7
rm /home/pray/pekat/syslog4
gammu -c /etc/gammu-smsdrc4 getussd $format > /home/pray/pekat/pulsa_slot5
harga=`cat /home/pray/pekat/pulsa_slot5 | tail -n1 | cut -f2 -d\"`
echo $harga
harga=`echo $harga | sed 's/ /_/g'`
harga=`echo $harga | sed 's/\*/_/g'`
harga=`echo $harga | sed 's/\#/_/g'`
harga=`echo $harga | sed 's/\./_/g'`
harga=`echo $harga | sed 's/\,/_/g'`
harga=`echo $harga | sed 's/\&/dan/g'`
harga=`echo $harga | sed 's/\:/_/g'`
harga=`echo $harga | sed 's/\"/_/g'`
harga=`echo $harga | sed 's/\//_/g'`
harga=`echo $harga | sed 's/\?/_/g'`
harga=`echo $harga | sed 's/\!/_/g'`

echo $harga
curl -s http://e-crmi.iqromedia.com/index.php/replay/pulsa_slot5/$harga
sleep 7
gammu-smsd --daemon --user gammu -c /etc/gammu-smsdrc4 --pid /var/run/gammu-smsd4.pid

###slot 6
serpisnya=`cat /var/run/gammu-smsd5.pid`
kill -9 $serpisnya

format=`curl -s http://e-crmi.iqromedia.com/index.php/replay/format_slot6/`
sleep 7
rm /home/pray/pekat/syslog5
gammu -c /etc/gammu-smsdrc5 getussd $format > /home/pray/pekat/pulsa_slot6
harga=`cat /home/pray/pekat/pulsa_slot6 | tail -n1 | cut -f2 -d\"`
echo $harga
harga=`echo $harga | sed 's/ /_/g'`
harga=`echo $harga | sed 's/\*/_/g'`
harga=`echo $harga | sed 's/\#/_/g'`
harga=`echo $harga | sed 's/\./_/g'`
harga=`echo $harga | sed 's/\,/_/g'`
harga=`echo $harga | sed 's/\&/dan/g'`
harga=`echo $harga | sed 's/\:/_/g'`
harga=`echo $harga | sed 's/\"/_/g'`
harga=`echo $harga | sed 's/\//_/g'`
harga=`echo $harga | sed 's/\?/_/g'`
harga=`echo $harga | sed 's/\!/_/g'`

echo $harga
curl -s http://e-crmi.iqromedia.com/index.php/replay/pulsa_slot6/$harga
sleep 7
gammu-smsd --daemon --user gammu -c /etc/gammu-smsdrc5 --pid /var/run/gammu-smsd5.pid

###slot 7
serpisnya=`cat /var/run/gammu-smsd6.pid`
kill -9 $serpisnya

format=`curl -s http://e-crmi.iqromedia.com/index.php/replay/format_slot7/`
sleep 7
rm /home/pray/pekat/syslog6
gammu -c /etc/gammu-smsdrc6 getussd $format > /home/pray/pekat/pulsa_slot7
harga=`cat /home/pray/pekat/pulsa_slot7 | tail -n1 | cut -f2 -d\"`
echo $harga
harga=`echo $harga | sed 's/ /_/g'`
harga=`echo $harga | sed 's/\*/_/g'`
harga=`echo $harga | sed 's/\#/_/g'`
harga=`echo $harga | sed 's/\./_/g'`
harga=`echo $harga | sed 's/\,/_/g'`
harga=`echo $harga | sed 's/\&/dan/g'`
harga=`echo $harga | sed 's/\:/_/g'`
harga=`echo $harga | sed 's/\"/_/g'`
harga=`echo $harga | sed 's/\//_/g'`
harga=`echo $harga | sed 's/\?/_/g'`
harga=`echo $harga | sed 's/\!/_/g'`

echo $harga
curl -s http://e-crmi.iqromedia.com/index.php/replay/pulsa_slot7/$harga
sleep 7
gammu-smsd --daemon --user gammu -c /etc/gammu-smsdrc6 --pid /var/run/gammu-smsd6.pid

###slot 8
serpisnya=`cat /var/run/gammu-smsd7.pid`
kill -9 $serpisnya

format=`curl -s http://e-crmi.iqromedia.com/index.php/replay/format_slot8/`
sleep 7
rm /home/pray/pekat/syslog7
gammu -c /etc/gammu-smsdrc7 getussd $format > /home/pray/pekat/pulsa_slot8
harga=`cat /home/pray/pekat/pulsa_slot8 | tail -n1 | cut -f2 -d\"`
echo $harga
harga=`echo $harga | sed 's/ /_/g'`
harga=`echo $harga | sed 's/\*/_/g'`
harga=`echo $harga | sed 's/\#/_/g'`
harga=`echo $harga | sed 's/\./_/g'`
harga=`echo $harga | sed 's/\,/_/g'`
harga=`echo $harga | sed 's/\&/dan/g'`
harga=`echo $harga | sed 's/\:/_/g'`
harga=`echo $harga | sed 's/\"/_/g'`
harga=`echo $harga | sed 's/\//_/g'`
harga=`echo $harga | sed 's/\?/_/g'`
harga=`echo $harga | sed 's/\!/_/g'`

echo $harga
curl -s http://e-crmi.iqromedia.com/index.php/replay/pulsa_slot8/$harga
sleep 7
gammu-smsd --daemon --user gammu -c /etc/gammu-smsdrc7 --pid /var/run/gammu-smsd7.pid


```
Untuk Melihat Service Gammu buat script :
```
#!/bin/bash
echo "lihat service gammu yang berjalan, slot nya tinggal di tambah 1"
ps aux | grep gammu
echo "melihat log masing masing modem"
echo "slot 1"
tail /home/pray/pekat/syslog
echo "slot 2"
tail /home/pray/pekat/syslog1
echo "slot 3"
tail /home/pray/pekat/syslog2
echo "slot 4"
tail /home/pray/pekat/syslog3
echo "slot 5"
tail /home/pray/pekat/syslog4
echo "slot 6"
tail /home/pray/pekat/syslog5
echo "slot 7"
tail /home/pray/pekat/syslog6
echo "slot 8"
tail /home/pray/pekat/syslog7
```