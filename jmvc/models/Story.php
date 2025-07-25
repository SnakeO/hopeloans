<?php

class Story extends JModelBase
{
	use ACFModelTrait;
	public static $post_type = 'story';
	public static $instances = array();

	protected static $shuffled_stories = array();

	public static function getShuffledStories()
	{
		if( count(Story::$shuffled_stories) == 0 ) 
		{
			$stories = get_posts(array(
				'post_type' 		=> 'story',
				'posts_per_page'	=> -1,
				'post_status'		=> 'publish'
			));

			foreach($stories as $story) {
				Story::$shuffled_stories[] = new Story($story->ID);
			}

			shuffle(Story::$shuffled_stories); 
		}

		return Story::$shuffled_stories;
	}
	
	public static function makeShortcodes()
	{
		/* Specific Story tools */
		add_shortcode('story-headshot', function($attrs)
		{
			$stories = Story::getShuffledStories();

			$attrs = shortcode_atts( array(
				'post_id' => null,
			), $attrs );

			
			$story = new Story($attrs['post_id']);

			$permalink = $story->permalink();
			$thumbnail_id = get_post_thumbnail_id($story->ID);
			return do_shortcode('[vc_single_image image="' . $thumbnail_id . '" img_size="full" alignment="center" style="vc_box_circle_2" el_class="mint-border"]');
		});

		/* Random Story tools */
		add_shortcode('story-random-headshot', function($attrs)
		{
			$stories = Story::getShuffledStories();

			$attrs = shortcode_atts( array(
				'index' => rand(0, count($stories)-1),
			), $attrs );

			$i = $attrs['index'];
			$story = $stories[$i];

			$permalink = $story->permalink();
			$thumbnail_id = get_post_thumbnail_id($story->ID);
			return "<a href='$permalink'>" . do_shortcode('[vc_single_image image="' . $thumbnail_id . '" img_size="full" alignment="center" style="vc_box_circle_2" el_class="mint-border"]') . "</a>";
		});

		add_shortcode('story-random-name', function($attrs)
		{
			$stories = Story::getShuffledStories();

			$attrs = shortcode_atts( array(
				'index' => rand(0, count($stories)-1),
			), $attrs );

			$i = $attrs['index'];
			$story = $stories[$i];

			return $story->post_title;
		});

		add_shortcode('story-random-excerpt', function($attrs)
		{
			$stories = Story::getShuffledStories();

			$attrs = shortcode_atts( array(
				'index' => rand(0, count($stories)-1),
			), $attrs );

			$i = $attrs['index'];
			$story = $stories[$i];

			$excerpt = apply_filters( 'the_excerpt', $story->post_content );
			$excerpt = strip_tags($excerpt, "<br><p><a><i><em><b><h1><h2><h3><h4><h5>");

			$limit = 35;	// number of words limit
			$words = explode(' ', $excerpt);

			if( count($words) <= $limit ) {
				return $excerpt;
			}

			return implode(' ', array_slice($words, 0, $limit)) . '...';
		});

		add_shortcode('story-random-readmore-btn', function($attrs)
		{
			$stories = Story::getShuffledStories();

			$attrs = shortcode_atts( array(
				'index' 	=> rand(0, count($stories)-1),
				'title'		=> 'READ MORE &raquo;',
				'color'		=> 'primary'
			), $attrs );

			$i = $attrs['index'];
			$story = $stories[$i];

			$permalink = urlencode($story->permalink());

			return do_shortcode('[vc_btn title="' . $attrs['title'] . '" style="flat" color="' . $attrs['color'] . '" size="sm" align="center" link="url:' . $permalink . '|||"]');
		});
		
	}

	public static function setupFilters()
	{
		
	}
}