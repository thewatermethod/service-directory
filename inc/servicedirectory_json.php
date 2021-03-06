<?php

	function servicedirectory_createjson(){
		global $post;

		$locations = array();
		$urls = array();


		$args = array(
			'post_type'=> 'service',
			'post_status'=>'publish',
			'posts_per_page'=> '-1'
		);

		query_posts($args);

		if (have_posts()){

			$x = 0;

			while( have_posts() ){
				the_post();
				$permalink = get_permalink();
				$name = get_the_title();
				$theID = get_the_ID();
				$is_premium = get_post_meta( $theID, 'is_premium', true );
				$theLocation = get_post_meta( $theID, 'place_location', true);
				$search = array("(", ",", ")");
				$replace = array(" ");
				$theLocation = str_replace($search, $replace, $theLocation);
				$theLocation = explode(" ", $theLocation);

				$new_input[ $x ] = array(
					'name' => $name,
					'longitude' => $theLocation[2],
					'latitude' => $theLocation[1],
					'url' => $permalink,
					'premium' => $is_premium
				);

				$locations['locations'][$x]  = $new_input[ $x ];
				$x++;

			}

			return json_encode($locations);
		}

		wp_reset_query();

	}

	$json = servicedirectory_createjson();
