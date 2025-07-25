<?php

class MapController extends APIController {

	// sample JSON
	public function sample()
	{
		header('Content-type:text/json');
		echo JView::get('map/samplejson', array(
			null
		));
	}

	// take all points from charitable campaigns and create 
	// map points for them
	public function json()
	{
		$posts = get_posts(array(
			'post_type' 		=> 'campaign',
			'posts_per_page'	=> -1,
			'post_status'		=> 'publish'
		));

		$markers = [];

		foreach($posts as $post) 
		{
			if( !$post->_campaign_latitude ) {
				continue;
			}

			$post_url = get_permalink($post);
			$cat = get_term($post->category);

			$markers[] = array(
				'title'		=> "<a href='$post_url'>$post->post_title</a>",
				'latitude'	=> $post->_campaign_latitude,
				'longitude' => $post->_campaign_longitude,
				'group'		=> $cat->slug,
				'icon'		=> "/jmvc/assets/img/map-markers/$cat->slug.png"
			);	 
		}

		header('Content-type:text/json');
		echo JView::get('map/markers', array(
			'markers'	=> $markers
		));
	}

	// take all points from COMPLETED charitable campaigns and create 
	// map points for them
	public function completed_campaigns_json()
	{
		$posts = get_posts(array(
			'post_type' 		=> 'campaign',
			'posts_per_page'	=> -1,
			'post_status'		=> 'publish',
			'meta_key'			=> 'is_complete',
			'meta_value'		=> 1
		));

		$markers = [];

		foreach($posts as $post) 
		{
			if( !$post->_campaign_latitude ) {
				continue;
			}

			$post_url = get_permalink($post);
			$cat = get_term($post->category);

			$markers[] = array(
				'title'		=> "<a href='$post_url'>$post->post_title</a>",
				'latitude'	=> $post->_campaign_latitude,
				'longitude' => $post->_campaign_longitude,
				'icon'		=> "/jmvc/assets/img/map-markers/$cat->slug.png"
			);	 
		}

		header('Content-type:text/json');
		echo JView::get('map/markers', array(
			'markers'	=> $markers
		));
	}
}

new MapController();