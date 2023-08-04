<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// add_action('woocommerce_after_single_product_summary', 'gss_additional_info');
add_filter( 'woocommerce_product_tabs', 'gss_new_product_tab' );
function gss_new_product_tab( $tabs ) {
  // Adds the new tab
  if(have_rows('tipo_de_documento')){

    while( have_rows('tipo_de_documento') ) : the_row();
      $name = get_sub_field('name');
      $files = get_sub_field('repeater_files');
      if( !empty($files) ): 
        $tabs[str_replace('+', '_', urlencode(remove_accents($name)))] = array(
          'title'     => __( $name, 'gasservei' ),
          'priority'  => 50,
          'callback_parameters' => $files,
          'callback'  => 'gss_files_tab_content',
      );
      endif;
    endwhile;
  }
	return $tabs;
}

add_filter( 'woocommerce_product_description_heading', 'gss_description_heading' );
function gss_description_heading( $heading ){
	return __('Additional information', 'gasservei');	
}

add_filter( 'woocommerce_product_tabs', 'gss_rename_description_tab' );
function gss_rename_description_tab( $tabs ) {
	$tabs['description']['title'] = __('Additional information', 'gasservei');
	return $tabs;
}

function gss_files_tab_content($tab_name, $files) {
  $repeater_files = $files;      
  ?>
   <ul class="file_attributes">
     <?php foreach($repeater_files as $files): 
            foreach($files as $file): 
              $filename = $file['nombre_del_fichero'];
              $file = $file['fichero'];
              if( $file ): 
              ?>
                  <li>
                    <a href="<?php echo $file['url']; ?>" class="file-link">
                      <svg width="31" height="39" viewBox="0 0 31 39" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.7274 0.297267C20.551 0.111512 20.3092 0 20.0586 0H5.05412C2.2854 0 0 2.27631 0 5.04473V33.4183C0 36.187 2.2854 38.4633 5.05412 38.4633H25.4191C28.1878 38.4633 30.4732 36.187 30.4732 33.4183V10.8885C30.4732 10.647 30.3617 10.4149 30.2038 10.2382L20.7274 0.297267ZM20.9968 3.27962L27.3424 9.94098H23.2173C21.991 9.94098 20.9968 8.95615 20.9968 7.72982V3.27962ZM25.4191 36.6052H5.05412C3.31689 36.6052 1.85814 35.1652 1.85814 33.4183V5.04473C1.85814 3.3075 3.3075 1.85814 5.05412 1.85814H19.1386V7.72982C19.1386 9.98734 20.9598 11.7991 23.2173 11.7991H28.6151V33.4183C28.6151 35.1652 27.1657 36.6052 25.4191 36.6052Z" fill="#EE7E12"/>
                        <path d="M22.8826 30.1948H7.5902C7.0793 30.1948 6.66113 30.6127 6.66113 31.1239C6.66113 31.6348 7.0793 32.053 7.5902 32.053H22.892C23.4029 32.053 23.821 31.6348 23.821 31.1239C23.821 30.6127 23.4029 30.1948 22.8826 30.1948Z" fill="#EE7E12"/>
                        <path d="M14.5583 26.8595C14.7349 27.0452 14.9764 27.1568 15.2364 27.1568C15.4967 27.1568 15.7382 27.0452 15.9146 26.8595L21.359 21.0157C21.712 20.6439 21.6842 20.0493 21.3127 19.7057C20.9409 19.3527 20.3463 19.3803 20.0027 19.7521L16.1655 23.8677V13.7225C16.1655 13.2113 15.7473 12.7935 15.2364 12.7935C14.7255 12.7935 14.3074 13.2113 14.3074 13.7225V23.8677L10.4796 19.7521C10.1266 19.3806 9.54113 19.3527 9.16962 19.7057C8.79811 20.0587 8.77023 20.6442 9.12325 21.0157L14.5583 26.8595Z" fill="#EE7E12"/>
                      </svg>

                      <h5><?php _e('Download', 'gasservei'); ?> <span><?php echo $filename; ?></span></h5>
                    </a>
                  </li>
              <?php endif; ?>
            <?php endforeach; ?>
     <?php endforeach; ?>
   </ul>
 <?php 
}