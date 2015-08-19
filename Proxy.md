# SOCKS 5 Proxy #

  * apt-get install dante-server
  * nano /etc/danted.conf
```
internal: 0.0.0.0 port = 1080
external: eth0
external: tun0

method: username none
user.notprivileged: nobody

client pass {
        from: 0.0.0.0/0 port 1-65535 to: 0.0.0.0/0
}

pass {
        from: 0.0.0.0/0 to: 0.0.0.0/0
        protocol: tcp udp
}
```
  * service danted stop
  * service danted start
  * netstat -n -a | grep 1080


# Details #

Add your content here.  Format your content with:
  * Text in **bold** or _italic_
  * Headings, paragraphs, and lists
  * Automatic links to other wiki pages