<div class="roteiros container-fluid">
	<div class="row justify-content-center">
		<div class="col-12 text-center">
			<h2>Roteiros</h2>
			<p class="lead mb-5">There’s a breaking change between Font Awesome 4 and Font Awesome 5 regarding CSS pseudo-elements.</p>
		</div>
		<div class="col-11 col-md-10">
			<div class="row">
				<?php
				$excludepost = array($post->ID);
				$query = new WP_Query( array(
					'post__not_in' => $excludepost,
					'post_type' => 'roteiro',
					'posts_per_page' => 4,
					'orderby' => 'rand',
				) );
				if ( $query->have_posts() ) : ?>
					<?php while ( $query->have_posts() ) : $query->the_post(); ?>

					<div class="col-12 col-sm-6 col-lg-3 text-center">
						<a href="<?php the_permalink(); ?>" target="_self">
							<div class="card animate">
									<?php if (has_post_thumbnail()):?>
									<img src="<?php echo the_post_thumbnail_url('thumbnail'); ?>" alt="" class="card-img-top">
									<?php endif ?>
								<div class="card-body">
									<h3><?php the_title(); ?></h3>
									<p><?php $term_list = wp_get_post_terms($post->ID, 'cidade', array("fields" => "all"));
										foreach ($term_list as $term) {
											echo '' . $term->name . '<br>';
										}
									?></p>
								</div>
							</div>
						</a>
					</div>

					<?php endwhile; ?>
					<?php wp_reset_postdata(); ?>
				<?php else : ?>
					<p><?php esc_html_e( 'Sorry, no posts matched your criteria.' ); ?></p>
				<?php endif; ?>
			</div>
		</div>
				
		<div class="col-12 text-center">
			<a href="<?php echo site_url('/roteiro') ?>">
				<button class="btn btn-outline-primary">Navegue em roteiros</button>
			</a>
		</div>
	</div> <!-- row end -->
</div> <!-- container end -->

<script>

$(function(){
	var waypoints = $('.card').waypoint({
	  handler: function(direction) {
	    $('.card').addClass('animated fadeInUp')
	  },
	  offset: '80%'
	})
});	
</script>