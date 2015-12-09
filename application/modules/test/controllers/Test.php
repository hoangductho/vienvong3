<?php
/**
 * Created by PhpStorm.
 * User: thohoang
 * Date: 12/9/15
 * Time: 1:43 PM
 */
date_default_timezone_set('UTC');
class Test extends CI_Controller {
    public $layout = 'default';
    public $layout_data = array();

    public function index() {
        $this->load->set_layout_data(array('time' => date('Y-m-d H:i:s')));
        $this->load->render('reder');
    }
}