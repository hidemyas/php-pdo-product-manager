<?php

class Admin extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $this->login();
    }

    public function login($status=false){
        Sesion::init();
        if (Sesion::get('login')){
            // eğer giriş yapmışsa
//            Sesion::destroy();// yönlendirme
            header('Location: '.SITE_URL.'/panel');
            exit();
        }else{
            $data=[];
            if ($status){
                $data['status']='Hatalı Giriş Yaptınız';
            }
            $this->load->view('admin/loginForm',$data);
        }
    }

    public function runLogin(){
        $username   =   $_POST['signin-email'] ?? '';
        $password   =   md5($_POST['signin-password'] ?? '' );
        $data   =   array(
            ":mail"=>$username,
            ":password"=>$password
        );
        // db işlemleri
        $admin_model    =   $this->load->model('admin');
        $result  =   $admin_model->userControl($data);

//        echo $result;
        if ($result==false){
            // yanlış giriş
//            print_r($result);
            // yönlendirme
            $this->login(true);
        }else{
            //         sesion işlemleri
            Sesion::init();
            Sesion::set("login",true);
            Sesion::set("username",$result[0]['mail']);
            Sesion::set("userID",$result[0]['id']);
//            echo "success";
            // yönlendirme
            header('Location: '.SITE_URL.'/panel/home');
            exit();
        }



    }

    public function logout(){
        Sesion::init();
        Sesion::destroy();
        // çıkış yönlendirmesi
        header('Location: '.SITE_URL."/admin/login");
        exit();
    }

}