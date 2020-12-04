<?php

// -----------------------------------------
// semplice
// admin/atts/modules/code.php
// -----------------------------------------

$code = array(
	'options' => array(
		'title'  	 => 'Options',
		'hide-title' => true,
		'break'		 => '1,2',
		'code' => array(
			'data-is-content' => true,
			'title'				=> 'Code',
			'size'				=> 'span4',
			'data-input-type'	=> 'codemirror',
			'data-target'		=> '.content-block',
			'placeholder'		=> '<!-- Please paste your code here -->',
			'default'			=> '',
			'button-title'		=> 'Edit Code',
			'class'				=> 'semplice-button codemirror admin-click-handler',
			'data-handler'		=> 'codemirror',
		),
		'is_video' => array(
			'data-input-type' => 'switch',
			'help'			  => 'Set to \'Yes\' if you embed a video from Youtube, Vimeo etc. to make the video responsive.',
			'switch-type'=> 'twoway',
			'title'		 => 'Responsive Video',
			'size'		 => 'span2',
			'class'      => 'editor-listen',
			'data-handler' => 'save',
			'default' 	 => 'no',
			'switch-values' => array(
				'no'	 => 'No',
				'yes'	 => 'Yes',
			),
		),
		'is_shortcode' => array(
			'data-input-type' => 'switch',
			'help'			  => 'Set to \'Yes\' if you use a shortcode from WordPress or a plugin.',
			'switch-type'=> 'twoway',
			'title'		 => 'Is Shortcode',
			'size'		 => 'span2',
			'class'      => 'editor-listen',
			'data-handler' => 'save',
			'default' 	 => 'no',
			'switch-values' => array(
				'no'	 => 'No',
				'yes'	 => 'Yes',
			),
		),
	),
);

?>