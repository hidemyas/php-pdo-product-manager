<?php 
 
class Urun extends Controller{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        header('Location: '.SITE_URL);
    }

    public function filtrele(){
        if (isset($_POST['filter']) || isset($_GET['page'])){

            $products    =   $this->getProducts();  // Ürünleri Getirerek varsayılan filtelemeyi çağıracağız
            $default_filter =   $this->filter;

            $filter =   $_POST['filter'];   //   Kullanıcıdan alınan filtreleme gelir

            $filter_model   =   $this->load->model('Urun'); //  modeldeki fonksiyonlrı kullanmak için çağırıyoruz

            /* Fiyata Göre Filtreleme */
            if (isset($filter['price'])){
                $filter['price']    =   $filter_model->filterPrice($filter['price'],$default_filter);
            }else{
                // eğer ürün price fiyatı göndermemişse kontrolünü
            }
            /* Kategoriye Göre Filtreleme */
            if (isset($filter['cats'])){
                $cats   =   $filter['cats'];
                if (count($cats)>0){
                    $filter['cats'] =   $filter_model->filterCats($cats);
                }else{
                    // kullanici kategori göndermemiş
                }
            }else{
                // eğer kategori filtrelemesi gelmemişse
            }

            /* Arama Yazısına Göre */
            if (isset($filter['search'])){
                $search   =   $filter['search'];
                if (strlen(trim($search))>0){
                    $filter['search'] =   $filter_model->filterSearch($search);
                }else{
                    unset($filter['search']);
                }
            }else{
                // eğer arama filtrelemesi gelmemişse
            }


//            print_r($filter);

            $this->load->view('Templates/header');

            echo '<section class="container my-5"> <div class="row">';
            $data['products']   =   $this->getProducts($this->per_page,$filter);


            $data['filter'] =   $this->filter;
            $this->filter=$filter;

            // Filtreye kategorileri çekelim
            $data['filter']['cats'] =   $this->getCats();

            $data['filtered'] =   $filter;
            if (isset($filter['search'])){
                $data['pagination'] =  "";
            }else{
                $data['pagination'] =   $this->createPaginationLinks('urun/filtrele',$this->per_page,'products',$this->paginationWhere);

            }

            $this->load->view('Templates/filter',$data);


            $this->load->view('products',$data);

            echo "</div></section>";

            $this->load->view('Templates/footer');





        }else{
            // kontrol işlemi
            $this->index();
        }
    }

    public function incele($param=""){
        $urun_model =   $this->load->model('Urun');
        $slug   =   $urun_model->filterParam($param);
        if (strlen($slug)>0){
            $product    =   $urun_model->searchProduct($slug);
//            echo "<pre>";
//                print_r($product);
//            echo "</pre>";
            if (count($product)>0){
                $this->load->view('Templates/header');

                echo '<section class="container my-5"> <div class="row">';
                $products    =   $this->getProducts(1,array(),$slug);  //  Filtreleme İçin
//                echo "<pre>";
//                print_r($products);
//                echo "</pre>";
                $data['product']   =   $products[0];

                $data['filter'] =   $this->filter;

                // Filtrelemeye Kategoriyi Ekliyoruz
                $data['filter']['cats'] =   $this->getCats();
                $this->load->view('Templates/filter',$data);


                $this->load->view('product',$data);

                echo "</div></section>";

                $this->load->view('Templates/footer');
            }else{
                // Ürün Bulunamadı
                // 404 Yönlendirmesi
                $this->notFound();
            }
        }else{
            // Ürün Bilgisi girilmemiş
            // @TODO    :   404 yönlendirilmesi yapılacak
            $this->notFound();
        }
    }



}
