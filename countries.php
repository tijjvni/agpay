
<h5>Upload Countries CSV</h5>
<form action="<?php echo $server; ?>/api/countries/upload.php" method="post" enctype="multipart/form-data">
    <div class="input-group">
        <div class="custom-file">
          <input type="file" class="custom-file-input" id="customFileInput" aria-describedby="customFileInput" name="countries">
          <label class="custom-file-label" for="customFileInput">Select file</label>
        </div>
        <div class="input-group-append">
           <input type="submit" name="submit" value="Upload" class="btn btn-primary">
        </div>
    </div>
</form>

<table>
	<tr>
		<th>Continent</th>
		<th>Currency</th>
		<th>ISO2 Code</th>
		<th>ISO3 Code</th>
		<th>ISO Num Code</th>
		<th>FIS Code</th>
		<th>Calling Code</th>
		<th>Common Name</th>
		<th>Offical Name</th>
		<th>Endonym</th>
		<th>Demonym</th>
	</tr>
	<?php

		// check search query
		$search = NULL;

		// get current page
		$page = (isset($_GET['page']) && is_numeric($_GET['page'])) ?  $_GET['page'] : 1;


		if(isset($_GET['q']) && !empty($_GET['q'])){
			$search = $_GET['q'];
			$api_url = $server.'/api/countries/search.php?q='.$search.'&page='.$page;
		}else {
			$api_url = $server.'/api/countries/get.php?page='.$page; 
		}


		// Read JSON file
		$json_response = file_get_contents($api_url);

		// Decode JSON data into PHP array
		$response = json_decode($json_response);

		// print_r($json_response); die();

		?>
			<tr>
				<td colspan="11">
					<form action="?" method="get">
					    <div class="input-group">
					        <div class="custom-file">
					          <input type="text" name="q" style="width: 100%; padding: 5px;" placeholder="Search currencies" value="<?php echo $search; ?>" />
					        </div>
					        <div class="input-group-append">
					        	<input type="hidden" name="show" value="countries">
					        	<input type="submit" value="Search" class="btn btn-primary">
					        </div>
					    </div>
					</form>					
				</td>
			</tr>
		<?php

		if(isset($response->data)){

			for ($x=0; $x < count($response->data); $x++) { 
				?>
				  <tr>
				    <td><?php echo $response->data[$x]->continent_code ?></td>
				    <td><?php echo $response->data[$x]->currency_code ?></td>
				    <td><?php echo $response->data[$x]->iso2_code ?></td>
				    <td><?php echo $response->data[$x]->iso3_code ?></td>
				    <td><?php echo $response->data[$x]->iso_numeric_code ?></td>
				    <td><?php echo $response->data[$x]->fis_code ?></td>
				    <td><?php echo $response->data[$x]->calling_code ?></td>
				    <td><?php echo $response->data[$x]->common_name ?></td>
				    <td><?php echo $response->data[$x]->official_name ?></td>
				    <td><?php echo $response->data[$x]->endonym ?></td>
				    <td><?php echo $response->data[$x]->demonym ?></td>
				  </tr>
				<?php
			}

			?>
				<tr>
					<td colspan="11" style="text-align: center;">

						<div class="pagination">
						  <a href="?show=countries&q=<?php echo $search  ?>&<?php echo $response->meta->links->first; ?>">&laquo;</a>						  
						  <?php
						  	$pages = round($response->meta->total/$response->meta->per_page);
						  	for ($x=0; $x < $pages; $x++) { 
						  		?>
						  			<a 
						  				href="?show=countries&q=<?php echo $search  ?>&page=<?php echo $x+1; ?>"
						  				class="<?php echo ($response->meta->page == ($x+1) )? 'active btn btn-primary' : ''; ?>" 
						  			>
						  				<?php echo $x+1; ?>
						  					
						  			</a>
						  		<?php
						  	}

						  ?>
						  <a href="?show=countries&q=<?php echo $search  ?>&<?php echo $response->meta->links->last; ?>">&raquo;</a>
						</div>

					</td>
				</tr>
			<?php

		}else {
			?>
				<tr>
					<td colspan="11" style="text-align: center;">
						<?php echo $response->message; ?>
					</td>
				</tr>
			<?php
		}

	?>  
</table>
