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

class Database extends CI_Controller {

    public $layout = 'setup';

    /**
     * Contruct class
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Connection database
     * 
     * @todo try connection with database by config info. If connect error, this function will show form to input new config info 
     * 
     */
    public function index() {
        $default = array();
        $post = filter_input(INPUT_POST, 'default', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        if (!empty($post)) {
            $default = $post;
        } else {
            include(APPPATH . 'config/database.php');
            $default = $db[$active_group];
        }
        try {
            ini_set('display_errors', 0);
            set_error_handler('var_dump', 0);
            $this->load->database($default);
            restore_error_handler();
            ini_set('display_errors', 1);
            if(($err = error_get_last())) {
                $data['errmsg'] = $err['message'];
                $data['db']['default'] = $default;
                $this->load->render('database', $data);
            }else {
                if(!empty($post)) {
                    $this->_rewriteDatabaseConfig($default);
                }

                redirect('/setup/create/table');
            }

        } catch (Exception $ex) {
            $data['errmsg'] = $ex->getMessage();
            $data['db']['default'] = $default;
            $this->load->render('database', $data);
        }
    }

    public static function demo() {
        echo 'Welcome to Demo page';
    }
    
    /**
     * Rewrite database config file
     * 
     * @link application/config/database.php database config file path
     * 
     * @access protected
     * 
     * @param array $database database config info
     * 
     * @return bool Result rewrite
     */
    protected function _rewriteDatabaseConfig ($database) {
        $configFile = APPPATH . 'config/database.php';
        
        include($configFile);
        $file = fopen($configFile, 'r');
        $replace = FALSE;
        $content = null;
        
        while (!feof($file)) {
            $line = fgets($file);
            
            if(strpos($line, ');') !==false && $replace) {
                $replace = FALSE;
            }
            
            if(!$replace) {
                $content .= $line;
            }else {
                $newline = $this->_replaceConfigValue($line, $database);
                $content .= $newline;
            }
            
            if(strpos($line, '$db[\''.$active_group.'\']') !==false ){
                $replace = TRUE;
            }   
        }
        fclose($file);
        
        file_put_contents($configFile, $content);
    }
    
    /**
     * Replace config value
     * 
     * @access protected
     * 
     * @param string $line line need replace
     * 
     * @param array $config list new config
     * 
     * @return string line after replace
     */
    protected function _replaceConfigValue($line, $config) {
        $current = explode('=>', $line);
        
        $index = trim(str_replace('\'', null, $current[0]));
        
        if(isset($config[$index])) {
            if($config[$index] == 'boolean_true' || $config[$index] == 'boolean_false') {
                $bool = explode('_', $config[$index]);
                $current[1] = ($bool[1]=='true'?'TRUE':'FALSE') . ',' . PHP_EOL;
            }else {
                $current[1] = '\'' . $config[trim(str_replace('\'', null, $current[0]))] . '\',' . PHP_EOL;
            }
            
            return implode('=>', $current);
        }else {
            return $line;
        }
    }
}
