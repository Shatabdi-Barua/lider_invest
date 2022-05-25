<?php if(session_id() == ''){
    //session_start();
}
    function twentyfourteen_wp_title( $title, $sep ) {
    	global $paged, $page;
    
    	if ( is_feed() ) {
    		return $title;
    	}
    
    	// Add the site name.
    	$title .= get_bloginfo( 'name', 'display' );
    
    	// Add the site description for the home/front page.
    	$site_description = get_bloginfo( 'description', 'display' );
    	if ( $site_description && ( is_home() || is_front_page() ) ) {
    		$title = "$title $sep $site_description";
    	}
    
    	// Add a page number if necessary.
    	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
    		$title = "$title $sep " . sprintf( __( 'Page %s', 'twentyfourteen' ), max( $paged, $page ) );
    	}
    
    	return $title;
    }
    add_filter( 'wp_title', 'twentyfourteen_wp_title', 10, 2 );
    
    add_theme_support( 'post-thumbnails' );
    add_image_size('testimonial_image', 270, 270, true);
    add_image_size('gallery_first', 417, 560, true);
    add_image_size('gallery_rest', 289, 278, true);
    
    register_nav_menus( array(
		'header_menu'   => __( 'Header menu', 'twentyfourteen' ),
        'footer_menu' => __( 'Footer menu', 'twentyfourteen' ),
	) );
    

if( function_exists('acf_add_options_page') ) {
    	
    	acf_add_options_page(array(
    		'page_title' 	=> 'Theme General Settings',
    		'menu_title'	=> 'Theme Settings',
    		'menu_slug' 	=> 'theme-general-settings',
    		'capability'	=> 'edit_posts',
    		'redirect'		=> false
    	));
    	
    	acf_add_options_sub_page(array(
    		'page_title' 	=> 'Home Page Blocks',
    		'menu_title'	=> 'Home Blocks',
    		'parent_slug'	=> 'theme-general-settings',
    	));
        acf_add_options_sub_page(array(
    		'page_title' 	=> 'Reservation Blocks',
    		'menu_title'	=> 'Reservation Blocks',
    		'parent_slug'	=> 'theme-general-settings',
    	));
    	
}

add_action('init', 'testimonials_custom_init');

function testimonials_custom_init()  
    {  
        // the remainder code goes here  
        $labels = array(  
        'name' => _x('Testimonials', 'post type general name'),  
        'singular_name' => _x('Testimonials', 'post type singular name'),  
        'add_new' => _x('Add New', 'Testimonials'),  
        'add_new_item' => __('Add New Testimonials'),  
        'edit_item' => __('Edit Testimonials'),  
        'new_item' => __('New Testimonials'),  
        'view_item' => __('View Testimonials'),  
        'search_items' => __('Search Testimonials'),  
        'not_found' =>  __('No Testimonials found'),  
        'not_found_in_trash' => __('No Testimonials found in Trash'),  
        'parent_item_colon' => '',  
        'menu_name' => 'Testimonials'  
    );  
    // Some arguments and in the last line 'supports', we say to WordPress what features are supported on the Project post type  
    $args = array(  
        'labels' => $labels,  
        'public' => true,  
        'publicly_queryable' => true,  
        'show_ui' => true,  
        'show_in_menu' => true,  
        'query_var' => true,  
        'rewrite' => true,  
        'capability_type' => 'post',  
        'has_archive' => true,  
        'hierarchical' => false,  
        'menu_position' => null,  
        'supports' => array('title','editor','thumbnail')  
    );  
    //Custom Meta Code End
    
    // We call this function to register the custom post type  
    register_post_type('testimonials',$args);  
    
    //register_taxonomy("testimonial_type", array("testimonials"), array("hierarchical" => true, "label" => "Testimonial type","query_var" => true, "singular_label" => "Testimonial type"));
}
add_action('init', 'reservation_custom_init');

function reservation_custom_init()  
    {  
        // the remainder code goes here  
        $labels = array(  
        'name' => _x('Reservation', 'post type general name'),  
        'singular_name' => _x('Reservation', 'post type singular name'),  
        'add_new' => _x('Add New', 'Reservation'),  
        'add_new_item' => __('Add New Reservation'),  
        'edit_item' => __('Edit Reservation'),  
        'new_item' => __('New Reservation'),  
        'view_item' => __('View Reservation'),  
        'search_items' => __('Search Reservation'),  
        'not_found' =>  __('No Reservation found'),  
        'not_found_in_trash' => __('No Reservation found in Trash'),  
        'parent_item_colon' => '',  
        'menu_name' => 'Reservation'  
    );  
    // Some arguments and in the last line 'supports', we say to WordPress what features are supported on the Project post type  
    $args = array(  
        'labels' => $labels,  
        'public' => true,  
        'publicly_queryable' => true,  
        'show_ui' => true,  
        'show_in_menu' => true,  
        'query_var' => true,  
        'rewrite' => true,  
        'capability_type' => 'post',  
        'has_archive' => true,  
        'hierarchical' => false,  
        'menu_position' => null,  
        'supports' => array('title','editor','thumbnail')  
    );  
    //Custom Meta Code End
    
    // We call this function to register the custom post type  
    register_post_type('eeservation',$args);  
    //register_taxonomy("testimonial_type", array("testimonials"), array("hierarchical" => true, "label" => "Testimonial type","query_var" => true, "singular_label" => "Testimonial type"));
}

function advisiblemain_widgets_init() {
    register_sidebar( array(
		'name' => __( 'Footer Columns One Widget', 'wpb' ),
		'id' => 'footer-columns-one-widget',
		'before_widget' => '',
		'after_widget' => '',
        'before_title'  => '',
		'after_title'   => '',
	) );
    register_sidebar( array(
		'name' => __( 'Footer Columns Two Widget', 'wpb' ),
		'id' => 'footer-columns-two-widget',
		'before_widget' => '',
		'after_widget' => '',
        'before_title'  => '',
		'after_title'   => '',
	) );
}
add_action( 'widgets_init', 'advisiblemain_widgets_init' );

function awesome_custom_post_type(){
    $labels = array(
        'name' => 'ResRequest Properties',
        'singular_name' => 'ResRequest Properties',
        'add_new' => 'Add item',
        'all_items' => 'All Items',
        'add_new_item' => 'Add Item',
        'edit_item' => 'Edit Item',
        'new_item' => 'New Item',
        'view_item' => 'View Item',
        'seach_item' => 'Seach ResRequest',
        'not_found' => 'No Item Found',
        'not_found_in_trash' => 'No Items Found In Trash',
        'parent_item_colon' => 'Parent Item'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'publicly_queryable' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'support' => array(
                        'title',
                        'editor',
                        'excerpt',
                        'thumbnail',
                        'revisions',
        ),
        'taxonomies'=> array('category','post_tag'),
        'menu_position' => 5,
        'exclude_form_seach' => false
    );
    register_post_type('portfolio',$args);
}
add_action('init','awesome_custom_post_type');

function ru_custom_post_type(){
    $labels = array(
        'name' => 'Rentals United Properties',
        'singular_name' => 'Rentals United Properties',
        'add_new' => 'Add item',
        'all_items' => 'All Items',
        'add_new_item' => 'Add Item',
        'edit_item' => 'Edit Item',
        'new_item' => 'New Item',
        'view_item' => 'View Item',
        'seach_item' => 'Seach Rentals United',
        'not_found' => 'No Item Found',
        'not_found_in_trash' => 'No Items Found In Trash',
        'parent_item_colon' => 'Parent Item'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'publicly_queryable' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'support' => array(
                        'title',
                        'editor',
                        'excerpt',
                        'thumbnail',
                        'revisions',
        ),
        'taxonomies'=> array('category','post_tag'),
        'menu_position' => 5,
        'exclude_form_seach' => false
    );
    register_post_type('ruproperties',$args);
}
add_action('init','ru_custom_post_type');


add_action('init','add_get_val');
function add_get_val() { 
    global $wp; 
    $wp->add_query_var('utm_medium');
    $wp->add_query_var('utm_campaign');
    $wp->add_query_var('utm_content');
    $wp->add_query_var('utm_term');
    $wp->add_query_var('ad_tag_id');
    $wp->add_query_var('utm_source');
}

add_filter( 'wpcf7_mail_components', 'trz_wpcf7_function', 50, 2 );

function trz_wpcf7_function($mail_params, $form = null) {
	$title = $form->title;
    $id = $form->id;
    $mail = $mail_params['body'];
    $data2 = print_r($mail, true);

    $myfile = fopen($_SERVER['DOCUMENT_ROOT'] . "/lider-invest/submission-file/submission_".$id.".txt","wb");
    
    fwrite($myfile, $data2);
    //$ftp_server="bdmonster.com";
    //$ftp_username="lider-invest@bdmonster.com";
    //$ftp_userpass="#?hvRIn^3cXSf";
    //$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to server");
    //$login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
    /*if(ftp_put("submission-file/submission_".$id.".txt",$_SERVER['DOCUMENT_ROOT'] . "/tempFile.txt",FTP_ASCII))
    {
        $success = 'Success';
    }
    else
    {
        $success = 'Failed';
    }*/
    fclose($myfile);
        
    return $mail_params;
}

/*add_action( 'wpcf7_before_send_mail', 'trz_wpcf7_function' ); 

function trz_wpcf7_function( $contact_form ) {    
    $title = $contact_form->title;
    $id = $contact_form->id;
    $submission = WPCF7_Submission::get_instance();
    
    if ( $submission ) {
        $posted_data = $submission->get_posted_data();
    }
    if ( 'Contact form 1' == $title ) { 
        // get mail property
        $mail = $contact_form->prop( 'mail' ); // returns array
        $data2 = print_r($mail, true);

        $myfile = fopen($_SERVER['DOCUMENT_ROOT'] . "/tempFile.txt","wb");
        
        fwrite($myfile, $data2);
        $ftp_server="bdmonster.com";
        $ftp_username="lider-invest@bdmonster.com";
        $ftp_userpass="#?hvRIn^3cXSf";
        $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to server");
        $login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
        if(ftp_put($ftp_conn,"submission-file/submission_".$id.".txt",$_SERVER['DOCUMENT_ROOT'] . "/tempFile.txt",FTP_ASCII))
        {
            //print("yay");
        }
        else
        {
            //print("f...");
        }
        fclose($myfile);
        /*echo '<pre>';
        print_r($mail);
        echo '<pre>';*/
         /*foreach($posted_data as $posted_d_key => $posted_d_val){
            echo $posted_d_key.' = '.$posted_d_val.'<br/>';
         }*/
    /*}
}*/
setcookie("ad_tag_id", $_GET['ad_tag_id']);
setcookie("utm_source", $_GET['utm_source']);
setcookie("utm_medium", $_GET['utm_medium']);
setcookie("utm_campaign", $_GET['utm_campaign']);
setcookie("utm_term", $_GET['utm_term']);
setcookie("utm_content", $_GET['utm_content']);

add_action( 'gform_after_submission_1', 'access_entry_via_field', 10, 2 );
function access_entry_via_field( $entry, $form ) {
    
    $firstName = rgar( $entry, '2.3' );
    $lastName = rgar( $entry, '2.6' );
    $email = rgar( $entry, '3' );
    $phone = rgar( $entry, '4' );
    $source_type = rgar( $entry, '8' );
    $postal_code = rgar( $entry, '5' );
    $broker1 = $entry['6.1'];
    $broker2 = $entry['6.2'];
    $broker = $broker1.''.$broker2;
    $ad_tag_id = $_COOKIE['ad_tag_id'];
    $utm_source = $_COOKIE['utm_source'];
    $utm_medium = $_COOKIE['utm_medium'];
    $utm_content = $_COOKIE['utm_content'];
    $utm_term = $_COOKIE['utm_term'];
    $utm_campaign = $_COOKIE['utm_campaign'];
    
    
    /********** Pipedrive Api **********/
        
    $api_token = '10d9bf33ac468b9e83463bae7ccc45a3e7bf774f';
    /*$find_broker_name = str_replace(' ', '%20', $broker_name);
    $url_find_organization = 'https://testre.pipedrive.com/v1/organizations/find/?term='. $find_broker_name .'&api_token=' . $api_token;

    $ch_find_organization = curl_init();
    curl_setopt($ch_find_organization, CURLOPT_URL, $url_find_organization);
    curl_setopt($ch_find_organization, CURLOPT_RETURNTRANSFER, true);
     
    //echo 'Sending request...' . PHP_EOL;
     
    $output_find_organization = curl_exec($ch_find_organization);
    curl_close($ch_find_organization);
    $result_find_organization = json_decode($output_find_organization, true);
    
    if($result_find_organization['data'][0]['id'] != ''){
        $organization_id = $result_find_organization['data'][0]['id'];
    }else{
    
        $organization = array(
          'name' => "$broker_name",
          '3de6027860d80447a3767b89c7a9656045b31f9a' => "$brokerage_name"
        );
        
        $url_organization = 'https://testre.pipedrive.com/v1/organizations/?api_token=' . $api_token;
        
        $ch_organization = curl_init();
        curl_setopt($ch_organization, CURLOPT_URL, $url_organization);
        curl_setopt($ch_organization, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_organization, CURLOPT_POST, true);
        curl_setopt($ch_organization, CURLOPT_POSTFIELDS, $organization);
    
        $output_organization = curl_exec($ch_organization);
        curl_close($ch_organization);
        
        $result_organization = json_decode($output_organization, true);
        $organization_id = $result_organization['data']['id'];
    }*/
    
    $url_find_person = 'https://testre.pipedrive.com/v1/persons/find/?term='. $firstName.'%20'.$lastName .'&api_token=' . $api_token;

    $ch_find_person = curl_init();
    curl_setopt($ch_find_person, CURLOPT_URL, $url_find_person);
    curl_setopt($ch_find_person, CURLOPT_RETURNTRANSFER, true);
     
    //echo 'Sending request...' . PHP_EOL;
     
    $output_find_person = curl_exec($ch_find_person);
    curl_close($ch_find_person);
    $result_find_person = json_decode($output_find_person, true);

    if($result_find_person['data'][0]['id'] != '' && $result_find_person['data'][0]['email'] == $email){
        $person_id = $result_find_person['data'][0]['id'];
    }else{
        $person = array(
            'name' => $firstName.' '.$lastName,
            'email' => "$email",
            'phone' => "$phone",
            'first_name' => "$firstName",
            'last_name' => "$lastName",
            'c6d41ebe72a84c736a2bdc25d9aa2fccb80c0754' => "$postal_code"
        );
        
        $url_person = 'https://testre.pipedrive.com/v1/persons/?api_token=' . $api_token;
        
        $ch_person = curl_init();
        curl_setopt($ch_person, CURLOPT_URL, $url_person);
        curl_setopt($ch_person, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_person, CURLOPT_POST, true);
        curl_setopt($ch_person, CURLOPT_POSTFIELDS, $person);
    
        $output_person = curl_exec($ch_person);
        curl_close($ch_person);
        
        $result_person = json_decode($output_person, true);
        $person_id = $result_person['data']['id'];
    }
    
    $deal = array(
      'title' => $firstName.' '.$lastName,
      'person_id' => "$person_id",
      /*'stage_id' => 8,*/
      'f6cf6dbc00608112ef1396113aae3299d47edeb9' => "$price_range",
      'dd0d772721bcdab313bff5be2f1fb098c7fcc66d' => "$suite_type",
      '73f8fcc8709cf512fd935d6b515d12832bd6930a' => "$broker",
      'bddd048fa8aae7d81f37478feedc64b4d0a8b662' => "$broker_agent",
      '069b42813b2fbb5d7659578c06cc8d82666ba158' => "$comments",
      'f3a6022b760974bb3f0b6fb09a21a5cb3414cc38' => "$source_type",
      'd5b563051b11fa36d65b1bd9934193985ebb2c8d' => "$utm_source",
      'a266787264687a20d3b1c044f20801c1367f1831' => "$utm_medium",
      'ab1725601562cb464531cbfbd0fc11a1066d8558' => "$utm_campaign",
      '03ddeb05cc8bbf9a385f06ca4eb25fa57d651dc6' => "$utm_content",
      'b62c1c095c7ec94f56cd2414a91a3b1f17f642fc' => "$utm_term",
      '7ea6fe2250aa2adb4fe55aa72629b7629f002073' => "$ad_tag_id",
      '62cfa8273752fa4a4c1bf0a3d020c31adb204ae5' => '',
    );
    $url = 'https://testre.pipedrive.com/v1/deals?api_token=' . $api_token;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $deal);
     
    //echo 'Sending request...' . PHP_EOL;
     
    $output = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($output, true);
    
    //var_dump($result);
    //echo '<pre>';
    //print_r($entry);
}

/*$wpdb->query("ALTER TABLE wp_google_sheet_chart_data ADD hpbc_data_one varchar(2000) NOT NULL");
$wpdb->query("ALTER TABLE wp_google_sheet_chart_data ADD hpbc_data_two varchar(2000) NOT NULL");
$wpdb->query("ALTER TABLE wp_google_sheet_chart_data ADD divprt_data_one varchar(2000) NOT NULL");
$wpdb->query("ALTER TABLE wp_google_sheet_chart_data ADD divprt_data_two varchar(2000) NOT NULL");
$wpdb->query("ALTER TABLE wp_google_sheet_chart_data ADD bbp_data_one varchar(2000) NOT NULL");
$wpdb->query("ALTER TABLE wp_google_sheet_chart_data ADD bbp_data_two varchar(2000) NOT NULL");
$wpdb->query("ALTER TABLE wp_google_sheet_chart_data ADD sp_data_one varchar(2000) NOT NULL");
$wpdb->query("ALTER TABLE wp_google_sheet_chart_data ADD sp_data_two varchar(2000) NOT NULL");
$wpdb->query("ALTER TABLE wp_google_sheet_chart_data ADD vynosnost_data varchar(2000) NOT NULL");*/
//$wpdb->query("ALTER TABLE wp_google_sheet_chart_data MODIFY hpbc_data_one LONGTEXT NOT NULL");


add_action( 'gform_after_submission_3', 'access_entry_via_field_application', 10, 2 );
function access_entry_via_field_application( $entry, $form ) {
    
    $firstName = rgar( $entry, '4' );
    $lastName = rgar( $entry, '5' );
    $email = rgar( $entry, '1' );
    $phone = rgar( $entry, '6' );
    $appoinment_type = rgar( $entry, '7' );
    $retailer = rgar( $entry, '8' );
    
    
    /********** Pipedrive Api **********/
        
    $api_token = '13fba55a00e73d1613fb072c888bcdb76adcb178';
    
    $url_find_person = 'https://silverberg-debut.pipedrive.com/v1/persons/find/?term='. $firstName.'%20'.$lastName .'&api_token=' . $api_token;

    $ch_find_person = curl_init();
    curl_setopt($ch_find_person, CURLOPT_URL, $url_find_person);
    curl_setopt($ch_find_person, CURLOPT_RETURNTRANSFER, true);
     
    //echo 'Sending request...' . PHP_EOL;
     
    $output_find_person = curl_exec($ch_find_person);
    curl_close($ch_find_person);
    $result_find_person = json_decode($output_find_person, true);

    if($result_find_person['data'][0]['id'] != '' && $result_find_person['data'][0]['email'] == $email){
        $person_id = $result_find_person['data'][0]['id'];
    }else{
        $person = array(
            'name' => $firstName.' '.$lastName,
            'email' => "$email",
            'phone' => "$phone",
            'first_name' => "$firstName",
            'last_name' => "$lastName"
        );
        
        $url_person = 'https://silverberg-debut.pipedrive.com/v1/persons/?api_token=' . $api_token;
        
        $ch_person = curl_init();
        curl_setopt($ch_person, CURLOPT_URL, $url_person);
        curl_setopt($ch_person, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_person, CURLOPT_POST, true);
        curl_setopt($ch_person, CURLOPT_POSTFIELDS, $person);
    
        $output_person = curl_exec($ch_person);
        curl_close($ch_person);
        
        $result_person = json_decode($output_person, true);
        $person_id = $result_person['data']['id'];
    }
    
    $deal = array(
      'title' => $firstName.' '.$lastName,
      'person_id' => "$person_id",
      'stage_id' => 10,
      'ebb493c882da63a8aea23f57bb3edd7d44da4a1f' => "$appoinment_type",
      '627d155d2d03a0a65d589bce3981cbc71581bb55' => "$retailer"
    );
    $url = 'https://silverberg-debut.pipedrive.com/v1/deals?api_token=' . $api_token;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $deal);
     
    $output = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($output, true);
    
    //var_dump($result);
    //echo '<pre>';
    //print_r($entry);
}




/*
*****seting up corn job****
*/



// adding custom interval

add_filter( 'cron_schedules', 'lider_invest_cron_interval' );

function lider_invest_cron_interval( $schedules ) { 
    $schedules['ten_seconds'] = array(
        'interval' => 30,
        'display'  => esc_html__( 'Every one Hour' ), );
    return $schedules;
}

// setting custom hook for wp corn

add_action( 'lider_invest_cron_hook', 'send_mail_corn_job' );

// the event function

function send_mail_corn_job(){

    //require_once( get_template_directory() . '/cron-job.php' );
    
}


// scheduling event

if ( ! wp_next_scheduled( 'lider_invest_cron_hook' ) ) {
    wp_schedule_event( time(), 'ten_seconds', 'lider_invest_cron_hook' );
}

//shatabdi
if(!is_admin())
{
  add_action('init', 'read_csv');
}

function read_csv(){
    // print('123');
    // exit();
  //getting all product id to check if already exists
  $products_IDs = new WP_Query( array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'fields' => 'ids' ) );
  $p_id = $products_IDs->posts;

  //preparing csv into array 
  $csv_url = get_template_directory_uri().'/css/arogga_new_2.csv';
  // print($csv_url);
  // exit();
  // $csv_url = 'arogga.csv';
//   echo getcwd();
//   exit();
  if(!empty($csv_url)){
    $file = fopen($csv_url,"r");

    $i=0;
    $col_head=array();
    $col_body =array();
    while (($line = fgetcsv($file)) !== FALSE) {
        // print('123');
        // exit();
      if($i ==0){
        $line_length = count($line);
        $col_head = $line; 
      }else{
        $product_array= array();
        for($k=0;$k<$line_length;$k++){
          $product_array[$col_head[$k]] = $line[$k];
        }
        $col_body[] =$product_array;
      }
      $i++;
    }
    // echo "<pre>";
    // print_r($col_body);
    // exit();
    //getting attribute name and their values
    $trz_at_attributes = trz_at_get_attributes($col_head);
    $trz_at_variations = trz_at_get_variations($trz_at_attributes,$col_head, $col_body);
    
    // print_r($trz_at_variations);
    // exit();
    //checking meta by sku and product id ; if flag =1, product exists, update product ; flag =0, add product
    $flag = 0;
    foreach ($p_id as$id) {
      
       if(!empty(get_post_meta( $id, '_print_api_product_sku' ))){
          
          $product_id = get_post_meta( $id, '_print_api_product_sku' ); // is an array with 1 row of id 
          
          if($product_id[0] == $col_body[0]['sku']){
            $prev_prdct_id = $id;
            
            $flag = 1;
          }
       }      
    }  
    
    if($flag==0){  
      $prev_prdct_id ='';
     // trz_at_add_variation_product($col_body,$col_head, $trz_at_variations,$trz_at_percentage);
    }
    else{
      // echo "<div class='update-nag notice notice-warning inline'><span class='closebtn' onclick='this.parentElement.style.display=\"none\";'>&times;</span>  <strong> This product already exists. Updating product id ".$prev_prdct_id.".</strong></div>"; 
    }

    //print_r($trz_artwork);
    
    trz_at_add_variation_product($col_body,$col_head, $trz_at_variations,$prev_prdct_id);
    // print($vr);
    // exit()
    fclose($file);

  }
  
}


function add_new_attribute($nam, $vals)
{
	// if($nam == 'medicine_weight ' || $nam == 'medicine_type' || $nam == 'medicine_company' || $nam == 'generic')
	// print_r($nam);
  // exit();
	if($nam == 'medicine_weight' || $nam == 'medicine_type' || $nam == 'medicine_company')
	{
		$attrs = array();      
		$attr_tax = wc_get_attribute_taxonomies();                          
		foreach ($attr_tax as $key => $value) {
			array_push($attrs,$attr_tax[$key]->attribute_name);                    
		} 
		// print_r($attrs);
    // print_r('nam: '.$nam);
    // exit();

		if ( ! in_array( $nam, $attrs ) ) {            
			$args = array(
				'id' => '',
				'slug'    => $nam,
				'name'   => __( $nam, 'woocommerce' ),
				'type'    => 'select',
				'orderby' => 'menu_order',
				'has_archives'  => false,
				'limit' => 1,
				'is_in_stock' => 1
			);   				
			wc_create_attribute( $args );
      WC_Post_Types::register_taxonomies();
      $tax_nam = 'pa_'.$nam;
      $add = wp_insert_term( $vals, $tax_nam, array( 'slug' => $vals ) );
      // $add = wp_insert_term( "def", 'pa_trenzatest', array( 'slug' => "def" ) );
      // print_r($cr);
			// exit();					            
		}
		$term_id = add_vars($nam, $vals);	 
		// print_r($term_id);
		// exit(); 
		
		// if($attr_val != '')
		// {
		// 	add_vars($nam, $vals);   
		// }		
		//var_dump($term_id);
		return $term_id;
	}
	
}
function add_vars($nam, $vals)
{
	$taxonomy = 'pa_'.$nam;      
    $term_slug = sanitize_title($nam); 
    // Check if the term exist and if not it create it (and get the term ID).
    for ($ff=0; $ff < count($vals) ; $ff++) 
	  {
		// register_taxonomy(
        //     $nam,
        //     'products',
        //     array(
        //         'label' => __( $nam ),
        //         'rewrite' => array( 'slug' => $vals),
        //         'hierarchical' => true,
        //     )
        // );
      if( ! term_exists( $vals[$ff], $taxonomy ) )
		  { 
        $term_data = wp_insert_term($vals[$ff], $taxonomy ); 
        // print_r($term_data);
        // exit();
        $term_id = $term_data['term_id']; 
			  // $term_id = get_term_by( 'name', $vals[$ff], $taxonomy )->term_id; 
		  } 
      else 
      { 
        $term_id = get_term_by( 'name', $vals[$ff], $taxonomy )->term_id; 
      } 
	}
	return $term_id; 
}


function trz_at_get_attributes($col_head)
{

  $trz_at_attributes=array();
  foreach ($col_head as $col) {
    // $pattern1 = "/price/i";
    // $pattern2 = "/day/i";
    // $pattern3 = "/product/i";
    // $pattern4 = "/height/i";
    // $pattern5 = "/width/i";
    // $pattern6 = "/updated/i";
    // $pattern7 = "/tax/i";
    // if(preg_match_all($pattern1, $col) ==0 && preg_match_all($pattern2, $col) ==0 && preg_match_all($pattern3, $col) ==0 && preg_match_all($pattern4, $col) ==0 && preg_match_all($pattern5, $col) ==0 && preg_match_all($pattern6, $col) ==0 && preg_match_all($pattern7, $col) ==0){
      $trz_at_attributes[] = $col;
    // }
  }
//   $trz_at_attributes[] = 'Production Days';

  return $trz_at_attributes;
}
function trz_at_get_variations($attrs,$col_head, $col_body)
{

    // print_r($col_body);
    // exit();
  $trz_at_variations= array();
  //$pattern1 = "/Purchase Type/i";
//   $pattern = "/Production Days/i";
  foreach ($attrs as $attr) {
    
    // if(preg_match_all($pattern, $attr) ==0  )
    // {
      //echo $attr ."<br>";
      $temp_array =array();
      foreach ($col_body as $body) {
        $temp_array[] = $body[$attr];
      }
     $trz_at_variations[$attr] = array_unique($temp_array);
    // }
    // else{
    //   $temp_array =array();
    //   foreach ($col_head as $col) {
        // $pattern = "/Production Days/i";
        // if(preg_match_all($pattern, $col) !=0  ){
        //   $temp_array[] = trim(strtolower(str_replace("Production Days", "",$col))) ;
         
        // }
    //   }
      $trz_at_variations[$attr] = array_unique($temp_array);
    // }
    
  }
  return $trz_at_variations;

}
function trz_at_add_variation_product($data,$col_head, $trz_at_variations,$prev_prdct_id)
{  

  if($prev_prdct_id !='')
  {
    $product = wc_get_product($prev_prdct_id);
    foreach ($product->get_children() as $child_id)
    {
        $child = wc_get_product($child_id); 
        $child->delete(true);
    }
    $product_id = $prev_prdct_id;
    $product = new WC_Product_Variable( $prev_prdct_id );
    $product->save();    
  }
  else
  {
    //creating product if product doesn't exist
    $product_id = trz_at_add_product($data);
    // Get an instance of the WC_Product_Variable object and save it
    $product = new WC_Product_Variable( $product_id );
    $product->save();
    $product->set_sku($data[0]['sku']);
    $product->save();

  }
  update_post_meta( $product_id, '_print_api_product_sku', $data[0]['sku']); //will use to update product
  update_post_meta( $product_id, '_print_api_product', 'trade_print' ); //will use to update product

  // $attributes= array();

  $i = 0;
  foreach ($trz_at_variations as $key => $values) 
  {
      
    $prices_variation = [];
    $price_type = [];
    $key = str_replace(' ', '_', $key);
    $key = strtolower($key);

    $attribute = new WC_Product_Attribute();
    $attribute->set_id(0);
    $attribute->set_name($key); //attribute name 

    $option_string = '';
    if($key == 'sku')
    {
          foreach($values as $sku_value)
          {
            $sku = $sku_value;
          }
    }
    if($key=='previous_price_amount')
    {
      foreach($values as $price_val)
      {
        // $get_price = (int)$price_val;
        $price_val = preg_replace('/৳/', "", $price_val);
        $get_price = (double)$price_val;
        // print(gettype($get_price));
        // exit();
      }
    }
    if($key== 'package_size')
    {                    
      $package_variation = array();
      $variation_val = str_ireplace('[','',$values[0]);
      $variation_val = str_ireplace(']','',$variation_val);  
      if($variation_val == '')
      {
          // $newl = strpos($variation_val, '*');
          // echo $newl;
          // echo 'NULL';
          // exit();
      }
      else
      {
        $vv = explode(",",$variation_val);

        // Check Array Avaibality

        if(count($vv))
        {
            
          $package_title = array();

          $get_first = $vv[0];
          $get_first = str_ireplace("'",'',$get_first);

          $has_star = strpos($get_first, "*");
          if($has_star == false)
          {
            $get_number = (int)$get_first;

            $get_types = preg_replace('!\d+!', "", $get_first); //tablet/capsule
 
            $price_for_first = (float)$get_price/$get_number; //for 1 table
            // array_push($package_variation, $price_for_first);
            $price_for_second = (float)$price_for_first*$get_number; //for 1 strip
            // array_push($package_variation, $price_for_second);
            $price_for_third = (float)$price_for_second*$get_number; //for 1 box
            // array_push($package_variation, $price_for_third);
            // $package_variation_count = count($package_variation);
            // print_r($package_variation);
            // exit();
            // for ($i=0; $i<$package_variation_count; $i++)
            // {
            //   $package_title_childs = array();
            //   $package_title_childs['title'] = $get_types;
            //   $package_title_childs['price'] = $package_variation[$i];
            // }
            // print_r("<pre>"); 
            // print_r($package_title_childs); 
            // exit();
            $package_title_childs = array();
            $package_title_childs['attributes']['package_size'] = $get_types;
            $package_title_childs['regular_price'] = $price_for_first;
            $package_title_childs['sale_price'] = '';
            $package_title_childs['sku']='';
            $package_title_childs['stock_qty'] = '100';
            // $package_title['package_title'][] = $package_title_childs;
            $package_title[] = $package_title_childs;

              
            $package_title_childs = array();
            $package_title_childs['attributes']['package_size'] = 'Strips';
            $package_title_childs['regular_price'] = $price_for_second;
            $package_title_childs['sale_price'] = '';
            $package_title_childs['sku']='';
            $package_title_childs['stock_qty'] = '100';
            $package_title[]  = $package_title_childs;

            $package_title_childs = array();
            $package_title_childs['attributes']['package_size'] = 'Box';
            $package_title_childs['regular_price'] = $price_for_third;
            $package_title_childs['sale_price'] = '';
            $package_title_childs['sku']='';
            $package_title_childs['stock_qty'] = '100';
            // $package_title['package_title'][] = $package_title_childs;
            $package_title[] = $package_title_childs;

            // print_r($package_title);
            // exit();
            $atribute_array = [];
            for($i=0; $i<count($package_title); $i++)
            {
              foreach($package_title[$i]['attributes'] as $key=> $values)
              {
                // print($values);
                if($key== 'package_size')
                {
                   $atribute_array[$key][] = $values;
                }
               
                
                // $option_string = $option_string . $values . ' | ';
                
              }
            }
            $attributes = array();
            foreach($atribute_array as $key=>$values)
            {
              $attribute = new WC_Product_Attribute();
              $attribute->set_id(0);
              $attribute->set_name($key); //attribute name 
              $option_string = '';
              foreach ($values as $val) {
                $option_string = $option_string . $val . ' | '; //attribute value
              }
              $option_string = substr($option_string,0,-3); // removing last ' | '
              $attribute->set_options(explode(WC_DELIMITER, $option_string)); // set value 
              if(count($values)>1){ // need to change when quantity add  
                $attribute->set_visible(true);
                $attribute->set_variation(true);
                
              }else{ //if not varriation
                $attribute->set_visible(true);
                $attribute->set_variation(false);
              }     
              $attributes[] = $attribute;
            }
            // echo '<pre>';
            // print_r($attributes);
            // exit();
            $product->set_attributes($attributes);
            $product->save();

            for ($i=0; $i<count($package_title); $i++)
            {
              // echo '<pre>';
              // print_r($package_title[$i]);
              // exit();
              trz_at_create_product_variation( $product_id, $package_title[$i]);
              $product->save();
            }
            
  
          }
        }
            // print_r("<pre>"); 
            // print_r($package_title_childs); 
            // exit();          
      }                
    } 
    
    // if(count($package_variation)>1)
    // { // if variation 
    //   $attribute->set_visible(false);
    //   $attribute->set_variation(true);
    // }
    // else
    // { //if not varriation
    //     $attribute->set_visible(true);
    //     $attribute->set_variation(false);
    // }
    foreach ($values as $val) 
    {
      $option_string = $option_string . $val . ' | '; //attribute value
    }
    $option_string = substr($option_string,0,-3); // removing last ' | '
    $attribute->set_options(explode(WC_DELIMITER, $option_string)); // set value 

    $term = add_new_attribute($key, $values); //29
      
    if($key == 'medicine_weight' || $key == 'medicine_type' || $key == 'medicine_company')
    {
      $at_val = implode(',',$values);
      if($key == 'medicine_type')
      {
        $at_val = ucwords($at_val);
      }

      $term_slug = sanitize_title($key);
      $taxonomy = 'pa_'.$key;       
      $term_taxonomy_ids = wp_set_object_terms($product_id, $at_val, $taxonomy, true);              
                // Create product attributes array
                $data_attr[$i] = array(
                    'name' => $taxonomy, // set attribute name
                    'value' => $at_val, // set attribute value
                    'is_visible' => 1,
                    'is_variation' => 0,
                    'is_taxonomy' => 1
                );              
              $i++;
        
    }
   
    if($key=='main_img')
    {
      foreach($values as $img_val)
      {            
            // echo __DIR__;
            // exit();
            // echo $img_val;  
            $upload_img = file_get_contents( $img_val);
            // $extension = pathinfo(parse_url($upload, PHP_URL_PATH), PATHINFO_EXTENSION);
            // echo $img_val;
            // print_r($extension);
            // exit();
            $imageName = $sku.'_main_'.time().'.webp';
            $destination = '/home3/bdmonst1/public_html/wp/lider-invest/wp-content/themes/liderinvest/images/arogga_image/'.$imageName;
            // print($destination);
            // exit();
            $img = file_put_contents($destination, $upload_img);
            
            $upload = wp_upload_bits( $imageName, null, file_get_contents( $destination,FILE_USE_INCLUDE_PATH ) );
            // echo $destination;
            
            $filename = $upload['file'];
            $wp_filetype = wp_check_filetype( $filename, null );
            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title' => sanitize_file_name( $filename ),
                'post_content' => '',
                'post_status' => 'inherit'
            );
 
            $attachment_id = wp_insert_attachment( $attachment, $filename, $product_id );
            require_once(ABSPATH . 'wp-admin/includes/image.php');
 
            $attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
            wp_update_attachment_metadata( $attachment_id, $attachment_data );
            set_post_thumbnail( $product_id, $attachment_id );
            // print($attachment_id);
            // // print_r($upload);
            // exit();
      }          
    }
    elseif($key == 'product_images')
    {
          // $type = is_array($values);
          // echo '<pre>';
          // print_r($values);
          // exit();
          foreach($values as $pro_img)
          {                        
            // print_r(substr($pro_img, -2, 2));
            if(substr($pro_img, 0, 2)=== "['" && substr($pro_img, -2, 2) === "']")
            {
              $pro_img = substr($pro_img, 2, -2);
            }            
            // print($pro_img);
            // if(substr($string, 0, 3) === "Mr.")
            // $pos = strpos($pro_img, "h");
            // var_dump($pos);
            // exit();
            $upload_other_image = file_get_contents( $pro_img);
            // $extension = pathinfo(parse_url($upload, PHP_URL_PATH), PATHINFO_EXTENSION);
            // echo $img_val;
            // print_r($extension);
            // exit();
            $imageName = $sku.'_other_'.time().'.webp';
            $destination = '/home3/bdmonst1/public_html/wp/lider-invest/wp-content/themes/liderinvest/images/arogga_image/'.$imageName;
            // print($destination);
            // exit();
            $other_img = file_put_contents($destination, $upload_other_image);
            
            $upload = wp_upload_bits( 'test.webp', null, file_get_contents( $destination,FILE_USE_INCLUDE_PATH ) );
            // echo $destination;
            
            $filename = $upload['file'];
            $wp_filetype = wp_check_filetype( $filename, null );
            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title' => sanitize_file_name( $filename ),
                'post_content' => '',
                'post_status' => 'inherit'
            );

            $attachment_id = wp_insert_attachment( $attachment, $filename, $product_id );
            // require_once(ABSPATH . 'wp-admin/includes/image.php');

            // $attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
            // wp_update_attachment_metadata( $attachment_id, $attachment_data );
            // set_post_thumbnail( $product_id, $attachment_id );
            update_post_meta($product_id,'_product_image_gallery',$attachment_id);
          }
          
    }
        
  }     
  $attributes[] = $attribute;
       update_post_meta($product_id, '_product_attributes', $data_attr);
    $product_attributes = get_post_meta($product_id, '_product_attributes', true);  
    
    }
function trz_at_add_product($data){
    // print_r($data);
    // exit();
  $postname = sanitize_title( $data[0]['medicine_name'] );
  $author = '1';
  //$author = empty( $data['author'] ) ? '1' : $data['author'];

    $post_data = array(
        'post_author'   => $author,
        'post_name'     => $postname,
        'post_title'    => $data[0]['medicine_name'],
        'post_content'  => '',
        'post_excerpt'  => '',
        'post_status'   => 'publish',
        'ping_status'   => 'closed',
        'post_type'     => 'product',
        'guid'          => home_url( '/product/'.$postname.'/' ),
    );

    // Creating the product (post data)
    $product_id = wp_insert_post( $post_data );
    
  
    return $product_id;
}
    function trz_at_get_artwork_service($data){
        $trz_artwork = array();
        // $pattern1 = "/Price /i"; // columns with price( with space) are the artwork service
        foreach ($data[0] as $key => $value) { //data[0]  is the first row of csv. all data in te columns are same 
            // if(preg_match_all($pattern1, $key) !=0){
            $trz_artwork[$key] = $value;
            // }
        }

        return $trz_artwork;
    }
    function trz_at_create_product_variation( $product_id, $variation_data ){
      // Get the Variable product object (parent)
        $product = wc_get_product($product_id);
    
        $variation_post = array(
            'post_title'  => $product->get_name(),
            'post_name'   => 'product-'.$product_id.'-variation',
            'post_status' => 'publish',
            'post_parent' => $product_id,
            'post_type'   => 'product_variation',
            'guid'        => $product->get_permalink()
        );
        // Creating the product variation
        $variation_id = wp_insert_post( $variation_post );
    
        // Get an instance of the WC_Product_Variation object
        $variation = new WC_Product_Variation( $variation_id );
        //variation set attribute;
        $v= $variation_data['attributes'];
        //$v =['Size' => 'A3 Landscape Deskpad', 'Pages Per Pad' =>'25'];
        $variation->set_attributes($v);
        ## Set/save all other data
    
        // SKU
        if( ! empty( $variation_data['sku'] ) )
        $variation->set_sku( $variation_data['sku'] );
    
        // Prices
        if( empty( $variation_data['sale_price'] ) ){
          $variation->set_price( $variation_data['regular_price'] );
        } 
        else {
          $variation->set_price( $variation_data['sale_price'] );
          $variation->set_sale_price( $variation_data['sale_price'] );
        }
        $variation->set_regular_price( $variation_data['regular_price'] );
    
        // Stock
        if( ! empty($variation_data['stock_qty']) ){
          $variation->set_stock_quantity( $variation_data['stock_qty'] );
          $variation->set_manage_stock(true);
          $variation->set_stock_status('');
        } 
        else {
          $variation->set_manage_stock(false);
      }
    
      $variation->set_width($variation_data['flat_width']); // weight (reseting)
      $variation->set_height($variation_data['flat_height']); // height (reseting)
    
      $variation->save(); // Save the data
    
    }
