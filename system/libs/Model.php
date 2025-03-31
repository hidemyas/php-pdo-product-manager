<?php 
 
class Model{
    protected $db   =   array();
    public function __construct()
    {
        $this->db   =   new Database();
    }

    /**
     * Kullanıcıdan gelen verileri güvenlik amacıyla filtreler
     *
     * @param mixed $input Filtrelenecek veri
     * @param string $type 'string' veya 'numeric' olabilir
     * @param bool $strip_tags HTML/XML tag'larını temizlemek için (string için)
     * @return mixed Filtrelenmiş veri
     */
    function securityFilter($input, $type = 'string', $strip_tags = true) {
        if (is_array($input)) {
            foreach ($input as $key => $value) {
                $input[$key] = secureInput($value, $type, $strip_tags);
            }
            return $input;
        }

        // Null kontrolü
        if ($input === null) {
            return null;
        }

        switch ($type) {
            case 'string':
                // Trim ile baştaki ve sondaki boşlukları temizle
                $input = trim($input);

                // HTML/XML tag'larını temizle
                if ($strip_tags) {
                    $input = strip_tags($input);
                }

                // Özel karakterleri HTML entity'lere çevir (XSS koruması)
                $input = htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');

                // SQL enjeksiyonuna karşı koruma (Eğer veritabanına yazılacaksa PDO parametreleri daha iyi)
                $input = str_replace(
                    array('\\', "\0", "\n", "\r", "'", '"', "\x1a"),
                    array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'),
                    $input
                );
                break;

            case 'numeric':
                // Sadece sayısal değerleri koru
                if (is_numeric($input)) {
                    $input = $input + 0; // String numeric'i int/float'a çevir
                } else {
                    $input = 0; // Geçersizse varsayılan değer
                }
                break;

            default:
                // Bilinmeyen tip için varsayılan string işlemi uygula
                $input = secureInput($input, 'string', $strip_tags);
        }

        return $input;
    }
}