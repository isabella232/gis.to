gis.to
======

Web frontend for NextGIS services landing page


Deployment
==========

General settings
----------------

```
$ sudo apt-get install mysql-server libapache2-mod-php5 php5-mysql php5-curl
$ cd /home/rykov
$ git clone git@github.com:nextgis/gis.to.git
$ cd gis.to
$ echo "CREATE DATABASE gisto" | mysql -u root -p
$ mysql gisto -u root -p < schema.sql
$ echo '127.0.0.1    gis.to' | sudo tee --append /etc/hosts
```

Apache settings
---------------

```
$ sudo ln -s /home/rykov/gis.to/ /var/www/html/
$ sudo touch /etc/apache2/sites-available/gis.to.conf
$ sudo a2ensite gis.to
$ sudo a2enmod rewrite
```

**gis.to.conf**

```xml
# Ensure that Apache listens on port 80

<VirtualHost *:80>

DocumentRoot /var/www/html/gis.to
ServerName gis.to

php_admin_value open_basedir /var/www/html/gis.to:/tmp

<Directory /var/www/html/gis.to>
    Options Indexes FollowSymlinks
    AllowOverride All
    Require all granted
    AddDefaultCharset utf-8
</Directory>

# Other directives here

</VirtualHost>
```

PHP settings 
------------

**php.ini**

extension=php_curl.dll


App settings
------------

**ConfigDebug.php**

```
...
$config['database']['password'] = 'your password';

$config['http_domain'] = 'gis.to';
$config['http_port'] = ':80';
...
```
