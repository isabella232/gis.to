<?php

class Hosting
{
    const DEFAULT_PROJECT = 'machineer';
    const DEFAULT_INSTANCE_CLASS = 'trusty-01';
    const DEFAULT_MASTER = 'master-20';

    const INSTANCE_CREATE_HTTP_TIMEOUT = 2;
    const INSTANCE_STATUS_HTTP_TIMEOUT = 10;

    const CACHE_STATUS_TIMEOUT = 300;

    static public function create($instanceId, $password, $ownerId) {
        Core::$sql->insert(array(
            'owner_id' => Core::$sql->i($ownerId),
            'instance_id' => Core::$sql->s($instanceId),
            'password' => Core::$sql->s($password),
            'insert_stamp' => Core::$sql->i(Core::$time['current_time']),
            'insert_user_id' => Core::$sql->i(Core::$user->info['id']),
            'update_stamp' => Core::$sql->i(Core::$time['current_time']),
            'update_user_id' => Core::$sql->i(Core::$user->info['id']),
        ), DB . 'hosting');

        return self::sendRequest('http://api-async.gis.to/api/class/machineer/start', json_encode(array('param' => array(
            'Project' => self::DEFAULT_PROJECT,
            'InstanceClass' => self::DEFAULT_INSTANCE_CLASS,
            'InstanceID' => $instanceId,
            'Master' => self::DEFAULT_MASTER,
            'Password' => $password
        ))), self::INSTANCE_CREATE_HTTP_TIMEOUT);
    }

    static public function getStatus($instanceId) {
        $data = Core::$sql->row('status_id, status_data, status_stamp', DB . 'hosting', 'instance_id=' . Core::$sql->s($instanceId));

        if ((Core::$time['current_time'] - $data['status_stamp']) > self::CACHE_STATUS_TIMEOUT) {

            $data['status_data'] = self::sendRequest('http://api-async.gis.to/api/class/machineer/status', json_encode(array('param' => array(
                'Project' => self::DEFAULT_PROJECT,
                'InstanceClass' => self::DEFAULT_INSTANCE_CLASS,
                'InstanceID' => $instanceId,
                'Master' => self::DEFAULT_MASTER,
            ))), self::INSTANCE_STATUS_HTTP_TIMEOUT);

            $data['status_id'] = (
                ($data['status_data']['LVM']['isRunning'] == 'True')
                && ($data['status_data']['salt']['isRunning'] == 'True')
                && ($data['status_data']['Mount']['isRunning'] == 'True')
                && ($data['status_data']['LXC']['isRunning'] == 'True')) ? 1 : 0;

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
        $ch = curl_init();

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