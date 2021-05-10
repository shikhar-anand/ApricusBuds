<!-- Pager -->
<?php if(get_previous_posts_link() || get_next_posts_link() ) {?>

    <?php previous_posts_link (__('&larr; Recents', 'mencia') ); ?>
        
    <?php next_posts_link (__('Previous &rarr;', 'mencia') ); ?>

<?php } ?>

  