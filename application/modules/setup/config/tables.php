<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$mysql['Account'] = 
        'CREATE TABLE IF NOT EXISTS Account ('
        . 'id INT NOT NULL,'
        . 'email varchar(32) NOT NULL,'
        . 'password varchar(64) NOT NULL,'
        . 'time TIMESTAMP NOT NULL DEFAULT NOW(),'
        . 'PRIMARY KEY (id)'
        . ');';

$mysql['Profile'] = 
        'CREATE TABLE IF NOT EXISTS Profile ('
        . 'aid INT NOT NULL,'
        . 'fullname  varchar(64) NOT NULL,'
        . 'birthday DATE NOT NULL,'
        . 'address TINYTEXT,'
        . 'avartar TINYTEXT,'
        . 'time TIMESTAMP NOT NULL DEFAULT NOW(),'
        . 'PRIMARY KEY (aid),'
        . 'FOREIGN KEY (aid) REFERENCES Account(id)'
        . ');';

$mysql['Picture'] = 
        'CREATE TABLE IF NOT EXISTS Picture ('
        . 'id INT NOT NULL AUTO_INCREMENT,'
        . 'data MEDIUMTEXT NOT NULL,'
        . 'aid INT NOT NULL,'
        . 'time TIMESTAMP NOT NULL DEFAULT NOW(),'
        . 'PRIMARY KEY (id),'
        . 'FOREIGN KEY (aid) REFERENCES Account(id)'
        . ');';

$mysql['Role'] = 
        'CREATE TABLE IF NOT EXISTS Role ('
        . 'id INT NOT NULL AUTO_INCREMENT,'
        . 'name varchar(16) NOT NULL,'
        . 'description TINYTEXT,'
        . 'time TIMESTAMP NOT NULL DEFAULT NOW(),'
        . 'PRIMARY KEY (id)'
        . ');';

$mysql['RoleAccount'] = 
        'CREATE TABLE IF NOT EXISTS RoleAccount ('
        . 'rid INT NOT NULL,'
        . 'aid INT NOT NULL,'
        . 'PRIMARY KEY (rid, aid),'
        . 'FOREIGN KEY (aid) REFERENCES Account(id),'
        . 'FOREIGN KEY (rid) REFERENCES Role(id)'
        . ');';

$mongo = array(
    'account' => array(),
    'sesssion' => array(),
    'log' => array(),
    'data' => array(),
    'data_structure' => array(),
    'data_record' => array(),
    'data_collection' => array(),
    'data' => array());

return $mongo;