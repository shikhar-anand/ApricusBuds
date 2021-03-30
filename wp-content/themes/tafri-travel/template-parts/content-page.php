<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package tafri-travel
 */
 ?>

<div class="pages-te">
    <?php if(has_post_thumbnail()) {?>
    <?php the_post_thumbnail(); ?>
    <hr>
    <?php }?>
    <h1><?php the_title(); ?></h1>
    <div class="entry-content"><p><?php the_content();?></p></div>
    <?php
      // If comments are open or we have at least one comment, load up the comment template.
      if ( comments_open() || get_comments_number() ) :
         comments_template();
      endif;
    ?>
    <div class="clear"></div>
</div>
