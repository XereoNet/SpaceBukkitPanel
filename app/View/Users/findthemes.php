<?php

	/* The below function will list all folders and files within a directory

	It is a recursive function that uses a global array.  The global array was the easiest 

	way for me to work with an array in a recursive function

	*This function has no limit on the number of levels down you can search.

	*The array structure was one that worked for me.

	ARGUMENTS:

	$startdir => specify the directory to start from; format: must end in a "/"

	$searchSubdirs => True/false; True if you want to search subdirectories

	$directoriesonly => True/false; True if you want to only return directories

	$maxlevel => "all" or a number; specifes the number of directories down that you want to search

	$level => integer; directory level that the function is currently searching

	*/

	function filelist ($startdir="./", $searchSubdirs=0, $directoriesonly=1, $maxlevel="1", $level=1) {

	    //list the directory/file names that you want to ignore

	    $ignoredDirectory[] = "."; 

	    $ignoredDirectory[] = "..";

	    $ignoredDirectory[] = "_vti_cnf";

	    global $directorylist;    //initialize global array

	    if (is_dir($startdir)) { 

	        if ($dh = opendir($startdir)) { 

	            while (($file = readdir($dh)) !== false) {

	                if (!(array_search($file,$ignoredDirectory) > -1)) {

	                 if (filetype($startdir . $file) == "dir") {

	                       //build your directory array however you choose; 

	                       //add other file details that you want.

	                       $directorylist[$startdir . $file]['level'] = $level;

	                       $directorylist[$startdir . $file]['dir'] = 1;

	                       $directorylist[$startdir . $file]['name'] = $file;

	                       $directorylist[$startdir . $file]['path'] = $startdir;

	                       if ($searchSubdirs) {

	                           if ((($maxlevel) == "all") or ($maxlevel > $level)) {

	                               filelist($startdir . $file . "/", $searchSubdirs, $directoriesonly, $maxlevel, $level + 1);

	                           }

	                       }

	                   } else {

	                       if (!$directoriesonly) {

	                           //if you want to include files; build your file array  

	                           //however you choose; add other file details that you want.

	                         $directorylist[$startdir . $file]['level'] = $level;

	                         $directorylist[$startdir . $file]['dir'] = 0;

	                         $directorylist[$startdir . $file]['name'] = $file;

	                         $directorylist[$startdir . $file]['path'] = $startdir;

	      }}}}

	           closedir($dh);

	}}

	return($directorylist);

	}

	$files = filelist("./themes/",1,1); // call the function

	foreach ($files as $list) {//print array

		$filename = WWW_ROOT.'themes/'.$list['name'].'/theme.xml';
		$xml = simplexml_load_file($filename); 

   		$tname = $xml->name;
   		$tver = $xml->version;
   		$taut = $xml->author;
   		$tdes = $xml->desc;
   		$turl = $xml->url;

   	    echo <<<END

	      <tr> 

	        <td><img src="$this->webroot$list[path]$list[name]/thumbnail.png" width="100px" height="50px" /></td> 

	        <td>$tname</td> 
	        <td>$tver</td> 
	        <td>$taut</td> 
	        <td>$tdes</td> 
	        <td>$turl</td> 

	        <td> 

END;
	
		if ($current_theme == $list['name']) {
   	    echo <<<END
	          <span class="button-group"> 
	          
	            <p class="nobutton">Enabled</a>            

	          </span> 

	        </td> 

	      </tr> 
END;
		} 
		else {
   	    echo <<<END
	          <span class="button-group"> 
END;
          
echo $this->Form->postLink(
                'Activate',
                '/tsettings/update_theme/'.$list['name'],
                array('class' => 'button icon approve')
            );
	                    
   	    echo <<<END

	          </span> 

	        </td> 

	      </tr> 
END;
		}



 }



?>