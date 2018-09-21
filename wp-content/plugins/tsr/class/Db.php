<?php

namespace tsr;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Db {
	static public $table;

	/**
	 * construct method
	 */
	function __construct() {
		global $wpdb;
		self::$table = $wpdb->get_blog_prefix() . 'abv_tsr';

	}

	static function get_count_product() {
		$count_posts = wp_count_posts( 'product' );

		return $count_posts->publish;
	}

	static function get_count_product_db() {
//    	global $wpdb;
//    	$res = $wpdb->get_results("SELECT COUNT(ID) c FROM wp_posts WHERE post_status = 'publish' AND post_type='product'");
//    	return $res[0]->c;

		$mysqli = new \mysqli( "localhost", "root", "Frt141076", "wootest" );
		if ( $mysqli->connect_errno ) {
			return 0;
		}
		$res = $mysqli->query( "SELECT COUNT(ID) c FROM wp_posts WHERE post_status = 'publish' AND post_type='product'" );
		$arr = $res->fetch_assoc();
		mysqli_free_result( $res );

		return $arr["c"];
	}


	static function add_products( $count ) {
		$arr     = [ 38, 39, 35, 36, 37, 32, 33, 34, 29, 30, 31, 28 ];
		$arr_obj = [];
		foreach ( $arr as $item ) {
			$res       = wc_get_product( $item );
			$arr_obj[] = [
				'data'              => $res->get_data(),
				'meta'              => $res->get_meta_data(),
				'image_id'          => $res->get_image_id(),
				'gallery_image_ids' => $res->get_gallery_image_ids(),
				'category_ids'      => $res->get_category_ids(),
			];
		}
		$iteration = ( (int) $count / 12 ) ? (int) $count / 12 : 1;
		for ( $k = 0; $k <= $iteration; $k ++ ) {
			foreach ( $arr_obj as $item ) {
				self::add_product( $item );
			}
		}


	}

	static function add_one_product( $id = 38 ) {
		$res     = wc_get_product( $id );
		$arr_obj = [
			'data'              => $res->get_data(),
			'meta'              => $res->get_meta_data(),
			'image_id'          => $res->get_image_id(),
			'gallery_image_ids' => $res->get_gallery_image_ids(),
			'category_ids'      => $res->get_category_ids(),
		];
		self::add_product( $arr_obj );
	}

	static function add_product( $arr ) {
		$data = $arr['data'];

		$product = new \WC_Product();
		$product->set_name( $data["name"] . ' - ' . date( "Y-m-d H:i:s", Functions::get_time_gmt() ) );
		$product->set_status( $data["status"] );
		$product->set_short_description( $data["short_description"] );
		$product->set_description( $data["description"] );
		$product->set_menu_order( $data["menu_order"] );
		$product->set_price( $data["price"] );
		$product->set_regular_price( $data["regular_price"] );
		$product->set_meta_data( $arr['meta'] );
		$product->set_image_id( $arr['image_id'] );
		$product->set_gallery_image_ids( $arr['gallery_image_ids'] );
		$product->set_category_ids( $arr['category_ids'] );
		$product->set_sku( $data["sku"] );

		$product->save();
		//$id = $product->get_id();

		//return $id;
	}

	static function insert_to_base( $count = 1 ) {
		global $wpdb;



		$res     = $wpdb->get_results( "SELECT MAX( ID ) m FROM $wpdb->posts;" );
		$next_id = $res[0]->m + 1;

		for($k = $next_id; $k<=$count+$next_id; $k++){

			$query = "INSERT INTO $wpdb->posts ( `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES ( 1, '@date@', '@date@', 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.', 'Tshirt - @no@', '', 'publish', 'open', 'closed', '', 'tshirt-@no@', '', '', '@date@', '@date@', '', 0, '@address@/product/tshirt-@no@/', 0, 'product', '', 0);";

			$query = str_replace('@address@',site_url(), $query);


			$query = str_replace('@no@',$k, $query);
			$date = date( "Y-m-d H:i:s", Functions::get_time_gmt() );
			$query = str_replace('@date@',$date, $query);
			if($wpdb->query($query)){
				$res = $wpdb->get_results( "SELECT ID m FROM $wpdb->posts WHERE post_name = 'tshirt-$k';" );
				$id = $res[0]->m;

				$arr =[
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_sku', '');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_regular_price', '18');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_sale_price', '');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_sale_price_dates_from', '');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_sale_price_dates_to', '');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', 'total_sales', '0');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_tax_status', 'taxable');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_tax_class', '');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_manage_stock', 'no');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_backorders', 'no');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_sold_individually', 'no');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_weight', '');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_length', '');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_width', '');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_height', '');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_upsell_ids', 'a:0:{}');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_crosssell_ids', 'a:0:{}');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_purchase_note', '');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_default_attributes', 'a:0:{}');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_virtual', 'no');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_downloadable', 'no');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_product_image_gallery', '');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_download_limit', '-1');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_download_expiry', '-1');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_thumbnail_id', '20');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_stock', NULL);",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_stock_status', 'instock');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_wc_average_rating', '0');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_wc_rating_count', 'a:0:{}');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_wc_review_count', '0');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_downloadable_files', 'a:0:{}');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_product_attributes', 'a:0:{}');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_product_version', '3.4.5');",
					"INSERT INTO $wpdb->postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_price', '18');",
				];

				$arr = str_replace('@id@',$id, $arr);

				foreach ($arr as $item){
					$wpdb->query($item);
				}

			}
		}



		//return $res;
	}
}