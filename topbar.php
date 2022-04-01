<?php

/*
Plugin Name:  Top bar plugin
Plugin URI:    
Description:  Displays text at the top of the site, pages or posts.
Version:      1.0
Author:       Kruti Dugade 
Author URI:   h
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  
Domain Path:  /languages
*/

if ( !defined( 'ABSPATH' ) )
exit;

//Adds bar at top of page
add_action('wp_body_open', 'kb_display_topbar');

function get_user_sitename(){
    if( !is_user_logged_in() )
    {
        if (get_option('kb_topbar_field')){
            return get_option('kb_topbar_field');
        } else{
            return 'Welcome to ' . get_bloginfo('name');
        }
        
    }
    else{
        $current_user = wp_get_current_user();
        return 'Welcome back ' . $current_user -> user_login; 
    }
}

function kb_display_topbar(){
    echo '<h3 class="kb"> ' . get_user_sitename() . '</h3>';
}

//CSS for top bar    
add_action('wp_print_styles', 'kb_css');

function kb_css()
{
    echo '
        <style>
            h3.kb  {color: #fff; 
                    margin:0; 
                    padding: 30px;
                    text-align: center;
                    background: orange;
                    }
        </style>
    ';
}


//Top bar plugin page

function kb_topbar_menu(){
    $page_title = 'Top Bar Options';
    $menu_title = 'Top Bar';
    $capability = 'manage_options';
    $slug = 'topbar-plugin';
    $callback = 'kb_topbar_page_html';
    $icon = 'dashicons-schedule';
    $position = 60;

    add_menu_page($page_title, $menu_title, $capability, $slug, $callback, $icon, $position);
}

//creating admin menu 
add_action('admin_menu', 'kb_topbar_menu');

add_action('admin_init', 'kb_topbar_register_settings');

function kb_topbar_register_settings() {
    register_setting('topbar_option_group', 'kb_topbar_field');
}


function kb_topbar_page_html(){ ?>

<div class = "wrap kb-topbar-wrapper">
    <form method="post" action="options.php">
        <?php settings_errors(); ?>
        <?php settings_fields('topbar_option_group'); ?>
        <label for="kb_topbar_field_eat">Top Bar Text:</label>
        <input name="kb_topbar_field" id="kb_topbar_field_eat" type="text" value="<?php echo get_option('kb_topbar_field') ?> ">
        <?php submit_button(); ?>

    </form>
</div>    

<?php }
