#OpenVPN Server-client configuration.

# Introduction #

Reference :
  1. [Stavrovski](http://d.stavrovski.net/blog/post/how-to-install-and-set-up-openvpn-in-debian-7-wheezy)
  1. [Awangga](https://awangga.wordpress.com/2014/10/31/setup-openvpn-server-on-debian-wheezy-and-set-up-client/)


# Details #

Server.ovpn:
```
port portnumber
proto tcp
dev tun

ca ca.crt
cert server.crt
key server.key
dh dh2048.pem
#tls-auth ta.key 0

server 192.168.8.0 255.255.255.0
ifconfig-pool-persist ipp.txt
#push "redirect-gateway def1 bypass-dhcp"
#push "dhcp-option DNS 8.8.8.8"
#push "dhcp-option DNS 8.8.4.4"

client-to-client
keepalive 1800 4000

cipher DES-EDE3-CBC # Triple-DES
comp-lzo

max-clients 100

user nobody
group nogroup

persist-key
persist-tun

#log openvpn.log
#status openvpn-status.log
verb 5
mute 20

```

Client.ovpn:
```
client
remote ipaddresserverordomain port
ca ca.crt
cert client.crt
key client.key
cipher DES-EDE3-CBC
comp-lzo yes
dev tun
proto tcp
#tls-auth ta.key 1
nobind
auth-nocache
script-security 2
persist-key
persist-tun


```