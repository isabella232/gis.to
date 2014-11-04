<!DOCTYPE html>
<html>
<head>
    <title>График проверок контролирующими органами | СкороПроверка.рф</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="/vendor/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link href='/css/style.css' rel='stylesheet' type='text/css'>
    <link href='/css/style-front.css' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="/vendor/html5shiv/3.6.2/html5shiv.js"></script>
    <script src="/vendor/respond/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script src="/vendor/jquery/jquery-1.10.2.min.js"></script>
</head>
<body>

<div class="wrap">
    <header>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h2><a href="/">СкороПроверка<span>.рф</span></a></h2>
                    <p>Узнайте когда произойдет ближайшая проверка вашей организации или индивидуального предпринимателя государственными органами.</p>
                </div>
            </div>

            <form class="form-inline search-form" role="form" method="get" action="/search/">
                <div class="form-group">
                    <input type="text" class="form-control input-lg" style="min-width:500px;" name="q" placeholder="Название организации, ИНН или ОГРН/ОГРНИП">
                </div>
                <button type="submit" class="btn btn-primary btn-lg">Найти</button>
            </form>

            <div class="row">
                <div class="col-md-8">
                    <p class="statistic">В нашей базе — 803362 госпроверок организаций по всей стране.<br/>
                    В следующем месяце — 92837 проверок.</p>
                </div>
            </div>
        </div>
    </header>
</div>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="social-share">
                    <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
                    <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareQuickServices="yaru,vkontakte,facebook,twitter" data-yashareTheme="counter" data-yashareLink="http://skoroproverka.info/"></div>
                </div>
            </div>
            <div class="col-md-8" style="text-align:right">
                <a class="btn btn-primary" href="/about/">О сервисе</a>
                <a class="btn btn-primary" href="/feedback/">Обратная связь</a>
            </div>
        </div>
    </div>
</footer>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/vendor/bootstrap/3.0.3/js/bootstrap.min.js"></script>

<?= $counters ?>

</body>
</html>