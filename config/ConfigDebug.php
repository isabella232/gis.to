<?php

$config['database']['server'] = 'localhost';
$config['database']['database']	= 'gisto';
$config['database']['username'] = 'root';
$config['database']['password'] = '123';

$config['http_domain'] = 'gis.to';
$config['http_port'] = ':80';
$config['http_path'] = '';
$config['http_root'] = 'http://' . $config['http_domain'] . $config['http_port'] . $config['http_path'];
$config['http_home'] = 'http://' . $config['http_domain'] . $config['http_port'] . $config['http_path'];

if ($config['feature']['user']) {
    $config['user']['cookie_domain'] = $config['http_domain'];
    $config['user']['cookie_path'] = $config['http_path'] ? $config['http_path'] : '/';
}
