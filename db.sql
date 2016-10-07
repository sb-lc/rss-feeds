CREATE DATABASE testDb;
USE testDb;
CREATE USER 'testUser'@'localhost' IDENTIFIED BY 'testPass';
GRANT ALL PRIVILEGES ON testDb.* To 'testUser'@'localhost' IDENTIFIED BY 'testPass';
FLUSH PRIVILEGES;



CREATE TABLE IF NOT EXISTS `rss` (
`id` int(11) NOT NULL,
  `url` varchar(2083) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;


INSERT INTO `rss` (`id`, `url`) VALUES
(1, 'http://slashdot.org/rss/slashdot.rss'),
(2, 'http://newsrss.bbc.co.uk/rss/newsonline_uk_edition/front_page/rss.xml'),
(3, 'http://slashdot.org/rss/slashdot2.rss');


ALTER TABLE `rss`
ADD PRIMARY KEY (`id`);


ALTER TABLE `rss`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=50;