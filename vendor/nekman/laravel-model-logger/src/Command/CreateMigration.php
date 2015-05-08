<?php

namespace NEkman\ModelLogger\Command;

use Illuminate\Console\Command;

/**
 * Command to create a migration for the package
 * 
 * @author Niklas Ekman <niklas.ekman@codr.se>
 */
class CreateMigration extends Command {

	protected $name = 'model-logger:migrate';
	protected $description = "Create a migration file for Laravel Model Logger";

	public function fire() {
		$file = date('Y_m_d_His') . '_model_logger.php';
		$migrations = "{$this->laravel->path}/database/migrations";
		$absFile = "{$migrations}/{$file}";

		if (file_exists($absFile)) :
			$this->error("Migration {$file} already exists");
			return;
		endif;

		if (!is_writable($migrations)) :
			$this->error("Can't write to folder {$migrations}");
			return false;
		endif;

		$packageFile = dirname(__FILE__) . '/../../migration.php';
		if (copy($packageFile, $absFile)) :
			$this->line("Created migration {$file}");
		else :
			$this->error('Could not create migration');
		endif;
	}

}
