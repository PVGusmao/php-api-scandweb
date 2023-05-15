CREATE TABLE product (
    id int NOT NULL AUTO_INCREMENT PRIMARY_KEY,
    sku VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    price double NOT NULL,
    type VARCHAR(255) NOT NULL,
    attribute VARCHAR(255) NOT NULL,
);
