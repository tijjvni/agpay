<?php

require_once 'config\Database.php';
require_once 'App\models\Currency.php';

class CurrencyModelTest extends PHPUnit\Framework\TestCase
{
    private $db;
    private $model;

    public function setUp() : void {
        $this->db = new Database;
        $this->model = new Currency($this->db->connect());
    }

    public function testCreateCurrency() {
        $currency = $this->model;

        $currency->iso_code = 'NGN';
        $currency->iso_numeric_code = '566';
        $currency->common_name = 'Nigerian naira';
        $currency->official_name = 'Nigerian naira';
        $currency->symbol = '₦';
        
        $currency->delete();
        $currency->create();
        $addedCurrency = $currency->get_one();

        $this->assertEquals($currency->iso_code,$addedCurrency['iso_code']);
        $this->assertEquals($currency->iso_numeric_code,$addedCurrency['iso_numeric_code']);
        $this->assertEquals($currency->common_name,$addedCurrency['common_name']);
        $this->assertEquals($currency->official_name,$addedCurrency['official_name']);
        $this->assertEquals($currency->symbol,$addedCurrency['symbol']);
    }

    public function testUpdateCurrency() {
        $currency = $this->model;

        $currency->iso_code = 'NGN';
        $currency->iso_numeric_code = '566';
        $currency->common_name = 'Nigerian naira';
        $currency->official_name = 'Nigerian naira';
        $currency->symbol = '₦';
        
        $currency->delete();
        $currency->create();
        $addedCurrency = $currency->get_one();

        $currency->common_name = 'Naira';
        $currency->update();

        $this->assertNotEquals($currency->common_name,$addedCurrency['common_name']);
        
    }

    public function testGetCurrencies() {
        $currency = $this->model;

        $currency->iso_code = 'NGN';
        $currency->iso_numeric_code = '566';
        $currency->common_name = 'Nigerian naira';
        $currency->official_name = 'Nigerian naira';
        $currency->symbol = '₦';
        
        $currency->delete();
        $currency->create();

        $currency->iso_code = 'GHC';
        $currency->iso_numeric_code = '567';
        $currency->common_name = 'Ghana Cedis';
        $currency->official_name = 'Ghana Cedis';
        $currency->symbol = 'GHC';
        
        $currency->delete();
        $currency->create();


        $this->assertGreaterThan(1,$currency->rowCount());
        
    }

    public function testSearchCurrency() {
        $currency = $this->model;

        $currency->iso_code = 'NGN';
        $currency->iso_numeric_code = '566';
        $currency->common_name = 'Nigerian naira';
        $currency->official_name = 'Nigerian naira';
        $currency->symbol = '₦';
        
        $currency->delete();
        $currency->create();

        $currency->search = 'Naira';
        $currency->search();

        $this->assertGreaterThan(0,$currency->rowCount());
        
    }
}
