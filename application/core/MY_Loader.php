<?php
(defined('BASEPATH')) or exit('No direct script access allowed');

/* load the HMVC_Loader class */
require APPPATH . 'third_party/HMVC/Loader.php';

class MY_Loader extends HMVC_Loader {
    /**
     * Instant Controller Pointer
     *
     * set a pointer to instant controller using get_instant()
     */
    protected $CI;

    /**
     * Layout name
     */
    protected $layout = '';

    /**
     * Layout data
     */
    protected $layout_data = array();

    // --------------------------------------------------------------------

    /**
     * Constructor
     *
     * Setup value for Properties
     */
    public function __construct() {
        parent::__construct();

        $this->CI = & get_instance();

        if(!empty($this->CI->layout)){
            $this->layout = $this->CI->layout;
        }

        if(!empty($this->CI->layout_data)) {
            $this->layout_data = $this->CI->layout_data;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Set Layout
     *
     * @param string $layout name of layout
     *
     * @return $this;
     */
    public function set_layout($layout) {
        $this->layout = $layout;
        return $this;
    }

    // --------------------------------------------------------------------

    /**
     * Get Layout
     *
     * @return string layout name
     */
    public function get_layout_name() {
        return $this->layout;
    }

    // --------------------------------------------------------------------

    /**
     * Set Data Push Into Layout
     *
     *
     */
    public function set_layout_data($data) {
        $this->layout_data = array_merge($this->layout_data, $data);
        return $this;
    }

    // --------------------------------------------------------------------

    /**
     * Get Data Pushed Into Layout
     *
     * @return array
     */
    public function get_layout_data() {
        return $this->layout_data;
    }

    // --------------------------------------------------------------------

    /**
     * Get layout directory path
     *
     * Layout directory contain all of layout file
     *
     * @param string layout name
     *
     * @return string Layout directory path
     */
    private function _layoutPath($layout) {
        $layoutPath = 'layouts' . DIRECTORY_SEPARATOR . $layout;
        return $layoutPath;
    }

    // --------------------------------------------------------------------

    /**
     * Render View
     *
     * @todo Render View And Include Into The template layout
     *
     * @param string $view - name or path of view
     * @param array $data - data push into view
     * @param bool $return - if true: get result to string; Else: express instant
     *
     * @return string (if $return true)
     */
    public function render($view, $data = array(), $return = FALSE) {
        if(!empty($this->get_layout_name())) {
            $input['ViewContentHTML'] = $this->CI->load->view($view, $data, TRUE);
            $this->set_layout_data($input);
            return $this->CI->load->view($this->_layoutPath($this->layout), $this->layout_data, $return);
        }else {
            return $this->CI->load->view($view, $data, $return);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Render View Sector
     *
     * @todo Render View And Include Into The template layout don't use My_Loader's Properties
     *
     * @param string $view - name or path of view
     * @param array $data - data push into view
     * @param string $layout - using another layout
     * @param array $input - data push into layout
     * @param bool $return - if true: get result to string; Else: express instant
     *
     * @return string (if $return true)
     */
    public function renderSector($view, $data = array(), $layout = '', $input = array(), $return = false) {
        if(!empty($layout)) {
            $input['ViewContentHTML'] = $this->CI->load->view($view, $data, TRUE);
            return $this->CI->load->view($this->_layoutPath($layout), $input, $return);
        }else {
            return $this->CI->load->view($view, $data, $return);
        }
    }

    // --------------------------------------------------------------------

}