# Internet Connection Sharing #
[IP Forward](http://codeless.fr/?p=21)
```
iptables -t nat -A POSTROUTING -s 192.168.1.0/24 -j MASQUERADE
iptables -A FORWARD -s 192.168.1.0/24 -j ACCEPT
```

# Address and Port Forwarding #
Untuk Kepentingan layanan SSH
```
iptables -t nat -A PREROUTING -p tcp -s 0/0 --dport 2 -j DNAT --to 10.8.0.6:22
```
Untuk Kepentingan layanan Web
```
iptables -t nat -A PREROUTING -p tcp -s 0/0 -d 185.53.128.235 --dport 3 -j DNAT --to 192.168.8.10:80
iptables -t nat -A POSTROUTING -o tun0 -d 192.168.8.10 -j SNAT --to-source 185.53.128.235
```