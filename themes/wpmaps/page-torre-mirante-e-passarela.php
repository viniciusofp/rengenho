<?php get_header('dois');

if ( have_posts() ) : while ( have_posts() ) : the_post();
$agenda = get_field('agenda');
$video = get_field('video');
$images = get_field('galeria');

?>
<div class="espetaculo">
	<div id="styled_video_container" class="embed-container">
		<div class="meta-container" style="background-image: url('<?php echo the_post_thumbnail_url('full');?>')">
			<div class="meta">
				<h1 class="big-header"><?php the_title(); ?></h1>
				<img class="play" src="<?php echo get_template_directory_uri();?>/img/play.svg" alt="">
			</div>
		</div>
	  <video src="<?php echo $video; ?>" type="video/mp4" poster="<?php echo the_post_thumbnail_url('full');?>" id="styled_video" muted preload="metadata">
	</div>
	<div class="container mb-5 mt-5">
		<div class="row justify-content-center">
			<div class="col-12 col-sm-8 page">
				<?php the_content(); ?>
			</div>
				<?php if ($images) : ?>
			<div class="col-sm-4 align-self-center">
				<div class="img-box">
					<img src="<?php echo $images[0]['sizes']['large']; ?>" alt="" class="img-fluid shadow-box"  data-toggle="modal" data-target="#exampleModal">
				</div>
					
				

			</div>
				<?php endif; ?>
		</div>
	</div>


	<?php 
	if ($images) : ?>
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
</div>
	
<?php endif; ?>

<?php endwhile; else : ?>
	<p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>
<script>
$(function(){
	$('.play').click(function() {
		console.log('cu')
		$('#styled_video_container .meta-container').fadeOut();
		$('#styled_video')[0].play();
		$('#styled_video').css('opacity', 1);
		document.getElementById('styled_video').setAttribute('controls', 'controls');
	})


	jQuery(document).on('click', 'video', function(){
    if (!this.paused) {
      this.pause();
			$('#styled_video_container .meta-container').fadeIn();
			$('#styled_video').css('opacity', .3)
			document.getElementById('styled_video').removeAttribute('controls', 'controls');
    }
	});
});
</script>
<?php include 'inc/appscripts.php'; ?>
<?php get_footer(); ?>