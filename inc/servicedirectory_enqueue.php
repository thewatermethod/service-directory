<?php
	function servicedirectory_css_and_js(){
		wp_register_style('servicedirectory-styles', plugins_url('../css/styles.css',__FILE__ ));
		wp_enqueue_style('servicedirectory-styles');

}

	add_action('init', 'servicedirectory_css_and_js');


	function serviceeditscript (){

		global $post_type;

		if( $post_type == "service"){
			wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDe710MLkkbulyOcOKU6G8vb1d8bA0X9YE&libraries=places', 'jquery', '', true);
			wp_enqueue_script('service-admin-script', plugins_url( '../js/serviceadmin.js', __FILE__),'google-maps','', true);
		}
	}


	add_action( 'admin_print_scripts-post-new.php', 'serviceeditscript', 11 );
	add_action( 'admin_print_scripts-post.php', 'serviceeditscript', 11 );

