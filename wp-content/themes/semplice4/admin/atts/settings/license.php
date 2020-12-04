<?php

// -----------------------------------------
// semplice
// admin/atts/settings/license.php
// -----------------------------------------

$license = array(
	'activation' => array(
		'title'		  => 'Activate your <br />Semplice License',
		//'description' => 'Enter your license code to activate our Semplice One-click Update feature. You can find your license code in your order confirmation email. If you don\'t like to activate one-click updates, leave this field empty.<br /><br />Note: Please dont forget the dashes in your license key.',
		'break'		  => '1,1,1',
		'class'		  => 'activate-semplice',
		'product' => array(
			'style-class'		 => 'product-select',
			'title'				 => 'Select Your License',
			'size'				 => 'span4',
			'data-input-type'    => 'select-box',
			'class'			  	 => 'admin-listen-handler',
			'data-handler'       => 'settings',
			'default'			 => 'single',
			'data-settings-type' => 'general',
			'select-box-values' => array(
				's4-single' => 'Single License',
				's4-studio'	=> 'Studio License',
				's4-single-to-studio' => 'Studio License (Upgrade from Single)',
				's4-business'	=> 'Business License',
				's4-single-to-business'	=> 'Business License (Upgrade from Single)',
				's4-studio-to-business' => 'Business License (Upgrade from Studio)'
			),
		),
		'license_key' => array(
			'style-class'		 => 'license-key-field',
			'data-input-type' 	 => 'input-key',
			'title'			  	 => 'License Key',
			'placeholder' 	  	 => 'XXXX-XXXX-XXXX-XXXX',
			'class'			  	 => 'admin-listen-handler',
			'size'		 	  	 => 'span4',
			'data-handler'    	 => 'settings',
			'default'		  	 => '',
			'data-settings-type' => 'general',
		),
		'license_check' => array(
			'style-class'		 => 'activate-button',
			'data-input-type' 	 => 'button',
			'title'		 		 => 'Preview',
			'hide-title'		 => true,
			'button-title'		 => 'Activate',
			'size'		 		 => 'span2',
			'class'			  	 => 'semplice-button check-license admin-listen-handler',
			'data-handler'    	 => 'settings',
			'data-settings-type' => 'general',
		),
	),
);