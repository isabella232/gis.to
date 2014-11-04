<?php

class IndexController
{
    public function index()
    {
        $html = '

<div class="container" style="margin-top:20px">

<form id="data-form" role="form" action="' . Core::$config['http_root'] . 'data/review">

<div class="tab-content" id="cards-content">
    <div class="tab-pane active" id="home">' . $this->includeView('CardIndex') . '</div>
    <div class="tab-pane" id="data">' . $this->includeView('CardData') . '</div>
    <div class="tab-pane" id="software">' . $this->includeView('CardSoftware') . '</div>
    <div class="tab-pane" id="hosting">' . $this->includeView('CardHosting') . '</div>
    <div class="tab-pane" id="support">' . $this->includeView('CardSupport') . '</div>
    <div class="tab-pane" id="summary">' . $this->includeView('CardSummary') . '</div>
</div>

</form>

</div>

<div class="summ-panel">
    <div class="container">
        <ul class="nav nav-pills" id="cards">
            <li style="display: none" class="active"><a href="#home" data-toggle="pill">Начало</a></li>
            <li><a href="#data" data-toggle="pill" class="checkable-button"><span class="glyphicon glyphicon-ok"></span> Геоданные</a></li>
            <li><a href="#hosting" data-toggle="pill" class="checkable-button"><span class="glyphicon glyphicon-ok"></span> Веб</a></li>
            <li><a href="#software" data-toggle="pill" class="checkable-button"><span class="glyphicon glyphicon-ok"></span> Софт</a></li>
            <li><a href="#support" data-toggle="pill" class="checkable-button"><span class="glyphicon glyphicon-ok"></span> Поддержка</a></li>
            <li style="float:right""><a href="#summary" data-toggle="pill"><span class="glyphicon glyphicon-shopping-cart"></span> Итого</a></li>
        </ul>
    </div>
</div>

        ';

        return include(dirname(__FILE__) . '/../View/Common.php');
    }

    public function includeView($viewName) {
        $path = dirname(__FILE__) . '/../View/' . $viewName . '.php';
        if (file_exists($path)) {
            ob_start();
            include($path);
            return ob_get_clean();
        }
        return false;
    }

    public function get404()
    {
        header('HTTP/1.0 404 Not Found');

        $html = '<div class="container">'
            . '<h3>Запрашиваемая страница не найдена</h3>'
            . '<p>Вы можете продолжить просмотр с <a href="/">главной страницы</a></p>'
            . '</div>';

        return include(dirname(__FILE__) . '/../View/Common.php');
    }
}