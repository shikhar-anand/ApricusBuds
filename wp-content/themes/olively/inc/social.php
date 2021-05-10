<?php
/*
** Template to Render Social Icons on Top Bar
*/

$social_networks = array( //Redefinied in Sanitization Function.
	'facebook-f' 	=> 'Facebook',
	'twitter' 		=> 'Twitter',
	'instagram' 	=> 'Instagram',
	'rss' 			=> 'RSS Feeds',
	'pinterest-p' 	=> 'Pinterest',
	'vimeo' 		=> 'Vimeo',
	'youtube' 		=> 'YouTube',
	'flickr' 		=> 'Flickr',
);

for ($i = 1; $i < 7; $i++) :
	$social = get_theme_mod('olively_social_'.$i);
	$social_url = get_theme_mod('olively_social_url'.$i);
	if ( ($social != 'none') && ($social != '') && ($social_url !='' ) ) : ?>

            <div class="icon">
                <a href="<?php echo esc_url($social_url); ?>" target="_blank">
                    <i class="fa fa-<?php echo esc_attr($social); ?>"></i>
                </a>
            </div>
	<?php endif;

endfor; ?>