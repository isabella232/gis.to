<?php

class User
{
	const ANONIMOUS = 1;
	const GUEST = 1;

	public $info = false;
	
	function __construct()
	{
		$this->init();
	}
	
	function init()
	{
		$this->info = array(
				'id' => User::ANONIMOUS,
				'title' => 'Гость',
				'is_admin' => false,
			);
		
		if (($cookie = $this->getCookie()) !== false) {
			$info = Core::$sql->row('*', DB.'user', 'is_disabled=0 and id='.Core::$sql->i($cookie['id']));
			if($info !== false && (($cookie['id'] == User::ANONIMOUS) || ($this->getHash(Core::$config['user']['cookie_password_salt'], $info['password']) == $cookie['password_hash']))) {
				$this->info = $info;
			}
		} else {
			$this->setCookie(User::ANONIMOUS, mt_rand());
		}
	}
	
	function getCookie()
	{
		if(isset($_COOKIE[Core::$config['user']['cookie_name']])) {
			$temp = explode('_', $_COOKIE[Core::$config['user']['cookie_name']]);
			if(count($temp) == 2) return array(
					'id' => (int)$temp[0],
					'password_hash' => trim($temp[1]),
				);
		}
		return false;
	}
	
	function setCookie($id, $password)
	{
		$cookie_password_hash = $this->getHash(Core::$config['user']['cookie_password_salt'], $password);
		if(version_compare(PHP_VERSION, '5.2.0', '>=')) {
			setcookie(Core::$config['user']['cookie_name'], $id.'_'.$cookie_password_hash, Core::$time['current_time'] + Core::$config['user']['cookie_expire'],
					Core::$config['user']['cookie_path'], Core::$config['user']['cookie_domain'], Core::$config['user']['cookie_secure'], true);
		} else {
			setcookie(Core::$config['user']['cookie_name'], $id.'_'.$cookie_password_hash, Core::$time['current_time'] + Core::$config['user']['cookie_expire'],
					Core::$config['user']['cookie_path'].'; HttpOnly', Core::$config['user']['cookie_domain'], Core::$config['user']['cookie_secure']);
		}
	}
	
    function getHash($salt, $value)
    {
    	return sha1($salt.$value);
    }
    
    function isLogin()
    {
        return $this->info['id'] != User::ANONIMOUS;
    }
    
    function login($email, $password)
    {
        $email = trim($email);
        $password = trim($password);
        
        if($email == '' || $password == '') {
            return false;
        }

        $info = Core::$sql->row('id, password', DB.'user',
        		'id<>'.Core::$sql->i(User::ANONIMOUS).' and is_disabled=0 and email='.Core::$sql->s($email));

        $password_hash = $this->getHash(Core::$config['user']['password_salt'], $password);
        
        if($info['password'] != $password_hash) {
        	return false;
        }

		$this->setCookie($info['id'], $info['password']);
		
        return $info['id'];
    }

    function logout()
    {
		$this->setCookie(User::ANONIMOUS, mt_rand());
    }

    function register($email, $password)
    {    
        $password_hash = $this->getHash(Core::$config['user']['password_salt'], $password);
        
        Core::$sql->insert(array(
            'email' => Core::$sql->s($email),
            'password' => Core::$sql->s($password_hash),
            'registered_stamp' => Core::$time['current_time'],
            'is_disabled' => 0,
        ), DB.'user');
        
        $id = Core::$sql->get_last_id();
        
        $this->login($email, $password);

        return $id;
    }
}
