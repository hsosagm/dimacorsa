<?php

namespace NEkman\ModelLogger\Command;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class DeleteOld extends Command {

	protected $name = 'model-logger:delete-old';
	protected $description = "Delete old log entries";

	public function fire() {
		$daysToKeep = (int) $this->argument('days-to-keep');

		if ($daysToKeep < 0) :
			$this->error('Argument "days-to-keep" must be a non positive integer');
			return;
		endif;

		$nMessages = \DB::delete('DELETE FROM `model_log` WHERE `timestamp` < (NOW() - INTERVAL ? DAY)', array($daysToKeep));

		$this->line("{$nMessages} deleted!");
	}

	public function getArguments() {
		return array(
		    array(
			'days-to-keep',
			InputOption::VALUE_REQUIRED,
			'How many days should a log entry be kept?',
			-1
		    )
		);
	}

}
