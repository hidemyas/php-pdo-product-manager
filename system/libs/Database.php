<?php 
 

class Database extends PDO {
    public function __construct($dsn=null, $username = null, $password = null, $options = null)
    {
        $dsn        =  "mysql:dbname=".DB_NAME.";host=".DB_HOST.";charset=UTF8";
        $username   =  DB_USERNAME;
        $password   =   DB_PASSWORD;
        parent::__construct($dsn, $username, $password, $options);

//        $stn    =   $this->prepare('SELECT * FROM esyalar');
//        $stn->execute();
//        $stn->fetchAll(PDO::FETCH_ASSOC);
//        print_r($stn);

    }

    public function select($sql,$arr=array(),$mode=PDO::FETCH_ASSOC){
        $query  =   $this->prepare($sql);

        foreach ($arr as $key => $val){
            $query->bindValue("$key","$val");
        }

        $query->execute();
        return $query->fetchAll($mode);
    }

    public function effectedRows($sql,$arr=array()){
        $query  =   $this->prepare($sql);

        foreach ($arr as $key => $val){
            $query->bindValue("$key","$val");
        }

        $query->execute();
        return $query->rowCount();

    }

    public function Filter($item){
        $step_one   =   trim($item);
        $step_two   =   strip_tags($step_one);
        $step_trhee =   htmlspecialchars($step_two,ENT_QUOTES);
        return $step_trhee;
    }

    public function insert($table_name,$data=array()){


        $fieldKeys  =   implode(",",array_keys($data));
//        echo $fieldKeys."<br/>";

        $fieldValues    =   ":".implode(', :',array_keys($data));
//        echo $fieldValues;


        $sql    =   "INSERT INTO $table_name ($fieldKeys) VALUES ($fieldValues)";
        $query  =   $this->prepare($sql);

        foreach ($data as $key => $val){
            $query->bindValue(":$key",$val);
        }

        $query->execute();

        $row_count  =   $query->rowCount();
        return $row_count;
    }

    public function update($table_name,$data,$where){

        $updateKeys="";
        foreach ($data as $key => $val){
            $updateKeys.="$key=:$key,";
        }

        $updateKeys =   rtrim($updateKeys,',');


        $sql    =   "UPDATE $table_name SET $updateKeys WHERE $where";
        $query  =   $this->prepare($sql);

        foreach ($data as $key=>$val){
            $query->bindParam(":$key",$val);
        }

//        echo $sql;
        $query->execute();
        return  $query->rowCount();

    }

    public function delete($table_name,$where,$limit=1){
        $sql    =   "DELETE FROM $table_name WHERE $where LIMIT $limit";
        $query  =   $this->prepare($sql);
        $query->execute();
        return $query->rowCount();
    }

    public function count($table_name,$select="*",$where=""){
        $sql = "SELECT COUNT($select) FROM `$table_name`";
        if (strlen($where)>0){
            $sql.=" WHERE $where";
        }
        $query  =   $this->prepare($sql);
        $query->execute();
        return $query->fetchColumn();
    }




}