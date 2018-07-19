<?php 
/**
 * Template Name: Update Record
 *
 * @package WordPress
 */
get_header();

// function to geocode address, it will return false if unable to geocode address
function geocode($address){
 
  // url encode the address
  $address = urlencode($address);
   
  // google map geocode api url
  $url = "http://maps.google.com/maps/api/geocode/json?address={$address}";

  // get the json response
  $resp_json = file_get_contents($url);
   
  // decode the json
  $resp = json_decode($resp_json, true);

  // response status will be 'OK', if able to geocode given address 
  if($resp['status']=='OK'){

    // get the important data
    $lati = $resp['results'][0]['geometry']['location']['lat'];
    $longi = $resp['results'][0]['geometry']['location']['lng'];
    $formatted_address = $resp['results'][0]['formatted_address'];

    // verify if data is complete
    if($lati && $longi && $formatted_address){

      // put the data in the array
      $data_arr = array();    
      array_push(
        $data_arr, 
          $lati, 
          $longi, 
          $formatted_address
        );
      return $data_arr;
    }else{
        return false;
    }
  }else{
      return false;
  }
}
?>
<h1>HELLO</h1>
<div class="container-fluid">
	<div class="row justify-content-md-center">
		<div class="col-auto">
			<?php
			// Get post ID in query var
			$p = $_GET['id'];
			$args = array(
					'post_type' => 'sitio',
					'p' => $p,
   		);
			// Begin Loop
			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) {
					$the_query->the_post();	

					$endereco = get_field('endereco');
					$geocodeObj = geocode($endereco);
					$style = 'color: red';
					$ok = false;
					$marginOfError = 0.00001;

					// Verify if lat and lng correspond to adress and are not null
					if ( abs(get_field('lat') - $geocodeObj[0]) < $marginOfError &&   abs(get_field('lng') - $geocodeObj[1]) < $marginOfError && get_field('lat') != null && get_field('lng') != null) {
						$ok = true;
						$message = '';
						$style = 'color: green';
					}

					
					// Update lat if necessary
					if (abs(get_field('lat') - $geocodeObj[0]) > $marginOfError || get_field('lat') == null) {
						if ($geocodeObj[0] != null) {
							$message = $message . '<p><strong>A informação de latitude foi atualizada.</strong></p><ul>';
							$message = $message . '<li>Antigo: '. get_field('lat') .'</li>' ;
							$message = $message . '<li>Novo: '. $geocodeObj[0] . '</li></ul>';
							update_field('lat', $geocodeObj[0]);
							$style = 'color: orange';
						} else {
							$message = $message . '<div class="alert alert-warning" role="alert">Não foi possível calcular a latitude.</div>';
						}
					}

					// Update lng if necessary
					if (abs(get_field('lng') - $geocodeObj[1]) > $marginOfError || get_field('lng') == null) {
						if ($geocodeObj[1] != null) {
							$message = $message . '<p><strong>A informação de longitude foi atualizada.</strong></p><ul>';
							$message = $message . '<li>Antigo: '. get_field('lng') .'</li>' ;
							$message = $message . '<li>Novo: '. $geocodeObj[1] . '</li></ul>';
							update_field('lng', $geocodeObj[1]);
							$style = 'color: orange';
						} else {
							$message = $message . '<div class="alert alert-warning" role="alert">Não foi possível calcular a longitude.</div>';
						}
					}

						echo '<h1 style="' . $style . '">' . get_the_title() . '</h1>';
					// Display Message
					if ($ok) {
						echo '<p class="lead">As informações de latitude e longitude parecem estar corretas.</p>';
						echo '<h6><small>Endereço:</small><br>' . get_field('endereco') . '</h6>';
						echo '<ul><li>Lat: ' . get_field('lat') . '</li><li>Lng:' . get_field('lng') . '</li></ul>';
					} else {
						echo $message;
						echo "<button class='btn btn-outline-dark' onclick='location.reload();' />Tentar novamente</button>";
					}
				}
			} else {
				// no posts found
			} ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>