<?php



global $mysqli;

$count_iteration = 1000;

$mysqli = new mysqli( "localhost", "root", "YOUR_PASSWORD", "wootest" );
if ( $mysqli->connect_errno ) {
	return 0;
}

function count_product(){
    global $mysqli;
	$res = $mysqli->query( "SELECT COUNT(ID) c FROM wp_posts WHERE post_status = 'publish' AND post_type='product'" );
	$arr = $res->fetch_assoc();
	mysqli_free_result( $res );
	return $arr["c"];
}

function site_url(){
  return $_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["HTTP_HOST"];
//    return 'http://wootest.siteeasy.ks.lo';
}

function get_time_gmt(){
    return date( "Y-m-d H:i:s", time() );
}

function base_size(){
	global $mysqli;
	$res = $mysqli->query( 'SELECT table_schema AS "Name",
ROUND(SUM(data_length + index_length) / 1024 / 1024 , 2) AS "Size"
FROM information_schema.TABLES
GROUP BY table_schema;' );

	$arr = [];
	while ($row = $res->fetch_assoc()) {
		$arr[] = [$row["Name"], $row["Size"]];
	}

	mysqli_free_result( $res );
	return $arr;
}

function add_product($nom){
	global $mysqli;

	$res = $mysqli->query( "SELECT MAX( ID ) m FROM wp_posts" );
	$arr = $res->fetch_assoc();
	$next_id = $arr['m']+1;
	mysqli_free_result( $res );

    for($k = $next_id; $k<=$nom+$next_id; $k++){
	    $query = "INSERT INTO wp_posts ( `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES ( 1, '@date@', '@date@', 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.', 'Tshirt - @no@', '', 'publish', 'open', 'closed', '', 'tshirt-@no@', '', '', '@date@', '@date@', '', 0, '@address@/product/tshirt-@no@/', 0, 'product', '', 0);";

	    $query = str_replace('@address@',site_url(), $query);
	    $query = str_replace('@no@',$k, $query);
	    $date = get_time_gmt();
	    $query = str_replace('@date@',$date, $query);

	    if($res = $mysqli->query( $query )){
		    $id = $mysqli->insert_id;
		    mysqli_free_result( $res );

		    $arr =[
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_sku', '');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_regular_price', '18');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_sale_price', '');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_sale_price_dates_from', '');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_sale_price_dates_to', '');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', 'total_sales', '0');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_tax_status', 'taxable');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_tax_class', '');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_manage_stock', 'no');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_backorders', 'no');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_sold_individually', 'no');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_weight', '');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_length', '');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_width', '');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_height', '');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_upsell_ids', 'a:0:{}');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_crosssell_ids', 'a:0:{}');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_purchase_note', '');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_default_attributes', 'a:0:{}');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_virtual', 'no');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_downloadable', 'no');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_product_image_gallery', '');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_download_limit', '-1');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_download_expiry', '-1');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_thumbnail_id', '20');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_stock', NULL);",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_stock_status', 'instock');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_wc_average_rating', '0');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_wc_rating_count', 'a:0:{}');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_wc_review_count', '0');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_downloadable_files', 'a:0:{}');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_product_attributes', 'a:0:{}');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_product_version', '3.4.5');",
			    "INSERT INTO wp_postmeta ( `post_id`, `meta_key`, `meta_value`) VALUES ( '@id@', '_price', '18');",
		    ];

		    $arr = str_replace('@id@',$id, $arr);

		    foreach ($arr as $item){
			    $res = $mysqli->query( $item );
			    @mysqli_free_result( $res );
		    }

		    //echo 'Add ' .  $id .'<br>';
	    }

    }
}

function diff_time($start, $stop){
	$time1 = new DateTime($start); // это время "сейчас" как объект DateTime
	$time2 = new DateTime($stop); // а это время в недавнем прошлом

	$diff = $time1->diff($time2); // разница как объект DateInterval
    $str = $diff->format('%d days %H:%i:%s');
	//return var_export($diff, true).' == '.$diff->format('%d days %H:%i:%s');
	return $str;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body{
            background-color: black;
            color: #fff;
        }
    </style>
</head>
<body>
<h3>Count add product for iteration <?php echo $count_iteration ?></h3>
<?php $start_time = get_time_gmt() ?>
<p><strong>Products start count </strong><?php echo count_product(). ' <strong>Time: </strong> '; echo $start_time; ?></p>
<?php
add_product($count_iteration);
?>
<?php $stop_time = get_time_gmt() ?>

<p><strong>Products stop count</strong> <?php echo count_product(). ' <strong>Time: </strong> '; echo $stop_time; ?> (<?php echo diff_time($start_time, $stop_time) ?>)</p>

<table>
    <tr>
        <th>Name</th>
        <th>Size</th>
    </tr>
	<?php foreach (base_size() as $item): ?>
        <tr>
            <?php if($item[0] == 'wootest'): ?>
                <td><?php echo $item[0] ?></td>
                <td><strong style="color: red;"><?php echo $item[1] ?></strong> Mb</td>
            <?php else: ?>
                <td><?php echo $item[0] ?></td>
                <td><strong><?php echo $item[1] ?></strong> Mb</td>
            <?php endif; ?>
        </tr>
	<?php endforeach; ?>
</table>

<!--<script-->
<!--        src="https://code.jquery.com/jquery-3.3.1.min.js"-->
<!--        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="-->
<!--        crossorigin="anonymous"></script>-->

<script>
    location.reload();
</script>

</body>
</html>