<?php
    //Function to get strings
    function get_string_between($string, $start, $end){
        $string = " ".$string;
        $ini = strpos($string,$start);
        if ($ini == 0) return "";
        $ini += strlen($start);
        $len = strpos($string,$end,$ini) - $ini;
        return substr($string,$ini,$len);
    }
include("SpaceBukkitAPI.php");
$api = new SpaceBukkitAPI("localhost", 2011, 2012, "IDontUseTheDefaultPassPhrase;)");
        $args = array("home");   
        $output = $api->call("getWorldInformations", $args);
        $s = get_string_between($output['FormattedTime'], "", " ");
var_dump($s);
?>
