<?php 
/**
 * Template Name: Full Width Page
 *
 * @package WordPress
 */
get_header(); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-12">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<h1><?php the_title(); ?></h1>
				<?php 
				$bens_visitados = get_field('bens_visitados');
				foreach ($bens_visitados as $sitio) {
					print $sitio->post_title . '<br>';
				}
				?>
				<?php the_content(); ?>
				<?php endwhile; else : ?>
					<p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
				<?php endif; ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>