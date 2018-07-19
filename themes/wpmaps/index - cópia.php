<?php get_header(); ?>

<div class="container-fluid" ng-controller="MainMap">
	<div class="row" style="border-bottom: 1px solid #ddd; padding-top: 10px; padding-bottom: 10px;">
		<div class="col-12">
			<h1>WP Maps</h1>
		</div>
		<div class="col-12">
				<button class="btn btn-warning" ng-click="mais()">VER TODOS</button>
				<button class="btn btn-info" ng-repeat="tag in tags" ng-click="filterTag(tag.id)" ng-if="tag.count > 0">{{tag.name}}</button>
    <input id="pac-input" class="controls" type="text" placeholder="Search Box">
		</div>
	</div>
	<div class="row">
		<div class="sidebar-map col-md-12 col-lg-4">
			<div class="row">
				<div class="sidebar-post-container col-md-4 col-lg-12" ng-repeat="post in posts">
					<div class="section-frame post-{{post.id}}" ng-class="{{post.class}}" ng-click="pop(post)">
						<img class="img-fluid img-thumbnail" src="{{post.img_thumbnail}}" alt="">
						<h6><small>{{post.date | date }}</small><br>
							{{ post.title.rendered }}</h6>
						<p>A íncrível churreria que vende, todo mês, 3000 unidades de 300 sabores diferentes</p>
					</div>
				</div>
			</div>
					
		</div>
		<div class="map-wrapper col-lg-8" style="padding: 0">
			<div id="map">
				
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>