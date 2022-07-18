<?php
  include_once './config/Init.php';
?>
<!doctype html>
<html lang="en">
 
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
 
  <title>Agpaytech Task</title>
 
  <style>
    .custom-file-input.selected:lang(en)::after {
      content: "" !important;
    }
 
    .custom-file {
      overflow: hidden;
    }
 
    .custom-file-input {
      white-space: nowrap;
    }
    .container {
    	padding: 25px;
    }

	table {
	  font-family: arial, sans-serif;
	  border-collapse: collapse;
	  width: 100%;
	  margin-top: 10px;
	  margin-bottom: : 10px;
	}

	td, th {
	  border: 1px solid #dddddd;
	  text-align: left;
	  padding: 8px;
	}

	tr:nth-child(even) {
	  background-color: #dddddd;
	}    

	.pagination {
	  display: inline-block;
	}

	.pagination a {
	  color: black;
	  float: left;
	  padding: 8px 16px;
	  text-decoration: none;
	  margin-top: 10px;
	  margin-bottom: 10px;
	}

	.pagination a.active {
	  color: white;
	}

  </style>
</head>
 
<body>
 
  <div class="container">
  	<?php
  		if(isset($_SESSION['message'])){
  			?><h6><?php echo $_SESSION['message']; unset($_SESSION["message"]);  ?></h6><?php
  		}

			$server = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);

		?>
		<h1 style="text-align: center;"><a href="index.php">Agpaytech Task</a></h1>


		<?php
			if(isset($_GET['show'])){
				$show = $_GET['show'];
				if($show == 'currencies'){
					include_once 'currencies.php';
				}else {
					include_once 'countries.php';
				}
			}else {
				?>
					<ul>
						<li>
							<a href="?show=currencies">Currencies</a>
						</li>
						<li>
							<a href="?show=countries">Countries</a>
						</li>
					</ul>
				<?php
			}
		?>

  </div>
 
</body>
 
</html>