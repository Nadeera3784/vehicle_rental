<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config_manager {

    public  $config = [];
    public  $ci;
    
    public function __construct(){
        $this->ci = &get_instance();
        $this->get_config();
    }

    public function get_config(){
        $this->ci->db->select('conf_id, IFNULL(conf_key, false) AS conf_key, IFNULL(conf_value,false) AS conf_value');
        $this->ci->db->from('configuration');
        $query = $this->ci->db->get();
        $config = $query->result_array();
        foreach ($config as $c) {
            if($c['conf_key']){
                if($c['conf_value']){
                    $this->config[trim($c['conf_key'])] = trim($c['conf_value']);
                }else{
                    $this->config[trim($c['conf_key'])] = false;
                }
            }
        }

    }

}