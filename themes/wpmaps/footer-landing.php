
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script> -->

<div class="footer-landing container-fluid">
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-6 col-md">
				<?php
	        wp_nav_menu([
	          'menu'            => 'top',
	          'theme_location'  => 'footer-landing',
	          'container'       => 'div',
	          'container_id'    => 'bs4navbar',
	          'container_class' => '',
	          'menu_id'         => false,
	          'menu_class'      => '',
	          'depth'           => 2,
	          'fallback_cb'     => 'bs4navwalker::fallback',
	          'walker'          => new bs4navwalker()
	        ]);
	      ?>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo get_template_directory_uri(); ?>/js/sitescripts.js"></script>
</body>
</html>
<?php wp_footer(); ?>