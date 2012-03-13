<?php
class Server extends AppModel {
    public $name = 'Server';
    public $tablePrefix = 'space_'; 

    public $hasMany = array(
        'ServersUsers' => array(
            'foreignKey'    => 'server_id',        	
            'dependent'     => true
        )
    );

    public $validate = array(
        'title' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A Title is required'
            )
        ),
        'address' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'An address is required'
            )
        )
    );

}