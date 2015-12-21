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

        if($this->db->dbdriver == 'mongo') {
            $this->_initStructure();
        }else {
            show_error('Structure_Model Class supports only Mongo Driver');
        }
    }
    // ------------------------------------------------------------
    /**
     * Create Structure Table
     *
     * @todo create structure table when it not existed
     */
    private function _initStructure() {
        if(!$this->db->table_exists($this->table)) {
            $structure = $this->db->db->createCollection($this->table);
            if(!$structure->w) {
                show_error('Create "structure" table error.');
            }
        }
        return true;
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
    public function createCollection($table, $fields, $config = array()) {
        $result['code'] = 1;
        $result['Object'] = array();

        if(!$this->db->table_exists($table)) {
            $create = $this->db->db->createCollection($table, $config);
            $result['code'] = $create->w;
            $result['Object'] = $create;
            $batch = 0;
            if($result['code'] && !empty($fields)) {
                if(is_string($fields)) {
                    $list_fields = explode(',', $fields);
                    $fields = array();
                    foreach($list_fields as $field) {
                        $fields[trim($field)] = array();
                    }
                }

                foreach($fields as $field => $options) {
                    $structure[$batch]['table'] = $table;
                    $structure[$batch]['field'] = ($field != 'id')?$field:'_id';
                    $structure[$batch]['validate_type'] = (isset($options['validate_type'])?$options['validate_type']:null);
                    $structure[$batch]['default_value'] = (isset($options['default_value'])?$options['default_value']:null);
                    $structure[$batch]['options'] = (isset($options['options'])?json_encode($options['options']):null);
                    $structure[$batch]['status'] = (isset($options['status'])?$options['status']:'enable');

                    if($field == '__mixed__') {
                        $structure[$batch]['status'] = 'system';
                        $structure[$batch]['default_value'] = TRUE;
                    }

                    $batch +=1;
                }

                $result['structure'] = $this->db->insert_batch($this->table, $structure);
            }
        }

        return $result;
    }
    // ------------------------------------------------------------
    /**
     * Add New Fields Into Table
     *
     * @todo if table have __mixed__ field with value 'TRUE', new fields will be added in table
     *
     * @param string $table name of table
     * @param array $fields list fields needed add and options of them
     *
     * @return array
     */
    public function addFields($table, $fields) {
        if($this->db->table_exists($table)) {
            $mixed = $this->db->select('default_value')->from($this->table)->where(array('table' => $table, 'field' => '__mixed__'))->get();
            var_dump($mixed); die();
        }
    }
    // ------------------------------------------------------------
}
// End of Class