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
   