<?php get_header(); ?>
  <div class="container" id="site-content">
    <div class="col-lg-8 col-md-10 mx-auto">
        <h1 class="page-title">
          <?php printf( esc_html__( 'Results found: %s', 'mencia' ), '<span>' . get_search_query() . '</span>' ); ?>       
        </h1>  
          
        <?php if (have_posts()) : 
          while (have_posts()) : 
            the_post();
            ?>
          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h2>
              <a href="<?php the_permalink(); ?>">
                <?php the_title(); 
                 the_time('Y-m-d'); 
                 the_author(); 
                 ?>
              </a>
            </h2>  
            <div class="">
              <a href="<?php the_permalink(); ?>"></a>
            </div>                          
          </article>
          <?php endwhile;
            
            else : 
         
              get_template_part( 'parts/content', 'none' );
         
          endif; ?>
        <div class="pager">
          <?php get_template_part( 'pagination' ); ?>    
        </div><!--.pager--> 
      </div>    
    </div><!--.col-lg-8 col-md-10 mx-auto-->
  </div><!--.container-->

<?php get_footer(); ?>