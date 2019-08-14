<?php
/*
* Main Temlate
*/
get_header();
?>
<div class="article-wrap">
		<?php if ( have_posts() ) : ?>

			

			<?php
			// Start the loop.
			while ( have_posts() ) :
				the_post();

				the_content();

				// End the loop.
			endwhile;

			

		endif;
		?>
	</div><!-- article-wrap -->
<?php
get_footer();
?> 