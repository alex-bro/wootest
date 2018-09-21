<?php
namespace tsr;

if (!defined('ABSPATH')) exit;

class Ajax
{
    /**
     * construct method
     */
    function __construct()
    {
        add_action('init', [$this, 'ajax_init']);
    }

    /**
     * init ajax actions
     */
    function ajax_init()
    {
        add_action('wp_ajax_nopriv_ajax_add_products', [$this, 'add_products']);
        add_action('wp_ajax_ajax_add_products', [$this, 'add_products']);

	    add_action('wp_ajax_nopriv_ajax_get_count', [$this, 'get_count']);
	    add_action('wp_ajax_ajax_get_count', [$this, 'get_count']);
    }

    function get_count(){
	    check_ajax_referer('ajax-va-nonce', 'security');
	    echo json_encode(Db::get_count_product_db());
	    wp_die();
    }

    function add_products()
    {
	    check_ajax_referer('ajax-va-nonce', 'security');
        $data = $_POST["data"]["count"];
		Db::insert_to_base((int)$data);
        echo json_encode(Db::get_count_product());
        wp_die();
    }


}