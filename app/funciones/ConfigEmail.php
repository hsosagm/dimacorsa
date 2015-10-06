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
		return  getenv('MAIL_ADDRESS');
	}

	public static function name () {
		return  getenv('MAIL_NAME');
	}

	public static function encryption () {
		return 'tls';
	}

	public static function username () {
		return getenv('MAIL_USERNAME');
	}

	public static function password() {
		return getenv('MAIL_PASSWORD');
	}
}
