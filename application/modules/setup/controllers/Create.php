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
 * Table Class
 * 
 * This Class contains function to setup database for application
 * 
 * @package         Bliz
 * @subpackage          Setup
 * @category        Database
 * @author          Tho Hoang
 * @link            https://github.com/hoangductho
 */
class Create extends CI_Controller {

    /**
     * list tables default of system
     * 
     * In list have tables name and query create table
     */
    public $tables;

    // -------------------------------------------------------------------------

    /**
     * Function Contructor
     */
    public function __construct() {
        parent::__construct();
        $this->tables = include_once $this->config->_config_paths[1] . 'config/tables.php';
//        $this->load->model('SetupModel');
        $this->load->model('Structure_Model');
        $this->load->set_layout('setup');
    }

    // -------------------------------------------------------------------------

    /**
     * Setup Table Processing
     * 
     * @todo check tables list in database and create new table if not exists
     */
    public function table() {
        $post = filter_input(INPUT_POST, 'create', FILTER_DEFAULT, FILTER_VALIDATE_INT);
        $error = null;

        if (!empty($post) && $post) {
            foreach ($this->tables as $name => $query) {
                $create = $this->Structure_Model->createCollection($name, $query['fields']);

                if (!$create['code']) {
                    $create['heading'] = "Create table $name error";
                    $error[] = $create;
                    break;
                }
            }

            if (empty($error)) {
                redirect('/setup/create/account');
            }
        }

        $data['tables'] = array_keys($this->tables);
        $data['error'] = $error;
        $this->load->render('table', $data);
    }

    // -------------------------------------------------------------------------

    /**
     * Create Admin Account
     *
     * @method Post
     *
     * @redirect Login page
     */
    public function account() {
        $this->Structure_Model->addFields('account', array());
    }

    // -------------------------------------------------------------------------

    public function regexp($string) {
        $options = array(
//            'prefix' => 'abc',
            'suffix' => '@vienvong.vn',
//            'modifier' => 'um',
            'validate_constant' => array(FILTER_VALIDATE_EMAIL, FILTER_VALIDATE_REGEXP),
            'min_length' => 4,
//            'max_length' => 9,
            'min_range' => 125
        );

        $BLFilter = new BLFilter($options);
        $filter = $BLFilter->regularString();

        if($filter['ok']) {
            var_dump($BLFilter->validate($string.'@vienvong.vn'));
        }else {
            var_dump($filter);
        }
    }
}
