CREATE TABLE IF NOT EXISTS `tcrw_tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `startat` datetime NOT NULL,
  `status` enum('created','requested','validated','failed','cancelled','denied') NOT NULL,
  `cli` varchar(11) NOT NULL,
  `rk` varchar(60) NOT NULL,
  `user_id` int(11) NOT NULL,
  `transaction_id` varchar(15) NOT NULL,
  `result` varchar(2) NOT NULL,
  `result_code` int(11) NOT NULL,
  `result_descr` varchar(40) NOT NULL,
  `service_type` int(11) NOT NULL,
  `amount` varchar(15) NOT NULL,
  `divisa` varchar(3) NOT NULL,
  `endat` varchar(15) NOT NULL,
  `credit_time` int(11) NOT NULL,
  `service_phone` varchar(20) NOT NULL,
  `customer_email` varchar(60) NOT NULL,
  `ps` int(11) NOT NULL,
  `merchant` varchar(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
