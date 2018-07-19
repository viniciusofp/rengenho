<div class="hero wrapper">
	<div class="container">
		<div class="row h-100 align-items-center">
			<div class="col-lg-12 col-xl-10">
				<h1>Descubra a <br>Baixada Santista</h1>
				<p class="lead">Navegue entre roteiros culturais e sítios arqueológicos e explore a Baixada Santista</p>
				<form role="search" method="get" action="<?php echo home_url(); ?>/">
				  <div class="form-row">
				    <div class="col-12 col-md-3">
				      <input name="s" type="text" class="form-control" placeholder="Palavra Chave">
				    </div>
				    <div class="col-6 col-md-3">
				    	<div class="select-div">
				    		<i class="fas fa-angle-down select-caret"></i>
					      <select name="cidade" class="form-control">
					        <option selected disabled>Cidade</option>
						      <?php $cidades = get_terms('cidade');
					    		foreach ($cidades as $cidade) {
					    			echo '<option value="'. $cidade->slug . '">' . $cidade->name . '</option>';
					    		 } ?>
					      </select>
					    </div>
				    </div>
				    <div class="col-auto">
				    	<input type="hidden" name="post_type" value="sitio" /> <!-- // hidden 'products' value -->

				      <button  class="form-control btn btn-success"><i class="fas fa-search"></i></button>
				    </div>
				  </div>
				</form>
				<a ng-click="initmap()" href="#homecarousel" role="button" data-slide="next">
					<div class="navegue">
						<h6>Navegue pelo mapa!</h6>
						<div class="map-icon">
							<img src="<?php echo get_template_directory_uri(); ?>/img/map-pin.png" alt="">
						</div>
					</div>
				</a>
			</div> <!-- col end -->
		</div> <!-- row end -->
	</div> <!-- container end -->
</div> <!-- hero wrapper end -->