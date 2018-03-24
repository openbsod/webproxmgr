# webproxmgr
Web Proxmox API VE manager ( nginx php7 mariadb )


Requirements:

- [Composer](https://getcomposer.org/download)
- [ZzAntares ProxmoxVE API Client](https://github.com/ZzAntares/ProxmoxVE)
- [noVNC](https://github.com/novnc/noVNC)
- [websockify](https://github.com/novnc/websockify)

- Nginx apt install nginx-full
- MariaDB /* apt install mysql-server */

```
  mysql_secure_installation /* set root password */
  mysql -u root -p < 20180324.admin.sql /* create db scheme for users */
  mysql -u root -p < 20180324.vds.sql /* create db scheme for vds deploying */
  CREATE USER 'admin'@'localhost' IDENTIFIED BY 'password'; /* grant permissions to db admin */
  GRANT ALL PRIVILEGES ON *.* TO 'admin'@'localhost';
  FLUSH PRIVILEGES;
```

###### PHP modules

- apt list --installed | grep php

php-common php7.0-gd php7.0-json php7.0-mysql php7.0-opcache php7.0-readline php7.0-xml
php-curl php-fpm php-mysql php7.0-cli php7.0-common php7.0-curl php7.0-fpm 

- php -v

PHP 7.0.28-0ubuntu0.16.04.1

###### early alpha draft esquisse

![alt text](https://github.com/openbsod/webproxmgr/blob/master/webproxmgr.png)

###### MVP (proof of concept) preview

[![IMAGE ALT TEXT](http://img.youtube.com/vi/202r8cK36K0/0.jpg)](http://www.youtube.com/watch?v=202r8cK36K0 "webproxmoxmgr")

License
-------
`` webproxmgr`` is licensed under the GPLv3 license.

