<?php
/**
 * Template part for displaying posts
 */

?>
<?php 
  $archive_year  = get_the_time('Y'); 
  $archive_month = get_the_time('m'); 
  $archive_day   = get_the_time('d'); 
?>
<?php
  $content = apply_filters( 'the_content', get_the_content() );
  $video = false;
  // Only get video from the content if a playlist isn't present.
  if ( false === strpos( $content, 'wp-playlist-script' ) ) {
    $video = get_media_embedded_in_content( $content, array( 'video', 'object', 'embed', 'iframe' ) );
  }
?>
<article class="page-box">
  <?php if(get_theme_mod('tafri_travel_blog_description') != 'Post Content'){ ?>
    <div class="box-image">
      <?php
        if ( ! is_single() ) {
          // If not a single post, highlight the video file.
          if ( ! empty( $video ) ) {
            foreach ( $video as $video_html ) {
              echo '<div class="entry-video">';
                echo $video_html;
              echo '</div>';
            }
          };
        };
      ?>
    </div>  
  <?php }?>
  <div class="content">
    <h2><a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo the_title_attribute(); ?>"><?php the_title(); ?><span class="screen-reader-text"><?php the_title();  ?></span></a></h2>
    <?php if(get_theme_mod('tafri_travel_blog_description') == 'Post Content'){ ?>
      <?php the_content(); ?>
    <?php }
    if(get_theme_mod('tafri_travel_blog_description', 'Post Excerpt') == 'Post Excerpt'){ ?>
      <?php if(get_the_excerpt()) { ?>      
        <div class="entry-caption"><p><?php $excerpt = get_the_excerpt(); echo esc_html( tafri_travel_string_limit_words( $excerpt, esc_attr(get_theme_mod('tafri_travel_excerpt_number','30')))); ?><?php echo esc_html( get_theme_mod('tafri_travel_post_excerpt_suffix','{...}') ); ?></p></div>
      <?php } ?>
    <?php }?>
    <?php if( get_theme_mod( 'tafri_travel_date_hide',true) != '' || get_theme_mod( 'tafri_travel_enable_disable_post_date',true) != '') { ?>
      <span class="entry-date"><i class="<?php echo esc_attr(get_theme_mod('tafri_travel_date_icon','fas fa-calendar-alt')); ?>"></i><a href="<?php echo esc_url( get_day_link( $archive_year, $archive_month, $archive_day)); ?>"><?php echo esc_html( get_the_date()); ?><span class="screen-reader-text"><?php echo esc_html( get_the_date() ); ?></span></a></span>
    <?php } ?>  
    <?php if( get_theme_mod('tafri_travel_button_text','READ MORE') != ''){ ?>
      <div class="read-more-btn">
        <a href="<?php the_permalink(); ?>"><?php echo esc_html(get_theme_mod('tafri_travel_button_text','READ MORE'));?><span class="screen-reader-text"><?php echo esc_html(get_theme_mod('tafri_travel_button_text','READ MORE'));?></span></a>
      </div>
    <?php } ?>
  </div>
  <?php if( get_theme_mod( 'tafri_travel_comment_hide',true) != '' || get_theme_mod( 'tafri_travel_author_hide',true) != '' && get_theme_mod( 'tafri_travel_enable_disable_post_comment',true) != '' || get_theme_mod( 'tafri_travel_enable_disable_post_author',true) != '') { ?>
    <div class="metabox">
      <div class="row">
        <div class="col-lg-6 col-md-6 col-6">
          <?php if( get_theme_mod( 'tafri_travel_comment_hide',true) != '' || get_theme_mod( 'tafri_travel_enable_disable_post_comment',true) != '') { ?>
            <span class="entry-comments"><i class="<?php echo esc_attr(get_theme_mod('tafri_travel_comment_icon','fas fa-comments')); ?>"></i> <?php comments_number( __('0 Comment', 'tafri-travel'), __('0 Comments', 'tafri-travel'), __('% Comments', 'tafri-travel') ); ?></span>
          <?php } ?>
        </div>
        <div class="col-lg-6 col-md-6 col-6">
          <?php if( get_theme_mod( 'tafri_travel_author_hide',true) != '' || get_theme_mod( 'tafri_travel_enable_disable_post_author',true) != '') { ?>
            <span class="entry-author"><i class="<?php echo esc_attr(get_theme_mod('tafri_travel_author_icon','fas fa-user')); ?>"></i><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' )) ); ?>"><?php the_author(); ?><span class="screen-reader-text"><?php the_author(); ?></span></a></span>
          <?php } ?>
        </div>
      </div>
    </div>
  <?php } ?>
</article>