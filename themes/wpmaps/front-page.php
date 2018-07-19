<?php get_header(); ?>
<div class="landing container-fluid">
	<div class="row justify-content-center">
		<div class="col-12 col-lg-auto align-self-center">
			<div class="text-center">
				<p class="lead">Projeto de Valorização Patrimonial <br class="d-block d-sm-none">do Monumento Nacional</p>
				<h1>Ruínas Engenho São Jorge dos Erasmos</h1>
			</div>
				
			<ul class="list-unstyled text-center fadeInUp animated">
				<li>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>torre-mirante-e-passarela">
						<button class="btn btn-outline-light btn-lg">Torre Mirante e Passarela</button>
				</a>
				</li>
				<li>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>espetaculo-de-luz-e-som">
						<button class="btn btn-outline-light btn-lg">Espetáculo de Luz e Som</button>
				</a>
				</li>
				<li>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>mapeamento">
						<button class="btn btn-outline-light btn-lg">Mapeamento de <br class="d-block d-sm-none">Sítios Arqueológicos</button>
				</a>
				</li>
			</ul>
		</div>
	</div>
</div>
<script>
$(function(){
	// var waypoints2 = $('.stats h1').waypoint({
	//   handler: function(direction) {
	//     $('.stats h1').addClass('animated fadeIn')
	//   },
	//   offset: '90%'
	// })
});
</script>
<?php get_footer(); ?>