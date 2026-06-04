RENAME TABLE `billing` TO `maintenance`;
RENAME TABLE `bills` TO `maintenance_items`;

ALTER TABLE `maintenance_items` CHANGE `billing_id` `maintenance_id` int(30) NOT NULL;
