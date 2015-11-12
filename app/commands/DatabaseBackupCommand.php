<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DatabaseBackupCommand extends Command {

	protected $name = 'backup:db';

	protected $description = 'Backup database.';

	public function fire()
	{
        $server   = "localhost";
        $username = getenv('DB_USER');
        $password = getenv('DB_PASS');
        $db       = getenv('DB_NAME');

        $date = date('Y_m_d-H-i-s');
        $restore_file = "/home/forge/backup/$date.$db.sql.gz";
        $cmd = "mysqldump -h{$server} -u{$username} -p{$password} {$db} | gzip > {$restore_file}";

        exec($cmd);

		$procesarInforme = new  InformeGeneralController;
	    $procesarInforme->procesarInformeDelDia();

        Mail::queue('emails.mensaje', array('asunto' => 'Copia de base de datos'), function($message) use($restore_file) {
            $message->to(array('hsosagm@gmail.com'))->subject('backup');
            $message->attach($restore_file);
        });
	}
}
