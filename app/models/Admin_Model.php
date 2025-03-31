<?php 
 

class Admin_Model extends Model {
    public function __construct()
    {
        parent::__construct();
//        echo "Model Dosyası";
    }

    public function userControl($arr    =   array()){
        $sql    =   "SELECT * FROM managers WHERE mail=:mail AND password=:password";
        $query_count    =   $this->db->effectedRows($sql,$arr);
        if ($query_count>0){
            return $this->db->select($sql,$arr);
        }else{
            return false;
        }
    }


}