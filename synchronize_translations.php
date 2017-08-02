<?php

include_once("database.php");
include_once("functions.php");
include_once("classes.php");

	set_time_limit(0);
	use Illuminate\Database\Capsule\Manager as DB;

echo("Translation synchronizer V1.0\n");
echo("===============================\n");

if(isset($argv[1]))
{

	$filename = $argv[1];
	


	if(file_exists($filename)){

		$content = file_get_contents($filename);

		$matches = array();

		preg_match_all("/translate\(('|\")(.*?)('|\").*?\)/", $content, $matches);

		

		$references = $matches[2];

		echo(count($references) . " vertalingen gevonden in opgegeven bestand\n");

		print_r($references);

		$answer = readline("Do you want to sync? Y/N: ");

		while(!in_array($answer,array('Y','N')))
		{
			$answer = readline("Do you want to sync? Y/N: ");	
		}

		if($answer=="Y")
		{

			foreach($references as $reference)
			{
				echo("$reference\n");
				echo("--------------\n");

				$translations = Translation::where('reference',$reference)->get();

				foreach($translations as $translation)
				{
					echo($translation->language->shortname . ": " . $translation->translation . "\n");

					$development_translation = DB::connection("development")->select("SELECT * FROM translation WHERE reference=:reference AND language_id=:language_id",["reference"=> $reference, "language_id" => $translation->language_id]);

					if($development_translation!=null)
					{

						$development_value=$development_translation[0]->translation;
						$development_unstable=$development_translation[0]->unstable;
						
						echo("Development_value: " . $development_value . "\n");
						if($translation->translation!=$development_value)
						{
							
							$want_to_update = readline("Do you want to update the translation? Y/N: ");

							while(!in_array($want_to_update,array('Y','N')))
							{
								$want_to_update = readline("Do you want to update the translation? Y/N: ");
							}

							if($want_to_update=="Y")
							{
								$translation->translation = $development_value;
								$translation->unstable = $development_unstable;
								$translation->save();
							}

						}
					}


				}

				

				

				echo("\n");
			}

		}

		

	}else{
		echo("Bestand niet gevonden!");
	}


}else{
	echo("Gelieve een filename op te geven\n");
}




?>