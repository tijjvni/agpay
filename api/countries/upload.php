<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Country.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate country opbject
  $country = new Country($db);

  // Get raw posted data
  $data = $_FILES;

  // Allowable MIME types
 $fileMimes = array(
      'text/x-comma-separated-values',
      'text/comma-separated-values',
      'application/octet-stream',
      'application/vnd.ms-excel',
      'application/x-csv',
      'text/x-csv',
      'text/csv',
      'application/csv',
      'application/excel',
      'application/vnd.msexcel',
  );

  // check if file is not empty and type is allowable
  if (!empty($data['countries']['name']) && in_array($data['countries']['type'], $fileMimes)){

    // Open uploaded country file with read-only mode
    $csvFile = fopen($data['countries']['tmp_name'], 'r');

    // Skip the first line

    // print_r($csvFile);die();

    // loop through 
    while (($getData = fgetcsv($csvFile, 10000, ",")) !== FALSE)
    {

      try {

        // Get current row data
        $continent_code = $getData[0];
        $currency_code = $getData[1];
        $iso2_code = $getData[2];
        $iso3_code = $getData[3];
        $iso_numeric_code = $getData[4];
        $fis_code = $getData[5];
        $calling_code = $getData[6];
        $common_name = $getData[7];
        $official_name = $getData[8];
        $endonym = $getData[9];
        $demonym = $getData[10];

        // set properties in country model
        $country->continent_code = $continent_code;
        $country->currency_code = $currency_code;
        $country->iso2_code = $iso2_code;
        $country->iso3_code = $iso3_code;
        $country->iso_numeric_code = $iso_numeric_code;
        $country->fis_code = $fis_code;
        $country->calling_code = $calling_code;
        $country->common_name = $common_name;
        $country->official_name = $official_name;
        $country->endonym = $endonym;
        $country->demonym = $demonym;



        // check if country exists update else create 

        if($country->get_one()){
          $country->update();
          $_SESSION["message"] = "Countries updated successfully."; 
        }else {
          $country->create();
          $_SESSION["message"] = "Countries uploaded successfully.";      
        }
        
      } catch (Exception $e) {
        echo json_encode(
          array(
            'error' => 'error',
            'message' => 'Invalid file upload'
          )
        );        
      }

    }

    // Close opened CSV file
    fclose($csvFile);

    // Redirect back
    header('Location: ' . $_SERVER['HTTP_REFERER']);
  
  } else {
    echo json_encode(
      array('message' => 'Invalid file upload')
    );    
  }
