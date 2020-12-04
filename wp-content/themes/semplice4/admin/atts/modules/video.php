<?php

// -----------------------------------------
// semplice
// admin/atts/modules/video.php
// -----------------------------------------

$video = array(
	'options' => array(
		'title'  	 => 'Options',
		'hide-title' => true,
		'break'		 => '1,1,2,1,1,1,1,1',
		'video' => array(
			'title'			=> 'Video Upload',
			'size'			=> 'span4',
			'help'			=> 'Please upload a .mp4 file. If a \'Download\' button is visible in the front end instead of your video, you are using a wrong format.',
			'data-input-type' => 'video-upload',
			'default'		=> '',
			'data-is-content' => true,
			'data-upload'	=> 'contentVideo',
		),
		'video_url' => array(
			'data-input-type'	=> 'input-text',
			'title'		 	=> 'Video Url',
			'help'			=> 'If your video is too big to upload into the WordPress media library or you want to include a video from an external source (like a CDN), you can paste the link here. Please use .mp4 format.',
			'size'		 	=> 'span4',
			'placeholder'	=> 'http://my.cdn.com/video.mp4',
			'default'		=> '',
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
		),
		'poster' => array(
			'title'			=> 'Poster',
			'size'			=> 'span2',
			'data-input-type'	=> 'editor-image-upload',
			'default'		=> '',
		),
		'ratio' => array(
			'data-input-type' 	=> 'input-text',
			'title'				=> 'Aspect Ratio',
			'size'				=> 'span2',
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
			'default' 	 		=> '',
			'placeholder'		=> 'Example: 16:9',
			'help'				=> 'If you experience black bars (mostly with non 16:9 aspect ratios), please add your aspect ratio here. Examples: 16:9. You can even just use your resolution like: 1280:720. (don\'t forget the colon between width and height)',
		),
		'autoplay' => array(
			'data-input-type' => 'onoff-switch',
			'style-class'=> 'first-switch',
			'title'		 => 'Autoplay',
			'hide-title' => true,
			'size'		 => 'span4',
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
			'default' 	 => 'off',
			'switch-values' => array(
				'on'	 => 'On',
				'off'	 => 'Off',
			),
		),
		'loop' => array(
			'data-input-type' => 'onoff-switch',
			'title'		 => 'Loop Video',
			'hide-title' => true,
			'size'		 => 'span4',
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
			'default' 	 => 'off',
			'switch-values' => array(
				'on'	 => 'On',
				'off'	 => 'Off',
			),
		),
		'muted' => array(
			'data-input-type' => 'onoff-switch',
			'title'		 => 'Muted',
			'hide-title' => true,
			'size'		 => 'span4',
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
			'default' 	 => 'off',
			'switch-values' => array(
				'on'	 => 'On',
				'off'	 => 'Off',
			),
		),
		'transparent_controls' => array(
			'data-input-type' => 'onoff-switch',
			'title'		 => 'Transparent Controls',
			'hide-title' => true,
			'size'		 => 'span4',
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
			'data-target'=> '.is-content',
			'default' 	 => 'off',
			'switch-values' => array(
				'on'	 => 'On',
				'off'	 => 'Off',
			),
		),
		'hide_controls' => array(
			'data-input-type' => 'onoff-switch',
			'title'		 => 'Hide Controls',
			'hide-title' => true,
			'size'		 => 'span4',
			'class'				=> 'editor-listen',
			'data-handler'		=> 'save',
			'data-target'=> '.is-content',
			'default' 	 => 'off',
			'switch-values' => array(
				'on'	 => 'On',
				'off'	 => 'Off',
			),
		),
	),
);

?>