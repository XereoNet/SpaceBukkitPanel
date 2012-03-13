<?php
class ServersUsers extends AppModel {
    public $name = 'ServersUsers';
    public $tablePrefix = 'space_'; 

    public $belongsTo = array(
        'Server', 'User', 'Role'
    );

}