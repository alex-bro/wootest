<?php
namespace tsr;
if (!defined('ABSPATH')) exit;

class Settings
{
    /**
     * construct method
     */
    function __construct()
    {
        add_action('init', [$this, 'init']);
        add_action('save_post', [$this, 'save_post']);
        add_action('add_meta_boxes', [$this, 'add_meta_boxes']);
        add_action('edit_form_after_editor', [(new Widgets()), 'la_all_setting_meta_callback']);
    }

    /**
     * add meta boxes
     */
    function add_meta_boxes()
    {
        add_meta_box('la_setting_id', __('Settings','linxact'), [(new Widgets()), 'la_setting_meta_callback'], 'la_notification_meta_setting','normal');
        add_meta_box('la_color_id', __('Color','linxact'), [(new Widgets()), 'la_color_meta_callback'], 'la_notification_meta_color','normal');
        add_meta_box('la_position_id', __('Position','linxact'), [(new Widgets()), 'la_position_meta_callback'], 'la_notification_meta_position','normal');

        add_meta_box('la_time_id', __('Set date and time','linxact'), [(new Widgets()), 'la_time_meta_callback'], 'la_notification','side');
        add_meta_box('la_pages_id', __('Select pages','linxact'), [(new Widgets()), 'la_pages_meta_callback'], 'la_notification', 'side');
    }



    function init()
    {
        register_post_type('la_notification',
            array(
                'labels' => array(
                    'name' => __('Notification','linxact'),
                    'singular_name' => __('Notification','linxact'),
                    'add_new' => __('Add New Notification','linxact'),
                    'add_new_item' => __('Add New Notification','linxact'),
                    'edit' => __('Edit','linxact'),
                    'edit_item' => __('Edit Notification','linxact'),
                    'new_item' => __('New Notification','linxact'),
                    'view' => __('View','linxact'),
                    'view_item' => __('View Notification','linxact'),
                    'search_items' => __('Search Notification','linxact'),
                    'not_found' => __('Notification not found','linxact'),
                    'not_found_in_trash' => __('Notification not found in trash','linxact'),
                    'parent' => __('Parent Notification','linxact')
                ),
                'show_in_menu'=>true,
                'menu_icon'=>'dashicons-flag',
                'show_ui' => true,
                'public' => false,
                'supports' => array('title', 'editor'),
                'taxonomies' => array(''),
                'has_archive' => true,
            )
        );
    }



    /**
     * save notification to wp
     */
    function save_post($post_id)
    {
        if (
            get_post_type($post_id) == "la_notification"
        ) {
            global $abv_linxact;
            if (!isset($_POST['abv_nonceName']))
                return $post_id;

            if (!wp_verify_nonce($_POST['abv_nonceName'], $abv_linxact::$plugin_dir))
                return $post_id;

            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
                return $post_id;

            if ('page' == $_POST['post_type'] && !current_user_can('edit_page', $post_id)) {
                return $post_id;
            } elseif (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }

            //////////////////////////

            if (get_post_type($post_id) == "la_notification") {
                $la_notification = [];
                if (isset($_POST['la_start_time'])) {
                    $la_notification['la_start_time'] = $_POST['la_start_time'];
                } else {
                    $la_notification['la_start_time'] = '';
                }


                update_post_meta($post_id, 'la_notification_meta_value_key', $la_notification);
            }

        }
    }
}