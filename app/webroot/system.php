<?php

    $system = array(

    //SYSTEM

    array(
        'name'              => 'Debug Level',
        'desc'              => 'The Debug level that SpaceBukkit should use. Should be set to "Normal" in almost all cases',
        'vars'              => array('Normal' => 0, 'Error reporting' => 1, 'Error reporting with debug and SQL stacktrace' => 2),
        'val'               => /*0*/'2'
        ), 
    array(
        'name'              => 'Use Cache',
        'desc'              => 'This setting should always be set to YES, unless there\'s issues with the caching engine.',
        'vars'              => array('Yes' => 'true', 'No' => 'false'),
        'val'               => /*1*/'true'
        ), 
    array(
        'name'              => 'Timezone',
        'desc'              => 'Manually edit this, pay attention to correct formatting',
        'vars'              => null,
        'val'               => /*2*/'Europe/Berlin'
        )

    ); 

?>