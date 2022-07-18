<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  // header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: GET');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../../config/Database.php';
  include_once '../../models/Currency.php';



  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate currency object
  $currency = new Currency($db);

  // check page_number
  if(isset($_GET['page']) && !empty($_GET['page']) && is_numeric($_GET['page'])){

    $page = $_GET['page'];
    if($page > round($currency->rowCount()/$currency->page['size']) && $page != 1){
      $page = round($currency->rowCount()/$currency->page['size']);
    }

  } else {
    $page = 1;
  }


  $currency->page['number'] = $page;

  // Cuurency read query
  $result = $currency->get_all();
  
  // Get row count
  $num = $result->rowCount();

    // echo 'tj';die();

  // Check if there is any currencies
  if($num > 0) {
    // Curr array
    $currency_arr = array();
    $currency_arr['data'] = array();

    // loop through fetched currencies
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $curr = array(
        'id' => $id,
        'iso_code' => $iso_code,
        'iso_numeric_code' => $iso_numeric_code,
        'common_name' => $common_name,
        'official_name' => $official_name,
        'symbol' => $symbol
      );

      // Push to "data"
      array_push($currency_arr['data'], $curr);
    }

    $currency_arr['meta'] = paginate($currency->rowCount(),$page,$currency->page['size']);

    echo json_encode($currency_arr);

  } else {
    // No Currencies
    echo json_encode(
      array('message' => 'No Currencies Found')
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



