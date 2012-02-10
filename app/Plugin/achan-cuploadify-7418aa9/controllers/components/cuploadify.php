<?php
/**
 * The Cuploadify Component class.
 * This script will take care of uploading the files specified by the uploadify DOM element.
 * If a session_id was specified in the uplaodified element, this component will also be responsible
 * for switching over to said session.
 *
 * @copyright Copyright 2011, AM05, inc. (http://am05.com)
 * @author Amos Chan <amos.chan@chapps.org>
 * @since Cuploadify v 1.0
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class CuploadifyComponent extends Object {
    /**
     * The instantiating controller.
     *
     * @var boolean
     * @access public
     */
    var $controller;

    /**
     * Switches the session to the session_id specified from request.
     *
     * @param object $controller Instantiating controller
     * @param array $settings Configuration settings
     * @return void
     */
    function initialize(&$controller, $settings=array()) {
        $this->controller = $controller;
        CakeLog::write("debug", "initializing cuploadify component..."); 
        if (isset($_REQUEST["session_id"])) {
            CakeLog::write("debug", "session found.."); 
            $session_id = $_REQUEST["session_id"];
            $this->controller->Session->id($session_id);
            CakeLog::write("debug", "session switched: $session_id"); 
        }
    }

    /**
     * Uploads data specified by the uploadify DOM element.
     *
     * @param array $options Associative array of options.
     */
    function upload($options = array()) {
        if (!empty($_FILES)) { 
            $file_data = isset($_REQUEST["fileDataName"]) ? $_REQUEST["fileDataName"] : "Filedata";
            $temp_file = $_FILES[$file_data]['tmp_name'];
            
            $target_path = $this->get_target_folder($options);

            if (!file_exists($target_path)) {
                CakeLog::write("debug", "Creating directory: $target_path");
                $old = umask(0);
                mkdir($target_path, 0777, true); 
                umask($old);
            }

            $target_file =  str_replace('//','/',$target_path) . $_FILES[$file_data]['name'];

            // $fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
            // $fileTypes  = str_replace(';','|',$fileTypes);
            // $typesArray = split('\|',$fileTypes);
            // $fileParts  = pathinfo($_FILES[$file_data]['name']);
            
            // if (in_array($fileParts['extension'],$typesArray)) {
                // Uncomment the following line if you want to make the directory if it doesn't exist
                // mkdir(str_replace('//','/',$target_path), 0755, true);
                
                move_uploaded_file($temp_file,$target_file);
                //echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$target_file);
            // } else {
            //  echo 'Invalid file type.';
            // }
        }
    }

    function get_target_folder($options=array()) {
        $doc_root = $this->get_doc_root($options);
        return $doc_root . $_REQUEST["folder"] . '/';
    }

    function get_doc_root($options=array()) {
        $doc_root = $this->remove_trailing_slash(env('DOCUMENT_ROOT'));
        if (isset($options["root"]) && strlen(trim($options["root"])) > 0) {
            $root = $this->remove_trailing_slash($options["root"]);
            $doc_root .=  $root;
        }

        return $doc_root;
    }

    function get_filename() {
        $file_data = isset($_REQUEST["fileDataName"]) ? $_REQUEST["fileDataName"] : "Filedata";
        return $_FILES[$file_data]['name'];
    }

    /**
     * Removes the trailing slash from the string specified.
     * @param $string the string to remove the trailing slash from.
     */
    function remove_trailing_slash($string) {
        $string_length = strlen($string);
        if (strrpos($string, "/") === $string_length - 1) {
            $string = substr($string, 0, $string_length - 1);
        }

        return $string;
    }
}
