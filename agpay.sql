

-- CREATE Database agpay_task;

-- USE agpay_task;


-- --------------------------------------------------------

--
-- Table structure for table countries
--

CREATE TABLE countries (
  id serial PRIMARY KEY,
  continent_code VARCHAR (5) NOT NULL,
  currency_code VARCHAR (5) NOT NULL,
  iso2_code VARCHAR (5) NOT NULL,
  iso3_code VARCHAR (5) NOT NULL,
  iso_numeric_code VARCHAR (5) DEFAULT NULL,
  fis_code VARCHAR (5) NOT NULL,
  calling_code INT NOT NULL,
  common_name VARCHAR (50) NOT NULL,
  official_name VARCHAR (50) NOT NULL,
  endonym VARCHAR (50) NOT NULL,
  demonym VARCHAR (50) NOT NULL
);

--
-- Table structure for table currencies
--

CREATE TABLE currencies (
  id serial PRIMARY KEY,
  iso_code VARCHAR (5) UNIQUE  NOT NULL,
  iso_numeric_code VARCHAR (5) NOT NULL,
  common_name VARCHAR (50) NOT NULL,
  official_name VARCHAR (50) NOT NULL,
  symbol VARCHAR (50) NOT NULL
);


