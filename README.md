# StuntCoders Utilities

## Installation

### WordPress autologin script

#### Docker

Download this script directly with ``wget`` or ``curl``, for example:

```bash
wget https://raw.githubusercontent.com/stuntcoders/stunt_utils/main/stunt_wp_autologin/autologin.php
```

Next, move script into autologin folder:

```bash
mkdir autologin
mv autologin.php autologin/index.php
```

In your ``docker-compose.yml`` file in wordpress service add:

```Dockerfile
services:
  wordpress:
        ...
    environment:
+     WORDPRESS_ADMIN_DOMAIN: 'domain name'
+     WORDPRESS_ADMIN_LOGIN: 'db admin name'
        ...

      volumes:
        ... 
+       - ./autologin:/var/www/autologin
```
