-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 05, 2018 at 05:44 PM
-- Server version: 5.7.22-0ubuntu0.16.04.1
-- PHP Version: 7.0.30-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lakita_finance`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_dimentional`
--

CREATE TABLE `detail_dimentional` (
  `id` int(11) NOT NULL,
  `dimen_id` int(11) NOT NULL,
  `code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `note` text COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `weight` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `detail_dimentional`
--

INSERT INTO `detail_dimentional` (`id`, `dimen_id`, `code`, `name`, `note`, `active`, `weight`) VALUES
(1, 2, 'Y100', 'Khóa học Yoga dành cho dân văn phòng', 'Khóa học Yoga dành cho dân văn phòng', 1, 0),
(2, 2, 'TC100', '99 Thủ thuật văn phòng', '99 Thủ thuật văn phòng', 1, 0),
(3, 2, 'KT800', 'Đào tạo kỹ thuật quyết toán thuế', 'Đào tạo kỹ thuật quyết toán thuế', 1, 0),
(4, 2, 'KT600', 'Hướng dẫn kê khai và quyết toán thuế thu nhập cá nhân', 'Hướng dẫn kê khai và quyết toán thuế thu nhập cá nhân', 1, 0),
(5, 2, 'KT400', 'Trọn bộ hướng dẫn lập báo cáo tài chính', 'Trọn bộ hướng dẫn lập báo cáo tài chính', 1, 0),
(6, 2, 'KT290', 'Trọn bộ kỹ thuật lập, kiểm tra và phân tích báo cáo tài chính', 'Trọn bộ kỹ thuật lập, kiểm tra và phân tích báo cáo tài chính', 1, 0),
(7, 2, 'KT280', 'Bảo hiểm - tiền lương - Thuế TNCN - giải pháp năm 2018', 'Bảo hiểm - tiền lương - Thuế TNCN - giải pháp năm 2018', 1, 0),
(8, 2, 'KT270', 'Trọn bộ kỹ thuật quyết toán thuế thu nhập cá nhân', 'Trọn bộ kỹ thuật quyết toán thuế thu nhập cá nhân', 1, 0),
(9, 2, 'KT260', 'Phát hiện rủi ro tiềm ẩn khi quyết toán 3 luật thuế', 'Phát hiện rủi ro tiềm ẩn khi quyết toán 3 luật thuế', 1, 0),
(10, 2, 'KT250', 'Thực hành làm kế toán tổng hợp trên Excel từ A-Z', 'Thực hành làm kế toán tổng hợp trên Excel từ A-Z', 1, 0),
(11, 2, 'KT240', 'Chia sẻ tất tần tật về kinh nghiệm bảo vệ, giải trình số liệu khi thanh tra thuế', 'Chia sẻ tất tần tật về kinh nghiệm bảo vệ, giải trình số liệu khi thanh tra thuế', 1, 0),
(12, 2, 'KT220', 'Trọn bộ kế toán cho người bắt đầu', 'Trọn bộ kế toán cho người bắt đầu', 1, 0),
(13, 2, 'KT210', 'Trọn bộ kế toán thuể từ A-Z', 'Trọn bộ kế toán thuể từ A-Z', 1, 0),
(14, 2, 'KT200', 'Làm chủ kiến thức và xử lý tình huống về hóa đơn', 'Làm chủ kiến thức và xử lý tình huống về hóa đơn', 1, 0),
(15, 2, 'KT130', 'Hướng dẫn lập, đọc, hiểu và phân tích các chỉ số báo cáo tài chính', 'Hướng dẫn lập, đọc, hiểu và phân tích các chỉ số báo cáo tài chính', 1, 0),
(16, 2, 'KT120', 'Trọn bộ quản trị tài chính kế toán dành cho các nhà quản lý', 'Trọn bộ quản trị tài chính kế toán dành cho các nhà quản lý', 1, 0),
(17, 2, 'KT110', 'Cách xác định chi phí hợp lý, công cụ bảo vệ tại các kỳ thanh tra, quyết toán thuế', 'Cách xác định chi phí hợp lý, công cụ bảo vệ tại các kỳ thanh tra, quyết toán thuế', 1, 0),
(18, 2, 'KT100', 'Làm chủ hóa đơn chứng từ trong 4h', 'Làm chủ hóa đơn chứng từ trong 4h', 1, 0),
(19, 2, 'EM100', 'Bí quyết làm chủ môn Excel cho người đi làm 2018', 'Bí quyết làm chủ môn Excel cho người đi làm 2018', 1, 0),
(20, 2, 'E400', 'Excel từ A-Z', 'Excel từ A-Z', 1, 0),
(21, 2, 'E300', 'Excel từ cơ bản tới chuyên sâu dành riêng cho kế toán', 'Excel từ cơ bản tới chuyên sâu dành riêng cho kế toán', 1, 0),
(22, 2, 'E200', '99 tuyệt chiêu Excel dành cho người đi làm', '99 tuyệt chiêu Excel dành cho người đi làm', 1, 0),
(23, 2, 'E130', 'Thủ thuật Excel', 'Thủ thuật Excel', 1, 0),
(24, 2, 'E120', '18 thủ thuật Excel', '18 thủ thuật Excel', 1, 0),
(25, 2, 'E110', 'Bí quyết làm chủ Excel 2007', 'Bí quyết làm chủ Excel 2007', 1, 0),
(26, 2, 'E100', 'Bí quyết làm chủ Excel năm 2018', 'Bí quyết làm chủ Excel năm 2018', 1, 0),
(27, 2, 'BH100', 'Bảo hiểm xã hội - tiền lương - Thuế thu nhập cá nhân năm 2018', 'Bảo hiểm xã hội - tiền lương - Thuế thu nhập cá nhân năm 2018', 1, 0),
(28, 1, 'YOGA', 'Yoga', '', 1, 0),
(29, 1, 'EXCEL', 'Excel', '', 1, 0),
(30, 1, 'THUE', 'Thuế', '', 1, 0),
(31, 1, 'BCTC', 'Báo cáo tài chính', '', 1, 0),
(32, 1, 'COMBO', 'Combo', '', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `detail_transactions`
--

CREATE TABLE `detail_transactions` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `dimensional_id` int(11) NOT NULL,
  `TOT` date NOT NULL,
  `TOA` date NOT NULL,
  `value` int(11) NOT NULL,
  `note` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dimensional_mng`
--

CREATE TABLE `dimensional_mng` (
  `id` int(11) NOT NULL,
  `code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `sequence` int(11) NOT NULL,
  `layer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dimensional_mng`
--

INSERT INTO `dimensional_mng` (`id`, `code`, `name`, `parent_id`, `note`, `sequence`, `layer`) VALUES
(1, 'NSP', 'Nhóm sản phẩm', NULL, '', 1, 1),
(2, 'SP', 'Sản phẩm', 1, '', 1, 2),
(3, 'MKT', 'Marketer', NULL, '', 1, 2),
(4, 'TOT', 'Ngày phát sinh giao dịch', NULL, '', 1, 2),
(5, 'TOA', 'Ngày thực hiện giao dịch', NULL, '', 1, 2),
(6, 'SALE', 'Sale', NULL, '', 1, 2),
(7, 'CHANNEL', 'Kênh', 8, '', 1, 2),
(8, 'GROUP_CHANNEL', 'Nhóm kênh', NULL, '', 1, 1),
(9, 'ACT', 'Hoạt động', NULL, '', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE `receipts` (
  `id` int(11) NOT NULL,
  `code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `code_real` text COLLATE utf8_unicode_ci NOT NULL,
  `type_id` int(11) NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `TOT` date NOT NULL,
  `TOA` date NOT NULL,
  `executor` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `date` date NOT NULL,
  `note` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `receipts`
--

INSERT INTO `receipts` (`id`, `code`, `code_real`, `type_id`, `content`, `TOT`, `TOA`, `executor`, `value`, `owner`, `date`, `note`) VALUES
(8, 'PTCOD1527849229', '', 1, 'Nhận từ a ship', '2018-06-01', '2018-06-01', 1, 1000, 1, '2018-06-01', ''),
(9, 'PCTNV1527849471', '', 6, 'Thưởng Hòa', '2018-06-01', '2018-06-01', 1, 100, 1, '2018-06-01', ''),
(10, 'PCVP1528171813', '', 4, 'Uống cà phê', '2018-06-05', '2018-06-05', 1, 57, 1, '2018-06-05', ''),
(11, 'PCL1528195163', '', 2, 'Lương tháng 4 của HuyNV', '2018-06-05', '2018-06-05', 1, 2500, 1, '2018-06-05', ''),
(12, 'PTCOD1528195390', '', 1, 'Nhận tiền hôm 01/06', '2018-06-05', '2018-06-05', 1, 5840000, 1, '2018-06-05', '');

-- --------------------------------------------------------

--
-- Table structure for table `receipt_type`
--

CREATE TABLE `receipt_type` (
  `id` int(11) NOT NULL,
  `code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_type_list_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `receipt_type`
--

INSERT INTO `receipt_type` (`id`, `code`, `transaction_type_list_id`, `name`) VALUES
(1, 'PTCOD', '1,3,4', 'Phiếu thu các khóa học từ COD'),
(2, 'PCL', '5', 'Phiếu chi lương cho nhân viên'),
(3, 'PCUT', '5', 'Phiếu chi ứng tiền'),
(4, 'PCVP', '5', 'Phiếu chi văn phòng'),
(5, 'PTCK', '1,2,3', 'Phiếu thu các khóa học từ chuyển khoản'),
(6, 'PCTNV', '5', 'Phiếu chi cho thưởng nhân viên'),
(7, 'PCSH', '5', 'Phiếu chi sinh hoạt chung'),
(8, 'PCHD', '5', 'Hoạt động ngoại khóa, Team building'),
(9, 'PTK', '3', 'Phiếu thu loại khác'),
(10, 'PCK', '5', 'Phiếu chi loại khác');

-- --------------------------------------------------------

--
-- Table structure for table `rules_of_attribution`
--

CREATE TABLE `rules_of_attribution` (
  `receipt_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `dimentional_id` int(11) NOT NULL,
  `attribution_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `receipt_id` int(11) NOT NULL,
  `TOT` date NOT NULL,
  `TOA` date NOT NULL,
  `value` int(20) NOT NULL,
  `TK_no` int(11) NOT NULL,
  `TK_co` int(11) NOT NULL,
  `note` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `receipt_id`, `TOT`, `TOA`, `value`, `TK_no`, `TK_co`, `note`) VALUES
(1, 8, '2018-06-01', '2018-06-01', 100, 0, 0, 'Thuế giá trị gia tăng: 10% giá trị của sản phẩm'),
(2, 8, '2018-06-01', '2018-06-01', 900, 0, 0, 'Ghi nhận doanh thu: Doanh thu thực tế'),
(3, 8, '2018-06-01', '2018-06-01', 100, 0, 0, 'Chi phí COD: 30000/1 sản phâm'),
(4, 9, '2018-06-01', '2018-06-01', 100000, 0, 0, 'Ghi nhận chi: Chi thực tế'),
(5, 10, '2018-06-05', '2018-06-05', 57000, 0, 0, 'Ghi nhận chi: Chi thực tế'),
(6, 11, '2018-06-05', '2018-06-05', 2500000, 0, 0, 'Ghi nhận chi: Chi thực tế'),
(7, 12, '2018-06-05', '2018-06-05', 584000, 0, 0, 'Thuế giá trị gia tăng: 10% giá trị của sản phẩm'),
(8, 12, '2018-06-05', '2018-06-05', 5340000, 0, 0, 'Ghi nhận doanh thu: Doanh thu thực tế'),
(9, 12, '2018-06-05', '2018-06-05', 500000, 0, 0, 'Chi phí COD: 30000/1 sản phâm');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_type`
--

CREATE TABLE `transaction_type` (
  `id` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `default_value` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transaction_type`
--

INSERT INTO `transaction_type` (`id`, `description`, `default_value`, `note`) VALUES
(1, 'Thuế giá trị gia tăng', '0.1', '10% giá trị của sản phẩm'),
(2, 'Chi phí giao dịch cho ngân hàng', '2000/1tr', '2000/1 triệu'),
(3, 'Ghi nhận doanh thu', NULL, 'Doanh thu thực tế'),
(4, 'Chi phí COD', '', '30000/1 sản phâm'),
(5, 'Ghi nhận chi', NULL, 'Chi thực tế');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `department` int(11) NOT NULL,
  `permission` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `avatar` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `department`, `permission`, `username`, `password`, `created`, `avatar`) VALUES
(1, 'HuyNV', 0, 0, 'huynv', 'code', '2018-05-16 08:10:46', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_dimentional`
--
ALTER TABLE `detail_dimentional`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `detail_transactions`
--
ALTER TABLE `detail_transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_id` (`transaction_id`,`dimensional_id`,`TOT`);

--
-- Indexes for table `dimensional_mng`
--
ALTER TABLE `dimensional_mng`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `receipts`
--
ALTER TABLE `receipts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `real_id` (`code`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `receipt_type`
--
ALTER TABLE `receipt_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `rules_of_attribution`
--
ALTER TABLE `rules_of_attribution`
  ADD KEY `receipt_code` (`receipt_code`),
  ADD KEY `dimentional_id` (`dimentional_id`),
  ADD KEY `attribution_id` (`attribution_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receipt_id` (`receipt_id`);

--
-- Indexes for table `transaction_type`
--
ALTER TABLE `transaction_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_dimentional`
--
ALTER TABLE `detail_dimentional`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `detail_transactions`
--
ALTER TABLE `detail_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dimensional_mng`
--
ALTER TABLE `dimensional_mng`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `receipts`
--
ALTER TABLE `receipts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `receipt_type`
--
ALTER TABLE `receipt_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `transaction_type`
--
ALTER TABLE `transaction_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `receipts`
--
ALTER TABLE `receipts`
  ADD CONSTRAINT `receipts_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `receipt_type` (`id`);

--
-- Constraints for table `rules_of_attribution`
--
ALTER TABLE `rules_of_attribution`
  ADD CONSTRAINT `rules_of_attribution_ibfk_1` FOREIGN KEY (`receipt_code`) REFERENCES `receipts` (`code`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`receipt_id`) REFERENCES `receipts` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
