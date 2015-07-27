<?php

	return array(
	  'driver' => ConfigEmail::driver(),
	  'host' => ConfigEmail::host(),
	  'port' => ConfigEmail::port(),
	  'from' => array('address' => ConfigEmail::address(), 'name' => ConfigEmail::name()),
	  'encryption' => ConfigEmail::encryption(),
	  'username' => ConfigEmail::username(),
	  'password' => ConfigEmail::password(),
	);

?>
