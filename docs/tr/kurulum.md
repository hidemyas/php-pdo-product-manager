# 🔧 Kurulum

### 1. Veritabanını Yükleme
`product_manager.sql` dosyasını kullandığınız veritabanına import ediniz

### 2. Veritabanı Ayarları
`app/config/config.php` dosyasını açarak veritabanı bağlantı bilgilerinizi hosting bilgilerinize göre yapılandırın:

```php
/*  SITE Ayarları */
define('SITE_URL','http://localhost');


/* Veritabanı Ayarları */
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME','product_manager');
define('DB_HOST','localhost');



