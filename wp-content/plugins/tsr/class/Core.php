<?php
namespace tsr;

if (!defined('ABSPATH')) exit;

class Core
{
	/**
	 * @var string version of theme
	 */
	public $version;

	static public $plugin_dir, $plugin_url;
    /**
     * construct method
     */
    function __construct()
    {
	    self::$plugin_dir = str_replace('class/', '', plugin_dir_path(__FILE__));
	    self::$plugin_url = plugins_url('tsr');

	    $this->version = '0.0.1';

	    $ajax = new Ajax();

	    add_action('wp_enqueue_scripts', [$this, 'add_scripts']);
	    add_shortcode( 'abv_show_table' , [$this, 'add_shortcode'] );
	    add_action('wp_footer', [$this, 'show_footer']);

    }

	/**
	 * add scripts and styles
	 */
	function add_scripts()
	{
		wp_enqueue_style('bootstrap-css', plugins_url('tsr') . '/assets/lib/bootstrap-4.0.0-dist/css/bootstrap.min.css', array(), $this->version);
		wp_enqueue_style('main-css', plugins_url('tsr') . '/assets/css/front-style.css', array(), $this->version);

		wp_enqueue_script('jquery-3-2-1', plugins_url('tsr') . '/assets/lib/jquery-3.2.1.min.js', array(), $this->version, true);
		wp_enqueue_script('popper', plugins_url('tsr') . '/assets/lib/bootstrap-4.0.0-dist/js/popper.min.js', array(), $this->version, true);
		wp_enqueue_script('bootstrap-js', plugins_url('tsr') . '/assets/lib/bootstrap-4.0.0-dist/js/bootstrap.min.js', array(), $this->version, true);
		wp_enqueue_script('main-js', plugins_url('tsr') . '/assets/js/main-front.js', array(), $this->version, true);

		wp_localize_script('jquery-3-2-1', 'abv', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
		));
	}

    /**
     * add nonce field to front pages
     */
    function show_footer()
    {
	    wp_nonce_field('ajax-va-nonce', 'security_va');
    }


    function add_shortcode(){
	    ob_start();
	    include self::$plugin_dir.DIRECTORY_SEPARATOR.'template-parts'.DIRECTORY_SEPARATOR.'shortcode-part.php';
	    $html = ob_get_contents();
	    ob_end_clean();
	    return $html;
    }
}