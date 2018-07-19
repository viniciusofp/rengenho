<?php 
/**
 * Template Name: Full Width Page
 *
 * @package WordPress
 */
get_header('dois');

if ( have_posts() ) : while ( have_posts() ) : the_post();

// ACF Field Objects

$mapa = get_field_object('mapa');
$constituicao = get_field_object('constituicao');
$deslocamento = get_field_object('deslocamento');
$bens_visitadosObj = get_field_object('bens_visitados');
$bens_visitados = get_field('bens_visitados');
?>

<div class="sitio-header container-fluid" style="background-image: url('');">
	<div class="row">
		<?php echo $mapa['value']; ?>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="sitio-content col-md-7 col-lg-8">

			<div id="roteiro-content" class="section">
				<h1><?php the_title(); ?></h1>
				<div class="bigtext">
					<?php the_content(); ?>
				</div>
				<a class="expand">Continuar Lendo</a>
				<a class="contract hide">Ocultar Texto</a>
			</div>
			
			<div class="bens-visitados section">
				<?php
				$letras = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N'];
				$flag = 0;
				$bens_visitados = get_field('bens_visitados');?>
				<h2><?php echo $bens_visitadosObj['label']; ?></h2>
				<ul class="list-unstyled">
				<?php
				foreach ($bens_visitados as $sitio) :?>
					<li class="media">
						<div class="media-tag">
							<?php echo $letras[$flag]; $flag++; ?>
						</div>
						<img src="<?php echo get_the_post_thumbnail_url($sitio->ID, 'thumbnail');?>" alt="<?php echo get_the_title($sitio->ID); ?>" class="mr-3">
						<div class="media-body align-self-center">
							
							<?php $term_list = wp_get_post_terms($sitio->ID, 'cidade', array("fields" => "all"));
								foreach ($term_list as $term) {
									echo '<h6>' . $term->name . '</h6>';
								}
							?>
							<a href="<?php echo get_permalink($sitio->ID); ?>">
								<h3><?php echo get_the_title($sitio->ID); ?></h3>
								<p>
<!-- 									<small>
										<?php 
										 $post_id = $sitio->ID; //where 52 is the id of post or page 
											$required_post = get_post($post_id); // getting all information of that post 
											$title = $required_post->post_title; // get the post title 
											$content = $required_post->post_content; //get the post content
											echo $content;
										?>[...]
									</small> -->
										
								</p>
							</a>
						</div>
						
					</li>
				<?php endforeach; ?>
				</ul>
			</div>
			


		</div> <!-- sitio-content col end -->

		<div class="sitio-sidebar roteiro-sidebar sidebar col-md-5 col-lg-4">
			<div class="wrapper">
				<div class="sitio-sidebar-tag">
					<h5>Perfil</h5>
				</div>
				<div class="meta">
					<h6>Cidade</h6>
					<p><?php $term_list = wp_get_post_terms($post->ID, 'cidade', array("fields" => "all"));
						foreach ($term_list as $term) {
							echo '' . $term->name . '<br>';
						}
					?></p>

					<?php if( $cidade['value'] ): ?> 
					<h6><?php echo $cidade['label']; ?></h6>
					<p><?php echo $cidade['value']; ?></p>
					<?php endif;?>

					<?php if( $deslocamento['value'] ): ?> 
					<h6><?php echo $deslocamento['label']; ?></h6>
					<p><?php echo $deslocamento['value']; ?>km</p>
					<?php endif;?>

					<?php if( $constituicao['value'] ): ?> 
					<h6><?php echo $constituicao['label']; ?></h6>
					<p><?php echo $constituicao['value']; ?></p>
					<?php endif;?>

<!-- 					<?php if( $ficha_patrimonial['value'] ): ?>
					<a href="<?php echo $ficha_patrimonial['value']; ?>" target="_blank">
						<button class="btn btn-outline-primary">Imprima a ficha</button>
					</a>
					<?php endif;?> -->
				</div>
			</div> <!-- wrapper end -->
			
			<div class="wrapper">
				<div class="sitio-sidebar-tag">
					<h5>Compartilhar</h5>
				</div>
				<div class="meta text-center">
					<ul class="list-inline">
						<li class="list-inline-item">
							<a href="">
								<i class="fab fa-twitter"></i>
							</a>
						</li>
						<li class="list-inline-item" >
							<a href="">
								<i class="fab fa-facebook-f"></i>
							</a>
						</li>
						<li class="list-inline-item">
							<a href="">
								<i class="fab fa-tumblr"></i>
							</a>
						</li>
					</ul>
				</div>
			</div> <!-- wrapper end -->
		</div> <!-- sitio sidebar col end -->

	</div> <!-- row end -->
</div> <!-- container end -->

<?php include 'inc/roteiros.php'; ?>

<?php endwhile; else : ?>
	<p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>

<script>
$(function(){


// Content collapse/expand
  var animspeed = 300; // animation speed in milliseconds
 
  var $blockquotes = $('.bigtext');
  console.log($blockquotes)
  $blockquotes.each(function() {
	  var height = $(this).height();
	  var mini = $('.bigtext p').eq(0).height() + $('.bigtext p').eq(1).height() - 32;
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
          scrollTop: target.offset().top - 50
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
</script>

<?php get_footer(); ?>