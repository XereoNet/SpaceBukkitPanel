<?php
class ServersUsers extends AppModel {
    public $name = 'ServersUsers';

    public $belongsTo = array(
        'Server', 'User', 'Role'
    );

}