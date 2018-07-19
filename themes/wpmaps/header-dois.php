<?php include 'inc/header-main.php' ?>
<span class="d-none apiurl"><?php echo site_url('/') ?></span>
<script>
  var url = jQuery('.apiurl').html();
</script>
  <nav class="navbar navbar-expand-lg navbar-dark bg-faded navbar-dois">
    <div class="container">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#bs4navbar" aria-controls="bs4navbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>
"><img src="<?php echo get_template_directory_uri(); ?>/img/bndes-logo.png" alt=""><img src="<?php echo get_template_directory_uri(); ?>/img/resje-logo.png" alt=""></a>
      <?php
        wp_nav_menu([
          'menu'            => 'top',
          'theme_location'  => 'first-menu',
          'container'       => 'div',
          'container_id'    => 'bs4navbar',
          'container_class' => 'collapse navbar-collapse ',
          'menu_id'         => false,
          'menu_class'      => 'navbar-nav ml-auto',
          'depth'           => 2,
          'fallback_cb'     => 'bs4navwalker::fallback',
          'walker'          => new bs4navwalker()
        ]);
      ?>
    </div>
 </nav>
    