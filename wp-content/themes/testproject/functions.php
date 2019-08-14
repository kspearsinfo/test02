<?php

add_theme_support('post-thumbnails');
add_post_type_support( 'testing_posts', 'thumbnail' );    

function testproject_theme_scripts() {
    wp_enqueue_script('jquery');
}
add_action( 'wp_enqueue_scripts', 'testproject_theme_scripts' );

function custom_excerpt_length( $length ) {
	return 60;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function create_test_post_type(){
		// Register post types and taxonomies
		$post_type_slug = apply_filters( 'testing_posts_module_slug', 'testing-posts' );
		$post_type_single_name = apply_filters( 'testing_posts_module_single_name', 'Testing Posts' );
		$post_type_plural_name = apply_filters( 'testing_posts_module_plural_name', 'Testing Posts' );
		$post_type_menu_icon = apply_filters( 'testing_posts_module_menu_icon', 'dashicons-analytics' );
		register_post_type( 'testing_posts', array(
			'label' => $post_type_plural_name,
			'labels' => array(
				'name' => $post_type_plural_name,
				'singular_name' => $post_type_single_name,
				'add_new' => 'Add New',
				'add_new_item' => 'Add New ' . $post_type_single_name,
				'edit_item' => 'Edit ' . $post_type_single_name,
				'new_item' => 'New ' . $post_type_single_name,
				'view_item' => 'View '  .$post_type_single_name,
				'view_items' => 'View ' . $post_type_plural_name,
				'search_items' => 'Search ' . $post_type_plural_name,
				'not_found' => 'No ' . strtolower( $post_type_plural_name ) . ' found',
				'not_found_in_trash' => 'No ' . strtolower( $post_type_plural_name ) . ' found in trash',
				'parent_item_colon' => 'Parent ' . $post_type_single_name,
				'all_items' => 'All ' . $post_type_plural_name,
				'archives' => $post_type_single_name . ' Archives',
				'attributes' => $post_type_single_name . ' Attributes',
				'insert_into_item' => 'Insert into ' . $post_type_single_name . ' page',
				'uploaded_to_this_item' => 'Uploaded to ' . $post_type_single_name . ' page'
			),
			'has_archive' => true,
			'hierarchical' => true,
			'public' => true,
			'menu_icon' => $post_type_menu_icon,
			'supports' => array( 'title', 'editor', 'revisions', 'page-attributes' ),
			'rewrite' => array(
				'slug' =>  $post_type_slug
			)
		) );

		$taxonomy_slug = apply_filters( 'testing_posts_taxonomy_slug', 'testingpostcat' );
		$taxonomy_single_name = apply_filters( 'testing_posts_taxonomy_single_name', 'Testing Post Category' );
		$taxonomy_plural_name = apply_filters( 'testing_posts_taxonomy_plural_name', 'Testing Post Category' );

		register_taxonomy( 'testing_posts_module', 'testing_posts', array(
			'label' => $taxonomy_plural_name,
			'labels' => array(
				'name' => $taxonomy_plural_name,
				'singular_name' => $taxonomy_single_name,
				'menu_name' => $taxonomy_plural_name,
				'all_items' => 'All ' . $taxonomy_plural_name,
				'edit_item' => 'Edit ' . $taxonomy_single_name,
				'view_item' => 'View ' . $taxonomy_single_name,
				'update_item' => 'Update ' . $taxonomy_single_name,
				'add_new_item' => 'Add New ' . $taxonomy_single_name,
				'new_item_name' => 'New ' . $taxonomy_single_name . ' Name',
				'parent_item' => 'Parent ' . $taxonomy_single_name,
				'search_items' => 'Search ' . $taxonomy_plural_name,
				'popular_items' => 'Popular ' . $taxonomy_plural_name,
				'separate_items_with_commas' => 'Separate with commas',
				'add_or_remove_items' => 'Add or remove ' . strtolower( $taxonomy_plural_name ),
				'choose_from_most_used' => 'Choose from most used ' . strtolower( $taxonomy_plural_name ),
				'not_found' => 'No ' . strtolower( $taxonomy_plural_name ) . ' found',
			),
			'hierarchical' => true,
			'rewrite' => array(
				'slug' => $taxonomy_slug
			),
			'show_admin_column' => true
		) );
	}
add_action('init','create_test_post_type');	

/*
 * load more script call back
 */
function ajax_script_load_more($args) {
    //init ajax
    $ajax = false;
    //check ajax call or not
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $ajax = true;
    }
    //number of posts per page default
	$posts_per_page = get_option( 'testposts_option_name' );
    $num =$posts_per_page;
    //page number
    $paged = $_POST['page'] + 1;
    //args
    $args = array(
        'post_type' => 'testing_posts',
        'post_status' => 'publish',
        'posts_per_page' =>$num,
        'paged'=>$paged
    );
    //query
    $query = new WP_Query($args);
    //check
    if ($query->have_posts()):
        //loop articales
        while ($query->have_posts()): $query->the_post();
            //include articles template
            //include 'ajax-content.php';
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
        <?php		
        endwhile;
    else:
        echo 0;
    endif;
    //reset post data
    wp_reset_query();
    //check ajax call
    if($ajax) die();
}
/*
 * load more script ajax hooks
 */
add_action('wp_ajax_nopriv_ajax_script_load_more', 'ajax_script_load_more');
add_action('wp_ajax_ajax_script_load_more', 'ajax_script_load_more');
 
 /*
 * enqueue js script
 */
add_action( 'wp_enqueue_scripts', 'ajax_enqueue_script' );
/*
 * enqueue js script call back
 */
function ajax_enqueue_script() {
    wp_enqueue_script( 'script_ajax', get_theme_file_uri( '/js/script_ajax.js' ), array( 'jquery' ), '1.0', true );
	//wp_enqueue_script( 'ava-test-js', plugins_url( '/js/script_ajax.js', __FILE__ ));
}
/*
* Like posts
*/
function post_like_cb(){

	/* Saving ajax value in variable. */ 
	$id = $_POST['id'];
	$liked = $_POST['liked'];
	$user_id = $_POST['user_id'];

	

	if($liked == 'true'){

		$like_meta_name = 'like_post-'.$user_id;
		delete_post_meta($id, $like_meta_name);

		$total_likes = get_post_meta($id, '_likes', true);

		$updated = update_post_meta( $id, '_likes', $total_likes - 1); 

		if(isset($updated)){
			echo wp_send_json_success($total_likes - 1);	
			die();
		}else{
			echo wp_send_json_error('Something went wrong, Please try again later');
			die();
		}

		
	}else{

			$total_likes = get_post_meta($id, '_likes', true);
// echo wp_send_json_success('sa');	
// 				die();

			$updated = update_post_meta( $id, '_likes', $total_likes +  1); 

			if(isset($updated)){

				$like_meta_name = 'like_post-'.$user_id;

				update_post_meta( $id, $like_meta_name, 'true'); 



				echo wp_send_json_success($total_likes +  1);	
				die();
			}else{
				echo wp_send_json_error('Something went wrong, Please try again later');
				die();
			}

	}

}

add_action('wp_ajax_nopriv_post_like', 'post_like_cb');
add_action('wp_ajax_post_like', 'post_like_cb');