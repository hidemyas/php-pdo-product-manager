<?php 
 

class Load{
    public function __construct()
    {

    }

    public function view($filename,$data=null){
        require_once "app/views/".$filename."_view.php";
    }

    public function model($filename){
        require_once "app/models/".$filename."_Model.php";
        $method_name    =   $filename."_Model";
        return new $method_name();
    }

    public function otherClasses($file_name){
        require_once "app/classes/".$file_name.".php";
        return  new $file_name();
    }

}