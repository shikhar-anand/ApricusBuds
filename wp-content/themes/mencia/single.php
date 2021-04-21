<?php get_header(); ?>

  <?php while (have_posts()) : 
   the_post();
   ?>
     <!-- Page Header -->
     <header class="masthead" style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url()); ?>')">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="post-heading">
              <h1><?php the_title(); ?></h1>
              <h2 class="subheading"><?php the_excerpt(); ?></h2>
              <span class="meta"><?php esc_html_e('Published by', 'mencia'); ?> <?php the_author(); ?> <?php esc_html_e('in', 'mencia'); ?><?php the_time(get_option('date_format')); ?>
            </span>
          </div>
        </div>
      </div>
    </div>
    </header>

    <!-- Post Content -->
    <article>
      <div class="container" id="site-content">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <?php 
              the_tags(); 
              the_content(); 
            ?>
          </div>
        </div>
      </div>
    </article>     
  <?php endwhile;?>

<?php get_footer(); ?>