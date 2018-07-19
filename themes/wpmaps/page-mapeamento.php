<?php get_header(); ?>
<div id="homecarousel" class="carousel slide" data-ride="carousel" data-interval="false" ng-app="wpMap"  ng-controller="MainMap">
  <div class="carousel-inner">
    <div class="carousel-item">
      <?php include 'inc/map.php' ?>
    </div>
    <div class="carousel-item active">
      <?php include 'inc/hero.php' ?>
    </div>
  </div>
<!--   <a ng-click="initmap()" class="carousel-control-prev" href="#homecarousel" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a ng-click="initmap()" class="carousel-control-next" href="#homecarousel" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a> -->
</div>

<?php include 'inc/roteiros.php'; ?>

<div class="stats container-fluid text-center">
	<div class="row">
		<div class="col">
			<?php $cidades = get_terms('cidade'); ?>
			<h1 class="animate"><?php echo sizeof($cidades)?></h1>
			<p>Municípios</p>
		</div>
		<div class="col">
			<?php $sitios = get_posts(array('post_type' => 'sitio', 'posts_per_page' => -1)); ?>
			<h1 class="animate"><?php echo sizeof($sitios)?></h1>
			<p>Sítios Arqueológicos</p>
		</div>
		<div class="col">
			<?php $roteiros = get_posts(array('post_type' => 'roteiro', 'posts_per_page' => -1)); ?>
			<h1 class="animate"><?php echo sizeof($roteiros)?></h1>
			<p>Roteiros de visita</p>
		</div>
	</div> <!-- row end -->
</div> <!-- container end -->
<div class="sobre wrapper">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-8 text-center">
				<h2>Sobre o projeto</h2>
				<p class="lead">We call it "logic-less" because there are no if statements, else clauses, or for loops. Instead there are only tags. Some tags are replaced with a value, some with nothing, and others with a series of values.</p>
				<a href="<?php echo site_url('/institucional') ?>"><button class="btn btn-lg btn-primary animate">Saiba Mais</button></a>
			</div>
		</div>
	</div>
</div>
<script>
$(function(){
	$('#bs4navbar a').attr('target', '_self')

	var waypoints2 = $('.stats h1').waypoint({
	  handler: function(direction) {
	    $('.stats h1').addClass('animated fadeIn')
	  },
	  offset: '90%'
	})
	var waypoints3 = $('.sobre .btn').waypoint({
	  handler: function(direction) {
	  	setTimeout(function(){
				$('.sobre .btn').addClass('animated fadeIn')
	  	}, 500)
	  },
	  offset: '100%'
	})
});
</script>
<?php include 'inc/appscripts.php'; ?>
<?php get_footer(); ?>