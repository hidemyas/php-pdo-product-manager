# Ürün Yönetim Sistemi (PHP MVC PDO)

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![PDO](https://img.shields.io/badge/PDO-4479A1?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![MVC](https://img.shields.io/badge/Architecture-MVC-blue?style=for-the-badge)


## Özellikler

✔️ Tam MVC (Model-View-Controller) Mimarisi  
✔️ PDO ile Veritabanı İşlemleri  
✔️ CRUD (Oluşturma-Okuma-Güncelleme-Silme) Operasyonları  
✔️ Responsive Tasarım (Bootstrap 5)  
✔️ Güvenli Oturum Yönetimi  
✔️ Dinamik Ürün Kategorizasyonu  
✔️ Kullanıcı Dostı Arayüz

## Kurulum

### Ön Koşullar
- PHP 7.4 veya üzeri
- MySQL 5.7 veya üzeri
- Apache/Nginx web sunucusu
- Composer (önerilir)

### Adım Adım Kurulum

1. Veritabanı oluşturma:


2. Veritabanı import işlemi:
`product_manager.sql` içe aktar seçeneği ile dosyasını yükleyin

3. `config.php` dosyasını düzenleyin:
```php
define('SITE_URL','http://localhost');
define('DB_USERNAME','veritabani_kullanici');
define('DB_PASSWORD','sifreniz');
define('DB_NAME','product_manager');
define('DB_HOST','localhost');
```

4. Bağımlılıkları yükleme (eğer varsa):
```bash
composer install
```

5. Tarayıcıdan erişim:
```
http://localhost/urun-yonetim-sistemi/public/
```

## Kullanılan Teknolojiler

| Teknoloji | Açıklama |
|-----------|----------|
| ![PHP](https://img.icons8.com/ios-filled/50/777BB4/php-logo.png) PHP 7.4+ | Backend programlama dili |
| ![PDO](https://img.icons8.com/ios/50/4479A1/database.png) PDO | Veritabanı erişim katmanı |
| ![MySQL](https://img.icons8.com/ios-filled/50/4479A1/mysql-logo.png) MySQL | İlişkisel veritabanı |
| ![Bootstrap](https://img.icons8.com/ios-filled/50/563D7C/bootstrap.png) Bootstrap 5 | Frontend framework |
| ![MVC](https://img.icons8.com/ios/50/000000/design.png) MVC | Yazılım mimarisi |



## Katkıda Bulunma

Katkılarınızı bekliyoruz! Katkıda bulunmak için:

1. Forklayın (https://github.com/hidemyas/php-pdo-product-manager/fork)
2. Yeni branch oluşturun (`git checkout -b feature/fooBar`)
3. Değişikliklerinizi commit edin (`git commit -am 'Add some fooBar'`)
4. Push yapın (`git push origin feature/fooBar`)
5. Yeni bir Pull Request oluşturun

## Lisans

MIT Lisansı - Detaylar için [LICENSE](LICENSE) dosyasına bakınız.

## İletişim

Geliştirici: HidemYas  
E-posta: info@hidemyas.org  
Proje Linki: [https://github.com/hidemyas/php-pdo-product-manager](https://github.com/hidemyas/php-pdo-product-manager)

