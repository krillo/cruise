<?php
/**
 * Template Name: All cruise calls items
 *
 * Description: This is a customized page template for listing all cruise calls items. They are listed by date, latset cruise call on top. 
 * Author: Kristian Erendi  <kristian@reptilo.se>
 * Author URI: http://reptilo.se
 * Date: 2013-10-23
 */
?>
<?php get_header(); ?>
<div id="primary" class="site-content rep-full-width">
  <div id="content" role="main">
    <?php while (have_posts()) : the_post(); ?>
      <?php if (has_post_thumbnail()) : ?>
        <div class="entry-page-image">
          <?php the_post_thumbnail(); ?>
        </div><!-- .entry-page-image -->
      <?php endif; ?>
      <?php get_template_part('content', 'page'); ?>
    <?php endwhile; // end of the loop. ?>
    <?php cruise_list_cruisecalls(); ?>
  </div><!-- #content -->
</div><!-- #primary -->
<!--?php get_sidebar( 'front-left' ); ?-->
<!--?php get_sidebar( 'front-right' ); ?-->
<?php get_footer(); ?>
