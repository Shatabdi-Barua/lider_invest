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
$i = 0;
 
 update_post_meta($product_id, '_product_attributes', $data_attr);
 $product_attributes = get_post_meta($product_id, '_product_attributes', true);  