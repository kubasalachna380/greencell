<?php

	class Log
	{
		
		function normal($count, $lenght_min, $lenght_max)
		{
			$this->now = date("Y.m.d, G:i:s");
			$this->count = $count;
			$this->lenght_min = $lenght_min;
			$this->lenght_max = $lenght_max;

			//LOG DO PLIKU
			$log  = $this->now.PHP_EOL."Ilość słów: ".$this->count.PHP_EOL."Minimalna długość słowa: ".$this->lenght_min.PHP_EOL."Maksymalna długośc słowa: ".$this->lenght_max.PHP_EOL."--------------------------------------------".PHP_EOL;

			file_put_contents('generator.log', $log, FILE_APPEND);
	
		}

		function exception($message)
		{
			$this->now = date("Y.m.d, G:i:s");
			$this->message = $message;

			//LOG DO PLIKU
			$log  = $this->now.PHP_EOL."Opis błędu: ".$this->message.PHP_EOL."--------------------------------------------".PHP_EOL;

			file_put_contents('exceptions.log', $log, FILE_APPEND);
		}

	}

?>