<?php 
 
class Index extends Controller{
    public function __construct()
    {
        parent::__construct();
    }

    public function Anasayfa(){
        $this->load->view('Templates/header');

        echo '<section class="container my-5"> <div class="row">';
        $products    =   $this->getProducts();
        $data['products']   =   $products;

        $data['filter'] =   $this->filter;
        $data['pagination'] =   $this->createPaginationLinks('',$this->per_page,'products');

        // Filtrelemeye Kategoriyi Ekliyoruz
        $data['filter']['cats'] =   $this->getCats();
        $this->load->view('Templates/filter',$data);


        $this->load->view('products',$data);

        echo "</div></section>";

        $this->load->view('Templates/footer');
    }

    public function index(){
        $this->Anasayfa();
    }

    public function sayfaBulunamadi(){
        $this->load->view('Templates/header');
        $this->load->view('404');
        $this->load->view('Templates/footer');
    }



}
