-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 
-- サーバのバージョン： 10.1.40-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `okashi_days`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `administrators`
--

CREATE TABLE `administrators` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `user_name` varchar(50) NOT NULL COMMENT 'ログインユーザー名',
  `password` varchar(255) NOT NULL COMMENT 'パスワード',
  `name` varchar(50) NOT NULL COMMENT '管理者氏名',
  `email` varchar(255) NOT NULL COMMENT 'メールアドレス',
  `is_login_allowed` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'ログイン許可',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '削除フラグ',
  `create_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録日時',
  `update_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `administrators`
--

INSERT INTO `administrators` (`id`, `user_name`, `password`, `name`, `email`, `is_login_allowed`, `is_deleted`, `create_date_time`, `update_date_time`) VALUES
(1, 'test1', '$2y$10$IDvdvXHnX/.e5wPq2Xwb4eDIO5g2AFAlk95Mrb3IdUIsSOCq8Wzui', 'テスト花子', 'test@co.jp', 1, 1, '2019-08-16 15:41:32', '2019-08-23 11:19:48'),
(4, 'test2', '$2y$10$qZk1iMhXT2l/vqvQ/fWdBuwlRdlfdSTYpHotGG4OtMiitw8.QEswG', 'テスト次郎', 'hoge@example.com', 1, 0, '2019-08-21 15:15:45', '2019-08-23 10:50:58'),
(5, 'test3', '$2y$10$fpnEtyBEKqVzilJP/NJL7elzDvxkjtZjuQdGugerdzqm1U6nl3kfS', '魔王', 'hogeeeeee@example.com', 1, 0, '2019-08-21 15:44:56', '2019-08-21 15:44:56');

-- --------------------------------------------------------

--
-- テーブルの構造 `allergy_items`
--

CREATE TABLE `allergy_items` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `allergy_item` varchar(20) NOT NULL COMMENT 'アレルギー品目名',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '削除フラグ',
  `create_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録日時',
  `update_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `area_delivery_charge`
--

CREATE TABLE `area_delivery_charge` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `delivery_charge` int(11) NOT NULL COMMENT '地域別送料',
  `area_name` varchar(20) NOT NULL COMMENT '地域名',
  `create_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録日時',
  `update_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `user_name` varchar(255) NOT NULL COMMENT 'ユーザー名',
  `password` varchar(255) NOT NULL COMMENT 'パスワード',
  `last_name` varchar(50) NOT NULL COMMENT '姓',
  `first_name` varchar(50) NOT NULL COMMENT '名',
  `last_name_kana` varchar(50) NOT NULL COMMENT '姓カナ',
  `first_name_kana` varchar(50) NOT NULL COMMENT '名カナ',
  `birthday` date NOT NULL COMMENT '生年月日',
  `gender` tinyint(4) NOT NULL COMMENT '性別',
  `postal_code` char(7) NOT NULL COMMENT '郵便番号',
  `prefecture` varchar(10) NOT NULL COMMENT '都道府県',
  `prefecture_id` int(11) NOT NULL COMMENT '都道府県ID',
  `address1` varchar(100) NOT NULL COMMENT '住所1（市区町村・町名）',
  `address2` varchar(100) NOT NULL COMMENT '住所2（番地・建物名）',
  `phone_number` varchar(20) NOT NULL COMMENT '電話番号',
  `email` varchar(255) NOT NULL COMMENT 'メールアドレス',
  `is_deactive` tinyint(4) NOT NULL DEFAULT '0' COMMENT '退会フラグ',
  `create_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録日時',
  `update_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `item_category_id` int(11) NOT NULL COMMENT '商品カテゴリID',
  `item_name` varchar(100) NOT NULL COMMENT '商品名',
  `item_model_number` varchar(100) NOT NULL COMMENT '商品型番',
  `item_description` varchar(100) NOT NULL COMMENT '商品説明',
  `allergy_item` varchar(255) NOT NULL COMMENT 'アレルギー品目',
  `item_detail` varchar(500) NOT NULL COMMENT '商品詳細',
  `unit_price` int(11) NOT NULL COMMENT '単価',
  `item_image` varchar(100) NOT NULL COMMENT '商品画像',
  `is_recommend` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'おすすめフラグ',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '削除フラグ',
  `create_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録日時',
  `update_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `item_categories`
--

CREATE TABLE `item_categories` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `item_category_name` varchar(100) NOT NULL COMMENT '商品カテゴリ名',
  `item_category_image` varchar(100) NOT NULL COMMENT '商品カテゴリ画像',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '削除フラグ',
  `create_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録日時',
  `update_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `news_index` varchar(100) NOT NULL COMMENT 'お知らせ見出し',
  `news_content` varchar(255) NOT NULL COMMENT 'お知らせ内容',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '削除フラグ',
  `expiration_date` date NOT NULL COMMENT '掲載期限日',
  `create_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録日時',
  `update_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `customer_id` int(11) NOT NULL COMMENT '会員ID',
  `customer_last_name` varchar(20) NOT NULL COMMENT '会員姓',
  `customer_first_name` varchar(20) NOT NULL COMMENT '会員名',
  `customer_last_name_kana` varchar(20) NOT NULL COMMENT '会員姓カナ',
  `customer_first_name_kana` varchar(20) NOT NULL COMMENT '会員名カナ',
  `postal_code` char(7) NOT NULL COMMENT '郵便番号',
  `prefecture` varchar(10) NOT NULL COMMENT '都道府県',
  `prefecture_id` int(11) NOT NULL COMMENT '都道府県ID',
  `tax_rate` float NOT NULL COMMENT '消費税率',
  `delivery_charge` int(11) NOT NULL COMMENT '送料',
  `address1` varchar(100) NOT NULL COMMENT '住所1（市区町村・町名）',
  `address2` varchar(100) NOT NULL COMMENT '住所2（番地・建物名）',
  `phone_number` varchar(20) NOT NULL COMMENT '電話番号',
  `email` varchar(255) NOT NULL COMMENT 'メールアドレス',
  `order_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '受注日時',
  `total_amount` int(11) NOT NULL COMMENT '合計金額',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '削除フラグ',
  `create_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録日時',
  `update_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `order_id` int(11) NOT NULL COMMENT '受注ID',
  `item_id` int(11) NOT NULL COMMENT '商品ID',
  `item_name` varchar(100) NOT NULL COMMENT '商品名',
  `item_model_number` varchar(50) NOT NULL COMMENT '商品型番',
  `quantity` int(11) NOT NULL COMMENT '数量',
  `subtotal_amount` int(11) NOT NULL COMMENT '小計金額',
  `is_deleted` tinyint(4) NOT NULL COMMENT '削除フラグ',
  `create_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録日時',
  `update_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `postal_code`
--

CREATE TABLE `postal_code` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `postal_code` char(7) NOT NULL COMMENT '郵便番号',
  `prefecture` varchar(10) NOT NULL COMMENT '都道府県名',
  `address1` varchar(100) NOT NULL COMMENT '住所1（市区町村・町名）',
  `address2` varchar(100) NOT NULL COMMENT '住所2（番地・建物名）'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `prefectures`
--

CREATE TABLE `prefectures` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `prefecture` varchar(20) NOT NULL COMMENT '都道府県名',
  `area_delivery_charge_id` int(11) NOT NULL COMMENT '地域別送料ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `tax_rates`
--

CREATE TABLE `tax_rates` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `tax_rate` float NOT NULL COMMENT '消費税率',
  `start_date` date NOT NULL COMMENT '適用開始日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IX_administrators_user_name` (`user_name`);

--
-- Indexes for table `allergy_items`
--
ALTER TABLE `allergy_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `area_delivery_charge`
--
ALTER TABLE `area_delivery_charge`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IX_customers_user_name` (`user_name`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IX_items_item_category_id` (`item_category_id`);

--
-- Indexes for table `item_categories`
--
ALTER TABLE `item_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_customer_id` (`customer_id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IX_order_detail_order_id` (`order_id`),
  ADD KEY `IX_order_detail_item_id` (`item_id`);

--
-- Indexes for table `postal_code`
--
ALTER TABLE `postal_code`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prefectures`
--
ALTER TABLE `prefectures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tax_rates`
--
ALTER TABLE `tax_rates`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrators`
--
ALTER TABLE `administrators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `allergy_items`
--
ALTER TABLE `allergy_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT for table `area_delivery_charge`
--
ALTER TABLE `area_delivery_charge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT for table `item_categories`
--
ALTER TABLE `item_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT for table `postal_code`
--
ALTER TABLE `postal_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT for table `prefectures`
--
ALTER TABLE `prefectures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT for table `tax_rates`
--
ALTER TABLE `tax_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
