<?php get_header(); ?>

  <!-- Page Header -->
  <header class="masthead" style="background-image: url('<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/home-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <h1><?php bloginfo( 'name' ); ?></h1>
            <span class="subheading"><?php bloginfo('description'); ?></span>
          </div>
        </div>
      </div>
    </div>
  </header>


  <!-- Main Content -->
  <div class="container" id="site-content">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        <?php if (have_posts()) : 
          while (have_posts()) : 
            the_post();
            
            get_template_part( 'parts/content', get_post_format() );

            endwhile;

            ?>

            <?php get_template_part( 'pagination' ); ?>
            
           
            
            <?php

            else :

              get_template_part( 'parts/content', 'none' );

            endif; ?>       
      </div>
    </div>
  </div>

  <?php get_footer(); ?>