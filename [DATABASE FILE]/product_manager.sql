-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 31 Mar 2025, 21:20:21
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `product_manager`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cats`
--

CREATE TABLE `cats` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `cats`
--

INSERT INTO `cats` (`id`, `title`) VALUES
(1, 'Telefon'),
(2, 'Bilgisayar'),
(1453, 'Tablet');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `managers`
--

CREATE TABLE `managers` (
  `id` int(10) UNSIGNED NOT NULL,
  `mail` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `readSSS` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `managers`
--

INSERT INTO `managers` (`id`, `mail`, `password`, `readSSS`) VALUES
(1, 'info@hidemyas.org', 'e10adc3949ba59abbe56e057f20f883e', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `price` double NOT NULL,
  `salePrice` double NOT NULL,
  `content` text NOT NULL,
  `thumbnail` varchar(100) NOT NULL,
  `catID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `products`
--

INSERT INTO `products` (`id`, `slug`, `title`, `description`, `price`, `salePrice`, `content`, `thumbnail`, `catID`) VALUES
(3, 'monster-tulpar-t7', 'Monster Tulpar T7', 'açıkşama', 90000, 85000, '<p><span style=\"font-family: Impact,Charcoal,sans-serif;\">wadwadawdwad</span></p><p><strong>yusuf</strong></p><p>demoSd</p>', '/public/assets/img/product.png', 2),
(5, 'iphone-7', 'İPHONE 7 Yenilendi', 'Ürün Kısa Açıklaması', 4000, 0, '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi?</p>', '/public/assets/img/product.png', 1),
(6, 'iphone-14', 'İPHONE 14', 'Ürün Kısa Açıklaması\r\n', 60000, 50000, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi?\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi?\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi?\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi?', '/public/assets/img/product.png', 1),
(10, 'iphone-152', 'İPHONE 15', 'Ürün Kısa Açıklaması\r\n', 80000, 70000, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi?\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi?\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi?\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi?', '/public/assets/img/product.png', 1),
(11, 'monster-tulpar-t73', 'Monster Tulpar T7', 'Ürün Kısa Açıklaması\r\n\r\n', 50000, 0, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi?\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi?\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi?\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi?', '/public/assets/img/product.png', 2),
(12, 'dell4', 'DELL', 'Ürün Kısa Açıklaması\r\n', 90000, 85000, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi?\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi?\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi?\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi?', '/public/assets/img/product.png', 2),
(13, 'iphone-75', 'İPHONE 7', 'Ürün Kısa Açıklaması\r\n\r\n', 40000, 0, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi?\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi?\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi?\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi?', '/public/assets/img/product.png', 1),
(14, 'iphone-146', 'İPHONE 14', 'Ürün Kısa Açıklaması\r\n', 60000, 50000, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi?\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi?\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi?\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi?', '/public/assets/img/product.png', 1),
(15, 'hp-omen7', 'HP OMEN', 'Ürün Kısa Açıklaması', 4000, 0, '<p><strong>Lorem ipsum dolor sit amet</strong>, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi? Lorem ipsum dolor sit amet, consectetur adipisicing elit.&nbsp;</p><p>Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi?</p>', '/public/assets/img/product.png', 2),
(16, 'hp-victus8', 'HP Victus', 'Ürün Kısa Açıklaması\r\n', 70000, 65000, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi?\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi?\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi?\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium, at aut consectetur ea eaque eos, et iure molestiae nihil quasi quo quod repudiandae, totam voluptate voluptatem? Beatae debitis porro quasi?', '/public/assets/img/product.png', 2),
(17, 'monster-abra', 'Monster Abra', 'descr', 12333, 0, '<p>awdwadaw</p>', '/public/assets/img/product.png', 2),
(26, 'monster-abram', 'Monster Abram', 'adwdwad', 1244, 0, '<p>awd</p>', '/public/assets/img/product.png', 1),
(29, 'monster-abrami', 'Monster Abramı', 'adwdwad', 1244, 0, '<p>awd</p>', '/public/assets/img/product.png', 1),
(32, 'monster-tulpar-t7dwadsadiuagdusco', 'Monster Tulpar T7dwadsadiüağdüşçö', 'awdwadwa', 12333, 12333, '<p>dwadaw</p>', '/public/assets/img/product.png', 2),
(36, 'monster-tulpar-t7dwadsadiudwa', 'Monster Tulpar T7dwadsadiüdwa', 'awdwadwa', 12333, 12333, '<p>dwadaw</p>', '/public/assets/img/product.png', 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `urunSayisi` int(10) UNSIGNED NOT NULL,
  `kategoriSayisi` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `settings`
--

INSERT INTO `settings` (`id`, `urunSayisi`, `kategoriSayisi`) VALUES
(3, 5, 10);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `cats`
--
ALTER TABLE `cats`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `managers`
--
ALTER TABLE `managers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- Tablo için indeksler `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Tablo için indeksler `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `cats`
--
ALTER TABLE `cats`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1455;

--
-- Tablo için AUTO_INCREMENT değeri `managers`
--
ALTER TABLE `managers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Tablo için AUTO_INCREMENT değeri `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
