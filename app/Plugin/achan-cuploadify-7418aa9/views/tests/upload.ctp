<?php
echo $this->element("uploadify", array(
    "plugin" => "cuploadify",
    "dom_id" => "file_upload",
    "session_id" => $this->Session->id(),
    "include_scripts" => 
            array("jquery"=>"/cuploadify/js/jquery.js", "swfobject", "uploadify", "uploadify_css"),
    "options" => array("script" => "/cuploadify/tests/upload",
                       "folder" => "/files", 
                       "buttonText" => "ADD FILE", 
                       "auto" => true, 
                       "multi" => true,
	))
);
