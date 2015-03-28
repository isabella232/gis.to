<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>gis.to</title>

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600&subset=latin,cyrillic' rel='stylesheet'
          type='text/css'>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <!--<link rel="stylesheet" href="/css/bootstrap.min.css">-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="<?= Core::$config['http_root'] ?>/css/style.css">
</head>
<body>

<header>

    <div class="container">
        <div class="row">

            <nav class="navbar" role="navigation">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse"
                                data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="<?= Core::$config['http_home'] ?>/">NextGIS Store</a>
                    </div>

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <?php if (Core::$config['feature']['user']) { ?>
                            <ul class="nav navbar-nav navbar-right">
                                <?php if (! Core::$user->isLogin()) { ?>
                                    <li><a href="<?= Core::$config['http_home'] ?>/login"><?= s('Вход') ?></a></li>
                                    <li><a href="<?= Core::$config['http_home'] ?>/register"><?= s('Регистрация') ?></a></li>
                                <?php } else { ?>
                                    <li><a href="<?= Core::$config['http_home'] ?>/hosting"><?= s('Мой хостинг') ?></a></li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <?= escape(Core::$user->info['email']) ?><span class="caret"></span></a>
                                        <ul class="dropdown-menu" role="menu">
                                        <li><a href="<?= Core::$config['http_home'] ?>/order"><?= s('Мои заказы') ?></a></li>
                                        <li><a href="<?= Core::$config['http_home'] ?>/logout"><?= s('Выход') ?></a></li>
                                        </ul>
                                    </li>
                                <?php } ?>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?= Core::$config['language'][Core::$config['current_language']]['title'] ?><span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li<?= Core::$config['current_language'] == 'ru' ? ' class="active"' : '' ?>><a
                                                href="<?= preg_replace('/^(' . escapeRegExp(Core::$config['http_path']) . '\/)en/Uui', '$1ru', $_SERVER['REQUEST_URI']) ?>">Ру</a></li>
                                        <li<?= Core::$config['current_language'] == 'en' ? ' class="active"' : '' ?>><a
                                                href="<?= preg_replace('/^(' . escapeRegExp(Core::$config['http_path']) . '\/)ru/Uui', '$1en', $_SERVER['REQUEST_URI']) ?>">En</a></li>
                                    </ul>
                                </li>
                                <li><a class="help" href="http://nextgis.ru/contact/"><span class="help glyphicon glyphicon-question-sign"></span></a></li>
                            </ul>
                        <?php } ?>
                    </div>
                    <!-- /.navbar-collapse -->
                </div>
                <!-- /.container-fluid -->
            </nav>

        </div>
    </div>

</header>

<?= isset($html) ? $html : '' ?>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4">

            </div>
        </div>
    </div>
</footer>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<!--<script src="/js/bootstrap.min.js"></script>-->

<?= isset(Core::$counters) ? Core::$counters : '' ?>

</body>
</html>