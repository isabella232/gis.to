<?php

class OrderController
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

        $data = Core::$sql->get('id, insert_user_id', DB . 'order', 'insert_user_id=' . Core::$sql->i(Core::$user->info['id']));

        if (count($data)) {
            $html .= '<ul>';
            foreach ($data as $row) {
                $html .= '<li><a href="' . Core::$config['http_home'] . '/order/' . $row['id'] . '">' . s('Заказ №') . $row['id'] . '</a></li>';
            }
            $html .= '</ul>';
        } else {
            $html .= '<p>' . s('Нет заказов') . '</p>';
        }

        $html .= '</div>';

        return include(dirname(__FILE__) . '/../View/Common.php');
    }

    public function get($id)
    {
        return Core::$sql->row('*', DB . 'order', 'id=' . Core::$sql->i($id));
    }

    public function show($id)
    {
        if (!Core::$user->isLogin()) {
            go(core::$config['http_home'] . '/auth');
        }

        if (($item = $this->get($id)) === false) {
            go(core::$config['http_home'] . '/order');
        }

        if ($item['insert_user_id'] != Core::$user->info['id']) {
            go(core::$config['http_home']);
        }

        $html = '<div class="container">';

        $html .= '<h1 style="margin-bottom:40px">' . s('Заказ №') . $item['id'] . '</h1>';


        $data = Core::$sql->get('oi.*, i.type_id as item_type_id, i.title as item_title, i.description as item_description, i.price as item_price, i.status_id as item_status_id, it.title as item_type_title',
            DB . 'order_item oi, ' . DB . 'item i,' . DB . 'item_type as it',
            'oi.item_id=i.id and i.type_id=it.id and oi.order_id=' . Core::$sql->i($item['id']));


        $items = Core::$sql->get('*', DB . 'item');

        echo '<p>'. count($items) .'</p>';
        echo '<p>'. $items[0]['title'] .'</p>';
        //echo '<p>'. .'</p>';
        //echo '<p>'. .'</p>';
        //echo '<p>'. .'</p>';
        if (count($data)) {
            $html .= '<table class="table">';

            $html .= '<tr><th>Наименование</th><th style="text-align:center;">Количество</th><th style="text-align:center;">Цена</th>';

            foreach ($data as $row) {
                $details = $row['details'] ? unserialize($row['details']) : false;
                $text = '<p><strong>' . $row['item_title'] . '</strong> <span>('. $row['item_type_title'] . ')</span></p>';
                switch ($row['item_type_id']) {
                    case 6:
                        $temp = $this->getDataRow($details['id']);
                        $temp['url'] = 'http://gis-lab.info/';
                        $text .= '<p><a target="_blank" href="' . escape($temp['url']) . '">' . escape($temp['title']) . '</a></p>';
                        break;

                    case 8:
                        $temp = $this->getSoftwareRow($details['version']);
                        $text .= '<p><a target="_blank" href="' . escape($temp['url']) . '">' . escape($temp['title']) . '</a></p>';
                        break;

                    case 7:
                        $text .= '<p>' . s('Информация о заказанном вами хостинге доступна в разделе') . ' «<a href="' . Core::$config['http_home'] . '/hosting">' . s('Мой хостинг') . '</a>»</p>';
                        break;

                    case 5:
                        break;
                }

                $html .= '<tr>
                    <td>' . $text . '</td>
                    <td style="text-align:center;">' . $row['amount'] . '</td>
                    <td style="text-align:center;">' . ($row['price'] ? $row['price'] : s('Бесплатно')) . '</td>
                    </tr>';
            }

            $html .= '</table>';
        }

        $html .= '</div>';

        return include(dirname(__FILE__) . '/../View/Common.php');
     }

    public function getDataRow($id) {
        if ($this->dataDict === false) {
            $this->dataDict = json_decode(file_get_contents(ROOT . 'web/data/osm-data.json'), true);
        }

        foreach ($this->dataDict as $row) {
            if ($row['code'] == $id) {
                return $row;
            }
        }

        return false;
    }

    public function getSoftwareRow($id) {
        if ($this->softwareDict === false) {
            $this->softwareDict = json_decode(file_get_contents(ROOT . 'web/data/software.json'), true);
        }

        foreach ($this->softwareDict as $row) {
            if ($row['id'] == $id) {
                return $row;
            }
        }

        return false;
    }

    public function getHostingRow($id) {
        if ($this->hostingDict === false) {
            $this->hostingDict = json_decode(file_get_contents(ROOT . 'web/data/hosting.json'), true);
        }

        foreach ($this->hostingDict as $row) {
            if ($row['id'] == $id) {
                return $row;
            }
        }

        return false;
    }

    public function getSupportRow($id) {
        if ($this->supportDict === false) {
            $this->supportDict = json_decode(file_get_contents(ROOT . 'web/data/support.json'), true);
        }

        foreach ($this->supportDict as $row) {
            if ($row['id'] == $id) {
                return $row;
            }
        }

        return false;
    }
}