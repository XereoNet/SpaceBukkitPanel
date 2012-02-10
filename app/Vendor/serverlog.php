<?php 

	function w_serverlog($server, $log) {

		$logfile ="./server/".$server.".log";
		
		$file = new File($logfile);

		if ($file->exists()) {
			
		$file->append('
['.date('Y-m-d-i-s').'] '.$log);

		} else {


		$file->create();
		$file->append('['.date('Y-m-d-i-s').'] '.$log);

		}

	}

	function r_serverlog($server) {

			$logfile ="./server/".$server.".log";
			
			$file = new File($logfile);

			if ($file->exists()) {
				
			$log = $file->read();
			return $log;
			} 

		}
?>