USE signup_db;

CREATE TABLE users_information (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(62) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  first_name VARCHAR(50) NOT NULL,
  last_name VARCHAR(50) NOT NULL,
  datepicker VARCHAR(20) NOT NULL, 
  city VARCHAR(50) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  postal_code VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL
);

ALTER TABLE users_information ADD COLUMN address VARCHAR(255) NOT NULL AFTER last_name;
