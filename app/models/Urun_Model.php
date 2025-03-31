<?php 
 

class Urun_Model extends Model {
    public function __construct()
    {
        parent::__construct();
//        echo "Model Dosyası";
    }

    public function filterPrice($price_data,$default_filter){
        $default_filter =   $default_filter['price'];

        if (isset($price_data['minPrice'])){
            $min    =   $this->securityFilter($price_data['minPrice'],'numeric');
            $min_msg="";
            if ($min<$default_filter['min']){
                $min=$default_filter['min'];
                $min_msg="Minumum fiyat ".$default_filter['min']." 'dan küçük olamaz";
            }
        }else{
            $min    =   0;
        }


        if (isset($price_data['maxPrice'])){
            $max    =   $this->securityFilter($price_data['maxPrice'],'numeric');
            $max_msg="";
            if ($max>$default_filter['max']){
                $max=$default_filter['max'];
                $max_msg="Maksimum fiyat ".$default_filter['max']." 'dan büyük olamaz";
            }
        }else{
            $max    =   0;
        }

        return array(
            'min'=>$min,
            'max'=>$max,
            'min_msg'=>$min_msg,
            'max_msg'=>$max_msg
        );

    }

    /**
     * @param $cats array   :   bir kategori dizisi bekler
     * @return array
     */
    public function filterCats($cats){
        $new_cats   =   array();
//        foreach ($cats as $cat) array_push($new_cats,$this->securityFilter($cat,'numeric'));
        foreach ($cats as $cat) {
            $cat_id =   $this->securityFilter($cat,'numeric');
            $new_cats[$cat_id]  =  $cat;
        };
        return $new_cats;
    }


    /**
     *
     * @param $search string   :   bir arama parametresi bekler
     * @return string
     */
    public function filterSearch($search){
        return $this->securityFilter($search);
    }


    /**
     *
     * @param $param string   :   ürün için slug
     * @return string
     */
    public function filterParam($param){
        return $this->securityFilter($param);
    }


    /**
     *
     * @param $param string   :   slug eşleşmesi yaparak ürün döndürür
     * @return array
     */
    public function searchProduct($param){
        $param_arr  =array(
            "slug"=>$param
        );
        return $this->db->select('SELECT * FROM products WHERE slug=:slug LIMIT 1',$param_arr);
    }




}