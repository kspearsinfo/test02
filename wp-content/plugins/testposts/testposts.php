<?php 
    /*
    Plugin Name: Test Posts Load More
    Description: Load more test posts on page scroll
    Author: Developer
    Version: 1.0
    */
	error_reporting(0);
	require_once(ABSPATH .'/wp-admin/includes/plugin.php');

    function testposts_register_settings() 
    {
       add_option( 'testposts_option_name', '0');
       register_setting( 'testposts_options_group', 'testposts_option_name', 'myplugin_callback' );
    }
    add_action( 'admin_init', 'testposts_register_settings' );

    function testposts_register_options_page() 
    {
      add_options_page('Page Title', 'Test Posts Options', 'manage_options', 'myplugin', 'myplugin_options_page');
    }
    add_action('admin_menu', 'testposts_register_options_page');

    function myplugin_options_page()
    {
    ?>
      <div>
        <?php screen_icon(); ?>
        <h2>Test Page Options</h2>
        <form method="post" action="options.php">
          <?php settings_fields( 'testposts_options_group' ); ?>
          <table>
            <tr valign="top">
              <th scope="row"><label for="myplugin_option_name">Posts Per Page:</label></th>
              <td><input type="text" id="testposts_option_name" name="testposts_option_name" value="<?php echo get_option('testposts_option_name'); ?>" /></td>
            </tr>
        </table>
        <?php  submit_button(); ?>
      </form>
      </div>
    <?php
    } 
    function script_load_more($args = array()) {
                ajax_script_load_more($args);
            echo '<a  style="text-indent:-400px;" href="#" id="loadMore"  data-page="1" data-url="'.admin_url("admin-ajax.php").'" >loadMore</a>';
    }
    add_shortcode('ajax_posts', 'script_load_more');