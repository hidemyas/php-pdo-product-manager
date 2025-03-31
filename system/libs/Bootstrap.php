<?php
class Bootstrap
{
    public $_url;
    public $_controller = "index";
    public $_method = "index";
    public $_controller_path = "app/controllers/";
    public $_active_controller;

    public function __construct()
    {

        $this->getUrl();


        $this->loadController();
        $this->callMethod();


    }

    public function getUrl()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : null;

        if ($url != null) {
            $url = rtrim($url, '/');
            $url = explode('/', $url);
            $this->_url=$url;
//            print_r($url);
        } else {
            unset($url);
            $this->_url=null;
        }
    }


    public function loadController()
    {
        if (!isset($this->_url[0])) {

            require_once $this->_controller_path . $this->_controller . ".php";

            $this->_active_controller = new $this->_controller();
//            $method_name = $this->_method;
//            $this->_active_controller->$method_name();

        }else{
            $this->_controller = $this->_url[0];
//            echo $this->_controller;
            $filename = $this->_controller_path . $this->_url[0] . ".php";
            if (file_exists($filename)) {
//                echo $filename;
                require_once $filename;
                if (class_exists($this->_controller)) {
//                    echo "run";
                    $this->_active_controller = new $this->_controller();
                } else {
                    //
                }
            } else {
                //
            }
        }



    }

    public function callMethod()
    {
        $url = $this->_url;
        $method_name = $this->_method;
//        echo $method_name;
        if (isset($url[2])) {
            $this->_method = $url[1];
            $method_name = $this->_method;
            if (method_exists($this->_active_controller, $method_name)) {
                $this->_active_controller->$method_name($url[2]);
            } else {
                echo "Controller Methodu Bulunamadı";
            }

//            echo $method_name;
        } else {
            if (isset($url[1])) {
                $this->_method = $url[1];
                $method_name = $this->_method;
                if (method_exists($this->_active_controller, $method_name)) {
                    $this->_active_controller->$method_name();
                } else {
//                    echo "Controllerda Method Bulunamadı";
                    /*
                     * 404 Yönlendirmesi
                     * Controllerda Method Bulunamadı
                     * */
                    header('Location: '.SITE_URL.'/index/sayfaBulunamadi');
                }
            } else {
                //hata
                    if ($this->_active_controller !== null && method_exists($this->_active_controller, $method_name)) {
                        $this->_active_controller->$method_name();
                    } else {
                        /*
                         * 404 Yönlendirmesi
                         * Controller veya İndex Methodu Bulunamadı
                         * */
//                        echo "Controller veya İndex Methodu Bulunamadı";
                        header('Location: '.SITE_URL.'/index/sayfaBulunamadi');
                    }


            }
        }
    }

}