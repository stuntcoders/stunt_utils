# StuntCoders Utilities

## WordPress autologin script

### Manual installation

Download this script directly with ``wget`` or ``curl``, for example:

```bash
wget https://raw.githubusercontent.com/stuntcoders/stunt_utils/main/stunt_wp_autologin/autologin.php
```

Next, move script into autologin folder:

```bash
mkdir autologin
mv autologin.php autologin/index.php
```

### Docker installation
#### Docker compose

In your ``docker-compose.yml`` file in wordpress service add:

```docker-compose.yml
services:
  wordpress:
        ...
+    command: bash -c "curl -O https://raw.githubusercontent.com/stuntcoders/stunt_utils/main/stunt_wp_autologin/autologin.php -o autologin/index.php && \
              apachectl -DFOREGROUND"
        ...
    environment:
+     WORDPRESS_LOGIN_URL: 'domain name'
+     WORDPRESS_LOGIN_NAME: 'db admin name'
        ...

      volumes:
        ... 
+       - autologin:/var/www/autologin
```

#### Dockerfile

If you're building your own image locally, you could add script setup in Dockerfile
```Dockerfile
RUN curl -O https://raw.githubusercontent.com/stuntcoders/stunt_utils/main/stunt_wp_autologin/autologin.php -o autologin/index.php
```
