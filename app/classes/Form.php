<?php
class Form
{
    public $currentValue;
    public $values = array();
    public $errors = array();
    public $currentField;

    public function __construct()
    {

    }

    public function post($key,$html=true)
    {
        if (isset($_POST[$key])){
            $data = $html ? $this->Filter($_POST[$key]) : $_POST[$key];
            $this->values[$key] = $data;
            $this->currentField = array('key'=>$key,'val'=>$data);
            $this->currentValue = $data;
        }else{
            $this->values[$key] = "";
            $this->currentField = array('key'=>$key,'val'=>"");
            $this->currentValue = "";
        }
        return $this;
    }

    public function file($key)
    {
        if (isset($_FILES[$key]) && $_FILES[$key]['error'] === UPLOAD_ERR_OK) {
            $this->values[$key] = $_FILES[$key];
            $this->currentField = array('key' => $key, 'val' => $_FILES[$key]);
            $this->currentValue = $_FILES[$key];
        } else {
            $this->values[$key] = null;
            $this->currentField = array('key' => $key, 'val' => null);
            $this->currentValue = null;

            // Dosya yükleme hatası varsa bunu kaydedelim
            $this->errors[$key]['file'] = "Dosya yüklenirken bir hata oluştu.";
        }

        return $this;
    }


    public function Filter($item)
    {
        $step_one = trim($item);
        $step_two = strip_tags($step_one);
        $step_trhee = htmlspecialchars($step_two, ENT_QUOTES);
        return $step_trhee;
    }

    public function isEmpty()
    {
        if (empty($this->currentField['val'])) {
            $this->errors[$this->currentField['key']]['empty'] = "Lütfen Bu Alanı Boş Bırakmayınız";
        } else {
            //
        }

        return $this;
    }

    public function isType(array $allowedTypes)
    {
        if (!empty($this->currentField['val'])) {
            $fileType = mime_content_type($this->currentField['val']['tmp_name']); // Dosya türünü al

            if (!in_array($fileType, $allowedTypes)) {
                $this->errors[$this->currentField['key']]['type'] = "Geçersiz dosya türü. Yalnızca şu türler destekleniyor: " . implode(', ', $allowedTypes);
            }
        }

        return $this;
    }


    public function length($min = 0, $max)
    {
        $str_with = strlen($this->currentValue);
        if ($min < $str_with and $str_with > $max) {
            $this->errors[$this->currentField['key']]['length'] = "Bu Alan istenilen karakterde girmediniz , Lütfen $min ve $max arasındaki uzunluk kadar yazınız";

        }

        return $this;
    }

    public function isEqual($param_one, $param_two)
    {
        if ($this->values[$param_one]!=$this->values[$param_two]) {
            $this->errors[$this->currentField['key']]['equal'] = "Lütfen ilgili alanları aynı değerleri giriniz";
            $this->errors[$this->currentField['key']]['params'] = [$param_one,$param_two];

        }

        return $this;
    }

    public function uploadFile($destinationPath = "/public/assets/img/")
    {
        if (!empty($this->currentField['val']) && is_array($this->currentField['val'])) {
            $file = $this->currentField['val'];
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . $destinationPath; // Gerçek sunucu yolunu al

            // Klasör yoksa oluştur
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Dosyanın orijinal adını güvenli hale getirme
            $fileName = time() . "_" . basename($file['name']); // Benzersiz isim oluştur
            $uploadPath = $uploadDir . $fileName;

            // Dosyayı belirtilen klasöre taşı
            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                return SITE_URL.str_replace($_SERVER['DOCUMENT_ROOT'], '', $uploadPath); // Site içi yol döndür
            } else {
                $this->errors[$this->currentField['key']]['upload'] = "Dosya yükleme başarısız.";
            }
        } else {
            $this->errors[$this->currentField['key']]['upload'] = "Yüklenmek üzere bir dosya seçilmedi.";
        }

        return false;
    }


    public function submit()
    {
        if (empty($this->errors)) {
            return true;
        } else {
            return false;
        }
    }

}