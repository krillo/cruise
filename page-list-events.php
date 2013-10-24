<?php
/**
 * Template Name: All events
 *
 * Description: This is a customized page template for listing all cruise calls. They are listed by date, latset cruise call on top. 
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
      <article>
        <div class="entry-content">
          <?php the_content(); ?>
        </div>
      </article>  
    <?php endwhile; // end of the loop. ?>
    <article>
      <div class="entry-content">        
        <?php cruise_list_events(); ?>
      </div>
    </article>
  </div><!-- #content -->
</div><!-- #primary -->
<?php get_footer(); ?>