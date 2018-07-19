<?php 
/**
 * Template Name: Full Width Page
 *
 * @package WordPress
 */
get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();

// ACF Field Objects
$historico = get_field_object('historico');
$descricao = get_field_object('descricao');
$acesso = get_field_object('acesso');
$outras_informacoes = get_field_object('outras_informacoes');
$referencias = get_field_object('referencias');
$endereco = get_field_object('endereco');
$telefone = get_field_object('telefone');
$cidade = get_field_object('cidade');
$bairro = get_field_object('bairro');
$horarios = get_field_object('horario');
$constituicao = get_field_object('constituicao_do_patrimonio');
$ficha_patrimonial = get_field_object('ficha_patrimonial');
$images = get_field('galeria');
$tipo = get_field('tipo');
?>

<div class="sitio-header container-fluid" style="background-image: url('<?php the_post_thumbnail_url(); ?>');">
	<div class="row justify-content-center align-items-center text-center">
			<div class="col-md-8 col-lg-6">

				<h1><?php the_title(); ?></h1>
				<?php if ($images) : ?>
					<button id="gallery-btn" class="btn btn-sm btn-outline-light"  data-toggle="modal" data-target="#exampleModal">Ver Fotos</button>
				<?php endif; ?>
			</div>
	</div>
</div>

<?php if ($images) : ?>
			<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
    	<div class="modal-body container-fluid">
    		<div class="row">
    			<div class="col-sm-12">
    				
						<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
							<ol class="carousel-indicators">

								<?php 
								$count = 0;
								foreach ( $images as $image ) : 
								if ($count == 0) {
									echo '<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>';
								}else {
									echo '<li data-target="#carouselExampleIndicators" data-slide-to="' . $count . '"></li>';
								};
								$count++;endforeach;?>

						  </ol>
						  <!-- Wrapper for slides -->
						  <div class="carousel-inner">
								<?php 
								$count = 0;
								foreach ( $images as $image ) : $count++;
								if ($count == 1) {
									echo '<div class="carousel-item active">';
								}else {
									echo '<div class="carousel-item">';
								}?>
					      		<a href="<?php echo $image['sizes']['large']; ?>" target="_blank"><img class="d-block w-100" src="<?php echo $image['sizes']['large']; ?>"></a>
					      	</div>
								<?php endforeach;?>
						  </div>

						  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
						    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
						    <span class="sr-only">Previous</span>
						  </a>
						  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
						    <span class="carousel-control-next-icon" aria-hidden="true"></span>
						    <span class="sr-only">Next</span>
						  </a>
						</div> <!-- carousel end -->

    			</div>
    		</div>
    	</div>
		</div>
	</div> <!-- row -->
</div> <!-- container -->
<?php endif; ?>

<div class="container sitio-menu-container sticky-top">
	<div class="row">
		<div class="col-lg-8">
			<div class="sitio-menu row justify-content-center text-center">
				<?php if( $historico['value'] ): ?>
				<div id="<?php echo $historico['name']; ?>-menu" class="col-xs-6 col-sm active"><a href="#<?php echo $historico['name']; ?>">Histórico</a></div>
				<?php endif;?>

				<?php if( $descricao['value'] ): ?>
				<div id="<?php echo $descricao['name']; ?>-menu" class="col-xs-6 col-sm"><a href="#<?php echo $descricao['name']; ?>">Descrição</a></div>
				<?php endif;?>

				<?php if( $outras_informacoes['value'] ): ?>
				<div id="<?php echo $outras_informacoes['name']; ?>-menu" class="col-xs-6 col-sm"><a href="#<?php echo $outras_informacoes['name']; ?>">Outras Informações</a></div>
				<?php endif;?>

				<?php if( $referencias['value'] ): ?>
				<div id="<?php echo $referencias['name']; ?>-menu" class="col-xs-6 col-sm"><a href="#<?php echo $referencias['name']; ?>">Referências</a></div>
				<?php endif;?>

				<div id="acesso-menu" class="col-xs-6 col-sm"><a href="#acesso">Como Chegar</a></div>

			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="sitio-content col-md-7 col-lg-8">

			<?php if( $historico['value'] ): ?>
			<div id="historico" class="section">
				<h2><?php echo $historico['label']; ?></h2>
				<div class="bigtext"><?php echo $historico['value']; ?></div>
				<a class="expand">Expandir</a>
				<a class="contract hide">Ocultar</a>
			</div> 
			<?php endif;?>

			<div class="mb-3 w-100 d-block"></div>
			<?php if( $descricao['value'] ): ?>
			<div id="descricao" class="section">
				<h2><?php echo $descricao['label']; ?></h2>
				<div class="bigtext"><?php echo $descricao['value']; ?></div>
				<a class="expand">Expandir</a>
				<a class="contract hide">Ocultar</a>
			</div> 
			<?php endif;?>

			<div class="mb-3 w-100 d-block clearfix"></div>
			<?php if( $outras_informacoes['value'] ): ?>
			<div id="outras_informacoes" class="section">
				<h2><?php echo $outras_informacoes['label']; ?></h2>
				<div class="bigtext"><?php echo $outras_informacoes['value']; ?></div>
				<a class="expand">Expandir</a>
				<a class="contract hide">Ocultar</a>
			</div> 
			<?php endif;?>
			<div class="mb-3 w-100 d-block"></div>

			<div class="mb-3 w-100 d-block clearfix"></div>
			<?php if( $referencias['value'] ): ?>
			<div id="referencias" class="section">
				<h2><?php echo $referencias['label']; ?></h2>
				<div class="bigtext"><?php echo $referencias['value']; ?></div>
				<a class="expand">Expandir</a>
				<a class="contract hide">Ocultar</a>
			</div> 
			<?php endif;?>
			<div class="mb-3 w-100 d-block"></div>

			<div id="acesso" ng-app="wpMap"  ng-controller="RouteMap">
 				<h2>Como Chegar</h2>
 				<?php $lat = get_field('lat');
 				$lng = get_field('lng'); ?>
				<p><small>Preencha o formulário abaixo com seu local de partida e meio de transporte para descobrir como chegar em <?php the_title(); ?></small></p>
				<form action="javascript:void(0);">
					<div class="form-row">
						<div class="col-sm-12 col-md-6 col-lg-5">
							<div class="form-group">
				      	<input id="start" class="form-control" type="text" size="22" placeholder="Local de partida"></input>
				      </div>
						</div>
						<div class="col-xs-6 col-md-6 col-lg-4">
				    	<div class="select-div">
				    		<i class="fas fa-angle-down select-caret"></i>
						    <select id="mode" class="form-control">
						      <option value="DRIVING">Carro</option>
						      <option value="TRANSIT">Transporte Público</option>
						      <option value="WALKING">Caminhada</option>
						      <option value="BICYCLING">Bicicleta</option>
						    </select>
				    	</div>
						</div>
			      	<input id="end" class="d-none"  value="<?php echo $lat . ',' . $lng; ?>" >
				      <button id="searchRoute" class="btn btn-primary">Traçar Rota</button>
					</div>
					
			      
		    </form>
 				<span id="sitio-lat" class="d-none"><?php echo $lat ?></span>
 				<span id="sitio-lng" class="d-none"><?php echo $lng ?></span>
 				<div id="route-container">
 					<div id="right-panel"></div>
					<div id="route-map" class="d-none"></div>
 				</div>

			</div> 

		</div> <!-- sitio-content col end -->
	
		<div class="sitio-sidebar sidebar col-md-5 col-lg-4">
			<div class="wrapper">
				<div class="sitio-sidebar-tag <?php echo $tipo['value']; ?>">
					<h5><?php echo $tipo['label']; ?></h5>
				</div>
				<?php $latlng = get_field('lat') . ',' . get_field('lng'); ?>
				<a href="https://www.google.com/maps/place/<?php echo $latlng; ?>" target="_blank">
					<div class="mapa">
						<img src="<?php echo get_template_directory_uri(); ?>/img/pin.png" alt="" class="mapa-pin">
							<img src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $latlng; ?>&zoom=12&size=400x300&maptype=roadmap&key=AIzaSyB9nXWYKcmRhUJ26KblKZToGNq0oN-cZjk
	" style="width: 100%"/>
					</div>
				</a>
				<div class="meta">
					<h6>Cidade</h6>
					<?php $term_list = wp_get_post_terms($post->ID, 'cidade', array("fields" => "all"));
						foreach ($term_list as $term) {
							echo '<p>' . $term->name . '</p>';
						}
					?>

					<?php if( $cidade['value'] ): ?> 
					<h6><?php echo $cidade['label']; ?></h6>
					<p><?php echo $cidade['value']; ?></p>
					<?php endif;?>

					<?php if( $bairro['value'] ): ?> 
					<h6><?php echo $bairro['label']; ?></h6>
					<p><?php echo $bairro['value']; ?></p>
					<?php endif;?>

					<?php if( $constituicao['value'] ): ?> 
					<h6><?php echo $constituicao['label']; ?></h6>
					<p><?php echo $constituicao['value']; ?></p>
					<?php endif;?>

					<a href="javascript:window.print()" target="_blank" class="d-block w-100">
						<button class="btn btn-outline-primary imprima-ficha">Imprima a ficha</button>
					</a>

				</div>
			</div> <!-- wrapper end -->
			
			<div class="wrapper share">
				<div class="sitio-sidebar-tag">
					<h5>Informações Úteis</h5>
				</div>
				<div class="meta">
					<?php if( $telefone['value'] ): ?> 
					<h6><?php echo $telefone['label']; ?></h6>
					<p><?php echo $telefone['value']; ?></p>
					<?php endif;?>

					<?php if( $endereco['value'] ): ?> 
					<h6><?php echo $endereco['label']; ?></h6>
					<p><?php echo $endereco['value']; ?></p>
					<?php endif;?>

					<?php if( $horarios['value'] ): ?> 
					<h6><?php echo $horarios['label']; ?></h6>
					<?php echo $horarios['value']; ?>
					<?php endif;?>
				</div>
			</div> <!-- wrapper end -->
			<?php 
			$roteiros_IDs = array();
			$roteiros_inc = get_posts(array(
				'post_type' => 'roteiro',
				'meta_query' => array(
					array(
						'key' => 'bens_visitados', // name of custom field
						'value' => '"' . get_the_ID() . '"', // matches exactly "123", not just 123. This prevents a match for "1234"
						'compare' => 'LIKE'
					)
				)
			));
			foreach ($roteiros_inc as $roteiro) {
				array_push($roteiros_IDs, $roteiro->ID);
			}
			?>
			<?php 

			$posts_array = get_posts(
			                        array(
															  'post_type' => 'roteiro',
															  'include' => $roteiros_IDs
															));
			if ($posts_array[0]) : ?>
			<div class="wrapper roteiros-list">
				<div class="sitio-sidebar-tag">
					<h5>Roteiros que visitam este sítio</h5>
				</div>
				<?php  ?>
				<div class="meta roteiros-list">
					<ul class="list-unstyled">
					<?php foreach ($posts_array as $taxonomy_post) : 

					// $bairroObj = get_field_object('bairro', $taxonomy_post->ID);
					// print_r($bairroObj['value']);
					?>

					  <li class="media">
					    <img class="mr-3" src="<?php echo get_the_post_thumbnail_url($taxonomy_post->ID, 'thumbnail');?>" alt="<?php echo get_the_title($taxonomy_post->ID);?>">
					    <div class="media-body align-self-center">
					    	<a href="<?php echo get_the_permalink($taxonomy_post->ID);?>">
					      	<p class="mt-0"><?php echo get_the_title($taxonomy_post->ID);?></p>
					    	</a>
								<!-- <p>Bairro / <?php echo $term_list[0]->name ?></p> -->
					    </div>
					  </li>
					<?php  endforeach; ?>
					</ul>
				</div>
			</div> <!-- wrapper end -->
			<?php endif; ?>
			<?php 
			$posts_array = get_posts(
			                        array(
															  'post_type' => 'sitio',
															  'numberposts' => 4,
															  'tax_query' => array(
															    array(
															      'taxonomy' => 'cidade',
															      'field' => 'id',
															      'terms' => $term_list[0]->term_id,
															      'include_children' => false
															    )
															  )
															));
			if ($posts_array[1]) : ?>
			<div class="wrapper roteiros-list">
				<div class="sitio-sidebar-tag">
					<h5>Outros sítios em <?php echo $term_list[0]->name; ?></h5>
				</div>
				<?php  ?>
				<div class="meta roteiros-list">
					<ul class="list-unstyled">
					<?php foreach ($posts_array as $taxonomy_post) : 
					// $bairroObj = get_field_object('bairro', $taxonomy_post->ID);
					// print_r($bairroObj['value']);
						if ($taxonomy_post->ID != get_the_ID()) :
					?>

					  <li class="media">
					    <img class="mr-3" src="<?php echo get_the_post_thumbnail_url($taxonomy_post->ID, 'thumbnail');?>" alt="<?php echo get_the_title($taxonomy_post->ID);?>">
					    <div class="media-body align-self-center">
					    	<a href="<?php echo get_the_permalink($taxonomy_post->ID);?>">
					      	<p class="mt-0"><?php echo get_the_title($taxonomy_post->ID);?></p>
					    	</a>
								<!-- <p>Bairro / <?php echo $term_list[0]->name ?></p> -->
					    </div>
					  </li>
					<?php  endif; endforeach; ?>
					</ul>
				</div>
			</div> <!-- wrapper end -->
			<?php endif; ?>
			<div class="wrapper share">
				<div class="sitio-sidebar-tag">
					<h5>Compartilhar</h5>
				</div>
				<div class="meta text-center">
					<ul class="list-inline">
						<li class="list-inline-item">
							<a target="_blank" href="https://twitter.com/home?status=<?php the_title(); ?> - <?php the_permalink(); ?>">
								<i class="fab fa-twitter"></i>
							</a>
						</li>
						<li class="list-inline-item" >
							<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>">
								<i class="fab fa-facebook-f"></i>
							</a>
						</li>
						<li class="list-inline-item">
							<a target="_blank" href="https://www.tumblr.com/widgets/share/tool?shareSource=legacy&canonicalUrl=<?php the_permalink(); ?>&posttype=link">
								<i class="fab fa-tumblr"></i>
							</a>
						</li>
					</ul>
				</div>
			</div> <!-- wrapper end -->
		</div> <!-- sitio sidebar col end -->

	</div> <!-- row end -->
</div> <!-- container end -->


<?php endwhile; else : ?>
	<p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>

<script>
$(function(){

// Sections menu Waypoints
	var sections = ['historico', 'descricao', 'acesso', 'outras_informacoes', 'referencias'];
	var inviews = [];
	sections.forEach(function(section) {
		if ($('#' + section + '-menu').length) {
			inviews.push(new Waypoint.Inview({
			  element: document.getElementById(section),
			  enter: function(direction) {
			    //$('#' + section + '-menu').addClass('active');
			  },
			  entered: function(direction) {
			  	if (this.element.clientHeight < Waypoint.viewportHeight()) {

				    if (direction == 'up') {
				    	$('#' + section + '-menu').addClass('active');
			    		$('#' + section + '-menu').siblings().removeClass('active');
				    }
			  	}
			  },
			  exit: function(direction) {
			  	if (this.element.clientHeight < Waypoint.viewportHeight()) {

				    $('#' + section + '-menu').removeClass('active');
				    if (direction == 'down') {
			    		$('#' + section + '-menu').siblings().removeClass('active');
				    	$('#' + section + '-menu').next().addClass('active');
				    }
				    if (direction == 'up') {
			    		$('#' + section + '-menu').siblings().removeClass('active');
				    	$('#' + section + '-menu').prev().addClass('active');
				    }
			  	}
			  },
			  exited: function(direction) {

			  	if (this.element.clientHeight > Waypoint.viewportHeight()) {

				    $('#' + section + '-menu').removeClass('active');
				    if (direction == 'down') {
			    		$('#' + section + '-menu').siblings().removeClass('active');
				    	$('#' + section + '-menu').next().addClass('active');
				    }
				    if (direction == 'up') {
			    		$('#' + section + '-menu').siblings().removeClass('active');
				    	$('#' + section + '-menu').prev().addClass('active');
				    }
			  	}
			  }
			}))
		}
		

	});

	console.log(inviews)

// Content collapse/expand
  var animspeed = 300; // animation speed in milliseconds
 
  var $blockquotes = $('.bigtext');
  console.log($blockquotes)
  $blockquotes.each(function() {
	  var height = $(this).height();
	  var mini = $('.bigtext p').eq(0).height();
	 if ($(this).children().length > 2) {
	  $(this).attr('data-fullheight',height+'px');
	  $(this).attr('data-miniheight',mini+'px');
	  $(this).css('height',mini+'px');
	 } else{
	 	$(this).next().next().remove()
	 	$(this).next().remove()
	 }

  })
 
  $('.expand').on('click', function(e){
    $text = $(this).prev();
 
    $text.animate({
      'height': $text.attr('data-fullheight')
    }, animspeed);
    $(this).next('.contract').removeClass('hide');
    $(this).addClass('hide');
    setTimeout(function() {
    	Waypoint.refreshAll();
    }, 500)
    
  });
  $('.contract').on('click', function(e){
    $text = $(this).prev().prev();
 
    $text.animate({
      'height': $text.attr('data-miniheight')
    }, animspeed);
    $(this).prev('.expand').removeClass('hide');
    $(this).addClass('hide');

    setTimeout(function() {
    	Waypoint.refreshAll();
    }, 500)
  });

})


// Smooth Scrolling
// Select all links with hashes
$('a[href*="#"]')
  // Remove links that don't actually link to anything
  .not('[href="#"]')
  .not('[href="#0"]')
  .not('[href="#carouselExampleIndicators"]')
  .click(function(event) {
    // On-page links
    if (
      location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
      && 
      location.hostname == this.hostname
    ) {
      // Figure out element to scroll to
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      // Does a scroll target exist?
      if (target.length) {
        // Only prevent default if animation is actually gonna happen
        event.preventDefault();
        $('html, body').animate({
          scrollTop: target.offset().top - 100
        }, 1000, function() {
          // Callback after animation
          // Must change focus!
          var $target = $(target);
          $target.focus();
          if ($target.is(":focus")) { // Checking if the target was focused
            return false;
          } else {
            $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
            $target.focus(); // Set focus again
          };
        });
      }
    }
  });
  $('.select-caret').click(function() {
  	var select = $('.select-caret').next();
  	var numberOfOptions = select[0].children.length;
  	select.focus();
  })
</script>

<?php include 'inc/appscripts.php'; ?>
<?php get_footer(); ?>