<?php

// -----------------------------------------
// semplice
// admin/atts/customize/webfonts.php
// -----------------------------------------

$webfonts = array(
	'add-ressource' => array(
		'service' => array(
			'options' => array(
				'title' => 'options',
				'break' => '1,1',
				'hide-title' => true,
				'ressource-name' => array(
					'title'				=> 'Resource Name',
					'size'				=> 'span4-popup',
					'data-input-type'	=> 'input-text',
					'default'			=> '',
					'placeholder'		=> 'Example: Typekit, Fonts.com'
				),
				'ressource-src' => array(
					'title'				=> 'Embed Code',
					'size'				=> 'span4-popup',
					'data-input-type'	=> 'textarea',
					'default'			=> '',
					'placeholder'		=> 'Paste your CSS/JS code here',
					'class'				=> 'ressource-src',
					'help'				=> 'Please paste the embed code for your CSS / JS file in this field. Normally you will get this code in the public settings of your font kit.<br /><br /><b>Example for fonts.com:</b><br /><i>' . htmlentities('<link type="text/css" rel="stylesheet" href="http://fast.fonts.net/cssapi/xxx.css"/>') . '</i>',
				),
			),
		),
		'self-hosted' => array(
			'options' => array(
				'title' => 'options',
				'break' => '1,1',
				'hide-title' => true,
				'ressource-name' => array(
					'title'				=> 'Resource Name',
					'size'				=> 'span4-popup',
					'data-input-type'	=> 'input-text',
					'default'			=> '',
					'placeholder'		=> 'Example: Helvetica CSS'
				),
				'ressource-src' => array(
					'title'				=> 'Embed Code',
					'size'				=> 'span4-popup',
					'data-input-type'	=> 'textarea',
					'default'			=> '',
					'placeholder'		=> 'Paste your CSS code here',
					'class'				=> 'ressource-src',
					'help'				=> 'Please paste the css code for your self hosted webfonts here. Normally this code is shipped with your webfonts.<br /><br /><b>Example code:</b> <a class="help-link" href="https://pastebin.com/5anukcSG" target="_blank">Pastebin</a>',
				),
			),
		),
	),
	// add font
	'add-font' => array(
		'options' => array(
			'title' => 'options',
			'break' => '1,2,1,2',
			'hide-title' => true,
			'display-name' => array(
				'title'				=> 'Display Name',
				'size'				=> 'span4-popup',
				'data-input-type'	=> 'input-text',
				'default'			=> '',
				'placeholder'		=> 'Helvetica Bold',
				'class'				=> 'is-font-setting',
				'help'				=> 'This name gets displayed in font select dropdowns. The name is up to you but it\'s there to help you find and select your font later.<br /><br /><b>Example</b><br />Helvetica Bold'
			),
			'system-name' => array(
				'title'				=> 'System Name',
				'size'				=> 'span2-popup',
				'data-input-type'	=> 'input-text',
				'default'			=> '',
				'placeholder'		=> 'minion-pro-bold',
				'class'				=> 'is-font-setting',
				'help'				=> 'This is the \'real\' font name which is registered by your font files. You can get the real fontname from your font kit export settings (service) or in your self hosted css assets. (self hosted)<br /><br /><b>Note:</b><br />If you are entering a double fontname from services like cloud typography please enter the names without a space in between the comma.<br /><br />Example: Fontname A,Fontname B',
			),
			'font-weight' => array(
				'title'				=> 'Font Weight',
				'size'				=> 'span2-popup',
				'data-input-type'	=> 'select-box',
				'default'			=> '400',
				'class'				=> 'is-font-setting',
				'help'				=> 'Select the font weight of your font. Normally your font service provides you with the correct font-weight values.<br /><br />If your fontname includes the font weight like in \'HelveticaNeueBold\' you can ignore this setting and just set \'Font Weight Usage\' to \'Via Fontname\'',
				'select-box-values' => array(
					100 => '100',
					200 => '200',
					300 => '300',
					400 => '400',
					500 => '500',
					600 => '600',
					700 => '700',
					800 => '800',
					900 => '900',
				),
			),
			'font-weight-usage' => array(
				'title'		 => 'Font Weight usage',
				'size'		 => 'span4-popup',
				'data-input-type' => 'switch',
				'switch-type'=> 'twoway',
				'class' 	 => 'admin-switch',
				'default' 	 => 'css',
				'class'				=> 'is-font-setting',
				'help'				=> 'If your fontname includes the font weight like in \'HelveticaNeueBold\' please set this setting to \'Via Fontname\'. If you have to define a numeric font weight please leave it to \'Via CSS\'',
				'switch-values' => array(
					'css'	=> 'Via CSS',
					'fontname' => 'Via Fontname',
				),
			),
			'category' => array(
				'title'		 => 'Category',
				'size'		 => 'span2-popup',
				'data-input-type' => 'switch',
				'switch-type'=> 'twoway',
				'class' 	 => 'admin-switch',
				'default' 	 => 'sans-serif',
				'class'				=> 'is-font-setting',
				'switch-values' => array(
					'sans-serif'	=> 'Sans-Serif',
					'serif' => 'Serif',
				),
			),
			'font-style' => array(
				'title'		 => 'Font Style',
				'size'		 => 'span2-popup',
				'data-input-type' => 'switch',
				'switch-type'=> 'twoway',
				'class' 	 => 'admin-switch',
				'default' 	 => 'normal',
				'class'				=> 'is-font-setting',
				'switch-values' => array(
					'normal'	=> 'Normal',
					'italic' => 'Italic',
				),
			),
		),
	),
);