<?php

class Panel extends Controller
{
    public function __construct()
    {
        parent::__construct();

        // Oturum Kontrolü
        Sesion::checkSesion();

    }

    public function index(){
        $this->home();
    }

    public function home(){
        $read_arr=array(
            'mail'=>Sesion::get('username')
        );
        $panel_model    =   $this->load->model('Panel');
        $data['readSSS']   =   $panel_model->getReadSSS($read_arr)[0]['readSSS'];
        $data['pageInfo']['title']  =   "Kontrol Paneli";
        $this->load->view('panel/Templates/header',$data);
        $this->load->view('panel/Templates/sidebar');

        $data['productsInfo']['total_products']=$panel_model->getProductsCount();
        $data['productsInfo']['total_price']=$this->priceFormat($panel_model->getTotalPrice());
//        print_r($data['productsInfo']);
        $this->load->view('panel/home',$data);
        $this->load->view('panel/Templates/footer');
    }

    public function setReadSSS(){
        $read_arr=array(
            'readSSS'=>1,
        );
        $panel_model    =   $this->load->model('Panel');
        $set_sss   =   $panel_model->setReadSSS($read_arr);

        header('Location: '.SITE_URL.'/panel');

    }

    public function editProfile(){
        $data['profile']   =   array(
            "username"  =>  Sesion::get('username')
        );
        $data['pageInfo']['title']  =   "Hesap Yönetimi";
        $this->load->view('panel/Templates/header',$data);
        $this->load->view('panel/Templates/sidebar');
        $this->load->view('panel/editProfile',$data);
        $this->load->view('panel/Templates/footer');
    }

    public function saveProfile(){

        $mail = Sesion::get('username');
        $data['pageInfo']['title']  =   "Hesap Yönetimi";
        $data['profile']   =   array(
            "username"  =>  $mail
        );


        $form   =   $this->load->otherClasses('Form');

        $form   ->post('lastpass')
            ->isEmpty();
        $form   ->post('newpass')
            ->isEmpty();
        $form   ->post('repeatnewpass')
            ->isEmpty()
            ->isEqual('repeatnewpass','newpass');

        if ($form->submit()){
            $change_data   =   array(
                ':password' =>  md5($form->values['lastpass']),
                ':mail' =>  $mail,
            );
//            print_r($data);
            $model  =   $this->load->model('Panel');
            $result =   $model->isEqualPass($change_data);

            if ($result){
                $chenge_data    =   array(
                  "password"   => md5($form->values['newpass'])
                );
                $change_password    =   $model->changePassword($chenge_data);
//                print_r($change_password);
                if ($change_password == true) {

                    $data['alert'] = array(
                        'type' => 'info',
                        'msg' => 'Şifreniz Değiştirildi <br/><b>Yeni girişinizde yeni şifrenizi kullanmalısınız</b><br/><b>5sn içerisinde yönlendirileceksiniz</b>'
                    );

                    $this->load->view('panel/Templates/header', $data);
                    $this->load->view('panel/editProfile', $data);
                    $this->load->view('panel/Templates/footer');

                    sleep(5); Sesion::destroy();
                    echo '<script>window.location.href = "'.SITE_URL.'/admin/login";</script>';
                    exit();
                }else{
                    $data['alert']  =   array('type'=>'danger','msg'=>'İşlem Sırasında Hata Oluştu');
                }
            }else{
                 $data['formErrors']['lastpass']['equal'] = "Mevcut Şifrenizle Eşleşmiyor";
            }
        }else{

            $data['formErrors'] =   $form->errors;
//            print_r($data['formErrors']);
        }

        $this->load->view('panel/Templates/header',$data);
        $this->load->view('panel/Templates/sidebar');
        $this->load->view('panel/editProfile',$data);
        $this->load->view('panel/Templates/footer');


    }

    public function settings(){
        $panel_model=$this->load->model('Panel');
        $data['profile']   =   array(
            "username"  =>  Sesion::get('username')
        );
        $data['siteSettings']   =   $panel_model->getSiteSettings()[0];
        $data['pageInfo']['title']  =   "Ayarlar Panosu";
        $this->load->view('panel/Templates/header',$data);
        $this->load->view('panel/Templates/sidebar');
        $this->load->view('panel/settings',$data);
        $this->load->view('panel/Templates/footer');
    }

    public function editSiteSettings(){
        $panel_model=$this->load->model('Panel');

        $data['siteSettings']   =   $panel_model->getSiteSettings()[0];
        $data['pageInfo']['title']  =   "Site Ayarlarını Düzenle";
        $this->load->view('panel/Templates/header',$data);
        $this->load->view('panel/Templates/sidebar');
        $this->load->view('panel/editSiteSettings',$data);
        $this->load->view('panel/Templates/footer');
    }

    public function saveSiteSettings(){

        $data['pageInfo']['title']  =   "Site Ayarlarını Düzenle";


        $form   =   $this->load->otherClasses('Form');

        $form   ->post('urunSayisi')
            ->isEmpty();
        $form   ->post('kategoriSayisi')
            ->isEmpty();

        $data['siteSettings']=$form->values;
        if ($form->submit()){
            if ($form->values['urunSayisi']>0 and $form->values['kategoriSayisi']>0 and is_numeric($form->values['urunSayisi']) and is_numeric($form->values['kategoriSayisi']) ){
                $panel_model    =   $this->load->model('Panel');
                $change_settings    =   $panel_model->changeSiteSettings($form->values);
                if ($change_settings){
                    $data['alert']  =   array('type'=>'success','msg'=>'Site Ayarları Güncellendi !');
                }else{
                    $data['alert']  =   array('type'=>'danger','msg'=>'Kayıt Ediliren Hata Oluştu <br/> Bunun sebebi zaten kayıtlı değerleri göndermis olabilirsiniz');
                }
            }else{
                $data['alert']  =   array('type'=>'danger','msg'=>'Lütfen ilgili değerleri numerik giriniz');
            }
        }else{

            $data['formErrors'] =   $form->errors;
//            print_r($data['formErrors']);
        }

        $this->load->view('panel/Templates/header',$data);
        $this->load->view('panel/Templates/sidebar');
        $this->load->view('panel/editSiteSettings',$data);
        $this->load->view('panel/Templates/footer');


    }

    public function products(){
        ob_start();
        $filter=[];
        if (isset($_GET['search'])){
            $panel_model    =   $this->load->model('Panel');
            $filter['search'] =   $panel_model->filterSearch($_GET['search']);
        }

        $data['pageInfo']['title']  =   "Ürünler";
        $this->load->view('panel/Templates/header',$data);
        $this->load->view('panel/Templates/sidebar');

//        print_r($data['productsInfo']);
        $products    =   $this->getProducts($this->per_page,$filter);
        $data['products']   =   $products;
//        echo "<pre>";
//        print_r($products);
//        echo "</pre>";
//        die();
        if (!isset($_GET['search'])){
            $data['pagination'] =   $this->createPaginationLinks('panel/products',$this->per_page,'products',$this->paginationWhere);
        }


        $this->load->view('panel/products',$data);
        $this->load->view('panel/Templates/footer');
        ob_end_flush();
    }


    public function editProduct($param=""){
        if ($param!=""){
            $panel_model    =   $this->load->model('Panel');
            $filtered_param =   $panel_model->filterSearch($param);
//            $urun_model =   $this->load->model('Urun');
//            $product    =   $urun_model->searchProduct($filtered_param);
            $product    =   $this->getProducts($this->per_page,array(),$filtered_param);
            if (count($product)>0){
                $product=$product[0];


                $data['pageInfo']['title']  =   $product['title']." - Ürününü Düzenle";

                preg_match_all('/\d+/', str_replace(['.', ','], '', $product['price']), $numeric_price);
                preg_match_all('/\d+/', str_replace(['.', ','], '', $product['salePrice']), $numeric_sale_price);
                $product['price']=$numeric_price[0][0];
                $product['salePrice']=$numeric_sale_price[0][0] ?? 0;

                $data['product']  =   $product;
                $data['cats'] =   $this->getCats();

                $editor = $this->load->otherClasses('FroalaEditor');
                $editor->setContent($data['product']['content']);
                $data['editor']['content']  = $editor->renderInput('product_content');
                $this->load->view('panel/Templates/header',$data);
                echo $editor->loadAssets();

        $this->load->view('panel/Templates/sidebar');
                $this->load->view('panel/editProduct',$data);
                echo $editor->render();
                $this->load->view('panel/Templates/footer');

            }else{
                $this->notFound('panel');
            }


        }else{
            $this->notFound('panel');
        }
    }

    public function updateProduct(){
        $form   =   $this->load->otherClasses('Form');

        $form   ->post('id')
            ->isEmpty();
        $form   ->post('product_name')
            ->isEmpty();


        $uploadedFilePath = $form->file('product_image')->isType(['image/jpeg', 'image/png'])->uploadFile();

        if ($uploadedFilePath) {
            $form->values['thumbnail']= $uploadedFilePath;
        } else {
//            echo "Hata oluştu: ";
//            print_r($this->errors);
        }

        $form   ->post('product_description')
            ->isEmpty()
        ->length(0,100);
         $form   ->post('product_content',false)
            ->isEmpty() ;
         $form   ->post('product_category')
            ->isEmpty() ;
         $form   ->post('product_price')
            ->isEmpty() ;
         $form   ->post('discount_price');
         $form   ->post('param')->isEmpty();

//         print_r($form->errors);

//        if ($form->submit()){
        if (1==1){
        $panel_model    =   $this->load->model('Panel');
        $update_product =   $panel_model->updateProduct($form->values);
//        if ($update_product){
            if (isset($form->values['param'])){
                if ($update_product){
                    $data['alert']=['type'=>'success','msg'=>'Ürün Başarılı Şekilde Güncellendi ! '];
                }else{
                    $data['alert']=['type'=>'info','msg'=>'Ürünü güncellenemedi , Farklı değerler girerek tekrar deneyin '];
                }
                $panel_model    =   $this->load->model('Panel');
                $filtered_param =   $panel_model->filterSearch($form->values['param']);
//                $urun_model =   $this->load->model('Urun');

//                $product    =   $urun_model->searchProduct($filtered_param);
                $product    =   $this->getProducts($this->per_page,array(),$filtered_param);

                if (count($product)>0){
                    $product=$product[0];
                    preg_match_all('/\d+/', str_replace(['.', ','], '', $product['price']), $numeric_price);
                    preg_match_all('/\d+/', str_replace(['.', ','], '', $product['salePrice']), $numeric_sale_price);
                    $product['price']=$numeric_price[0][0];
                    $product['salePrice']=$numeric_sale_price[0][0] ?? 0;

                    $data['pageInfo']['title']  =   $product['title']." - Ürününü Düzenle";
                    $data['product']  =   $product;
                    $data['cats'] =   $this->getCats();

                    $editor = $this->load->otherClasses('FroalaEditor');
                    $editor->setContent($data['product']['content']);
                    $data['editor']['content']  = $editor->renderInput('product_content');
                    $this->load->view('panel/Templates/header',$data);
                    echo $editor->loadAssets();

        $this->load->view('panel/Templates/sidebar');
                    $this->load->view('panel/editProduct',$data);
                    echo $editor->render();
                    $this->load->view('panel/Templates/footer');

                }else{
                    $this->notFound('panel');
                }


            }
//        }else{
//            echo "ürün güncellenemedi.Lütfen ilgili alanları kontrol ediniz";
//        }

        }else{
            echo "From verileri alınırken hata oluştu !";
        }

    }


    public function deleteProduct($param=""){
        if ($param!=""){
            $panel_model    =   $this->load->model('Panel');
            $filtered_param =   $panel_model->filterSearch($param);
//            $urun_model =   $this->load->model('Urun');
//            $product    =   $urun_model->searchProduct($filtered_param);
            $product    =   $panel_model->getProductID($filtered_param);
            if (count($product)>0){

                // Get ile run geliyorsa silme işlemi onaylanmıştır
                if (isset($_GET['run'])){
                    $delete_work    =   $panel_model->deleteProductID($filtered_param);
                    if ($delete_work){
                        $data['alert']=array(
                            'type'=>'success',
                            'msg'=>'Aşağıdaki Ürün Artık Silindi'
                        );
                    }else{
                        $data['alert']=array(
                          'type'=>'danger',
                          'msg'=>'Silme İşleminde Sistemsel Bir Hata Oluştu'
                        );
                    }
                }

                $data['pageInfo']['title']  =   $product[0]['title']." Ürün Silme İşlemi";
                $this->load->view('panel/Templates/header',$data);
        $this->load->view('panel/Templates/sidebar');

                $data['products']   =   $product;



                $this->load->view('panel/deleteProduct',$data);
                $this->load->view('panel/Templates/footer');
                ob_end_flush();



            }else{
                $this->notFound('panel');
            }


        }else{
            $this->notFound('panel');
        }
    }

    public function addProduct(){
        $data['pageInfo']['title']  =   "Yeni Ürün Ekle";


        $data['cats'] =   $this->getCats();

        $editor = $this->load->otherClasses('FroalaEditor');
        $data['editor']['content']  = $editor->renderInput('product_content');
        $this->load->view('panel/Templates/header',$data);
        echo $editor->loadAssets();

        $this->load->view('panel/Templates/sidebar');
        $this->load->view('panel/addProduct',$data);
        echo $editor->render();
        $this->load->view('panel/Templates/footer');
    }

    public function setProduct(){
        $form   =   $this->load->otherClasses('Form');

        $form   ->post('product_name')
            ->isEmpty();


        $uploadedFilePath = $form->file('product_image')->isType(['image/jpeg', 'image/png'])->uploadFile();

        if ($uploadedFilePath) {
            $form->values['thumbnail']= $uploadedFilePath;
        } else {

        }

        $form   ->post('product_description')
            ->isEmpty()
            ->length(0,100);
        $form   ->post('product_content',false)
            ->isEmpty() ;
        $form   ->post('product_category')
            ->isEmpty() ;
        $form   ->post('product_price')
            ->isEmpty() ;
        $form   ->post('discount_price');

        $data['form']=$form->values;
        if (!$form->submit()):
//            echo "<pre>";
//
//            print_r($form->values);
//            print_r($form->errors);
//            echo "</pre>";
            $data['alert']=array(
                'type'=>'warning',
                'msg'=>'Lütfen Ürün Ekleme Formunu Tekrar Gözden Geçiriniz'
            );
            $data['errors']=$form->errors;

        else:

            $panel_model    =   $this->load->model('Panel');
            $add_product    =   $panel_model->setProduct($data['form']);

            if ($add_product==1){
                $data['alert']=array(
                    'type'=>'success',
                    'msg'=>'Ürün Başarılı Şekilde Eklendi !'
                );
            }else if ($add_product==23000){ // 23000 : duplicate aynı isimli ürün
                $data['alert']=array(
                    'type'=>'danger',
                    'msg'=>'Ürün Eklenmedi ! <br/>Bu ürün Daha Önceden eklenmiş. <b>Ürün İsmini Değiştirerek Devam Ediniz</b>'
                );
            }else{
                $data['alert']=array(
                    'type'=>'danger',
                    'msg'=>'Ürün Eklenirken Sistemsel Hata Oluştu !'
                );
            }
        endif;

        $data['pageInfo']['title']  =   "Yeni Ürün Ekle";


        $data['cats'] =   $this->getCats();

        $editor = $this->load->otherClasses('FroalaEditor');

        if ($data['form']['product_content']){
            $editor->setContent($data['form']['product_content']);
        }

        $data['editor']['content']  = $editor->renderInput('product_content');
        $this->load->view('panel/Templates/header',$data);
        echo $editor->loadAssets();

        $this->load->view('panel/Templates/sidebar');
        $this->load->view('panel/addProduct',$data);
        echo $editor->render();
        $this->load->view('panel/Templates/footer');
    }

    public function sss(){

            $data['pageInfo']['title']  =   "Yardım Merkezi";



            $this->load->view('panel/Templates/header',$data);

        $this->load->view('panel/Templates/sidebar');
            $this->load->view('panel/sss',$data);
             $this->load->view('panel/Templates/footer');

    }


    public function sayfaBulunamadi(){
        $data['pageInfo']['title']  =   "Sayfa Bulunamadı";
        $this->load->view('panel/Templates/header',$data);
        $this->load->view('panel/404');
        $this->load->view('panel/Templates/footer');
    }

}