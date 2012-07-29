<?php

/**
*
*   ####################################################
*   UpdateController.php 
*   ####################################################
*
*   DESCRIPTION
*
*   This controller is responsible for SpaceBukkit updating.
*   
*   TABLE OF CONTENTS
*   
*   1)  index
*   2)  update
*   
* @copyright  Copyright (c) 20011 XereoNet and SpaceBukkit (http://spacebukkit.xereo.net)
* @version    Last edited by Antariano
* @since      File available since Release 1.0
*
*
*/

class UpdateController extends AppController {

    public $components = array('RequestHandler');

    public $name = 'Update';

    function index() {


        require APP .'webroot/configuration.php';

        //get CURRENT SpaceBukkit version

        $c_sb = $sbconf['app_version'];
        $app = $sbconf['app'];
 
        //get LATEST SpaceBukkit version

        $filename = 'http://dl.nope.bz/sb/build/build.xml';
        $l_sb = simplexml_load_file($filename); 

        $json = json_encode($l_sb);
        $l_sb = json_decode($json, TRUE);

        //Redirect if no new version is avaible

        if ($app >= $l_sb["BUILD"]["APP"]) {
            
            $this->redirect(array('controller' => 'Dash', 'action' => 'index'));

        }


        $this->set('title_for_layout', __('Updating SpaceBukkit'));
        $this->set('current', $c_sb);
        $this->set('latest', $l_sb["BUILD"]["VERSION"]);
        $this->set('changelog', $l_sb["BUILD"]["CHANGELOG"]);

        $command = '';
        if (PHP_OS !== 'WINNT') {
            $user = exec('whoami');
            if (get_current_user() == $user) {
                $chown = true;
            } else {
                $chown = false;
                $command = 'chown -R '.$user.' '.ROOT;
            }
        } else {
            $chown = true;
        }
        $this->set('owner', array($chown, $command));

        $this->layout = 'update';

    }

    function getStatus() {
        if ($this->request->is('ajax')) {
            $this->disableCache();
            Configure::write('debug', 0);
            $this->autoRender = false;

            $file = new File(TMP.'update');
            if (!$file->exists()) {
                exit(json_encode(array('pb' => 100, 'msg' => 'Redirecting...')));
            }
            $file = explode(',', $file->read());
            echo json_encode(array('pb' => $file[0], 'msg' => $file[1]));
        }
    }

    function update() {
        session_write_close();

        $updateFile = new File(TMP.'update');
        $updateFile->create();

        file_put_contents(TMP.'update', '0,Locking panel...');
        $maintenance = new File(APP."webroot/.maintenance");
        $maintenance->create();

        require APP.'webroot/configuration.php';

        //get CURRENT SpaceBukkit version

        $c_sb = $sbconf['app'];

        //get LATEST SpaceBukkit version

        $filename = 'http://dl.nope.bz/sb/build/build.xml';
        $l_sb = simplexml_load_file($filename); 

        $json = json_encode($l_sb);
        $l_sb = json_decode($json, TRUE);

        if ($c_sb >= $l_sb["BUILD"]["APP"]) {
            
            exit(__("already up to date"));
        } 

        //Download new file

        function download_remote_file_with_curl($file_url, $save_to)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch,CURLOPT_URL,$file_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $file_content = curl_exec($ch);
            curl_close($ch);
     
            $downloaded_file = fopen($save_to, 'w');
            fwrite($downloaded_file, $file_content);
            fclose($downloaded_file);
     
        }
        $file = $l_sb["BUILD"]["FILE"];
        file_put_contents(TMP.'update', '2,Downloading update...');


        download_remote_file_with_curl($file, realpath(WWW_ROOT."upgrade") . '/app.zip');

        file_put_contents(TMP.'update', '32,Unzipping...');

        //Extract it to /upgrade and delete zip

        $appname = WWW_ROOT."upgrade/app.zip";

        //check if file was downloaded

        $checkfile = new File($appname);
        if (!($checkfile->exists())) {
            exit("File not downloaded properly.");
        }

        //continue

        $appdir = WWW_ROOT."upgrade/app";

        $zip = new ZipArchive;
         $res = $zip->open($appname);
         if ($res === TRUE) {
             $zip->extractTo($appdir);
             $zip->close();
         } else {
             exit(__("unzipping failed!"));
         }      

        unlink($appname);

        //Make sure it was unzipped

        if (!is_dir($appdir)) {
            
            exit(__("unzip didn't unzip! :("));

        }

    /** 
     * Copy file or folder from source to destination, it can do 
     * recursive copy as well and is very smart 
     * It recursively creates the dest file or directory path if there weren't exists 
     * Situtaions : 
     * - Src:/home/test/file.txt ,Dst:/home/test/b ,Result:/home/test/b -> If source was file copy file.txt name with b as name to destination 
     * - Src:/home/test/file.txt ,Dst:/home/test/b/ ,Result:/home/test/b/file.txt -> If source was file Creates b directory if does not exsits and copy file.txt into it 
     * - Src:/home/test ,Dst:/home/ ,Result:/home/test/** -> If source was directory copy test directory and all of its content into dest      
     * - Src:/home/test/ ,Dst:/home/ ,Result:/home/**-> if source was direcotry copy its content to dest 
     * - Src:/home/test ,Dst:/home/test2 ,Result:/home/test2/** -> if source was directoy copy it and its content to dest with test2 as name 
     * - Src:/home/test/ ,Dst:/home/test2 ,Result:->/home/test2/** if source was directoy copy it and its content to dest with test2 as name 
     * @param $source //file or folder 
     * @param $dest ///file or folder 
     * @param $options //folderPermission,filePermission 
     * @return boolean 
     */ 
    function smartCopy($source, $dest, $options=array('folderPermission'=>0755,'filePermission'=>0755)) 
    { 
        $result=false; 
        
        if (is_file($source)) { 
            if ($dest[strlen($dest)-1]=='/') { 
                if (!file_exists($dest)) { 
                    cmfcDirectory::makeAll($dest,$options['folderPermission'],true);
                } 
                $__dest=$dest."/".basename($source); 
            } else { 
                $__dest=$dest; 
            } 
            $result=copy($source, $__dest); 
            chmod($__dest,$options['filePermission']); 
            
        } elseif(is_dir($source)) { 
            if ($dest[strlen($dest)-1]=='/') { 
                if ($source[strlen($source)-1]=='/') { 
                    //Copy only contents 
                } else { 
                    //Change parent itself and its contents 
                    $dest=$dest.basename($source); 
                    @mkdir($dest); 
                    chmod($dest,$options['filePermission']); 
                } 
            } else { 
                if ($source[strlen($source)-1]=='/') { 
                    //Copy parent directory with new name and all its content 
                    @mkdir($dest,$options['folderPermission']); 
                    chmod($dest,$options['filePermission']); 
                } else { 
                    //Copy parent directory with new name and all its content 
                    @mkdir($dest,$options['folderPermission']); 
                    chmod($dest,$options['filePermission']); 
                } 
            } 

            $dirHandle=opendir($source); 
            while($file=readdir($dirHandle)) 
            { 
                if($file!="." && $file!="..") 
                { 
                     if(!is_dir($source."/".$file)) { 
                        $__dest=$dest."/".$file; 
                    } else { 
                        $__dest=$dest."/".$file; 
                    } 
                    //echo "$source/$file ||| $__dest<br />"; 
                    $result=smartCopy($source."/".$file, $__dest, $options); 
                } 
            } 
            closedir($dirHandle); 
            
        } else { 
            $result=false; 
        } 
        return $result; 
    } 
        file_put_contents(TMP.'update', '47,Copying new files...');


        $status = smartCopy($appdir, APP);

        //Upgrade the database if sql file exists

        file_put_contents(TMP.'update', '77,Upgrading database...');


        $sql_upgrade = new File($appdir."/upgrade.sql");

        if ($sql_upgrade->exists()) {

            function executeSQLScript($db, $fileName) {
                    $statements = file_get_contents($fileName);
                    $statements = explode(';', $statements);

                    foreach ($statements as $statement) {
                        if (trim($statement) != '') {
                            $db->query($statement);
                        }
                    }
                }

            App::uses('ConnectionManager', 'Model');
            
            $db = ConnectionManager::getDataSource('default');
            $run = executeSQLScript($db, $appdir.'upgrade.sql');        

        }

        //Delete the unzipped files

        // ------------ lixlpixel recursive PHP functions -------------
        // recursive_remove_directory( directory to delete, empty )
        // expects path to directory and optional TRUE / FALSE to empty
        // ------------------------------------------------------------
        function recursive_remove_directory($directory, $empty=FALSE)
        {
            if(substr($directory,-1) == '/')
            {
                $directory = substr($directory,0,-1);
            }
            if(!file_exists($directory) || !is_dir($directory))
            {
                return FALSE;
            }elseif(is_readable($directory))
            {
                $handle = opendir($directory);
                while (FALSE !== ($item = readdir($handle)))
                {
                    if($item != '.' && $item != '..')
                    {
                        $path = $directory.'/'.$item;
                        if(is_dir($path)) 
                        {
                            recursive_remove_directory($path);
                        }else{
                            unlink($path);
                        }
                    }
                }
                closedir($handle);
                if($empty == FALSE)
                {
                    if(!rmdir($directory))
                    {
                        return FALSE;
                    }
                }
            }
            return TRUE;
        }
        // ------------------------------------------------------------
        file_put_contents(TMP.'update', '92,Deleting update folder...');

        recursive_remove_directory($appdir, TRUE);
        rmdir($appdir);
        clearCache();
  
        //Delete .maintenance file and redirect to DashBoard
        file_put_contents(TMP.'update', '98,Unlocking panel...');

        unlink(WWW_ROOT.".maintenance");
        file_put_contents(TMP.'update', '100,Redirecting...');

        $updateFile->delete();


    }

}
