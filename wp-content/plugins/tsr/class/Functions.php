<?php
namespace tsr;

if (!defined('ABSPATH')) exit;

class Functions
{
    /**
     * construct method
     */
    function __construct()
    {

    }

    /**
     * get current dmt time
     */
    static function get_time_gmt()
    {
        return time() + (get_option('gmt_offset') * 60 * 60);
    }

	static function RandomString()
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randstring = '';
		for ($i = 0; $i < 10; $i++) {
			$randstring = $characters[rand(0, strlen($characters))];
		}
		return $randstring;
	}

}