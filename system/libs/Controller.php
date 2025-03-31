<?php

class Controller{
    protected $load =   array();
    protected $db =   array();
    protected $filter   =   array();    //filtreleme işlemleri için
    protected $per_page =   5;  // bazı fonksiyonlarda varsayılan olarak 5 atanışmıştır . getProducts
    protected $cat_show =   10;  // Anasayfada Filtreleme İçin Listelenecek Kategori Sayısı
    protected $paginationPage   =   1; // Sayfalama için varsayılan olarak 1 atanır sistem başladığında GET ile kntrol edilir
    protected $limit   =   ""; // Sayfalama için varsayılan olarak 1 atanır sistem başladığında GET ile kntrol edilir

    protected $paginationWhere  =   ""; // Sayfalama için where koşulu WHERE OLMADAN

    public function __construct()
    {

        /*
         * sistem gerekesinimleri model - view - sistem dışı (3.parti) classların controller seviyesinde kullanılması
         * */
        $this->load =   new Load();

        /*
         * Veritabanı Classının implemente edilmesi
         * */
        $this->db =   new Database();

        /*
         * Site Ayarlarını Getiriyoruz
         * */
        $settings =   $this->db->select('SELECT * FROM settings LIMIT 1');
        $this->per_page =   $settings[0]['urunSayisi'];
        $this->cat_show =   $settings[0]['kategoriSayisi'];


        /*
         * Sayfalama için Kontrol Yapılacak
         * @TODO    :   Sayfalama Kontrolü
         * */
        if (isset($_REQUEST['page'])){
            $this->paginationPage = $_REQUEST['page'];  //  Güvenkik Filtresi Yapılacak
        }
        $one_limit  =   ($this->paginationPage-1)*$this->per_page;
        $this->limit    =   $one_limit.','.$this->per_page;

    }

        /*
         * Uygulama Başladığında Ürünlerin Veritabanu İle çağırılması Controller seviyesinde
         * eğer hata olursa products boş dizi döndürür
         * amaç controllerın ürünlere erişmesi
         * */
    public function getProducts($limit=null,$filter=array(),$slug=false){  // limit değeri burda varsayılan olarak 5'tir ek olarak $per_page değişkeninden ayrı olarak çalışır
        try {

//            if ($limit==null){
                $limit  =   $this->limit;
//            }

            $sql    =   "SELECT * FROM products";

            $min_price_sql    = "SELECT MIN(price) FROM products";  //  Fiyata Göre En düşük Fiyatlı Ürün sorgusu
            $max_price_sql    = "SELECT MAX(price) FROM products";  //  Fiyata Göre En yüksek Fiyatlı Ürün sorgusu

            $min_price  =   $this->db->select($min_price_sql) ? $this->db->select($min_price_sql)[0]['MIN(price)'] : 0;
            $max_price  =   $this->db->select($max_price_sql) ? $this->db->select($max_price_sql)[0]['MAX(price)'] : 9999;


            $this->filter['price']  =   array('min'=>$min_price,'max'=>$max_price);

            /*SQL Sorgusuna min ve max değerleri atama*/
            if (isset($filter['price'])){
                $min_price  =   $filter['price']['min'];
                $max_price  =   $filter['price']['max'];

                $sql.=" WHERE (($min_price<=price AND price<=$max_price AND salePrice=0) ";  //  Normal Fiyatlarına göre
                $sql.=" OR ($min_price<=salePrice AND salePrice<=$max_price)) ";  //  İndirilmi  Fiyatlarına da göre

                $this->paginationWhere.="(($min_price<=price AND price<=$max_price AND salePrice=0)  OR ($min_price<=salePrice AND salePrice<=$max_price)) ";
            }

            /*SQL Sorgusuna kategori id değerlerini atama*/
            if (isset($filter['cats'])){
//                print_r($keys[0]);
                $cat_query  =   " AND catID IN (" . implode(',', $filter['cats']) . ")";
                $sql.=$cat_query;
                $this->paginationWhere.=$cat_query;

            }
            /*Search Dizgisine göre ürün isimlerinde arama*/
            if ( isset($filter['search'])  and isset($filter['price']) ){
                $p =   $filter['search'];
                    $sql.=" AND title LIKE '%$p%' ";
            }else if (isset($filter['search'])){
                $p =   $filter['search'];
                $sql.=" WHERE title LIKE '%$p%' ";
            }

            /*  Tekil Ürünlerde Slug Kullanılır ve direkt where sorgusu eklenir
             * */
            if ($slug){
                $sql.=  " WHERE slug='$slug'";
            }

            // limit ekleme
            $sql   .=   " LIMIT $limit";

//            echo  $sql;


            // 1. Ürünleri veritabanından çek
            $products = $this->db->select($sql);

            // 2. Kategori bilgilerini ekle
            $products = $this->addCat($products);

            // 3. Fiyat formatını uygula
            $products = $this->changePriceFormat($products);

            // 4. URL ekle
            $products = $this->addPermalink($products);

            return $products;
        }catch (PDOException $exception){
//            echo $exception->getMessage();
        }
    }

    /*
     * Kategorileri önceden ayarlanmış cat limite göre getirir
     * */
    public function getCats(){
        try {
             $sql   =   "SELECT * FROM cats LIMIT "."$this->cat_show";
             $cats  =    $this->db->select($sql);
             $new_cats  =   array();
             foreach ($cats as $cat) $new_cats[$cat['id']]=$cat;
             return $new_cats;
        }catch (PDOException $exception){
//            echo $exception->getMessage();
        }
    }

    /*  @param array  $products   :   dizi beklenir
     *  dizideki ürünlerin cat id göre veritabanındaki kategori bilgisini getirir
     *
     * */
    public function addCat($products){
        if (count($products)>0){
            foreach ($products as $key => $product){
                $cat_id =   $product['catID'];
                // Veritabanına bağlanıp kategori bilgisini alıyoruz ve parametre olarak id gönderiyoruz
                $params =   array(':id'=>$cat_id);
                $cat    =   $this->db->select('SELECT * FROM cats WHERE id=:id',$params);

                $products[$key]['cat']  =   $cat[0];
            }
            return $products;
        }else{
            return $products;
        }
    }

    /*  @param array  $products  :   dizi beklenir
     *  ürünlerdeki fiyatlara özel formatla biçimlendirir
     * */
    public function changePriceFormat($products){
        if (count($products)>0){
            foreach ($products as $key => $product){
                $salePrice =   $product['salePrice'];
                $price  =   $product['price'];

                // eğer indirimsiz ürünse indirimsiz fiyat formatlanmamalı
                if ($salePrice!=0){
                    $products[$key]['salePrice']=$this->priceFormat($salePrice)." TL";
                }

                $products[$key]['price']    =   $this->priceFormat($price)." TL";
            }
            return $products;
        }else{
            return $products;
        }
    }
    /**
     * @param $price numeric : sadece ürün tutarı
     * */
    public function priceFormat($price){
        return number_format($price,"2",",",".");
    }

    /*  @param array  $products  :   dizi beklenir
     *  ürünlerdeki slug değerini kullanarak permalink ekler
     * */
    public function addPermalink($products){
        if (count($products)>0){
            foreach ($products as $key => $product){
                $slug =   $product['slug'];

                // path değerini controllerdaki CONTROLLER - METHOD - SLUG yapısına getirilmeyi hedefler
                $products[$key]['url']   =   $this->getPermalink('urun/incele',$slug);
            }
            return $products;
        }else{
            return $products;
        }
    }

    /*  @param string $path :   permalink için aradaki CONTROLLER - MODEL yapısına uygun path
     * @param string $slug  :   ürün için id gibi davranan değerdir
     * */
    public function getPermalink($path='index',$slug){
        return SITE_URL.'/'.$path.'/'.$slug;
    }


    /*
     * 404 Sayfası İçin Direkt Yönlendirme
     * */
    public function notFound($page_slug=""){
        ob_end_clean();
        if (str_contains($page_slug,'panel')){
            header('Location: '.SITE_URL.'/panel/sayfaBulunamadi');
            exit();
        }else{
            header('Location: '.SITE_URL.'/index/sayfaBulunamadi');
            exit();
        }

    }


    /*
     * Sayfalama İçin Veritabanındaki sorguların sayısını alacam
     * 100 sorgu varsa 100 / 5 (her sayfa başına 5 diyelim) 20 sayfa demek
     *  ardından bu sayfalamayı html olarak retun edeceğim
     * */
    /**
     * @param $page_slug string :  Ana url yapısına ekleme yapar
     * @param $per_page numeric :   sayfa başın kaç kayıt gösterilecek
     * @param $table    string  :   count ile mysql deki tablo sayısı
     * @param string $where     :   koşul
     * */
    public function createPaginationLinks($page_slug,$per_page,$table,$where=""){
        $html="";



        $count  =   $this->db->count($table,'*',$where);
        $total_page =   ceil($count/$per_page) ;


        if ($this->paginationPage > $total_page){
            $this->notFound($page_slug);
            exit();
        }
        $prev_page  =   $this->paginationPage -1;
        $next_page  =   $this->paginationPage -1;



        if ($total_page>1):
            $html   =   '<nav aria-label="Page navigation example"> <ul class="pagination">'; // sayfalama başlangıcı
            //        $html   .=   "<a class='pagination-link' href='".SITE_URL."/$page_slug?page=1'> << </a>"; // İlk Sayfaya giden buton
            //        $html   .=   "<a class='pagination-link' href='".SITE_URL."/$page_slug?page=$prev_page'> < </a>"; // Hemen Bir Önceki Sayfa


            for ($pagination=1;$pagination<=$total_page;$pagination++){
                if ($pagination==$this->paginationPage){
                    $html.='<li class="page-item">';
                    $html   .=   "<a class='pagination-link active page-link' href='".SITE_URL."/$page_slug?page=$pagination'> $pagination </a>"; // Aktif Sayfa
                    $html.='</li>';
                }else{
                    $html.='<li class="page-item">';
                    $html   .=   "<a class='pagination-link page-link' href='".SITE_URL."/$page_slug?page=$pagination'> $pagination </a>"; // Diğer Sayfalar
                    $html.='</li>';
                }
            }


            //        $html   .=   "<a class='pagination-link' href='".SITE_URL."/$page_slug?page=$next_page'> > </a>"; // Bir Sonraki Sayfaya giden buton
            //        $html   .=   "<a class='pagination-link' href='".SITE_URL."/$page_slug?page=$total_page'> >> </a>"; // En Son Sayfa
            $html.="</ul></nav>";
        endif;

        return $html;
    }


}
 

