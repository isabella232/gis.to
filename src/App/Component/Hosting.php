<?php

class Hosting
{
    const DEFAULT_PROJECT = 'machineer';
    const DEFAULT_INSTANCE_CLASS = 'trusty-01';
    const DEFAULT_MASTER = 'master-20';

    const INSTANCE_CREATE_HTTP_TIMEOUT = 2;
    const INSTANCE_STATUS_HTTP_TIMEOUT = 10;

    const CACHE_STATUS_TIMEOUT = 30;

    static public function create($instanceId, $password, $ownerId) {
        $json = file_get_contents('http://api-async.gis.to/api/registry/projects/nextgisweb/new');
        $obj = json_decode($json);
        $obj->param->Name = escape($instanceId) . '.gis.to';

        Core::$sql->insert(array(
            'owner_id' => Core::$sql->i($ownerId),
            'instance_id' => Core::$sql->s($instanceId),
            'password' => Core::$sql->s($obj->param->Password),
            'insert_stamp' => Core::$sql->i(Core::$time['current_time']),
            'insert_user_id' => Core::$sql->i(Core::$user->info['id']),
            'update_stamp' => Core::$sql->i(Core::$time['current_time']),
            'update_user_id' => Core::$sql->i(Core::$user->info['id']),
            'instance_server_id' => Core::$sql->s($obj->param->InstanceID)
        ), DB . 'hosting');

        $result = self::sendRequest('http://api-async.gis.to/api/call/nextgisweb/start', json_encode($obj), self::INSTANCE_CREATE_HTTP_TIMEOUT);
        return $result;
    }

    static public function getStatus($instanceId) {
        $data = Core::$sql->row('status_id, status_data, status_stamp, instance_server_id, insert_stamp', DB . 'hosting', 'instance_id=' . Core::$sql->s($instanceId));

        if ((Core::$time['current_time'] - $data['status_stamp']) > self::CACHE_STATUS_TIMEOUT) {

            //echo 'http://api-async.gis.to/api/registry/projects/nextgisweb/instance/' . $data['instance_server_id'] .'/status';
            $server_json = file_get_contents('http://api-async.gis.to/api/registry/projects/nextgisweb/instance/' . $data['instance_server_id'] .'/status');
            $server_data = json_decode($server_json);
            $data['status_data'] = $server_data;
            $data['status_id'] = count($server_data) > 0 ? $server_data[0]->proxy->running : false;

            $data['status_stamp'] = Core::$time['current_time'];

            Core::$sql->update(array(
                'status_id' => Core::$sql->i($data['status_id']),
                'status_data' => Core::$sql->s(serialize($data['status_data'])),
                'status_stamp' => Core::$sql->i($data['status_stamp']),
            ), DB . 'hosting', 'instance_id=' . Core::$sql->s($instanceId));
        }

        return $data;
    }

    static public function sendRequest($url, $postParams, $timeout) {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postParams);

        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));

        $data = curl_exec($ch);

        curl_close($ch);

        return json_decode($data, true);
    }
}