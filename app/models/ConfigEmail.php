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
		return '*/\<2=\*0=/*E=/=*/l=*/=m\=*/=u=\*/=n\*/=d\*/o\*/.\*/=e=\*/=s=\*';
	}

}
