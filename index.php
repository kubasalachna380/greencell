<?php 
require_once('inc/classes.php');

$log = new Log();

//POBRANIE OBECNEGO NUMERU DNIA TYGODNIA ORAZ PELNEJ GODZINY
$day = date("N");
$hour = date("G");

if(($day == 6 || $day == 7 || ($day == 5 && $hour >= 15) || ($day == 1 && $hour < 10)) && end($argv) != "--force")
{
	echo "O tej porze dostęp nie jest możliwy. Spróbuj w innym czasie.";
	$log -> exception("Próba wejścia o zabronionej porze.");
	sleep(2);
	exit();
}

//TABLICE Z SPÓŁGŁOSKAMI I SAMOGŁOSKAMI
$consonant = array ('b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm');

$vowel = array ('a', 'e', 'i', 'o', 'u', 'a', 'e', 'i', 'o', 'u');

//*****************************//

echo "Hey, Hi, Hello".PHP_EOL;

sleep(1);

echo "Podaj ile słów chcesz wygenerować: ";
$count = readline();

echo "Ile minimalnie znaków ma mieć każde słowo: ";
$lenght_min = readline();

echo "Ile maksymalnie znaków ma mieć każde słowo: ";
$lenght_max = readline();

//SPRAWDZENIE PODANYCH PARAMETRÓW
if($count < 1 || $lenght_min < 1 || $lenght_max < $lenght_min || is_numeric($count) != 1 || is_numeric($lenght_min) != 1 || is_numeric($lenght_max) != 1)
{
	//GDY KTÓRYŚ Z PARAMETRÓW JEST BŁĘDNY TO LOG I PRZERWANIE DZIAŁANIA
	echo "Jeden z podanych parametrów jest niepoprawny. Spróbuj jeszcze raz.";
	$log -> exception("Niepoprawne dane: Ilość słów: ".$count." - Minimalna długość: ".$lenght_min." - Maksymalna długość: ".$lenght_max);

	sleep(2);
	exit();
}


for($x = 1; $x <= $count; $x++)
{ //KOLEJNE SŁOWO
	$word = "";
	$check = 1;

	$lenght = rand($lenght_min, $lenght_max); // ILOŚĆ ZNAKÓW W SŁOWIE

	for($i = 1; $i <= $lenght; $i++)
	{
		//KOLEJNY ZNAK W SŁOWIE
		$prepare = rand(0, 9);

		if($i == 1)
		{
			//GDY PIERWSZY ZNAK
			$word .= $consonant[$prepare];
		}
		elseif($i == 2)
		{
			//GDY DRUGI ZNAK
			$word .= $vowel[$prepare];
		}
		else
		{
			//GDY POZOSTAŁE ZNAKI
			if($check == 2)
			{
				//GDY DWIE POPRZEDNIE LITERY SĄ SPÓŁGŁOSKAMI TO AUTOMATYCZNIE SAMOGŁOSKA
				$word .= $vowel[$prepare];
				$check = 1;
			}
			else
			{

				$z = rand(1, 2); //1 DLA SPÓŁGŁOSKI, 2 DLA SAMOGŁOSKI

				switch ($z) {
					case '1':
							//SPÓŁGŁOSKA
							$word .= $consonant[$prepare];
							$check++;
						break;

					case '2':
							//SAMOGŁOSKA
							$word .= $vowel[$prepare];
							$check = 1;
						break;
					
					default:
							echo "Coś poszło nie tak :(";
							$log -> exception("Bład podczas generowania losowej zmiennej $z, której zadaniem jest określenie czy litera jest spółgłoską lub samogłoską");

							sleep(2);
							exit();
						break;
				}
			}

			$word .= $consonant[$prepare]; //PRZYPISANIE KOLEJNEJ LITERY DO SŁOWA
		}

		
	}

	echo $word.PHP_EOL; //WYŚWIETLENIE CAŁEGO SŁOWA W JEDNEJ LINI
}


//UTWORZENIE LOG PO ZAKOŃCZENIU LISTOWANIA SŁÓW
$log -> normal($count, $lenght_min, $lenght_max);

exit();
?>
