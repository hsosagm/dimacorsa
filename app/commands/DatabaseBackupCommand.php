<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DatabaseBackupCommand extends Command {

	protected $name = 'backup:db';

	protected $description = 'Buckup all databases.';

	public function fire()
	{
        $this->info( "Todo generado con exito" );
	}
}
