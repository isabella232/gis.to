<?php

class HostingController
{
    var $dataDict = false;
    var $softwareDict = false;
    var $hostingDict = false;
    var $supportDict = false;

    public function index()
    {
        if (!Core::$user->isLogin()) {
            go(core::$config['http_home'] . '/auth');
        }

        $html = '<div class="container">';

        $html .= '<h3>' . s('Мои заказы') . '</h3>';

        $data = Core::$sql->get('id, instance_id, password, status_id', DB . 'hosting', 'owner_id=' . Core::$sql->i(Core::$user->info['id']));

        if (count($data)) {
            $html .= '<ul>';
            foreach ($data as $row) {
                $html .= '<li><a href="' . Core::$config['http_home'] . '/hosting/' . $row['id'] . '">' . s('Хост') . ' "' . $row['instance_id'] . '"</a></li>';
            }
            $html .= '</ul>';
        } else {
            $html .= '<p>' . s('Нет хостов') . '</p>';
        }

        $html .= '</div>';

        return include(dirname(__FILE__) . '/../View/Common.php');
    }

    public function get($id)
    {
        return Core::$sql->row('*', DB . 'hosting', 'id=' . Core::$sql->i($id));
    }

    public function show($id)
    {
        if (!Core::$user->isLogin()) {
            go(core::$config['http_home'] . '/auth');
        }

        if (($item = $this->get($id)) === false) {
            go(core::$config['http_home'] . '/hosting');
        }

        if ($item['owner_id'] != Core::$user->info['id']) {
            go(core::$config['http_home']);
        }

        $data = Hosting::getStatus($item['instance_id']);
        $html = '<div class="container">';

        $html .= '<h1 style="margin-bottom:40px">' . s('Хост') . ' "' . $item['instance_id'] . '"</h1>';

        $html .= '<table class="table">
                <tr><td>' . s('Адрес') . '</td><td><a href="http://' . escape($item['instance_id']) . '.gis.to/">http://' . escape($item['instance_id']) . '.gis.to/</a></td></tr>
                <tr><td>' . s('Пароль') . '</td><td>' . escape($item['password']) . '</td></tr>
                <tr><td>' . s('Состояние') . '</td><td>' . escape($data['status_id'] ? s('Запущен') : s('Остановлен')) . '</td></tr>
                <tr><td>' . s('Обновлен') . '</td><td>' . time_format_datetime($data['status_stamp']) . '</td></tr>
            </table>';

        $html .= '</div>';

        return include(dirname(__FILE__) . '/../View/Common.php');
    }
}