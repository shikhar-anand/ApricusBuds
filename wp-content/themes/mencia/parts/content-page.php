<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Mencia
 */

?>
  <!-- Page Header -->
  <header class="masthead" style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url()); ?>')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="page-heading">
            <h1><?php the_title(); ?></h1>
            <hr class="small">
            <span class="subheading"><?php echo esc_html(get_post_meta(get_the_ID(),'subtitle',true)); ?></span>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <div class="container" id="site-content">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        <?php 
          the_content();
          wp_link_pages();
        ?>
      </div>
      <div>
        <?php comments_template(); ?>
      </div>  
    </div>
  </div>