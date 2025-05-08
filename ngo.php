<?php
/**
 * The main template file for shriramnavyugtrust.org
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 */

get_header();

if ( have_posts() ) :
    while ( have_posts() ) :
        the_post();
        get_template_part( 'template-parts/content', get_post_type() );
    endwhile;
    
    the_posts_pagination();
else :
    get_template_part( 'template-parts/content', 'none' );
endif;

get_sidebar();
get_footer();

