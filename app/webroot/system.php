<?php

    $system = array(

    //SYSTEM

    array(
        'name'              => 'Debug Level',
        'desc'              => 'The Debug level that SpaceBukkit should use. Should be 0 in almost all cases',
        'vars'              => array('Normal' => 0, 'Error reporting' => 1, 'Error reporting with debug and SQL stacktrace' => 2),
        'val'               => /*0*/'3'
        ), 
    array(
        'name'              => 'Use Cache',
        'desc'              => 'This setting should always be set to YES, unless there\'s issues with the caching engine.',
        'vars'              => array('Yes' => 'true', 'No' => 'false'),
        'val'               => /*1*/'true'
        ), 
    array(
        'name'              => 'Security Hash',
        'desc'              => 'A random string used in security hashing methods.',
        'vars'              => null,
        'val'               => /*2*/'Oijasfdj544dsASd44dsh9a9sdASdgjyky8455s1as8w789q'
        ), 
    array(
        'name'              => 'Security Cypher speed',
        'desc'              => 'A random numeric string (digits only) used to encrypt/decrypt strings.',
        'vars'              => null,
        'val'               => /*3*/'3196725290708910560802715405054'
        ), 
    array(
        'name'              => 'Timezone',
        'desc'              => 'For formatting help use google...',
        'vars'              => null,
        'val'               => /*4*/'Europe/Berlin'
        )

    ); 

?>