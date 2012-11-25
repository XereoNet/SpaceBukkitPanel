<?php

    /*  SpaceBukkit Configuration  */

    $variables = array(

    array(
        'name'              => 'Console refresh time',
        'desc'              => 'The amount of time SpaceBukkit waits before refreshing the console when it\'s opened.',
        'vars'              => null,
        'val'               => /*0*/'1000'
        ),
    array(
        'name'              => 'Console lines to load',
        'desc'              => 'The amount of lines of console that should be loaded',
        'vars'              => null,
        'val'               => /*1*/'100'
        ),
    array(
        'name'              => 'Chat refresh time',
        'desc'              => 'The amount of time SpaceBukkit waits before refreshing the chat when it\'s opened.',
        'vars'              => null,
        'val'               => /*2*/'1000'
        ),
    array(
        'name'              => 'Chat lines to load',
        'desc'              => 'The amount of lines of chat that should be loaded',
        'vars'              => null,
        'val'               => /*3*/'100'
        ),
    array(
        'name'              => 'Dashboard Stats refresh time',
        'desc'              => 'The amount of time SpaceBukkit waits before refreshing the dashboard statistics.',
        'vars'              => null,
        'val'               => /*4*/'2000'
        ),
    array(
        'name'              => 'Dashboard Graphs refresh time',
        'desc'              => 'The amount of time SpaceBukkit waits before refreshing the dashboard statistics.',
        'vars'              => null,
        'val'               => /*5*/'1000'
        ),
    array(
        'name'              => 'Admin online refresh time',
        'desc'              => 'The amount of time SpaceBukkit waits before refreshing the dashboard "admins online" section.',
        'vars'              => null,
        'val'               => /*6*/'10000'
        ),
    array(
        'name'              => 'Players check time',
        'desc'              => 'The amount of time SpaceBukkit waits before checking if someone has joined the server recently. If yes, the player list get\'s reloaded',
        'vars'              => null,
        'val'               => /*7*/'5000'
        ),
    array(
        'name'              => 'Backup progress check time',
        'desc'              => 'The amount of time SpaceBukkit waits before rechecking the current backup status',
        'vars'              => null,
        'val'               => /*8*/'750'
        ),
    array(
        'name'              => 'Previous/Scheduled backups reload time',
        'desc'              => 'The amount of time SpaceBukkit waits before reloading the previous and scheduled backups',
        'vars'              => null,
        'val'               => /*9*/'10000'
        ),
    array(
        'name'              => 'Server notifications name',
        'desc'              => 'The name used for server notifications',
        'vars'              => null,
        'val'               => /*10*/'SpaceBukkit'
        ),
    array(
        'name'              => 'Kill Notification',
        'desc'              => 'The message for killing somebody',
        'vars'              => null,
        'val'               => /*11*/'{player} was killed from orbit!'
        ),
    array(
        'name'              => 'Heal Notification',
        'desc'              => 'The message for healing somebody',
        'vars'              => null,
        'val'               => /*12*/'{player} was magically healed from space!'
        ),
    array(
        'name'              => 'Feed Notification',
        'desc'              => 'The message for feeding somebody',
        'vars'              => null,
        'val'               => /*13*/'{player} ate some delicious MoonCheese (tm)!'
        ),
    array(
        'name'              => 'Kick Notification',
        'desc'              => 'The message for kicking somebody',
        'vars'              => null,
        'val'               => /*14*/'{player} has been kicked. Spacey!'
        ),
    array(
        'name'              => 'Ban Notification',
        'desc'              => 'The message for banning somebody',
        'vars'              => null,
        'val'               => /*15*/'{player} has been banned. SpaceBukkit is gonna miss him :('
        ),
    array(
        'name'              => 'Panel Notifications',
        'desc'              => 'Who should see panel notifications (like updates or messages from the team)',
        'vars'              => array('Everybody' => "e", 'Superusers' => "s"),
        'val'               => /*16*/'s'
        ),
    array(
        'name'              => 'Dashboard image',
        'desc'              => 'Should the dashboard display a gradient, images or a live dynmap view?',
        'vars'              => array('Gradient' => "g", 'Images' => "i", 'Dynmap' => "d"),
        'val'               => /*17*/'i'
        )
    );


?>