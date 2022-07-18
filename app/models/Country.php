<?php
  class Country {
    // DB Stuff
    private $conn;
    private $table = 'countries';

    // Properties
    public $id;
    public $continent_code;
    public $currency_code;
    public $iso2_code;
    public $iso3_code;
    public $iso_numeric_code;
    public $fis_code;
    public $calling_code;
    public $common_name;
    public $official_name;
    public $endonym;
    public $demonym;

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
        continent_code,
        currency_code,
        iso2_code,
        iso3_code,
        iso_numeric_code,
        fis_code,
        calling_code,
        common_name,
        official_name,
        endonym,
        demonym
      FROM
        ' . $this->table . '
      ORDER BY
        iso3_code ASC';

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
        continent_code,
        currency_code,
        iso2_code,
        iso3_code,
        iso_numeric_code,
        fis_code,
        calling_code,
        common_name,
        official_name,
        endonym,
        demonym
          FROM
            ' . $this->table . '
        WHERE iso3_code = ?
        LIMIT 0,1';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind params
        $stmt->bindParam(1, $this->iso3_code);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // check row existance
        if($row){
          // set properties
          $this->id = $row['id'];
          $this->continent_code = $row['continent_code'];
          $this->currency_code = $row['currency_code'];
          $this->iso2_code = $row['iso2_code'];
          $this->iso3_code = $row['iso3_code'];
          $this->iso_numeric_code = $row['iso_numeric_code'];
          $this->fis_code = $row['fis_code'];
          $this->calling_code = $row['calling_code'];
          $this->common_name = $row['common_name'];
          $this->official_name = $row['official_name'];
          $this->endonym = $row['endonym'];
          $this->demonym = $row['demonym'];

          return $row;
        }

        return false;
    }

    // Create Currency
    public function create() {
      // Create Query
      $query = 'INSERT INTO ' . $this->table . ' SET continent_code = :continent_code, currency_code = :currency_code, iso2_code = :iso2_code, iso3_code = :iso3_code, iso_numeric_code = :iso_numeric_code, fis_code = :fis_code, calling_code = :calling_code, common_name = :common_name, official_name = :official_name, endonym = :endonym,  demonym = :demonym';

      // Prepare Statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->continent_code = htmlspecialchars(strip_tags($this->continent_code));
      $this->currency_code = htmlspecialchars(strip_tags($this->currency_code));
      $this->iso2_code = htmlspecialchars(strip_tags($this->iso2_code));
      $this->iso3_code = htmlspecialchars(strip_tags($this->iso3_code));
      $this->iso_numeric_code = htmlspecialchars(strip_tags($this->iso_numeric_code));
      $this->fis_code = htmlspecialchars(strip_tags($this->fis_code));
      $this->calling_code = htmlspecialchars(strip_tags($this->calling_code));
      $this->common_name = htmlspecialchars(strip_tags($this->common_name));
      $this->official_name = htmlspecialchars(strip_tags($this->official_name));
      $this->endonym = htmlspecialchars(strip_tags($this->endonym));
      $this->demonym = htmlspecialchars(strip_tags($this->demonym));

      // Bind data
      $stmt-> bindParam(':continent_code', $this->continent_code);
      $stmt-> bindParam(':currency_code', $this->currency_code);
      $stmt-> bindParam(':iso2_code', $this->iso2_code);
      $stmt-> bindParam(':iso3_code', $this->iso3_code);
      $stmt-> bindParam(':iso_numeric_code', $this->iso_numeric_code);
      $stmt-> bindParam(':fis_code', $this->fis_code);
      $stmt-> bindParam(':calling_code', $this->calling_code);
      $stmt-> bindParam(':common_name', $this->common_name);
      $stmt-> bindParam(':official_name', $this->official_name);
      $stmt-> bindParam(':endonym', $this->endonym);
      $stmt-> bindParam(':demonym', $this->demonym);

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
        $query = 'UPDATE ' . $this->table . 
                  ' SET continent_code = :continent_code, currency_code = :currency_code, iso2_code = :iso2_code, iso_numeric_code = :iso_numeric_code, fis_code = :fis_code, calling_code = :calling_code, common_name = :common_name, official_name = :official_name, endonym = :endonym,  demonym = :demonym
                    WHERE iso3_code = :iso3_code';


        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->continent_code = htmlspecialchars(strip_tags($this->continent_code));
        $this->currency_code = htmlspecialchars(strip_tags($this->currency_code));
        $this->iso2_code = htmlspecialchars(strip_tags($this->iso2_code));
        $this->iso3_code = htmlspecialchars(strip_tags($this->iso3_code));
        $this->iso_numeric_code = htmlspecialchars(strip_tags($this->iso_numeric_code));
        $this->fis_code = htmlspecialchars(strip_tags($this->fis_code));
        $this->calling_code = htmlspecialchars(strip_tags($this->calling_code));
        $this->common_name = htmlspecialchars(strip_tags($this->common_name));
        $this->official_name = htmlspecialchars(strip_tags($this->official_name));
        $this->endonym = htmlspecialchars(strip_tags($this->endonym));
        $this->demonym = htmlspecialchars(strip_tags($this->demonym));

        // Bind data
        $stmt-> bindParam(':continent_code', $this->continent_code);
        $stmt-> bindParam(':currency_code', $this->currency_code);
        $stmt-> bindParam(':iso2_code', $this->iso2_code);
        $stmt-> bindParam(':iso3_code', $this->iso3_code);
        $stmt-> bindParam(':iso_numeric_code', $this->iso_numeric_code);
        $stmt-> bindParam(':fis_code', $this->fis_code);
        $stmt-> bindParam(':calling_code', $this->calling_code);
        $stmt-> bindParam(':common_name', $this->common_name);
        $stmt-> bindParam(':official_name', $this->official_name);
        $stmt-> bindParam(':endonym', $this->endonym);
        $stmt-> bindParam(':demonym', $this->demonym);

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
        continent_code,
        currency_code,
        iso2_code,
        iso3_code,
        iso_numeric_code,
        fis_code,
        calling_code,
        common_name,
        official_name,
        endonym,
        demonym
        FROM
          ' . $this->table . '
        WHERE 
          continent_code LIKE :search 
        OR 
          currency_code LIKE :search
        OR 
          iso2_code LIKE :search
        OR 
          iso3_code LIKE :search
        OR 
          iso_numeric_code LIKE :search
        OR 
          fis_code LIKE :search
        OR 
          calling_code LIKE :search
        OR 
          common_name LIKE :search
        OR 
          official_name LIKE :search
        OR 
          endonym LIKE :search
        OR 
          demonym LIKE :search';

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

  // Delete Country
  public function delete() {
    // Create query
    $query = 'DELETE FROM ' . $this->table . ' WHERE iso3_code = :iso3_code';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->iso3_code = htmlspecialchars(strip_tags($this->iso3_code));

    // Bind data
    $stmt->bindParam(':iso3_code', $this->iso3_code);

    // Execute query
    if($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
  }


}
