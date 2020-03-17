-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2020 at 09:10 PM
-- Server version: 10.1.39-MariaDB
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
-- Database: `fraow`
--

-- --------------------------------------------------------

--
-- Table structure for table `available_social_networks`
--

CREATE TABLE `available_social_networks` (
  `asn_id` int(11) NOT NULL,
  `asn_name` varchar(50) NOT NULL,
  `asn_type` varchar(50) NOT NULL,
  `asn_url` varchar(50) NOT NULL,
  `asn_status` int(11) NOT NULL,
  `asn_display_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `available_social_networks`
--

INSERT INTO `available_social_networks` (`asn_id`, `asn_name`, `asn_type`, `asn_url`, `asn_status`, `asn_display_name`) VALUES
(1, 'facebook', 'socialmedia', 'facebook.com', 1, 'Facebook'),
(2, 'twitter', 'socialmedia', 'twitter.com', 1, 'Twitter'),
(3, 'instagram', 'socialmedia', 'instagram.com', 1, 'Instagram'),
(4, 'snapchat', 'socialmedia', 'snapchat.com', 1, 'Snapchat'),
(5, 'mobilephone', 'contactinfo', '', 1, 'Mobile Phone'),
(6, 'homephone', 'contactinfo', '', 1, 'Home Phone'),
(7, 'whatsapp', 'contactinfo', '', 1, 'Whatsapp'),
(8, 'email', 'contactinfo', '', 1, 'Email'),
(9, 'website', 'contactinfo', '', 1, 'Website');

-- --------------------------------------------------------

--
-- Table structure for table `social_links`
--

CREATE TABLE `social_links` (
  `social_link_id` int(11) NOT NULL,
  `social_link_type` varchar(50) NOT NULL,
  `social_link_value` varchar(50) NOT NULL,
  `social_link_position` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `social_network_icons`
--

CREATE TABLE `social_network_icons` (
  `social_network_icon` int(11) NOT NULL,
  `asn_name` varchar(50) NOT NULL,
  `icon_value` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `social_network_icons`
--

INSERT INTO `social_network_icons` (`social_network_icon`, `asn_name`, `icon_value`) VALUES
(1, 'facebook', 'fa fa-facebook'),
(2, 'twitter', 'fa fa-twitter'),
(3, 'instagram', 'fa fa-instagram'),
(4, 'whatsapp', 'fa fa-whatsapp'),
(5, 'mobilephone', 'fa fa-mobile-alt'),
(6, 'homephone', 'fa fa-phone'),
(7, 'email', 'fa fa-email'),
(8, 'website', 'fa fa-globe');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_fullname` varchar(50) NOT NULL,
  `user_username` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `user_profileimage` varchar(70) NOT NULL,
  `user_verification` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users_details`
--

CREATE TABLE `users_details` (
  `user_detail_id` int(11) NOT NULL,
  `user_gender` varchar(50) NOT NULL,
  `user_about` varchar(200) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users_tickets`
--

CREATE TABLE `users_tickets` (
  `ticket_id` int(11) NOT NULL,
  `user_username` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `ticket_message` varchar(300) NOT NULL,
  `ticket_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `available_social_networks`
--
ALTER TABLE `available_social_networks`
  ADD PRIMARY KEY (`asn_id`);

--
-- Indexes for table `social_links`
--
ALTER TABLE `social_links`
  ADD PRIMARY KEY (`social_link_id`);

--
-- Indexes for table `social_network_icons`
--
ALTER TABLE `social_network_icons`
  ADD PRIMARY KEY (`social_network_icon`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users_details`
--
ALTER TABLE `users_details`
  ADD PRIMARY KEY (`user_detail_id`);

--
-- Indexes for table `users_tickets`
--
ALTER TABLE `users_tickets`
  ADD PRIMARY KEY (`ticket_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `available_social_networks`
--
ALTER TABLE `available_social_networks`
  MODIFY `asn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `social_links`
--
ALTER TABLE `social_links`
  MODIFY `social_link_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `social_network_icons`
--
ALTER TABLE `social_network_icons`
  MODIFY `social_network_icon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users_details`
--
ALTER TABLE `users_details`
  MODIFY `user_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users_tickets`
--
ALTER TABLE `users_tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
