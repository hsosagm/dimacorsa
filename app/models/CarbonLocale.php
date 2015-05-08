<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;

class CarbonLocale extends Carbon {
	

	public function diffForHumans(Carbon $other = null)
	{
		$isNow = $other === null;
		
		if ($isNow) {
			$other = static::now($this->tz);
		}
		
		$isFuture = $this->gt($other);
		
		$delta = $other->diffInSeconds($this);
		
// 4 weeks per month, 365 days per year... good enough!!
		$divs = array(
			'second' => self::SECONDS_PER_MINUTE,
			'minute' => self::MINUTES_PER_HOUR,
			'hour' => self::HOURS_PER_DAY,
			'day' => self::DAYS_PER_WEEK,
			'week' => 4,
			'month' => self::MONTHS_PER_YEAR
			);
		
		$unit = 'year';
		
		foreach ($divs as $divUnit => $divValue) {
			if ($delta < $divValue) {
				$unit = $divUnit;
				break;
			}
			
			$delta = floor($delta / $divValue);
		}
		
		if ($delta == 0) {
			$delta = 1;
		}
		
// Código adaptado para utilizar el gestor de idiomas de Laravel
		$txt = 'carbonlocale';
		
		if ($isFuture) {
			return Lang::choice("$txt.future.$unit", $delta, compact('delta'));
		}
		
		return Lang::choice("$txt.past.$unit", $delta, compact('delta'));
	}
} 