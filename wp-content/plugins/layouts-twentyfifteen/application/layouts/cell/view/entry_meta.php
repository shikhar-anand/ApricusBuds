<?php if(is_single()):?>
<footer class="entry-footer">
        <?php twentyfifteen_entry_meta(); ?>
        <?php edit_post_link( __( 'Edit', 'twentyfifteen' ), '<span class="edit-link">', '</span>' ); ?>
</footer><!-- .entry-footer -->
<?php endif;?>