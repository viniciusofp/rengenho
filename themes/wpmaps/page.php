<?php 
/**
 * Template Name: Full Width Page
 *
 * @package WordPress
 */
get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();

?>

<div class="sitio-header container-fluid" style="background-image: url('<?php the_post_thumbnail_url(); ?>');">
	<div class="row justify-content-center align-items-center text-center">
			<div class="col-md-8 col-lg-6">
				<h1><?php the_title(); ?></h1>
			</div>
	</div>
</div>

<div class="container">
	<div class="row justify-content-center">
		<div class="sitio-content institucional col-auto text-center">
			<div id="content">
				<?php the_content(); ?>
			</div>
		</div> 
	</div> <!-- row end -->
</div> <!-- container end -->

<?php endwhile; else : ?>
	<p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>

<?php include 'inc/appscripts.php'; ?>
<?php get_footer(); ?>