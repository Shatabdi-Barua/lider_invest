function trz_at_add_variation_product($data,$col_head, $trz_at_variations,$prev_prdct_id)
{  

  if($prev_prdct_id !=''){

  
    $product = wc_get_product($prev_prdct_id);

    foreach ($product->get_children() as $child_id)
    {
        $child = wc_get_product($child_id); 
        $child->delete(true);
    }
    $product_id = $prev_prdct_id;
    $product = new WC_Product_Variable( $prev_prdct_id );
    $product->save();
    
  }else{
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

    //array for artwork service additional price
    // $trz_artwork = trz_at_get_artwork_service($data);
     
    // update_post_meta( $product_id, '_product_artwork_additional_price', $trz_artwork); 
    
    //print_r($trz_artworks);
    //adding attributes
    $attributes= array();
    // echo '<pre>';
    // print_r(array_keys($trz_at_variations));
    // exit();
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
           
            //     
            // exit();
            $get_first = $vv[0];
            $get_first = str_ireplace("'",'',$get_first);

            
            // print_r(gettype($get_first));      
            // print_r(substr($get_first, 2, -2));
            $has_star = strpos($get_first, "*");
            if($has_star == false)
            {
              // print('no star exist');
              $get_number = (int)$get_first;
              // $get_text= ()$get_first;
              $get_types = preg_replace('!\d+!', "", $get_first); //tablet/capsule
              // print_r($get_types); 
              // echo $get_price;
              // echo $get_number;
              $price_for_first = (float)$get_price/$get_number; //for 1 table
              array_push($package_variation, $price_for_first);
              $price_for_second = (float)$price_for_first*$get_number; //for 1 strip
              array_push($package_variation, $price_for_second);
              $price_for_third = (float)$price_for_second*$get_number; //for 1 box
              array_push($package_variation, $price_for_third);
              $package_variation_count = count($package_variation);
              for ($i=0; $i<$package_variation_count; $i++)
              {
                $package_title_childs = array();
                $package_title_childs['title'] = $get_types;
                $package_title_childs['price'] = $package_variation[$i];
              }
              print_r("<pre>"); 
              print_r($package_title_childs); 
              exit();
              $package_title = $package_title_childs;
             

              
             
              $package_title_childs = array();
              $package_title_childs['title'] = 'Strips';
              $package_title_childs['price'] = $price_for_second;
              $package_title  = $package_title_childs;
              


             


              $package_title_childs = array();
              $package_title_childs['title'] = 'Box';
              $package_title_childs['price'] = $price_for_third;
              // $package_title['package_title'][] = $package_title_childs;
              $package_title = $package_title_childs;
              
                
            }

          }
            // print_r("<pre>"); 
            // print_r($package_title_childs); 
            // exit(); 
         
        }
                
      } 
        trz_at_create_product_variation( $product_id, $package_title );
        $product->save();

        // foreach($price_type as $pr_type)
        // {
        //   $temp_array =array();
        //   foreach ($col_body as $body) {
        //     $temp_array[] = $body[$attr];
        //   }
        //   $trz_at_variations[$attr] = array_unique($temp_array);
        // }
        // foreach ($price_type as $pr_type) 
        // {    
        //   $temp_price_array =array();
        //   foreach ($prices_variation as $pr_variation) {
        //       $temp_price_array[] = $pr_variation[$pr_type];
        //     }
        //   $variations_price[$pr_type] = array_unique($temp_price_array);
        //   $variations_price[$pr_type] = array_unique($temp_price_array);        
        // }
        if(count($package_variation)>1){ // if variation 
          $attribute->set_visible(false);
          $attribute->set_variation(true);
        }else{ //if not varriation
          $attribute->set_visible(true);
          $attribute->set_variation(false);
        }
        foreach ($values as $val) {
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
        if($key == 'sku')
        {
          foreach($values as $sku_value)
          {
            $sku = $sku_value;
          }
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
      
    
    }
    update_post_meta($product_id, '_product_attributes', $data_attr);
    //echo '<pre>';
    //print_r($data_attr); 
    $product_attributes = get_post_meta($product_id, '_product_attributes', true);  
    //echo '<pre>';
    //print_r($product_attributes); 
    // exit();
    
    //  $product->set_attributes($attributes);
    //  $product->save();
   
    //array to track production days, will be saved in update_option
    // $trz_at_track_production_days = array();
    //making combinations of all variations

    // foreach ($data as $data_each) {

    //   //each row       
    //   $variant_array = array();
    //   foreach ($data_each as $col_key => $col_value) {    
    //     //each col  
    //     foreach ($trz_at_variations as $key => $value) {
    //       if(count($value)>1){
    //         $col_key = str_replace(' ', '_', $col_key);
    //         $col_key = strtolower($col_key);
    //         $key = str_replace(' ', '_', $key);
    //         $key = strtolower($key); 
                       
    //         if($key == $col_key){
    //           $variant_array[$col_key] = $col_value;
    //         }                      
    //       }
    //     }
    //   }

      // //for days & price 
      // foreach ($price_type as $key => $value) 
      // {
      //   // if( $key == 'Production Days')
      //   // { 
      //     $key = str_replace(' ', '_', $key);
      //     $key = strtolower($key);  
      //     foreach ($value as  $v) {
      //       // v = expand, saver, sameday, express
      //       $trz_at_variation_data = array();
      //       $trz_at_track =array(); 
      //       $variant_array[$key] = $v;          
      //       //preparing variation data
      //       $trz_at_variation_data['attributes']=$variant_array;
      //       $trz_at_variation_data['sku']='';

      //       // getting price
      //       foreach ($prices_variation as $col_value)
      //       {
      //       //   $pattern1 = "/Production Days/i";
      //       //   $pattern2 = "/price/i";
      //       //   $pattern3 = "/Flat/i"; 
      //       //   $pattern4 = "/Width/i"; 
      //       //   $pattern5 = "/Height/i"; 
      //       //   if(preg_match_all($pattern2, $col_key) !=0  ){
      //           // $v_pattern = "/".trim($v)."/i";
      //           // if(preg_match_all($v_pattern, $col_key) !=0  ){
      //             //echo $col_key;

      //           //   $x = (float) $col_value +  (float) $data_each['Tax']; // price with tax 
      //           //   $y = (float) $trz_at_percentage / 100; // add percentage
      //           //   $x = $x + $x * $y;
      //             $trz_at_variation_data['regular_price']= $col_value;
      //           //   $trz_at_track['Price']= $x;
      //           // }
      //       //   }
      //         //show production days
      //       //   if(preg_match_all($pattern1, $col_key) !=0  ){
      //       //     $v_pattern = "/".trim($v)."/i";
      //       //     if(preg_match_all($v_pattern, $col_key) !=0  ){
      //       //       //echo $col_key. '=>'. $col_value;
      //       //       //update_option('trz_production_days', $col_value);
      //       //       $trz_at_track[$v] = $col_value;
      //       //       $trz_at_track['Quantity']= $data_each['Quantity'];
      //       //       $trz_at_track['Type']= $v;
      //       //     }
      //       //   }

      //       //   if(preg_match_all($pattern3, $col_key) !=0){
      //       //     if(preg_match_all($pattern4, $col_key) !=0){
      //       //       $trz_at_variation_data['flat_height']=$col_value;
      //       //     }
      //       //     if(preg_match_all($pattern5, $col_key) !=0){
      //       //       $trz_at_variation_data['flat_width']=$col_value;
      //       //     }
      //       //   }

      //       }
      //       // $trz_at_variation_data['sale_price']='';
      //       // $trz_at_variation_data['stock_qty']=99999;
      //       // $trz_at_track_production_days[] = $trz_at_track;
      //       //echo '<pre>';
      //       //print_r($trz_at_variation_data);
      //       // echo '<pre>';
      //       // print_r($trz_at_variation_data);
      //       // exit();
            

           
      //     }          
      //   // } 
      // }
      // trz_at_create_product_variation( $product_id, $package_title );
      // $product->save();
      
    // }
    //echo '<pre>';
    //print_r($trz_at_track_production_days);
    //echo '<pre>';

    //getting varian product id and then preseving info (update post meta) for creating orders 
    // $product = wc_get_product($product_id);
    // $variations = $product->get_available_variations();
    // //for post meta 
    // $variation_metas=array();
    // foreach ($variations as $v) {
    //   $variation_meta=array();
    //   $variation_meta['attributes'] = $v['attributes'];
    //   $variation_meta['display_regular_price'] = $v['display_regular_price'];
    //   $variation_metas[] = $variation_meta;
    // }

    // $variations_id = wp_list_pluck( $variations, 'variation_id' );
    
    // $data_count =  count($data);
    // $variation_count=count($variations_id);
    // // $production_days_count =count($trz_at_variations['Production Days']);
    // $i=1;
    // $k =0;
    // foreach($variations_id as $v_id){      
    //   //echo "variation :<br>"; 
    //   //echo $v_id .' '. $k .' '.$i.'<br>';
    // //   update_post_meta( $v_id, '_print_api_product', 'trade_print' );
    // //   update_post_meta( $v_id, '_print_api_product_id', $data[$k]['ProductID']);
    // //   update_post_meta( $v_id, '_print_api_product_name', $data[$k]['ProductName']);
    // //   update_post_meta( $v_id, '_print_api_product_json_data', $data[$k]['productionDataJSON']);
    //   if($i == $production_days_count){
    //     $i=1;
    //     $k++;
    //   }else{
    //     $i++;
    //   } 
    // }
    // update_post_meta($product_id,'production_days_count', $production_days_count);
    // update_post_meta($product_id,'trz_production_days',$trz_at_track_production_days );
    // update_post_meta($product_id,'trz_attributes_meta',$trz_at_variations );
    // update_post_meta($product_id,'trz_variations_meta',$variation_metas );

    // echo "<div class='update-nag notice notice-sucess inline'><span class='closebtn' onclick='this.parentElement.style.display=\"none\";'>&times;</span>  <strong> Product Uploaded Succesfully.</strong></div>"; 
}