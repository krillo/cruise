<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
	</div><!-- #main .wrapper -->
  <?php if(!is_front_page()): ?> 
	<footer id="colophon" role="contentinfo">
		<div class="site-info">
			Welcome to Helsingborg - the main alternative to the capital cities in the Baltic sea region.
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
  <?php endif; ?> 
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>