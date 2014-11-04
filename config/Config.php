<?php

$config['current_language'] = 'ru';

mb_internal_encoding('UTF-8');

$config['database'] = array(
    'server' 	=> 'localhost',
    'database' 	=> 'gisto',
    'username' 	=> 'gisto',
    'password' 	=> 'cf234mj081u',
    'codepage' 	=> 'utf8',
    'collate' 	=> 'utf8_bin',
);

$config['feedback_notification_emails'] = array('keliones@yandex.ru', 'info@nextgis.ru');
$config['order_notification_emails'] = array('keliones@yandex.ru', 'info@nextgis.ru');

$config['order_id_salt'] = '!D<UI({:CH*${J02eDK247123';

$config['http_domain'] = 'front.gis.to';
$config['http_path'] = '';
$config['http_root'] = 'http://' . $config['http_domain'] . $config['http_path'];
$config['http_home'] = 'http://' . $config['http_domain'] . $config['http_path'];

$config['feature']['language'] = true;
$config['feature']['user'] = true;

define('DB', 'gt_');

if ($config['feature']['user']) {
    $config['user'] = array(
        'cookie_name' => 'gisto_user',
        'cookie_domain' => $config['http_domain'],
        'cookie_path' => $config['http_root'],
        'cookie_secure' => 0,
        'cookie_expire' => 86400, // one week
        'cookie_password_salt' => 'm<#du!@pdh[HFQ[FU41-4FI3-14J0G413-',
        'password_salt' => '<k@()eurj!:pfh81PHjhfp(!@#H8F0H13200',
        'lost_password_salt' => '@j!y*(){f:;;124[Pcvj<1C0,-ZX3I4-1`8U93',
    );

    define('M_USER', 1);

    $config[M_USER] = array(
        'upload_path' => ROOT . 'up/user/',
        'upload_url' => $config['http_root'] . 'up/user/',
    );
}
