<?php get_header('dois'); ?>
<div class="container-fluid search-page">
	<div class="row">
		<div class="col-12 col-md-4 col-xl-5 search-itens-col">
			<h3>Resultados</h3>
			<h5 onclick="filtre()">Filtre sua busca</h5>
			<form role="search" method="get" action="<?php echo home_url('/'); ?>/" class="hide-form">
			  <div class="form-row">
			    <div class="col-6 col-md-12 col-xl-6">
			      <input name="s" type="text" class="form-control" placeholder="Palavra Chave">
			    </div>
			    <div class="col-6 col-md-12 col-xl-5">
			    	<div class="select-div">
			    		<i class="fas fa-angle-down select-caret"></i>
				      <select name="cidade" class="form-control">
				        <option selected disabled>Cidade</option>
					      <?php $cidades = get_terms('cidade');
				    		foreach ($cidades as $cidade) {
				    			echo '<option value="'. $cidade->slug . '">' . $cidade->name . '</option>';
				    		 } ?>
				      </select>
				    </div>
			    </div>
			    <div class="col-12 col-xl-1">
			    	<input type="hidden" name="post_type" value="sitio" /> <!-- // hidden 'products' value -->

			      <button  class="form-control btn btn-success"><i class="fas fa-search"></i></button>
			    </div>
			  </div>
			</form>
			<div class="row">
			<?php if ( have_posts() ): while ( have_posts() ) : the_post(); ?>

				<div class="search-item-col col-12 col-sm-6 col-md-12 col-xl-6">
					<div class="search-item">
						<a href="<?php the_permalink() ?>">
							<?php the_post_thumbnail('thumbnail'); ?>
						</a>
						<h2><?php the_title(); ?></h2>
						<?php $term_list = get_the_terms(get_the_ID(), 'cidade');
							foreach ($term_list as $term) {
								echo '<h6>' . $term->name . '</h6>';
							}
						?>
						<a href="<?php the_permalink() ?>">
							<button class="btn btn-primary btn-sm mt-2 mb-2">Ver mais</button>
						</a>
						<div class="post-info d-none">
							<span class="title"><?php the_title(); ?></span>
							<span class="id"><?php the_ID(); ?></span>
							<span class="thumb"><?php the_post_thumbnail_url('thumbnail'); ?></span>
							<span class="permalink"><?php the_permalink(); ?></span>
							<span class="lat"><?php the_field('lat'); ?></span>
							<span class="lng"><?php the_field('lng'); ?></span>
						</div>
					</div>
				</div>
				
			<?php endwhile; else:?>
				<div class="col-12">
					<p>Não encontramos resultados para a sua busca.</p>
					<script>
						jQuery('form').removeClass('hide-form');
					</script>
				</div>
		<?php endif ?>

			</div>
		</div>
		<div id="search-map" class="d-none d-md-flex col-md-8 col-xl-7 search-map">
		</div>
	</div>
</div>


<?php include 'inc/appscripts.php' ?>
<script>
	
	var filtre = function() {
		if (jQuery('.hide-form').length) {
			jQuery('form').removeClass('hide-form');
		} else {
			jQuery('form').addClass('hide-form');
		}
		
	}

	var locations = jQuery('.post-info').toArray();
	var posts = [];
	locations.forEach(function(location) {
		var locationObj = {};
		locationObj.title = {};
		locationObj.title.rendered = jQuery(location).children('.title').html();
		locationObj.link = jQuery(location).children('.permalink').html();
		locationObj.img_thumbnail = jQuery(location).children('.thumb').html();
		locationObj.id = jQuery(location).children('.id').html();
		locationObj.lat = jQuery(location).children('.lat').html();
		locationObj.lng = jQuery(location).children('.lng').html();
		posts.push(locationObj);
	})
	console.log(posts);
	// console.log(locations);
	// Initialize map




  var map;
  var markers = [];
  var infowindows = [];


  function initMap() {
    var latlng = new google.maps.LatLng(-23.9738609,-46.3367274);
    var mapOptions = {
      // scrollwheel: false,
      zoom: 10,
      minZoom: 4,
      center: latlng,
      // styles: styles,
      mapTypeControl: false,
      fullscreenControl: false,
      streetViewControl: false,
      mapTypeId: 'satellite',
      mapZoomControl: true,
    }
    // Create map
    map = new google.maps.Map(document.getElementById('search-map'), mapOptions);


      posts.forEach(function(post) {

        var contentString = '<div class="infowindow card"><img class="card-img-top" src="' + post.img_thumbnail + '" alt=""><div class="card-body"><h3>' + post.title.rendered + '</h3><a href="' + post.link + '" target="_self"><p>EXPLORAR</p></a>' + '</div></div>';

        // Create Infowindos
        var infowindow = new google.maps.InfoWindow({
          content: contentString,
          id: post.id,
        });

        google.maps.event.addListener(infowindow, 'domready', function() {
           var iwOuter = $('.gm-style-iw');
           var iwBackground = iwOuter.prev();
           iwBackground.children(':nth-child(2)').css({'display' : 'none'});
           iwBackground.children(':nth-child(4)').css({'display' : 'none'});
        });
        infowindows.push(infowindow);

        // Create markers
        var marker = new google.maps.Marker({
          position: {lat: parseFloat(post.lat), lng: parseFloat(post.lng)},
          map: map,
          id: post.id,
          icon: url + '/wp-content/themes/wpmaps/img/pin.png'
        });
        markers.push(marker);

        // Add click listener to markers
        marker.addListener('click', function() {
          infowindows.forEach(function(info) {
            info.close();
          })
          infowindow.open(map, marker);
          setTimeout(function() {
            $('.gm-style-iw').next().addClass('closebtn');
          },400)
          if (map.getZoom() < 16) {map.setZoom(20);}
          map.setCenter(marker.position);
        });

      });
      var clusterStyle = [{
        url: url + '/wp-content/themes/wpmaps/img/clusterer/m1.png',
        height: 68,
        width: 53,
        anchor: [19, 0],
        textColor: '#ffffff',
        textSize: 12
      }]
      // Add a marker clusterer to manage the markers.
      var markerCluster = new MarkerClusterer(map, markers,
          {maxZoom: 13, imagePath: url + '/wp-content/themes/wpmaps/img/clusterer/m', styles: clusterStyle});

  } // initMap() end
  window.onload = function () { initMap(); }

  
</script>

<?php get_footer(); ?>