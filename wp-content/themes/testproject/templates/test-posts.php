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
		<div class="article <?php the_ID();?>">
		<?php if ( has_post_thumbnail() ) { ?>
			<div class="article-photo">
			<img src="<?php the_post_thumbnail_url(); ?>" alt="<?php echo get_the_post_thumbnail_caption(); ?>">
			</div>
		<?php } ?>
			<div class="article-info">
				<h3><?php the_title(); ?></h3>
				<?php the_excerpt(); ?>
				<a href="<?php the_permalink(); ?>" class="btn">Click Here</a>


				<div class="likes_holder position">
				<?php if(is_user_logged_in()):
					  

					$c_user_id = get_current_user_id();
					$like_meta_name = 'like_post-'.$c_user_id;

					$liked_val = get_post_meta(get_the_ID(), $like_meta_name, true);
   // delete_post_meta(get_the_ID(), '_likes'); delete_post_meta(get_the_ID(), $like_meta_name);
					if(isset($liked_val) && 'true' == $liked_val):
						$is_liked = 'true'; $liked_class = 'liked';

						else: $is_liked = 'false'; $liked_class = null;
					endif;	

					   // echo "<pre>"; print_r($liked_val);exit();

				 ?>	
				 <?php if(get_post_meta(get_the_ID(), '_likes', true) == 1) :?>
					<i class=" fa fa-heart add_like <?php echo $liked_class; ?>" data-liked="<?php echo $is_liked; ?>" data-user_id="<?php echo get_current_user_id(); ?>" data-id="<?php echo get_the_ID(); ?>" aria-hidden="true" style="color: green;"></i> 
				<?php endif; ?>	
				<?php if(get_post_meta(get_the_ID(), '_likes', true) == 0) :?>
					<i class=" fa fa-heart add_like <?php echo $liked_class; ?>" data-liked="<?php echo $is_liked; ?>" data-user_id="<?php echo get_current_user_id(); ?>" data-id="<?php echo get_the_ID(); ?>" aria-hidden="true" ></i> 
				<?php endif; ?>	
				<?php  endif; ?>	
				<span class="total_likes"><?php //echo get_post_meta(get_the_ID(), '_likes', true); ?></span></div>
			</div>
		</div>
		<?php endwhile; endif; ?>
		<?php wp_reset_query(); ?>
		<?php echo do_shortcode('[ajax_posts]'); ?>
	</div><!-- article-wrap -->
<?php
get_footer();
?> 