# pihole-wol
An unofficial wake-on-lan "plugin" for Pihole.

### Install

This plugin uses `wakeonlan` cli which needs to be installed on RPi first:

```sh
sudo apt install wakeonlan
```

### Setup

The plugin consists of two files:

1. A php file (`wol.php`), to be copied to pihole's admin php dir.

   ```sh
   sudo cp wol.php /var/www/html/admin/wol.php
   ```

1. A conf file (`wol.conf`), to be populated with machine names and addresses and copied to pihole's conf dir.

   ```sh
   sudo cp sample.conf /etc/pihole/wol.conf
   sudo nano /etc/pihole/wol.conf
   ```
### Usage

On a web browser login to Pihole's admin page and navigate to `/admin/wol.php` (e.g. http://mypihole/admin/wol.php)