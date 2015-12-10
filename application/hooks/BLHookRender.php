<?php

/**
 * Created by PhpStorm.
 * User: thohoang
 * Date: 12/9/15
 * Time: 1:49 PM
 */
class BLHookRender {
    public function layout() {
        $CI =& get_instance();

        $CI->output->set_output($CI->load->view($CI->layout, true));

        $CI->output->_display();
    }
}