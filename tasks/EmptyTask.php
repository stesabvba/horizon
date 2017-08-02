<?php

class EmptyTask
{
	public function fire($job, $data)
	{
		try
		{
			echo("Trying this empty task\n");
			
			$job->delete();
			

		}catch (Exception $e) {

			echo $e->getMessage();

			$job->delete();
		}
	}
}

?>