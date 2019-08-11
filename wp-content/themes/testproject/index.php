<?php
/*
* Main Temlate
*/
get_header();
?>
<div class="article-wrap">
		<?php

		 while(have_posts()):
		   the_post();
		?>
		<div class="article">
		<?php if ( has_post_thumbnail() ) { ?>
			<div class="article-photo">
			<img src="<?php the_post_thumbnail_url(); ?>" alt="<?php echo get_the_post_thumbnail_caption(); ?>">
			</div>
		<?php } ?>
			<div class="article-info">
				<h3><?php the_title(); ?></h3>
				<?php the_excerpt(); ?>
				<a href="<?php the_permalink(); ?>" class="btn">Click Here</a>
			</div>
		</div>
		<?php endwhile; ?>
		<?php wp_reset_query(); ?>
		<?php echo do_shortcode('[ajax_posts]'); ?>
	</div><!-- article-wrap -->
<?php
get_footer();
?> 