-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2018 at 10:25 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `advanced2`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subscription_lists`
--

CREATE TABLE `tbl_subscription_lists` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `creator_id` int(11) DEFAULT NULL,
  `last_modified_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `last_modifier_id` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subscription_mails`
--

CREATE TABLE `tbl_subscription_mails` (
  `id` int(10) UNSIGNED NOT NULL,
  `campaign_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `creator_id` int(11) DEFAULT NULL,
  `last_modified_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `last_modifier_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subscription_mail_list`
--

CREATE TABLE `tbl_subscription_mail_list` (
  `mail_id` int(11) UNSIGNED NOT NULL,
  `list_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subscription_subscribers`
--

CREATE TABLE `tbl_subscription_subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `ip_address` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirmed` tinyint(1) DEFAULT '0',
  `status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subscription_subscriber_list`
--

CREATE TABLE `tbl_subscription_subscriber_list` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `list_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subscrption_campaigns`
--

CREATE TABLE `tbl_subscrption_campaigns` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_date` datetime NOT NULL,
  `creator_id` int(11) NOT NULL,
  `last_modified_date` datetime NOT NULL,
  `last_modifer_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_subscription_lists`
--
ALTER TABLE `tbl_subscription_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_subscription_mails`
--
ALTER TABLE `tbl_subscription_mails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `campaign_id` (`campaign_id`);

--
-- Indexes for table `tbl_subscription_mail_list`
--
ALTER TABLE `tbl_subscription_mail_list`
  ADD PRIMARY KEY (`mail_id`,`list_id`),
  ADD KEY `list_id` (`list_id`);

--
-- Indexes for table `tbl_subscription_subscribers`
--
ALTER TABLE `tbl_subscription_subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `tbl_subscription_subscriber_list`
--
ALTER TABLE `tbl_subscription_subscriber_list`
  ADD PRIMARY KEY (`user_id`,`list_id`),
  ADD KEY `list_id` (`list_id`);

--
-- Indexes for table `tbl_subscrption_campaigns`
--
ALTER TABLE `tbl_subscrption_campaigns`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_subscription_lists`
--
ALTER TABLE `tbl_subscription_lists`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_subscription_subscribers`
--
ALTER TABLE `tbl_subscription_subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_subscrption_campaigns`
--
ALTER TABLE `tbl_subscrption_campaigns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_subscription_mails`
--
ALTER TABLE `tbl_subscription_mails`
  ADD CONSTRAINT `tbl_subscription_mails_ibfk_1` FOREIGN KEY (`campaign_id`) REFERENCES `tbl_subscrption_campaigns` (`id`);

--
-- Constraints for table `tbl_subscription_mail_list`
--
ALTER TABLE `tbl_subscription_mail_list`
  ADD CONSTRAINT `tbl_subscription_mail_list_ibfk_1` FOREIGN KEY (`list_id`) REFERENCES `tbl_subscription_lists` (`id`),
  ADD CONSTRAINT `tbl_subscription_mail_list_ibfk_2` FOREIGN KEY (`mail_id`) REFERENCES `tbl_subscription_mails` (`id`);

--
-- Constraints for table `tbl_subscription_subscriber_list`
--
ALTER TABLE `tbl_subscription_subscriber_list`
  ADD CONSTRAINT `tbl_subscription_subscriber_list_ibfk_1` FOREIGN KEY (`list_id`) REFERENCES `tbl_subscription_lists` (`id`),
  ADD CONSTRAINT `tbl_subscription_subscriber_list_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tbl_subscription_subscribers` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
