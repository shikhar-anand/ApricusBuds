<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Mencia
 */

?>
<div class="post-preview">
  <a href="<?php the_permalink(); ?>">
    <h2 class="post-title">
      <?php the_title(); ?>
    </h2>
    <h3 class="post-subtitle">
      <?php the_excerpt(); ?>
    </h3>
  </a>
  <p class="post-meta"><?php esc_html_e('Published by', 'mencia'); ?> 
  		<?php the_author(); ?> <?php esc_html_e('in', 'mencia'); ?>  	
  		<?php the_time(get_option('date_format')); ?>
  	</p>
</div>
<hr>