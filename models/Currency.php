<?php
  class Currency {
    // DB Stuff
    private $conn;
    private $table = 'currencies';

    // Properties
    public $id;
    public $iso_code;
    public $iso_numeric_code;
    public $common_name;
    public $official_name;
    public $symbol;

    public $search;
    public $page = array();



    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;

      $this->page['number'] = 1;
      $this->page['size'] = 15;   

    }

    // Get all currencies
    public function get_all($no_limit=false) {
      // Create query
      $query = 'SELECT
        id,
        iso_code,
        iso_numeric_code,
        common_name,
        official_name,
        symbol
      FROM
        ' . $this->table . '
      ORDER BY
        iso_code ASC';

      $query .= ($no_limit) ? '' :  ' LIMIT '.($this->page['number'] - 1).','.$this->page['size'];

      // Prepare statement
      $stmt = $this->conn->prepare($query);


      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Currency
    public function get_one(){
      // Create query
      $query = 'SELECT
            id,
            iso_code,
            iso_numeric_code,
            common_name,
            official_name,
            symbol
          FROM
            ' . $this->table . '
        WHERE iso_code = ?
        LIMIT 0,1';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind params
        $stmt->bindParam(1, $this->iso_code);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // check row existance
        if($row){
          // set properties
          $this->id = $row['id'];
          $this->iso_code = $row['iso_code'];
          $this->iso_numeric_code = $row['iso_numeric_code'];
          $this->common_name = $row['common_name'];
          $this->official_name = $row['official_name'];
          $this->symbol = $row['symbol'];

          return $row;
        }

        return false;
    }

    // Create Currency
    public function create() {
      // Create Query
      $query = 'INSERT INTO ' . $this->table . ' SET iso_code = :iso_code, iso_numeric_code = :iso_numeric_code, common_name = :common_name, official_name = :official_name, symbol = :symbol';

      // Prepare Statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->iso_code = htmlspecialchars(strip_tags($this->iso_code));
      $this->iso_numeric_code = htmlspecialchars(strip_tags($this->iso_numeric_code));
      $this->common_name = htmlspecialchars(strip_tags($this->common_name));
      $this->official_name = htmlspecialchars(strip_tags($this->official_name));
      $this->symbol = htmlspecialchars(strip_tags($this->symbol));

      // Bind data
      $stmt-> bindParam(':iso_code', $this->iso_code);
      $stmt-> bindParam(':iso_numeric_code', $this->iso_numeric_code);
      $stmt-> bindParam(':common_name', $this->common_name);
      $stmt-> bindParam(':official_name', $this->official_name);
      $stmt-> bindParam(':symbol', $this->symbol);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: $s.\n", $stmt->error);

      return false;
    }


    // Update Post
    public function update() {
         
        // Create query
        $query = 'UPDATE ' . $this->table . '
                              SET iso_numeric_code = :iso_numeric_code, common_name = :common_name, official_name = :official_name, symbol = :symbol
                              WHERE iso_code = :iso_code';


        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->iso_code = htmlspecialchars(strip_tags($this->iso_code));
        $this->iso_numeric_code = htmlspecialchars(strip_tags($this->iso_numeric_code));
        $this->common_name = htmlspecialchars(strip_tags($this->common_name));
        $this->official_name = htmlspecialchars(strip_tags($this->official_name));
        $this->symbol = htmlspecialchars(strip_tags($this->symbol));

        // Bind data
        $stmt-> bindParam(':iso_code', $this->iso_code);
        $stmt-> bindParam(':iso_numeric_code', $this->iso_numeric_code);
        $stmt-> bindParam(':common_name', $this->common_name);
        $stmt-> bindParam(':official_name', $this->official_name);
        $stmt-> bindParam(':symbol', $this->symbol);

        // Execute query
        if($stmt->execute()) {
          return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;

    }
 
  // Search Currencies
  public function search($no_limit = false) {
    // Create query
    $query = 'SELECT
          id,
          iso_code,
          iso_numeric_code,
          common_name,
          official_name,
          symbol
        FROM
          ' . $this->table . '
        WHERE 
          iso_code LIKE :search 
        OR 
          iso_numeric_code LIKE :search
        OR 
          common_name LIKE :search
        OR 
          official_name LIKE :search
        OR 
          symbol LIKE :search';

      $query .= ($no_limit) ? '' :  ' LIMIT '.($this->page['number'] - 1).','.$this->page['size'];

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // clean data
    $this->search = htmlspecialchars(strip_tags($this->search));

    // Bind Data
    $this->search = '%'.$this->search.'%';

    $stmt-> bindParam(':search', $this->search);

    // Execute query
    if($stmt->execute()) {
      return $stmt;
    }

    // Print error if something goes wrong
    printf("Error: $s.\n", $stmt->error);

    return false;
  }


  public function rowCount(){
    if($this->search){
      return $this->search(true)->rowCount();
    } else {
      return $this->get_all(true)->rowCount();
    }
  }


}
