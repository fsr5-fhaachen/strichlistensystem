# Deployment

You can follow our [guide for portals](https://github.com/fsr5-fhaachen/portals/blob/main/deploy/README.md) to create the basic infrastructure (cluster, addons etc.)

This guide will only contain the steps that are needed for the Strichlistensystem.

## VPN

This is needed because the tablets that show all users must be connected via VPN because the endpoint should not be reachable from the internet.

### Create server

Create a new server that is used as VPN server.

You could choose a CAX11 server from Hetzner, the performance is enough for the VPN server.

### Install Updates

Run `apt update` and `apt upgrade` to install all updates.

### Install Wireguard

Install wireguard with:

```bash	
apt install wireguard wireguard-tools iptables -y
```

### Enable IP forwarding

Enable IP forwarding with:

```bash
nano /etc/sysctl.d/wireguard.conf
```

The content of the file should be:

```bash
net.ipv4.ip_forward=1
```

Reload the config with:

```bash
sysctl -p
```

### Create keys

Create a private and public key with:

```bash
# server
wg genkey | tee /etc/wireguard/server.key
cat /etc/wireguard/server.key | wg pubkey | tee /etc/wireguard/server.pub

# client | tablet 0
wg genkey | tee /etc/wireguard/client_tablet_0.key
cat /etc/wireguard/client_tablet_0.key | wg pubkey | tee /etc/wireguard/client_tablet_0.pub

# client | tablet 1
wg genkey | tee /etc/wireguard/client_tablet_1.key
cat /etc/wireguard/client_tablet_1.key | wg pubkey | tee /etc/wireguard/client_tablet_1.pub

# client | tablet 2
wg genkey | tee /etc/wireguard/client_tablet_2.key
cat /etc/wireguard/client_tablet_2.key | wg pubkey | tee /etc/wireguard/client_tablet_2.pub

# client | tablet 3
wg genkey | tee /etc/wireguard/client_tablet_3.key
cat /etc/wireguard/client_tablet_3.key | wg pubkey | tee /etc/wireguard/client_tablet_3.pub

# client | user 0
wg genkey | tee /etc/wireguard/client_user_0.key
cat /etc/wireguard/client_user_0.key | wg pubkey | tee /etc/wireguard/client_user_0.pub

# client | user 1
wg genkey | tee /etc/wireguard/client_user_1.key
cat /etc/wireguard/client_user_1.key | wg pubkey | tee /etc/wireguard/client_user_1.pub
```

### Create Interface

Create the interface with:

```bash
nano /etc/wireguard/wg0.conf
```

The content of the file should be:

```bash
[Interface]
# server.key
PrivateKey = <server.key>
Address = 172.30.0.1/24
PostUp = iptables -A FORWARD -i wg0 -j ACCEPT; iptables -t nat -A POSTROUTING -o eth0 -j MASQUERADE
PostDown = iptables -D FORWARD -i wg0 -j ACCEPT; iptables -t nat -D POSTROUTING -o eth0 -j MASQUERADE
ListenPort = 51820

[Peer]
# client_tablet_0.pub
PublicKey = <client_tablet_0.pub>
AllowedIPs = 172.30.0.10/32

[Peer]
# client_tablet_1.pub
PublicKey = <client_tablet_1.pub>
AllowedIPs = 172.30.0.11/32

[Peer]
# client_tablet_2.pub
PublicKey = <client_tablet_2.pub>
AllowedIPs = 172.30.0.12/32

[Peer]
# client_tablet_3.pub
PublicKey = <client_tablet_3.pub>
AllowedIPs = 172.30.0.13/32

[Peer]
# client_user_0.pub
PublicKey = <client_user_0.pub>
AllowedIPs = 172.30.0.20/32

[Peer]
# client_user_1.pub
PublicKey = <client_user_1.pub>
AllowedIPs = 172.30.0.21/32
```

### Enable Wireguard

Enable Wireguard with:

```bash
wg-quick up wg0
```

You can check if the interface is up with:

```bash
wg show
```

### Enable Wireguard on boot

Enable Wireguard on boot with:

```bash
systemctl enable wg-quick@wg0
```

### Clients

You have to create client configurations that are similar to this file example:

```conf
[Interface]
PrivateKey = <client_user_0.key>
Address = 172.30.0.20/32

[Peer]
PublicKey = <server.pub>
AllowedIPs = <ingress_ip_of_cluster>/32
Endpoint = <url_of_vpn_server>:51820
PersistentKeepalive = 30
```
