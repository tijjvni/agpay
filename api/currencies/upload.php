<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Currency.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate currency opbject
  $currency = new Currency($db);

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
  if (!empty($data['currencies']['name']) && in_array($data['currencies']['type'], $fileMimes)){

    // Open uploaded currency file with read-only mode
    $csvFile = fopen($data['currencies']['tmp_name'], 'r');

    // Skip the first line
    fgetcsv($csvFile);

    // loop through 
    while (($getData = fgetcsv($csvFile, 10000, ",")) !== FALSE)
    {

      try {

        // Get current row data
        $iso_code = $getData[0];
        $iso_numeric_code = $getData[1];
        $common_name = $getData[2];
        $official_name = $getData[3];
        $symbol = $getData[4];

        // set properties in currency model
        $currency->iso_code = $iso_code;
        $currency->symbol = $symbol;
        $currency->iso_numeric_code = $iso_numeric_code;
        $currency->common_name = $common_name;
        $currency->official_name = $official_name;

        
        // check if currency exists update else create        
        if($currency->get_one()){
          $currency->update();
          $_SESSION["message"] = "Currencies updated successfully."; 
        }else {
          $currency->create();
          $_SESSION["message"] = "Currencies uploaded successfully.";      
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
    // Set session variables
    header('Location: ' . $_SERVER['HTTP_REFERER']);
  
  } else {
    echo json_encode(
      array('message' => 'Invalid file upload')
    );    
  }
