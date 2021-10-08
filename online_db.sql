-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2021 at 03:19 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `identity_num` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `user_id`, `identity_num`) VALUES
(1, 'jawwad', 1, 'nvwsl'),
(3, 'muntaha', 5, 'k/1qm');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_id` int(11) NOT NULL,
  `cat_title` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `cat_title`) VALUES
(1, 'Drinks'),
(7, 'Starters'),
(8, 'Dessert'),
(9, 'Main Dish');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mobile_number` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `identity_num` char(5) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(20) NOT NULL,
  `zipcode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `username`, `user_id`, `mobile_number`, `email`, `identity_num`, `address`, `city`, `zipcode`) VALUES
(1, 'mimo', 2, '65413', 'moumy@hotmail.com', 'ymjl3', 'House no. 5, Farmgate', 'Dhaka', 1256),
(8, 'aysha', 18, '141561', 'aysha@gmail.com', '18rc2', '', 'Dhaka', 0),
(9, 'tarin', 21, '216351', 'tarin@gmail.com', 'qhlu5', 'Mirpur, Road no. 12', 'Dhaka', 1289),
(10, 'zinan', 23, '35131', 'zinan@gmail.com', 'a7qst', 'New Dhanmondi', 'Dhaka', 563),
(11, 'shakib', 24, '31531', 'shakib@yahoo.com', '8jk$/', '', 'Dhaka', 0);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_man`
--

CREATE TABLE `delivery_man` (
  `driver_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `mobile_number` varchar(20) NOT NULL,
  `identity_num` char(5) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(20) NOT NULL,
  `salary` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `delivery_man`
--

INSERT INTO `delivery_man` (`driver_id`, `user_id`, `name`, `mobile_number`, `identity_num`, `address`, `city`, `salary`) VALUES
(2, 7, 'Rafi Ahmed', '563241', 'rdq2y', 'Cox Bazar', 'Dhaka', 25000),
(6, 20, 'Sunny Beaudalaire', '123541', 'ckfq)', '', 'Dhaka', 10000),
(7, 22, 'Tommy Lauren', '51332', '1u)i7', '', '', 10000);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `food_quality` varchar(256) NOT NULL,
  `suggestion` varchar(256) NOT NULL,
  `service` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `cust_id`, `food_quality`, `suggestion`, `service`) VALUES
(1, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla tempor ipsum in dui convallis, non dapibus purus ornare.', 'Sed condimentum, dolor eget tincidunt condimentum, arcu arcu posuere odio, at aliquet ex eros at augue.', 'Excellent food. Menu is extensive and seasonal to a particularly high standard. Definitely fine dining. It can be expensive but worth it and they do different deals on different nights so it’s worth checking them out before you book. Highly recommended.'),
(2, 8, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque volutpat ligula dui, eget congue orci malesuada sed.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque volutpat ligula dui, eget congue orci malesuada sed.', 'This place is great! The atmosphere is chill and cool but the staff is also really friendly. They know what they’re doing and what they’re talking about, and you can tell making the customers happy is\r\ntheir main priority. Food is pretty good.'),
(3, 11, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque volutpat ligula dui, eget congue orci malesuada sed.\',\'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque volutpat ligula dui, eget congue orci malesuada sed.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque volutpat ligula dui, eget congue orci malesuada sed.\',\'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque volutpat ligula dui, eget congue orci malesuada sed.', 'We are so fortunate to have this place just a few minutes drive away from home. Food is stunning, both the tapas and downstairs restaurant. Cocktails wow, wine great and lovely selection of beers. Love this place and will continue to visit.'),
(5, 9, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque volutpat ligula dui, eget congue orci malesuada sed.\',\'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque volutpat ligula dui, eget congue orci malesuada sed.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque volutpat ligula dui, eget congue orci malesuada sed.\',\'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque volutpat ligula dui, eget congue orci malesuada sed.', 'The most amazing food ever! And also the staff is so nice to everyone. I highly recommend buying food from here. The best pizza ever.'),
(6, 10, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque volutpat ligula dui, eget congue orci malesuada sed.\',\'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque volutpat ligula dui, eget congue orci malesuada sed.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque volutpat ligula dui, eget congue orci malesuada sed.\',\'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque volutpat ligula dui, eget congue orci malesuada sed.', 'My husband and I had our Anniversary dinner at the Fairway last night. We sat outside on the terrace which was very pretty and private. Our waitress was wonderful and the food was absolutely delicious!! It could not have been more spectacular! ');

-- --------------------------------------------------------

--
-- Table structure for table `food_items`
--

CREATE TABLE `food_items` (
  `food_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `food_name` varchar(20) NOT NULL,
  `food_image` text NOT NULL,
  `food_price` double NOT NULL,
  `description` varchar(150) NOT NULL,
  `short_description` varchar(50) NOT NULL,
  `keywords` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `food_items`
--

INSERT INTO `food_items` (`food_id`, `quantity`, `category_id`, `food_name`, `food_image`, `food_price`, `description`, `short_description`, `keywords`) VALUES
(3, 20, 7, 'Potato Wedges', 'images/items/wedges.jpg', 300, 'Potato Wedges is everyone\'s favorite Snacks. Its inside is full of purr, so it\'s tasty to eat.', 'Potato Wedges is everyone\'s favorite Snacks. Its i', 'starters,meal'),
(4, 5, 8, 'Red Velvet Cake', 'images/items/dessert-1.jpg', 790, 'Is a Red Velvet Cake Just a Chocolate Cake? It\'s a much lighter chocolate cake with a tangy note from the cream cheese frosting.', 'Is a Red Velvet Cake Just a Chocolate Cake? It\'s a', 'ice cream,cake,dessert,cone'),
(5, 35, 9, 'Chicken Egg Ramen', 'images/items/Side6.jpg', 420, 'Japanese style ramen mixed with boiled eggs and chicken', 'Japanese style ramen with boiled eggs and chicken', 'fish,main dish,ramen,chicken'),
(6, 5, 1, 'Mango Juice', 'images/items/drink1.png', 250, 'Fresh Mango Drinks served with ice', 'Fresh Mango Drinks served with ice', 'drinks,juice'),
(7, 5, 1, 'Lemonade', 'images/items/Drink3.jpg', 350, 'Fresh Lemonade served with ice', 'Fresh Lemonade served with ice', 'drinks,juice,lemonade'),
(8, 20, 1, 'Strawberry Juice', 'images/items/Drink2.jpg', 300, 'Fresh Strawberry Juice served with ice', 'Fresh Strawberry Juice served with ice', 'drinks,juice,strawberry'),
(9, 25, 1, 'Orange Juice', 'images/items/Drink10.jpg', 200, 'Fresh Orange Juice served with ice', 'Fresh Orange Juice served with ice', 'drinks,juice,orange'),
(10, 18, 1, 'Cold Coffee', 'images/items/Drink5.jpg', 200, 'Sweet Delicious Cold Coffee with melting chocolate.', 'Sweet Delicious Cold Coffee with melting chocolate', 'drinks,juice,cofee'),
(12, 15, 1, 'Avocado Juice', 'images/items/Drink6.jpg', 230, 'Fresh Avacado served with ice.', 'Fresh Avacado served with ice.', 'drinks,juice,avocado'),
(13, 5, 7, 'Mix Fried Rice', 'images/items/Start1.jpg', 350, 'Fried Rice containing juicy chicken with seasoned vegetables', 'Fried Rice containing juicy chicken with seasoned ', 'starters,meal,vege,chicken'),
(14, 20, 7, 'Chicken Soup', 'images/items/Start2.jpg', 280, 'Bits of chicken mixed with thick Thai soup', 'Bits of chicken mixed with thick Thai soup', 'starters,meal,soup,chicken'),
(15, 30, 7, 'Beef Porata', 'images/items/Start4.jpg', 230, 'Delicious Juicy Beef with a huge Porata that will certainly make your day', 'Delicious Juicy Beef with a huge Porata that will ', 'starters,meal,beef,porata'),
(16, 12, 7, 'Vegetable Ramen', 'images/items/Start6.jpg', 350, 'Soup with white noodles and a mixture of vegetables', 'Soup with white noodles and a mixture of vegetable', 'starters,meal,ramen,vegetable'),
(17, 35, 7, 'American French Fry', 'images/items/french.jpg', 98, 'Thinly sliced potatoes are deep-fried till they\'re crisp on all sides and then sprinkled with salt, pepper or really any seasoning of your choice.', 'Thinly sliced potatoes are deep-fried till they\'re', 'starters,meal,fish'),
(18, 25, 8, 'Vanilla Ice-cream', 'images/items/Deser3.jpg', 350, 'Triple Scoped Vanilla Ice-cream which is sure to melt in your mouth', 'Triple Scoped Vanilla Ice-cream which is sure to m', 'dessert,ice-cream,vanilla'),
(19, 10, 8, 'Blackberry Cake', 'images/items/dessert-4.jpg', 290, 'Swirling blueberry puree into cheesecake batter isn\'t only beautiful, it\'s extremely delicious.', 'Swirling blueberry puree into cheesecake batter is', 'dessert,cupcake'),
(20, 35, 8, 'Chocolate Ice-cream', 'images/items/Desert4.jpg', 260, 'Double Scoped Chocolate Ice-cream which is sure to melt in your mouth', 'Double Scoped Chocolate Ice-cream which is sure to', 'dessert,ice-cream,chocolate'),
(21, 25, 8, 'Hot Pancakes ', 'images/items/dessert-2.jpg', 490, 'Bee sweet to your family with delicious honey pancakes! They\'ll love the honey-cinnamon syrup, too.', 'Bee sweet to your family with delicious honey panc', 'dessert,strawberry,cake'),
(22, 10, 8, 'Chocolate Muffin', 'images/items/Desert10.jpg', 890, 'Fruitcake is really just like any other quick bread or loaf cake, only with a lot more fruit and nuts added.', 'Fruitcake is really just like any other quick brea', 'dessert,cake'),
(23, 20, 9, 'BBQ Pizza', 'images/items/image_3.jpg', 350, 'A massive pizza suitable enough to enjoy with your whole family', 'A massive pizza suitable enough to enjoy with your', 'main dish,platter,rice,noodle'),
(24, 5, 9, 'Shrimp platter', 'images/items/side11.jpg', 200, 'Two massive chewy Shrimp combined with soup', 'Two massive chewy Shrimp combined with soup', 'main dish,platter,shrimp'),
(25, 5, 9, 'Grilled Beaf', 'images/items/dish-2.jpg', 290, 'Enjoy these grilled beef steaks sprinkled with salt and pepper that’s ready in just 20 minutes – perfect for a dinner.', 'Enjoy these grilled beef steaks sprinkled with sal', 'main dish,platter,vegetables'),
(26, 25, 9, 'Chicken Platter with', 'images/items/chicken.jpg', 390, 'Enjoy these grilled chicken steaks sprinkled with salt and pepper that’s ready in just 20 minutes – perfect for a dinner', 'Enjoy these grilled chicken steaks sprinkled with', 'main dish,platter,chicken'),
(27, 20, 9, 'Fish Platter', 'images/items/Side5.jpg', 800, 'A huge serving of juicy fish of various kinds', 'A huge serving of juicy fish of various kinds', 'main dish,platter,fish'),
(28, 20, 7, 'Naga Wings', 'images/items/Wings.jpeg', 385, 'Naga wings barre', 'Naga wings barre', 'starters,wings');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `identify_num` char(5) NOT NULL,
  `cus_id` int(11) NOT NULL,
  `cus_name` varchar(20) NOT NULL,
  `cus_email` varchar(50) NOT NULL,
  `order_date` datetime NOT NULL,
  `order_pin_code` text NOT NULL,
  `total_amount` double NOT NULL,
  `total_quantity` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `delivery_status` varchar(30) NOT NULL,
  `driver_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `identify_num`, `cus_id`, `cus_name`, `cus_email`, `order_date`, `order_pin_code`, `total_amount`, `total_quantity`, `status`, `transaction_id`, `delivery_status`, `driver_id`) VALUES
(1, 'mcq2e', 1, 'Moumy Kabir', 'moumy@hotmail.com', '2021-05-30 17:01:06', 'bsrh3ovy', 3030, 9, 'Success', 'TYISHL-SSLCZ_TEST_60b3a8b73f321', 'On The Way', 6),
(2, 'n$qz1', 1, 'Moumy Kabir', 'moumy@hotmail.com', '2021-05-30 17:08:49', 'ab1d402i', 1480, 3, 'Success', 'TYISHL-SSLCZ_TEST_60b3aa83899fe', 'Not Assigned', 0),
(3, 'awhp2', 1, 'Moumy Kabir', 'moumy@hotmail.com', '2021-05-30 18:02:22', '6cuslax(', 2310, 7, 'Canceled', 'TYISHL-SSLCZ_TEST_60b3b712f07ab', 'On The Way', 6),
(4, '0ca3u', 1, 'Moumy Kabir', 'moumy@hotmail.com', '2021-05-31 17:19:34', '1dp7tyql', 2690, 6, 'Success', 'TYISHL-SSLCZ_TEST_60b4fe8f00b21', 'Delivered', 6),
(5, 'qc17y', 1, 'Moumy Kabir', 'moumy@hotmail.com', '2021-06-01 18:12:23', '7jlqa02m', 1550, 4, 'Pending', 'TYISHL-SSLCZ_TEST_60b65c6ee23f7', 'Not Assigned', 0),
(6, '1w68/', 1, 'Moumy Kabir', 'moumy@hotmail.com', '2021-06-01 18:14:22', '/s1wpx7c', 1900, 5, 'Success', 'TYISHL-SSLCZ_TEST_60b65ce0ec764', 'Delivered', 6);

-- --------------------------------------------------------

--
-- Table structure for table `payment_details`
--

CREATE TABLE `payment_details` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `cus_id` int(11) NOT NULL,
  `payment_type` varchar(100) NOT NULL,
  `receipt_number` varchar(255) NOT NULL,
  `receipt_date` datetime NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `transaction_date` varchar(255) NOT NULL,
  `bank_transaction_id` varchar(255) NOT NULL,
  `paid_amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_details`
--

INSERT INTO `payment_details` (`payment_id`, `order_id`, `cus_id`, `payment_type`, `receipt_number`, `receipt_date`, `transaction_id`, `transaction_date`, `bank_transaction_id`, `paid_amount`) VALUES
(1, 1, 1, 'BKASH-BKash', 'mcq2e', '2021-05-30 17:01:06', 'TYISHL-SSLCZ_TEST_60b3a8b73f321', '2021-05-30 21:01:11', '2105302101141xCY4ckh4ubGWJ0', 3030),
(2, 2, 1, 'BKASH-BKash', 'n$qz1', '2021-05-30 17:08:49', 'TYISHL-SSLCZ_TEST_60b3aa83899fe', '2021-05-30 21:08:51', '210530210856xK8BSwvNuqzt7Fs', 1480),
(3, 3, 1, 'BKASH-BKash', 'awhp2', '2021-05-30 18:02:22', 'TYISHL-SSLCZ_TEST_60b3b712f07ab', '2021-05-30 22:02:27', '2105302203420zB3Bl9E92llf58', 2310),
(4, 4, 1, 'BKASH-BKash', '0ca3u', '2021-05-31 17:19:34', 'TYISHL-SSLCZ_TEST_60b4fe8f00b21', '2021-05-31 21:19:43', '210531212010IP6GnDdYC2aeMpa', 2690),
(5, 6, 1, 'BKASH-BKash', '1w68/', '2021-06-01 18:14:22', 'TYISHL-SSLCZ_TEST_60b65ce0ec764', '2021-06-01 22:14:24', '2106012214340agaBLtL4cC9Dgw', 1900);

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `booking_id` int(11) NOT NULL,
  `cust_id` int(11) NOT NULL,
  `cust_name` varchar(20) NOT NULL,
  `mobile_number` varchar(20) NOT NULL,
  `persons_reserved` int(11) NOT NULL,
  `reservation_date` date NOT NULL,
  `reservation_time` time NOT NULL,
  `message` varchar(100) DEFAULT NULL,
  `reserve_pin_code` text NOT NULL,
  `status` varchar(20) NOT NULL,
  `identify_num` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`booking_id`, `cust_id`, `cust_name`, `mobile_number`, `persons_reserved`, `reservation_date`, `reservation_time`, `message`, `reserve_pin_code`, `status`, `identify_num`) VALUES
(2, 1, 'Moumy Kabir', '65413', 5, '2021-05-08', '18:45:00', 'I hope you will provide good service', 'ym3k/rnv', 'success', 'I98Hg'),
(4, 1, 'Moumy Kabir', '65413', 4, '2021-06-03', '13:30:00', 'Hoping the lunch will be amazing!', 'nq1hvgui', 'pending', 'pwr/$'),
(5, 1, 'Moumy Kabir', '65413', 5, '2021-05-11', '10:15:00', 'ghvvyhfgcg', 'ygj68t0z', 'success', 'vgf60'),
(6, 1, 'Moumy Kabir', '65413', 8, '2021-05-27', '12:59:00', '', ')e2/a(y5', 'success', 'fpo$)'),
(7, 1, 'Moumy Kabir', '65413', 6, '0000-00-00', '08:30:00', 'taste', '1xy)r(6s', 'success', 'f/tc2'),
(8, 1, 'Moumy Kabir', '65413', 5, '0000-00-00', '12:00:00', 'Taste', 'gvx79u)c', 'success', 'j5b$n');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_role` char(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(256) NOT NULL,
  `user_image` text NOT NULL,
  `date_of_birth` date NOT NULL,
  `identity_num` char(5) NOT NULL,
  `token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_role`, `name`, `username`, `user_email`, `user_password`, `user_image`, `date_of_birth`, `identity_num`, `token`) VALUES
(1, 'admin', 'Mohammed Jawwadul Islam', 'jawwad', 'sky@gmail.com', '$2y$10$tBGIVoaq6a8Nre0cV6nSKeI4q6juvrAt9JnQQ6vCDV5jVSKwiIOjy', 'images/jawwad.jpg', '2018-02-13', 'nvwsl', ''),
(2, 'customer', 'Moumy Kabir', 'mimo', 'moumy@hotmail.com', '$2y$10$i.d6rE/YPWS08vnRlDB.OuV3L.08Yf.O5RKXEyjT4jiYbG28g7Ire', 'images/people16.jpg', '2016-02-17', 'ymjl3', ''),
(5, 'admin', 'Sayeda Muntaha', 'muntaha', 'sayeda@gmail.com', '$2y$10$.X7bi8d9WWzJZmoC4wITmeKwiOgXa/IVtWcx.WUB41MAKUMPw/Y3S', 'images/muntaha.jpg', '2016-02-25', 'k/1qm', ''),
(7, 'driver', 'Rafi Ahmed', 'rafiAh', 'rafi@gmail.com', '$2y$10$BGs/zTaEgEO6L0u400NfKeg3OAEF97FWIvFOBFSy4C392NHs98d1.', 'images/people3.jpg', '2017-01-27', 'rdq2y', ''),
(18, 'customer', 'Aysha Siddika', 'aysha', 'aysha@gmail.com', '$2y$10$/a7OR8TMPdCo5OQNThdobuY1e8tlU0l5SihnqNZwFfYPXnZjneJmm', 'images/people5.jpg', '2021-04-20', '18rc2', ''),
(20, 'driver', 'Sunny Beaudalaire', 'sunny', 'sunny@hotmail.com', '$2y$10$anTSm39VNxo6qYDyLOILheiyKD9fS5g1LnJeY6.zJueYZoxIb6tC.', 'images/people11.jpg', '2014-08-21', 'ckfq)', 'Token used'),
(21, 'customer', 'Nafisa Akhter', 'tarin', 'tarin@gmail.com', '$2y$10$NJeVBPuK..nxSKXTCFIYOuzjKZgKZcrHunUfz0IkjfClxxOt9EeWO', 'images/people13.jpg', '2017-06-27', 'qhlu5', ''),
(22, 'driver', 'Tommy Lauren', 'tom', 'tommy@gmail.com', '$2y$10$7/XfqQNe9bXBYAjuypyLauGibheARCC3DaZLw5qjuFfxAdl79dObG', 'images/people14.jpg', '2021-04-16', '1u)i7', ''),
(23, 'customer', 'Zinan Moushi', 'zinan', 'zinan@gmail.com', '$2y$10$.HjWHKbY89/xaQY2lTS.1uhJe90zTOsj1/V3zgpAPYuzU2AQAkqAS', 'images/people25.jpg', '0000-00-00', 'a7qst', ''),
(24, 'customer', 'Shakib Al Hasan', 'shakib', 'shakib@yahoo.com', '$2y$10$AZMFmUc.0UpIbrWSAslpn.5NWlnbeR7wnlmuENZKjWx40basOWyv2', 'images/people18.jpg', '0000-00-00', '8jk$/', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `uk2` (`username`,`identity_num`),
  ADD KEY `fk1` (`user_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `uk3` (`username`,`email`,`identity_num`),
  ADD KEY `fk2` (`user_id`);

--
-- Indexes for table `delivery_man`
--
ALTER TABLE `delivery_man`
  ADD PRIMARY KEY (`driver_id`),
  ADD UNIQUE KEY `uk4` (`identity_num`),
  ADD KEY `fk3` (`user_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `fk5` (`cust_id`);

--
-- Indexes for table `food_items`
--
ALTER TABLE `food_items`
  ADD PRIMARY KEY (`food_id`),
  ADD KEY `fk7` (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk9` (`cus_id`);

--
-- Indexes for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `fk11` (`cus_id`),
  ADD KEY `fk12` (`order_id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `fk6` (`cust_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `uk1` (`username`,`user_email`,`identity_num`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `delivery_man`
--
ALTER TABLE `delivery_man`
  MODIFY `driver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `food_items`
--
ALTER TABLE `food_items`
  MODIFY `food_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payment_details`
--
ALTER TABLE `payment_details`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `fk1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `fk2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `delivery_man`
--
ALTER TABLE `delivery_man`
  ADD CONSTRAINT `fk3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `fk5` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE;

--
-- Constraints for table `food_items`
--
ALTER TABLE `food_items`
  ADD CONSTRAINT `fk7` FOREIGN KEY (`category_id`) REFERENCES `category` (`cat_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk9` FOREIGN KEY (`cus_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD CONSTRAINT `fk11` FOREIGN KEY (`cus_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk12` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `fk6` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
