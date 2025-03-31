<?php

class Panel_Model extends Model
{
    public function __construct()
    {
        parent:: __construct();
    }

    public function isEqualPass($arr=[]){
        return $this->db->effectedRows('SELECT * FROM managers WHERE mail=:mail AND password=:password',$arr);
    }

    public function changePassword($arr=[]){
        try {
            $mail=Sesion::get('username');
            return $this->db->update('managers',$arr,"mail="."'$mail'");
        }catch (PDOException $exception){
            echo $exception->getMessage();
        }
    }

    public function getSiteSettings(){
        return  $this->db->select('SELECT * FROM settings LIMIT 1');
    }

    public function changeSiteSettings($arr=[]){
        try {
            $sql = "UPDATE settings SET urunSayisi=?,kategoriSayisi=? LIMIT 1";
            $query  =   $this->db->prepare($sql);
            $query->execute(array_values($arr));
            return $query->rowCount();

        }catch (PDOException $exception){
            echo $exception->getMessage();
            die();
        }
    }

    public function getReadSSS($arr){
        return $this->db->select('SELECT readSSS FROM managers WHERE mail=:mail',$arr);
    }

    public function setReadSSS($arr){
        $mail   =Sesion::get('username');
        return $this->db->update('managers',$arr,"mail='$mail'");
    }

    public function getProductsCount(){
        return $this->db->count('products','*');
    }

    public function getTotalPrice(){
        return $this->db->query('SELECT SUM(price) FROM products')->fetch(PDO::FETCH_ASSOC)['SUM(price)'];
    }

    /**
     *
     * @param $search string   :   bir arama parametresi bekler
     * @return string
     */
    public function filterSearch($search){
        return $this->securityFilter($search);
    }

    public function updateProduct($product){

        return $this->setUpdateProduct($product);
    }

    public function setUpdateProduct($product) {
        $product_id = $product['id'];

        $sql = "UPDATE products SET 
        title = :title,
        thumbnail = :thumbnail,
        description = :description,
        content = :content,
        price = :price,
        salePrice = :salePrice,
        catID = :catID
    WHERE id = :id";

        $query = $this->db->prepare($sql);

        $thumbnail=isset($product['thumbnail']) ? $product['thumbnail'] : SITE_URL.'/public/assets/img/product.png';
        // Parametreleri bağla
        $query->bindValue(':title', $product['product_name']);
        $query->bindValue(':thumbnail', $thumbnail);
        $query->bindValue(':description', $product['product_description']);
        $query->bindValue(':content', $product['product_content']);
        $query->bindValue(':price', $product['product_price']);
        $query->bindValue(':salePrice', $product['discount_price']);
        $query->bindValue(':catID',  $product['product_category'] ?? 1); // $product['product_category']
        $query->bindValue(':id', $product_id);

        // Sorguyu çalıştır
        $query->execute();

        return $query->rowCount();
    }

    public function getProductID($id){
        $params  =   array(
            ':id'=>$id
        );
        return $this->db->select('SELECT * FROM products WHERE id=:id',$params);
    }

    public function deleteProductID($id){
        $where  =   "id=$id";
        return $this->db->delete('products',$where);
    }

    public function setProduct($product){
        $product_name   =   $product['product_name'];
        $product_slug   =   $this->createSlug($product_name);
        $arr=array(
            'title'=>$product_name,
            'description'=>$product['product_description'],
            'price'=>$product['product_price'],
            'salePrice'=>$product['discount_price'],
            'content'=>$product['product_content'],
            'thumbnail'=>$product['thumbnail'],
            'catID'=>$product['product_category'],
            'slug'=>$product_slug
        );
//        echo "<pre>";
//        print_r($arr);
//        echo "</pre>";
        try {
            return $this->db->insert('products',$arr);
        }catch (PDOException $exception){
            return $exception->getCode();
        }

    }
/*
 id Birincil	int(10)		UNSIGNED	Hayır	Yok		AUTO_INCREMENT	Değiştir Değiştir	Kaldır Kaldır
	2	slug Index	varchar(100)	utf8_general_ci		Hayır	Yok			Değiştir Değiştir	Kaldır Kaldır
	3	title	varchar(100)	utf8_general_ci		Hayır	Yok			Değiştir Değiştir	Kaldır Kaldır
	4	description	varchar(100)	utf8_general_ci		Hayır	Yok			Değiştir Değiştir	Kaldır Kaldır
	5	price	double			Hayır	Yok			Değiştir Değiştir	Kaldır Kaldır
	6	salePrice	double			Hayır	Yok			Değiştir Değiştir	Kaldır Kaldır
	7	content	text	utf8_general_ci		Hayır	Yok			Değiştir Değiştir	Kaldır Kaldır
	8	thumbnail	varchar(100)	utf8_general_ci		Hayır	Yok			Değiştir Değiştir	Kaldır Kaldır
	9	catID
 * */

    public function createSlug($string) {
        // Türkçe karakterlerin İngilizce karşılıkları
        $turkish = array('ı', 'ğ', 'ü', 'ş', 'ö', 'ç', 'İ', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç');
        $english = array('i', 'g', 'u', 's', 'o', 'c', 'i', 'g', 'u', 's', 'o', 'c');

        // Türkçe karakterleri değiştir
        $string = str_replace($turkish, $english, $string);

        // Tüm karakterleri küçük harfe çevir
        $string = mb_strtolower($string, 'UTF-8');

        // Harf ve rakam dışındaki tüm karakterleri tire ile değiştir
        $string = preg_replace('/[^a-z0-9]/', '-', $string);

        // Birden fazla tireyi tek tireye düşür
        $string = preg_replace('/-+/', '-', $string);

        // Başta ve sondaki tireleri kaldır
        $string = trim($string, '-');

        return $string;
    }


}