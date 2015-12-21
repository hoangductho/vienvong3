<?php

/**
 * Bliz 
 * An Opensource System Development from CI3
 * 
 * Copyright (c) 2015, Hoang Duc Tho
 * 
 * @copyright (c) 2015, Hoang Duc Tho (hoangductho.3690@gmail.com)
 * 
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * DBCreate Class
 * 
 * This Class contains function to setup database for application
 * 
 * @package         Bliz
 * @subpackage          Setup
 * @category        Database
 * @author          Tho Hoang
 * @link            https://github.com/hoangductho
 */
class SetupModel extends CI_Model {

    /**
     * Class Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Create Tables
     * 
     * @param query create table
     * 
     * @return bool insert result
     */
    public function createTable($query) {
        $this->db->simple_query($query);
        return $this->db->error();
    }

    /**
     * Mongo Create Collection
     *
     * @param string    $collection     name of collection
     * @param array     $config         config info
     *
     * @return Object
     */
    public function createCollection($collection, $config = array()) {
        $create = $this->db->db->createCollection($collection, $config);
        var_dump($create);
        $result['code'] = !$create->w;
        $result['Object'] = $create;

        return $result;
    }

    /**
     * Insert Data Into Table
     *
     * @param string $table table will be insert
     * @param array $data data will be inputed
     *
     * @return array result insert
     */
    public function InsertData($table, $data) {
        $this->db->insert($table, $data);
    }
}
