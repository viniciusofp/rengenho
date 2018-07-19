<?php get_header('dois'); ?>
<div class="archive-roteiro" ng-app="wpMap" ng-controller="Roteiro">
	<div class="container roteiro-menu">
		<div class="row">
			<div class="col-sm-12">
				<form>
				  <div class="row">
				    <div class="col-sm-4">
				    	<label for="cidadeselect">Cidade</label>
				    	<?php
				    	$cities = get_terms(array(
							    'taxonomy' => 'cidade',
							    'hide_empty' => false,
							));
				    	?>
				    	<div class="select-div">
				    		<i class="fas fa-angle-down select-caret"></i>
					      <select ng-change="changecity()" ng-model="cidadeFilter" name="cidade" id="cidadeselect" class="form-control">
					      	<option value="todas" selected>Todas</option>
					      	<?php foreach ($cities as $cidade): ?>
					      		<option value="<?php echo $cidade->slug ?>"><?php echo $cidade->name ?></option>
					      	<?php endforeach ?>
<!-- 					      	<option value="{{cidade.slug}}" ng-repeat="cidade in cidades" ng-bind-html="cidade.name"></option>
 -->					      </select>
				    	</div>
				    </div>
				    <div class="col-sm-4">
				    	<label for="categoriaselect">Categoria</label>
				    	<?php
				    	$cats = get_terms(array(
							    'taxonomy' => 'category',
							    'hide_empty' => false,
							));
				    	?>
				    	<div class="select-div">
				    		<i class="fas fa-angle-down select-caret"></i>
					      <select ng-change="changecat()" ng-model="catFilter.categoria" name="categoria" id="catselect" class="form-control">
					      	<option value="todas" selected>Todas</option>
					      	<?php foreach ($cats as $cat): ?>
					      		<option value="<?php echo $cat->name ?>"><?php echo $cat->name ?></option>
					      	<?php endforeach ?>
					      </select>
				    	</div>
				    </div>
				    <div class="col">
				    	<label for="deslocamentoslider">Deslocamento</label>
				      <rzslider id="deslocamentoslider" rz-slider-model="slider.minValue"
          rz-slider-high="slider.maxValue"
          rz-slider-options="slider.options"></rzslider>
				    </div>
				  </div>
				</form>
			</div>
		</div>
	</div>
	<div class=" container">
		<div class="row">

				<div class="col-12 col-md-6 col-xl-4" ng-repeat="post in filteredPosts = (posts | filter: catFilter)">

					<a href="{{post.link}}">
						<div class="box" style="background-image: url('{{post.img_large}}')">
							<div class="shadow">
								<div class="meta">
									<h2 class="title" ng-bind-html="post.title.rendered"></h2>
									<small class="cidade" ng-repeat="cidade in post.cidades">{{cidade.name}}</small>
									<span class="deslocamento"><i class="fas fa-walking"></i> {{post.deslocamento}} km</span>
								</div>
							</div>
						</div>
					</a>
				</div>
				<div class="col-sm-12" ng-if="posts.length == 0">
					<h1>Não há roteiro para esses filtros.</h1>
				</div>

		</div>
	</div>
</div>

	
<?php include 'inc/appscripts.php' ?>
<?php get_footer(); ?>