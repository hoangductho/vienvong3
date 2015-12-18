<?php

/**
 * User: thohoang
 * Date: 12/18/15
 * Time: 3:50 PM
 *
 * @Class Structure_Model
 *
 * @Description Class contains functions to interactive with structure table
 *
 * @Property
 *      - $table: string - name of table
 */
class Structure_Model extends CI_Model {
    /**
     * table name
     */
    protected $table = 'structure';
    // ------------------------------------------------------------
    /**
     * Constructor
     *
     * @todo init environment and variables for class
     */
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    // ------------------------------------------------------------
    /**
     * Create Table
     *
     * @todo create table and save this structure into structure table
     *
     * @param string $table name of table
     * @param array $fields list fields and data structure of that
     * @exam $fields = array(
     *          'field_name' => array(
     *              'validate_type' => FILTER_VALIDATE_INT,
     *              'options' => array(
     *                  'max_rate' => 1000,
     *                  'min_rate' => 10,
     *                  'regexp' => '/^(7).(2)$/',
     *              ),
     *              'status' => 'system | enable | disable'
     *          )
     *      );
     * @param array $config config of table created
     *
     * @return array result create
     */
    public function createTable($table, $fields, $config = array()) {
        $create = $this->db->db->createCollection($table, $config);
        $result['code'] = !$create->w;
        $result['Object'] = $create;

        if($result['code']) {
            foreach($fields as $field => $options) {
                $structure['table'] = $table;
                $structure['field'] = $field;
                $structure['validate_type'] = (isset($options['validate_type'])?$options['validate_type']:null);
                $structure['options'] = (isset($options['options'])?json_encode($options['validate_type']):null);
                $structure['status'] = (isset($options['status'])?$options['status']:'enable');
            }
        }

        return $result;
    }
    // ------------------------------------------------------------
}
// End of Class