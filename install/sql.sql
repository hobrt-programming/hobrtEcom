CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `cats` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `discounts` (
  `id` int(11) NOT NULL,
  `coupon` varchar(100) NOT NULL,
  `num` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `name` varchar(300) NOT NULL,
  `tele` varchar(300) NOT NULL,
  `address` varchar(300) NOT NULL,
  `city` varchar(300) NOT NULL,
  `coupon` varchar(300) NOT NULL,
  `totalPrice` float NOT NULL,
  `shipping` float NOT NULL,
  `products` text NOT NULL,
  `date` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(300) NOT NULL,
  `descr` text NOT NULL,
  `price` float NOT NULL,
  `discount` int(2) NOT NULL,
  `images` text NOT NULL,
  `cat` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `shipping` float NOT NULL,
  `info` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `vote` int(1) NOT NULL,
  `name` varchar(300) NOT NULL,
  `email` varchar(300) NOT NULL,
  `img` varchar(300) NOT NULL,
  `comment` text NOT NULL,
  `product` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `ac` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `settings` (
  `title` varchar(300) NOT NULL,
  `googlea` text NOT NULL,
  `fbpixel` text NOT NULL,
  `color` varchar(300) NOT NULL,
  `descr` text NOT NULL,
  `header` text NOT NULL,
  `teles` text NOT NULL,
  `whs` text NOT NULL,
  `messangers` text NOT NULL,
  `logo` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `cats`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `cats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `discounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;