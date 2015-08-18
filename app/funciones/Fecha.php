<?php

class Fecha {

	public function month($v, $end, $diff)
	{
		$dt = $end;
		$m = $dt->month;

		for($i=0; $i <= $diff; $i++)
		{
		    if($m <= 0)
		    {
		        $m = 12;
		    }
		    $months[] = $m;
	        $meses = $months[$i];

	        $mesArray = array( 
	            1  => "Enero",
	            2  => "Febrero",
	            3  => "Marzo",
	            4  => "Abril", 
	            5  => "Mayo",
	            6  => "Junio", 
	            7  => "Julio", 
	            8  => "Agosto",
	            9  => "Septiembre", 
	            10 => "Octubre", 
	            11 => "Noviembre", 
	            12 => "Diciembre" 
	        );

	        $mesReturn = $mesArray[$meses];  
	        $month[] = $mesReturn;
	        $m--;
		}

	    return $month[$v];
	}


	public function monthNum($v, $end, $diff)
	{
		$dt = $end;
		$m = $dt->month;

		for($i=0; $i <= $diff; $i++)
		{
		    if($m <= 0)
		    {
		        $m = 12;
		    }

		    $monthNum[] = $m;
		    $m--;
		}

	    return $monthNum[$v];
	}


	public function year($v, $end, $diff)
	{
		$dt = $end;
		$m = $dt->month;
		$y = $dt->year;

		for($i=0; $i <= $diff; $i++)
		{
		    if($m <= 0)
		    {
		        $y--;
		        $m = 12;
		    }

		    $year[] = $y;
		    $m--;
		}

	    return $year[$v];
	}

	public function Weekday($date)
	{
        $dia = date('w', strtotime($date));

	    switch ($dia) {
	       case 0:
	             return "Domingo";
	             break;
	       case 1:
	             return "Lunes";
	             break;
	       case 2:
	             return "Martes";
	             break;
	       case 3:
	             return "Miercoles";
	             break;
	       case 4:
	             return "Jueves";
	             break;
	       case 5:
	             return "Viernes";
	             break;
	       case 6:
	             return "Sabado";
	             break;
	    }	
	}

	public function monthsNames($i)
	{
        $mesArray = array( 
            1  => "Enero",
            2  => "Febrero",
            3  => "Marzo",
            4  => "Abril", 
            5  => "Mayo",
            6  => "Junio", 
            7  => "Julio", 
            8  => "Agosto",
            9  => "Septiembre", 
            10 => "Octubre", 
            11 => "Noviembre", 
            12 => "Diciembre" 
        );
	    return $mesArray[$i];
	}
}
