<?php
/**
 * The template part for displaying single post
 *
 * @package tafri-travel
 * @subpackage tafri-travel
 * @since tafri-travel 1.0
 */
?>  
<?php 
  $archive_year  = get_the_time('Y'); 
  $archive_month = get_the_time('m'); 
  $archive_day   = get_the_time('d'); 
?>
<article class="page-box-single">
  <?php if( get_theme_mod( 'tafri_travel_single_post_image',true) != '') { ?>
    <div class="box-img">
      <?php the_post_thumbnail(); ?>
    </div>
  <?php } ?>
  <div class="new-text">
    <h1><?php the_title(); ?></h1>
    <?php if( get_theme_mod( 'tafri_travel_single_post_date',true) != '' || get_theme_mod( 'tafri_travel_single_post_comment',true) != '' || get_theme_mod( 'tafri_travel_single_post_author',true) != '') { ?>
      <div class="metabox">
        <?php if( get_theme_mod( 'tafri_travel_single_post_date',true) != '') { ?>
          <span class="entry-date"><i class="<?php echo esc_attr(get_theme_mod('tafri_travel_date_icon','fas fa-calendar-alt')); ?>"></i><a href="<?php echo esc_url( get_day_link( $archive_year, $archive_month, $archive_day)); ?>"><?php echo esc_html( get_the_date()); ?><span class="screen-reader-text"><?php echo esc_html( get_the_date() ); ?></span></a></span><?php echo esc_html( get_theme_mod('tafri_travel_seperator_metabox') ); ?>
        <?php } ?>
        <?php if( get_theme_mod( 'tafri_travel_single_post_comment',true) != '') { ?>
          <span class="entry-comments"><i class="<?php echo esc_attr(get_theme_mod('tafri_travel_comment_icon','fas fa-comments')); ?>"></i> <?php comments_number( __('0 Comment', 'tafri-travel'), __('0 Comments', 'tafri-travel'), __('% Comments', 'tafri-travel') ); ?></span><?php echo esc_html( get_theme_mod('tafri_travel_seperator_metabox') ); ?>
        <?php } ?>
        <?php if( get_theme_mod( 'tafri_travel_single_post_author',true) != '') { ?>
          <span class="entry-author"><i class="<?php echo esc_attr(get_theme_mod('tafri_travel_author_icon','fas fa-user')); ?>"></i><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' )) ); ?>"><?php the_author(); ?><span class="screen-reader-text"><?php the_author(); ?></span></a></span>
        <?php } ?>
        <?php if( get_theme_mod( 'tafri_travel_single_post_time',false) != '' || get_theme_mod( 'tafri_travel_enable_disable_single_post_time',false) != '') { ?>
          <span class="entry-time"><i class="<?php echo esc_attr(get_theme_mod('tafri_travel_post_time_icon','fas fa-clock')); ?>"></i> <?php echo esc_html( get_the_time() ); ?></span>
        <?php }?>
      </div>
    <?php } ?>
    <div class="entry-caption"><p><?php the_content();?></p></div>
    <?php if( get_theme_mod( 'tafri_travel_tags_hide',true) != '') { ?>
      <div class="tags"><p><?php
        if( $tags = get_the_tags() ) {
          echo '<span class="meta-sep"></span>';
          foreach( $tags as $content_tag ) {
            $sep = ( $content_tag === end( $tags ) ) ? '' : ' ';
            echo '<a href="' . esc_url(get_term_link( $content_tag, $content_tag->taxonomy )) . '">' . esc_html($content_tag->name) . '</a>' . esc_html($sep);
          }
        } ?></p></div>
    <?php } ?>
  </div>

  <div class="clearfix"></div>
</article>

<?php if (get_theme_mod('tafri_travel_related_posts',true) != '') {
  get_template_part( 'template-parts/related-posts' );
}