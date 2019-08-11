<?php
/*
* Template Name: Test Posts
*/
get_header();

$posts_per_page = get_option( 'testposts_option_name' );
?>
<div class="article-wrap" id="ajax-content">
		<?php
		$args = array(
		'post_type' => 'testing_posts',
		'posts_per_page' => $posts_per_page,
		'order' => 'DESC'
		);
		$query = new WP_Query( $args );
		if($query->have_posts()):
		 while($query->have_posts()):
		   $query->the_post();
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
		<?php endwhile; endif; ?>
		<?php wp_reset_query(); ?>
		<?php echo do_shortcode('[ajax_posts]'); ?>
	</div><!-- article-wrap -->
<?php
get_footer();
?> 