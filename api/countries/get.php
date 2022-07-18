<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  // header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: GET');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Country.php';



  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate county object
  $country = new Country($db);

  // check page_number
  if(isset($_GET['page']) && !empty($_GET['page']) && is_numeric($_GET['page'])){

    $page = $_GET['page'];
    if($page > round($country->rowCount()/$country->page['size']) && $page != 1){
      $page = round($country->rowCount()/$country->page['size']);
    }

  } else {
    $page = 1;
  }



  $country->page['number'] = $page;

  // Country read query
  $result = $country->get_all();
  
  // Get row count
  $num = $result->rowCount();

  // Check if there is any countries
  if($num > 0) {
    // country array
    $country_arr = array();
    $country_arr['data'] = array();

    // loop through fetched countries
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $countr = array(
        'id' => $id,
        'continent_code' => $continent_code,
        'currency_code' => $currency_code,
        'iso2_code' => $iso2_code,
        'iso3_code' => $iso3_code,
        'iso_numeric_code' => $iso_numeric_code,
        'fis_code' => $fis_code,
        'calling_code' => $calling_code,
        'common_name' => $common_name,
        'official_name' => $official_name,
        'endonym' => $endonym,
        'demonym' => $demonym        
      );

      // Push to "data"
      array_push($country_arr['data'], $countr);
    }

    $country_arr['meta'] = paginate($country->rowCount(),$page,$country->page['size']);

    echo json_encode($country_arr);

  } else {
    // No countries
    echo json_encode(
      array('message' => 'No Country Found')
    );
  }

  function paginate($total, $page = 0, $per_page = 10){

    $self = "page=".$page;

    $first = "page=1";
    $last = "page=".round($total/$per_page);

    $previous = ($page == 1) ? NULL : "page=".($page - 1);
    $next = ($page == $last) ? NULL : "page=".($page + 1);

    // format to JSON meta output
    return array(
      "page" => $page,
      "per_page" => $per_page,
      "total" => $total,
      "links" => array(
        "self" => $self,
        "first" => $first,
        "previous" => $previous,
        "next" => $next,
        "last" => $last
      )
    );
  }



