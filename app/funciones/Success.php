<?php

class Success {

	public static function true()
	{
		return Response::json(array(
			'success' => true
        ));
	}

	public static function false()
	{
		return Response::json(array(
			'success' => false
        ));
	}
}
