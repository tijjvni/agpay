<?php

require_once 'config\Database.php';
require_once 'App\models\Country.php';

class CountryModelTest extends PHPUnit\Framework\TestCase
{
    private $db;
    private $model;

    public function setUp() : void {
        $this->db = new Database;
        $this->model = new Country($this->db->connect());
    }

    public function testCreateCountry() {
        $country = $this->model;

        $country->continent_code = 'AF';
        $country->currency_code = 'NGN';
        $country->iso2_code = 'NG';
        $country->iso3_code = 'NGA';
        $country->iso_numeric_code = '566';
        $country->fis_code = 'NI';
        $country->calling_code = '234';
        $country->common_name = 'Nigeria';
        $country->official_name = 'Nigeria';
        $country->endonym = 'Nigeria';
        $country->demonym = 'Nigerian';
        
        $country->delete();
        $country->create();
        $addedCountry = $country->get_one();

        $this->assertEquals($country->continent_code,$addedCountry['continent_code']);
        $this->assertEquals($country->currency_code,$addedCountry['currency_code']);
        $this->assertEquals($country->iso2_code,$addedCountry['iso2_code']);
        $this->assertEquals($country->iso3_code,$addedCountry['iso3_code']);
        $this->assertEquals($country->iso_numeric_code,$addedCountry['iso_numeric_code']);
        $this->assertEquals($country->fis_code,$addedCountry['fis_code']);
        $this->assertEquals($country->calling_code,$addedCountry['calling_code']);
        $this->assertEquals($country->common_name,$addedCountry['common_name']);
        $this->assertEquals($country->official_name,$addedCountry['official_name']);
        $this->assertEquals($country->endonym,$addedCountry['endonym']);
        $this->assertEquals($country->demonym,$addedCountry['demonym']);
    }

    public function testUpdateCountry() {
        $country = $this->model;

        $country->continent_code = 'AF';
        $country->currency_code = 'NGN';
        $country->iso2_code = 'NG';
        $country->iso3_code = 'NGA';
        $country->iso_numeric_code = '566';
        $country->fis_code = 'NI';
        $country->calling_code = '234';
        $country->common_name = 'Nigeria';
        $country->official_name = 'Nigeria';
        $country->endonym = 'Nigeria';
        $country->demonym = 'Nigerian';
        
        
        $country->delete();
        $country->create();
        $addedCountry = $country->get_one();

        $country->common_name = 'Naija';
        $country->update();

        $this->assertNotEquals($country->common_name,$addedCountry['common_name']);
        
    }

    public function testGetCountries() {
        $country = $this->model;

        $country->continent_code = 'AF';
        $country->currency_code = 'NGN';
        $country->iso2_code = 'NG';
        $country->iso3_code = 'NGA';
        $country->iso_numeric_code = '566';
        $country->fis_code = 'NI';
        $country->calling_code = '234';
        $country->common_name = 'Nigeria';
        $country->official_name = 'Nigeria';
        $country->endonym = 'Nigeria';
        $country->demonym = 'Nigerian'; 
        
        $country->delete();
        $country->create();


        $country->continent_code = 'AF';
        $country->currency_code = 'GHC';
        $country->iso2_code = 'GH';
        $country->iso3_code = 'GHA';
        $country->iso_numeric_code = '567';
        $country->fis_code = 'GH';
        $country->calling_code = '233';
        $country->common_name = 'Ghana';
        $country->official_name = 'Ghana';
        $country->endonym = 'Ghana';
        $country->demonym = 'Ghanaian';
        
        $country->delete();
        $country->create();

        $this->assertGreaterThan(1,$country->rowCount());
        
    }

    public function testSearchCountry() {
        $country = $this->model;

        $country->continent_code = 'AF';
        $country->currency_code = 'GHC';
        $country->iso2_code = 'GH';
        $country->iso3_code = 'GHA';
        $country->iso_numeric_code = '567';
        $country->fis_code = 'GH';
        $country->calling_code = '233';
        $country->common_name = 'Ghana';
        $country->official_name = 'Ghana';
        $country->endonym = 'Ghana';
        $country->demonym = 'Ghanaian';
        
        $country->delete();
        $country->create();

        $country->search = 'Gh';
        $country->search();

        $this->assertGreaterThan(0,$country->rowCount());
        
    }
}
