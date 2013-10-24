<?php

$args = array(
    'width' => 960,
    'height' => 120,
);
add_theme_support('custom-header', $args);

function insert_analytics_script() {
  echo <<<EOD
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-10755363-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
EOD;
}

add_action('wp_head', 'insert_analytics_script');



add_action('wp_enqueue_scripts', 'cruise_scripts');

/**
 * Enqueue some java scripts, only on front page
 * 
 * Author: Kristian Erendi 
 * URI: http://reptilo.se 
 * Date: 2013-10-22
 */
function cruise_scripts() {
  if (is_front_page()) {
    wp_register_style('custom-style', get_bloginfo('stylesheet_directory') . '/flexslider/flexslider.css', array(), '20120208', 'all');
    wp_enqueue_style('custom-style');
    wp_enqueue_script('flexslider', get_stylesheet_directory_uri() . '/flexslider/jquery.flexslider.js', array('jquery'));
  }
}

add_action('init', 'cruise_create_post_type');

/**
 * Custom posttype named Slideshow.
 * All images added here will show in the slideshow on first page
 * 
 * Author: Kristian Erendi 
 * URI: http://reptilo.se 
 * Date: 2013-10-22
 */
function cruise_create_post_type() {
  register_post_type('Slideshow', array(
      'labels' => array(
          'name' => __('Slideshow'),
          'singular_name' => __('Slide')
      ),
      'public' => true,
      'has_archive' => false,
          )
  );
  register_post_type('cruisecalls', array(
      'labels' => array(
          'name' => __('Cruise calls'),
          'singular_name' => __('Cruise call')
      ),
      'public' => true,
      'has_archive' => false,
      'supports' => array('title', 'editor', 'thumbnail', 'comments'),
          )
  );
  register_post_type('events', array(
      'labels' => array(
          'name' => __('Events'),
          'singular_name' => __('Event')
      ),
      'public' => true,
      'has_archive' => false,
          )
  );
  register_post_type('guestbook', array(
      'labels' => array(
          'name' => __('Guestbook'),
          'singular_name' => __('Guestbook')
      ),
      'public' => true,
      'has_archive' => false,
      'supports' => array('title', 'editor', 'thumbnail', 'comments'),
          )
  );
}

/**
 * List all images in the Slideshow.
 * 
 * Author: Kristian Erendi 
 * URI: http://reptilo.se 
 * Date: 2013-10-22
 */
function cruise_list_slideshow() {
  global $post;
  $args = array('post_type' => 'Slideshow', 'posts_per_page' => 16);
  $loop = new WP_Query($args);
  if ($loop->have_posts()):
    while ($loop->have_posts()) : $loop->the_post();
      echo '<li class="rep-slideshow-li"><img src="' . get_field('bild') . '" alt="Cruise the Baltic Sea, Helsingborg Sweden" /></li>';
    endwhile;
  endif;
  wp_reset_query();
}

/**
 * List all images in the Slideshow.
 * 
 * Author: Kristian Erendi 
 * URI: http://reptilo.se 
 * Date: 2013-10-23
 */
function cruise_list_guestbook() {
  global $post;
  $args = array('post_type' => 'guestbook', 'orderby' => 'modified', 'order' => 'DESC');
  $loop = new WP_Query($args);
  if ($loop->have_posts()):
    while ($loop->have_posts()) : $loop->the_post();
      //print_r($post);
      $title = $post->post_title;
      $permalink = get_permalink($post->ID);
      $img_url = $post->ID;
      $img = get_the_post_thumbnail($post->ID, 'thumbnail');
      echo <<<POST
<div class="rep-guestbook-puff">
  <a href="{$permalink}" title="{$title}">{$img}</a>
  <div class="">
    {$title}
  </div>
</div>  
POST;
    endwhile;
  endif;
  wp_reset_query();
}

/**
 * List all events. Order by slutdatum.
 * 
 * Author: Kristian Erendi 
 * URI: http://reptilo.se 
 * Date: 2013-10-23
 */
function cruise_list_events() {
  global $post;
  $today = date('Y-m-d');
  $args = array('post_type' => 'events', 'meta_key' => 'slutdatum', 'orderby' => 'meta_value', 'order' => 'DESC',
      'meta_query' => array(
          array(
              'key' => 'slutdatum',
              'value' => $today,
              'compare' => '>='
          )
      )
  );
  $loop = new WP_Query($args);
  if ($loop->have_posts()):
    while ($loop->have_posts()) : $loop->the_post();
      //print_r($post);
      $title = $post->post_title;
      $post_content = $post->post_content;
      $extern_lank = get_field('extern_lank');
      $startdatum = get_field('startdatum');
      $slutdatum = get_field('slutdatum');
      $klockslag = get_field('klockslag');
      echo <<<POST
<p><strong>{$startdatum} - {$slutdatum}</strong><br>
<a href="{$extern_lank}">{$title}</a> {$klockslag}<br>
{$startdatum}<br>
{$post_content}
</p>
POST;
    endwhile;
  endif;
  wp_reset_query();
}



/**
 * List all cruisecalls. Order by year and date.
 * 
 * Author: Kristian Erendi 
 * URI: http://reptilo.se 
 * Date: 2013-10-24
 */
function cruise_list_cruisecalls() {
  global $post;
  $output = '';
  $newTable = true;
  $tableYear = 0;
  $args = array('post_type' => 'cruisecalls', 'meta_key' => 'datum', 'orderby' => 'meta_value', 'order' => 'DESC',);
  $loop = new WP_Query($args);  
  if ($loop->have_posts()){
    while ($loop->have_posts()){ 
      $loop->the_post();
      $datum = get_field('datum');
      $day = date("j", strtotime($datum));
      $month = date("F", strtotime($datum));
      $year = date("Y", strtotime($datum));
      $weekday = date("l", strtotime($datum));
      $title = $post->post_title;
      $extern_lank = get_field('extern_lank');
      $cruise_line = get_field('cruise_line');
      $hamn = get_field('hamn');
      $klockslag = get_field('klockslag');
      
      
      if($newTable === false && $tableYear != $year){
        $newTable = true;
        $output .= _cruise_calls_table_footer($year);
      }
      if($newTable === true && $tableYear != $year){
        $newTable = false;
        $tableYear = $year;
        $output .= _cruise_calls_table_top($year);
      }
      
      $output .= <<<POST
        </tr>  
          <td>{$month}</td>
          <td>{$day}</td>
          <td>{$klockslag}</td>
          <td>{$weekday}</td>
          <td>{$title}</td>
          <td><p align="left"><a href="{$extern_lank}">{$cruise_line}</a></p></td>
          <td>{$hamn}</td>
        </tr>
POST;
    }
  }
  $output .= _cruise_calls_table_footer($year);
  wp_reset_query();  
  echo $output;
}

/**
 * Help function to cruise_list_cruisecalls
 * 
 * Author: Kristian Erendi 
 * URI: http://reptilo.se 
 * Date: 2013-10-24
 *
 * @param type $year
 * @return type
 */
function _cruise_calls_table_top($year){
  return <<<OUT
<div class="entry-content">
  <p>Cruise calls {$year}</p>
  <div id="">
    <table border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
      <tbody>
        <tr>
          <td><strong>Month</strong></td>
          <td><p align="left"><strong>Day</strong></p></td>
          <td><strong>Time</strong></td>
          <td><strong>Weekday</strong></td>
          <td><strong>Ship</strong></td>
          <td><strong>Cruiseline</strong></td>
          <td><strong>Port area</strong></td>
        </tr>
OUT;
}

/**
 * Help function to cruise_list_cruisecalls
 * 
 * Author: Kristian Erendi 
 * URI: http://reptilo.se 
 * Date: 2013-10-24
 *
 * @return type
 */
function _cruise_calls_table_footer(){
  return <<<OUT
      </tbody>
    </table>
  </div>
</div>
OUT;
}        
