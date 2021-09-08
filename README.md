# StuntCoders Utilities

## Installation

### WordPress autologin script

#### Docker
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
+       - autologin:/var/www/autologin
```

Note that if you use ssl add domain as https.

Add this step to Dockerfile

```Dockerfile
# Add autologin
RUN cd /var/www/html && mkdir -p /var/www/html/autologin && \ 
    curl -O https://raw.githubusercontent.com/stuntcoders/stunt_utils/main/stunt_wp_autologin/autologin.php && \
    mv autologin.php /var/www/html/autologin/index.php
```

#### Manual setup

Download the script directly with ``wget`` or ``curl``, for example:

```bash
curl -O https://raw.githubusercontent.com/stuntcoders/stunt_utils/main/stunt_wp_autologin/autologin.php
```

Next, move the script into autologin folder:

```bash
mkdir autologin
mv autologin.php autologin/index.php
```

Set your site url and admin name respectfully in autologin/index.php

```php
$login_url_env  = 'WORDPRESS_LOGIN_URL';
$login_name_env = 'WORDPRESS_LOGIN_NAME';
```

Go to ``/autologin``.
