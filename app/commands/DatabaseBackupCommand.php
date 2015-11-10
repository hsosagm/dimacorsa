<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DatabaseBackupCommand extends Command {

	protected $name = 'backup:db';

	protected $description = 'Buckup all databases.';

	public function fire()
	{
	    Mail::queue('emails.mensaje', array('asunto' => 'Cierre del Dia'), function($message) {
	        $message->to(array('intelpcventas@hotmail.com'))->subject('probando');
	    });
	}
}
