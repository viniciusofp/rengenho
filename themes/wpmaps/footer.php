
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script> -->

<footer class="container-fluid">
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-6 col-md">
				<h5 class="footer-header">Torre Mirante <br> e Passarela</h5>
				<?php
	        wp_nav_menu([
	          'menu'            => 'top',
	          'theme_location'  => 'footer-menu-1',
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
			<div class="col-12 col-sm-6 col-md">
				<h5 class="footer-header">Espetáculo de <br>Luz e Som</h5>
				<?php
	        wp_nav_menu([
	          'menu'            => 'top',
	          'theme_location'  => 'footer-menu-2',
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
			<div class="col-12 col-sm-6 col-md">
				<h5 class="footer-header">Mapeamento <br> de Sítios <br> Arqueológicos</h5>
				<?php
	        wp_nav_menu([
	          'menu'            => 'top',
	          'theme_location'  => 'footer-menu-3',
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
			<div class="col-12 col-sm-6 col-md">
				<h5 class="footer-header">Institucional</h5>
				<?php
	        wp_nav_menu([
	          'menu'            => 'top',
	          'theme_location'  => 'footer-menu-4',
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
			<div class="col-12 col-sm-6 col-md">
				<h5 class="footer-header">Realização</h5>
				<a target="_blank" href="https://www.bndes.gov.br/wps/portal/site/home">
					<img class="footer-logos img-fluid" src="<?php echo get_template_directory_uri(); ?>/img/bndes-logo.png" alt="">
				</a>
				<a class="footer-logos img-fluid" target="_blank" href="http://www.engenho.prceu.usp.br/">
					<img class="footer-logos img-fluid" src="<?php echo get_template_directory_uri(); ?>/img/resje-logo.png" alt="">
				</a>
			</div>
		</div>
	</div>
</footer>

<script src="<?php echo get_template_directory_uri(); ?>/js/sitescripts.js"></script>
</body>
</html>
<?php wp_footer(); ?>