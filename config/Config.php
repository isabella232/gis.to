<?php

$config['current_language'] = 'ru';

mb_internal_encoding('UTF-8');

$config['database'] = array(
    'server' 	=> 'localhost',
    'database' 	=> 'gisto',
    'username' 	=> 'gisto',
    'password' 	=> 'Gh2118tdh#423',
    'codepage' 	=> 'utf8',
    'collate' 	=> 'utf8_bin',
);

$config['http_domain'] = 'front.gis.to';
$config['http_port'] = '';
$config['http_path'] = '';
$config['http_root'] = 'http://' . $config['http_domain'] . $config['http_port'] . $config['http_path'];
$config['http_home'] = 'http://' . $config['http_domain'] . $config['http_port'] . $config['http_path'];

$config['feature']['language'] = true;
$config['feature']['user'] = true;

$config['site']['url'] = 'http://front.gis.to/';
$config['site']['title'] = 'NextGIS Shop';
$config['site']['email_title'] = $config['site']['title'];
$config['site']['email'] = 'sim@gis-lab.info';

define('DB', 'gt_');

if ($config['feature']['language']) {
    $config['language'] = array(
        'ru' => array('title' => 'Ру'),
        'en' => array('title' => 'En')
    );
}

if ($config['feature']['user']) {
    $config['user'] = array(
        'cookie_name' => 'gisto_user',
        'cookie_domain' => $config['http_domain'],
        'cookie_path' => $config['http_path'] ? $config['http_path'] : '/',
        'cookie_secure' => 0,
        'cookie_expire' => 86400, // one week
        'cookie_password_salt' => 'PLO*&Dgtp2hdy293p7fdgG#d32@!J(E&YGUJC',
        'password_salt' => 'LJH!O@#*!YE)*(#_HQOUE#&*YDIDJIJDsdsWI',
        'lost_password_salt' => 'NJU!ODY*L:HBHJAShjoadocn/;Gkjh:IG83#K!JHD8',
    );

    define('M_USER', 1);

    $config[M_USER] = array(
        'upload_path' => ROOT . 'up/user/',
        'upload_url' => $config['http_root'] . 'up/user/',
    );
}
