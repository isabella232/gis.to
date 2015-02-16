<?php

session_start();

define('__DIR__', dirname(__FILE__));

define('ROOT', dirname(__FILE__) . '/../');

require_once(__DIR__ . '/../config/Config.php');
if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
    require_once(__DIR__ . '/../config/ConfigDebug.php');
    error_reporting(E_ALL ^ E_DEPRECATED);
}

require_once(__DIR__ . '/../src/App/Component/lib.util.php');
require_once(__DIR__ . '/../src/App/Component/lib.string.php');
require_once(__DIR__ . '/../src/App/Component/lib.time.php');
time_init();
timer_start();

$action = '';
if(isset($_GET['action'])) $action = $_GET['action'];
if(isset($_POST['action'])) $action = $_POST['action'];

require_once(__DIR__ . '/../src/App/Component/lib.upload.php');
require_once(__DIR__ . '/../src/App/Component/lib.image.php');
require_once(__DIR__ . '/../src/App/Component/lib.mail.php');
require_once(__DIR__ . '/../src/App/Component/Page.php');
require_once(__DIR__ . '/../src/App/Component/Form.php');
require_once(__DIR__ . '/../src/App/Component/lib.image_cache.php');
require_once(__DIR__ . '/../src/App/Component/Hosting.php');
require_once(__DIR__ . '/../src/App/Component/Core.php');

Core::$time = $time;
Core::$config = &$config;

function loginRequired() {
    if (!Core::$user->isLogin()) {
        require_once(__DIR__ . '/../src/App/Controller/IndexController.php');
        $controller = new IndexController();
        $controller->get403Forbidden();
        die();
    }
}

function managerRequired() {
    if (!Core::$user->isLogin() || !Core::$user->info['is_manager']) {
        require_once(__DIR__ . '/../src/App/Controller/IndexController.php');
        $controller = new IndexController();
        $controller->get403Forbidden();
        die();
    }
}

function adminRequired() {
    if (!Core::$user->isLogin() || !Core::$user->info['is_admin']) {
        require_once(__DIR__ . '/../src/App/Controller/IndexController.php');
        $controller = new IndexController();
        $controller->get403Forbidden();
        die();
    }
}

if ($config['feature']['language']) {
    if (file_exists(__DIR__ . '/../lang/en.php')) {
        require_once(__DIR__ . '/../lang/en.php');
        Core::$lang = &$lang;
    }

    function s($str) {
        if (isset(Core::$lang[Core::$config['current_language']][$str])) {
            return Core::$lang[Core::$config['current_language']][$str];
        } else {
            return $str;
        }
    }
} else {
    function s($str) {
        return $str;
    }
}

require_once(__DIR__ . '/../src/App/Component/lib.db.php');
require_once(__DIR__ . '/../src/App/Component/lib.db_mysql.php');
$sql = new db_mysql($config['database']);
Core::$sql = $sql;

if ($config['feature']['user']) {
    require_once(__DIR__ . '/../src/App/Component/User.php');
    $user = new User();
    Core::$user = $user;
}

function firstUpper($str) {
    return mb_strtoupper(mb_substr($str, 0, 1)) . mb_substr($str, 1);
}

function escapeRegExp($str){
    return preg_replace('/([.*+?^=!:${}()|\[\]\/])/Uu', "\\\\$1", $str);
}

Core::$counters = file_get_contents(ROOT . '/config/counters.htm');

$url = $_SERVER['REQUEST_URI'];

if (preg_match('/([^\/]+)\/\?/Uui', $url)) {
	//go(preg_replace('/([^\/]+)\/\?/Uui', '$1?', $url));
}

if (preg_match('/^([^?]*[^\/?]+)\/$/Uui', $url)) {
	//go(preg_replace('/^([^?]*[^\/?]+)\/$/Uui', '$1', $url));
}

$rootPathMatch = str_replace(".", '\.', str_replace("/", '\/', $config['http_path'])) . '\/';

if ($config['feature']['language']) {
    if (preg_match('/^' . $rootPathMatch . '((en|ru)(|\/.+))$/Uu', $url, $matches)) {
        Core::$config['current_language'] = $matches[2];
        $url = '/' . $matches[1];
        $rootPathMatch = '\/' . Core::$config['current_language'];
        Core::$config['http_home'] .= '/' . Core::$config['current_language'];
    } else {
        go(Core::$config['http_home'] . '/ru');
    }
}

if (preg_match('/^' . $rootPathMatch . '$/Uu', $url, $matches)) {
    require_once(__DIR__ . '/../src/App/Controller/IndexController.php');
    $controller = new IndexController();
    $controller->index();
    die();
}

if (preg_match('/^' . $rootPathMatch . '\/get(|\?.*)$/Uu', $url, $matches)) {
    require_once(__DIR__ . '/../src/App/Controller/IndexController.php');
    $controller = new IndexController();
    $controller->get();
    die();
}

if (preg_match('/^' . $rootPathMatch . '\/feedback(|\?.*)$/Uu', $url, $matches)) {
    require_once(__DIR__ . '/../src/App/Controller/FeedbackController.php');
    $controller = new FeedbackController();
    $controller->index();
    die();
}

if (preg_match('/^' . $rootPathMatch . '\/feedback\/ok(|\?.*)$/Uu', $url, $matches)) {
    require_once(__DIR__ . '/../src/App/Controller/FeedbackController.php');
    $controller = new FeedbackController();
    $controller->ok();
    die();
}

if (preg_match('/^' . $rootPathMatch . '\/order(|\?.*)$/Uu', $url, $matches)) {
    require_once(__DIR__ . '/../src/App/Controller/OrderController.php');
    $controller = new OrderController();
    $controller->index();
    die();
}

if (preg_match('/^' . $rootPathMatch . '\/order\/(\d+)(|\?.*)$/Uu', $url, $matches)) {
    require_once(__DIR__ . '/../src/App/Controller/OrderController.php');
    $controller = new OrderController();
    $controller->show($matches[1]);
    die();
}

if (preg_match('/^' . $rootPathMatch . '\/hosting(|\?.*)$/Uu', $url, $matches)) {
    require_once(__DIR__ . '/../src/App/Controller/HostingController.php');
    $controller = new HostingController();
    $controller->index();
    die();
}

if (preg_match('/^' . $rootPathMatch . '\/hosting\/(\d+)(|\?.*)$/Uu', $url, $matches)) {
    require_once(__DIR__ . '/../src/App/Controller/HostingController.php');
    $controller = new HostingController();
    $controller->show($matches[1]);
    die();
}

if (Core::$config['feature']['user']) {
    if (preg_match('/^' . $rootPathMatch . '\/login(|\?.*)$/Uu', $url, $matches)) {
        require_once(__DIR__ . '/../src/App/Controller/AuthController.php');
        $controller = new AuthController();
        echo $controller->login();
        die();
    }

    if (preg_match('/^' . $rootPathMatch . '\/logout(|\?.*)$/Uu', $url, $matches)) {
        require_once(__DIR__ . '/../src/App/Controller/AuthController.php');
        $controller = new AuthController();
        echo $controller->logout();
        die();
    }

    if (preg_match('/^' . $rootPathMatch . '\/register(|\?.*)$/Uu', $url, $matches)) {
        require_once(__DIR__ . '/../src/App/Controller/AuthController.php');
        $controller = new AuthController();
        echo $controller->register();
        die();
    }

    if (preg_match('/^' . $rootPathMatch . '\/auth(|\?.*)$/Uu', $url, $matches)) {
        require_once(__DIR__ . '/../src/App/Controller/AuthController.php');
        $controller = new AuthController();
        echo $controller->auth();
        die();
    }

    if (preg_match('/^' . $rootPathMatch . '\/lost-password/Uu', $url, $matches)) {
        require_once(__DIR__ . '/../src/App/Controller/AuthController.php');
        $controller = new AuthController();

        if (preg_match('/^' . $rootPathMatch . '\/lost-password(|\?.*)$/Uu', $url, $matches)) {
            echo $controller->lostPassword();
            die();
        }

        if (preg_match('/^' . $rootPathMatch . '\/lost-password\/sent(|\?.*)$/Uu', $url, $matches)) {
            echo $controller->lostPasswordSent();
            die();
        }

        if (preg_match('/^' . $rootPathMatch . '\/lost-password\/change(|\?.*)$/Uu', $url, $matches)) {
            echo $controller->lostPasswordChange();
            die();
        }
    }
}

require_once(__DIR__ . '/../src/App/Controller/IndexController.php');
$controller = new IndexController();
$controller->get404();
