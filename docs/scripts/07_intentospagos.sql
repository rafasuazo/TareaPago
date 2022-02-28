CREATE TABLE `intentospagos` (
    `id` bigint(15) NOT NULL AUTO_INCREMENT,
    `fecha` DATE DEFAULT NULL,
    `cliente` varchar(128) DEFAULT NULL,
    `monto` numeric(13,2) DEFAULT NULL,
    `fechaVencimiento` date DEFAULT NULL,
    `estado` enum('ENV', 'PGD', 'CNL', 'ERR') DEFAULT NULL,
    PRIMARY KEY(`id`)
)