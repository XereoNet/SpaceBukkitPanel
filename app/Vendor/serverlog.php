<?php 

	function w_serverlog($server, $log) {

		$logfile =TMP . "server/".$server.".log";
		
		$file = new File($logfile);

		if ($file->exists()) {
			
		$file->append('
['.date('Y-m-d H:i:s').'] '.$log);

		} else {


		$file->create();
		$file->append('['.date('Y-m-d H:i:s').'] '.$log);

		}

	}

	function r_serverlog($server) {

			$logfile = TMP . "server/".$server.".log";
			
			$file = new File($logfile);

			if ($file->exists()) {
				
			$log = $file->read();
			return $log;
			} 

		}
?>