<?php

class ConfigEmail {

	public static function driver () {
		return 'smtp';
	} 

	public static function host () {
		return 'smtp.sendgrid.net';
	} 

	public static function port () {
		return 587;
	} 

	public static function address () {
		return 'appReport@notificacion.com';
	} 

	public static function name () {
		return 'Notificacion';
	} 

	public static function encryption () {
		return 'tls';
	} 

	public static function username () {
		return 'nelug';
	}

	public static function password() {
		return preg_replace('/[^A-Za-z0-9-.]/', '',ConfigEmail::_password());
	}

	public static function _password() {
		return ConfigEmail::decrypt('lpvBq6CiyJaVrJ2PsamUrJiU2KmPnqvSyKmPnqvaqciPnqvTyJaUrNLBlpvUy5iUmsiPnqvKqciPnqvYqciP','leonel');
	}

	public static function encrypt($string, $key) {
		$result = '';
		for($i=0; $i<strlen($string); $i++) {
			$char = substr($string, $i, 1);
			$keychar = substr($key, ($i % strlen($key))-1, 1);
			$char = chr(ord($char)+ord($keychar));
			$result.=$char;
		}
		return base64_encode($result);
	}

	public static function decrypt($string, $key) {
		$result = '';
		$string = base64_decode($string);
		for($i=0; $i<strlen($string); $i++) {
			$char = substr($string, $i, 1);
			$keychar = substr($key, ($i % strlen($key))-1, 1);
			$char = chr(ord($char)-ord($keychar));
			$result.=$char;
		}
		return $result;
	}

}
