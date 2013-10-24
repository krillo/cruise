<?php
/**
 * Template Name: Home - page-template
 *
 * Description: This is a customized page template for the home page. get_header() gets only the fist part of the header. A specialized one is here
 * Author: Kristian Erendi  <kristian@reptilo.se>
 * Author URI: http://reptilo.se
 * Date: 2013-10-21
 */
?>
<?php get_header(); ?>
<div id="main" class="wrapper">
  <div id="primary" class="">
    <div id="content" role="main">

      <script type="text/javascript" charset="utf-8">
        jQuery(document).ready(function($) {
          //kickstart the slider
          $('.flexslider').flexslider({
            animation: "slide",
            controlNav: false
          });

          //add video and stop the player
          $("#puff1").click(function() {
            var sliderx = $('.flexslider').data('flexslider');
            $('.flexslider').flexslider("stop");
            $("#rep_video").show();
            sliderx.addSlide($("#rep_video"), 0);
            $('.flexslider').flexslider("stop");
            $('.flexslider').flexslider(0);
          });
        });
      </script>        

      <li id="rep_video" style="display:none;"> <?php the_field('video_embed_code'); ?></li>
      <div id="flexslider-container">
        <div class="flexslider" >
          <ul class="slides">
            <?php cruise_list_slideshow(); ?>
          </ul>
        </div>
      </div>
      <header id="rep-header">
        <div id="rep-search-area">
          <?php get_search_form(); ?> <div id="rep-payoff"><?php the_field('payoff'); ?></div>
          <div id="rep-logo"><img src="/wp-content/themes/cruisehelsingborg/images/logo.png" alt="Cruise Helsingborg"/></div>
        </div>
        <nav id="home-page-navigation" class="main-navigation " role="navigation">
          <a class="assistive-text" href="#content" title="<?php esc_attr_e('Skip to content', 'twentytwelve'); ?>"><?php _e('Skip to content', 'twentytwelve'); ?></a>
          <?php wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => 'nav-menu')); ?>
        </nav><!-- #site-navigation -->
      </header>
      <div id="rep-welcome">
        <p><?php the_field('welcome'); ?></p>
      </div>

      <div class="puff" id="puff1"><img src="<?php the_field('bild_url'); ?>" alt="Video of Helsingborg"/><div id="puff1-t1"><?php the_field('bildtext11'); ?></div><br/><div id="puff1-t2"><?php the_field('bildtext12'); ?></div> </div>
      <a href="<?php the_field('extern_lank_2'); ?>" ><div class="puff" id="puff2"><div><?php the_field('lanktext2'); ?> <br/>&raquo;</div></div></a>
      <div class="puff" id="puff3"><a href="<?php
        $post_obj = get_field('sida_3');
        echo $post_obj->guid;
        ?>" ><img src="<?php the_field('bild3'); ?>" alt=""/></a></div>
      <div class="puff last-puff" id="puff4">
        <div>
          <a href="<?php $post_obj = get_field('lank_41');
        echo $post_obj->guid;
        ?>"><?php the_field('text_41'); ?> &raquo;</a><div class="clearfix"></div>
          <a href="<?php $post_obj = get_field('lank_42');
             echo $post_obj->guid;
        ?>"><?php the_field('text_42'); ?> &raquo;</a><div class="clearfix"></div>
          <a href="<?php $post_obj = get_field('lank_43');
             echo $post_obj->guid;
        ?>"><?php the_field('text_43'); ?> &raquo;</a><div class="clearfix"></div>
          <a href="<?php $post_obj = get_field('lank_44');
             echo $post_obj->guid;
        ?>"><?php the_field('text_44'); ?> &raquo;</a><div class="clearfix"></div>
        </div>
      </div>
      <div id="rep-partners" class="rep-footer">
        <div><a href="/?cat=69">Partners</a></div>
        <img src="/wp-content/themes/cruisehelsingborg/images/partners.png" alt="partner to Cruise Helsingborg"/>
      </div>
      <div id="rep-signup" class="rep-footer">
        <div>Sign-up for Newsletter</div>
        <form method="POST" id="2" action="http://www.bwz.se/porthelsingborg/b.aspx?fid=2&amp;ucrc=F925E5E6">
          <input type="hidden" value="" name="hidRecipientId"><input type="hidden" value="CF40F68E" name="hidRecipientCrc">
          <input type="hidden" value="D34TB8" name="hidCaptchaValue" id="hidCaptchaValue">
          <input id="FG_86e26df7685749f6b596ea6e359fa130" name="field_13">
          <input id="FG_c84b3395e0934dd1883982b39c8d7e83" name="field_10" value="Subscribe" size="43" type="submit">
        </form>
      </div>
      <div id="rep-contact" class="rep-footer">
        <div><a href="/?p=100">Contact</a></div>
      </div>
      <div id="rep-copyright" class="rep-footer">
        <div>&copy; <?php echo date('Y'); ?> Cruise Helsingborg</div>
      </div>
    </div><!-- #content -->
  </div><!-- #primary -->
<?php get_footer(); ?>