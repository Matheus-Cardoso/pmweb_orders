
/* OUTPUT FOR "SHOW CREATE TABLE PRODUCT OWNER" */

CREATE TABLE `product_order` (
 `order_id` int(10) unsigned NOT NULL COMMENT 'order id ',
 `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'timestamp for dealing with different time zones',
 `product_sku` bigint(20) NOT NULL COMMENT 'product identification number',
 `SIZE` char(2) NOT NULL COMMENT 'size(numerical, U, PP, P, M, G, GG, XG, XX) ',
 `color` char(25) NOT NULL COMMENT 'product color',
 `quantity` int(11) NOT NULL DEFAULT '1' COMMENT 'at least one item per product, maximum quantity for order not specified',
 `price` decimal(12,2) NOT NULL COMMENT 'order price (10 digits for decimal part, 2 to fractional '
)