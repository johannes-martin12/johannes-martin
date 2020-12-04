<?php

// -----------------------------------------
// semplice
// admin/atts/customize.php
// -----------------------------------------

// customize list
$customize_settings = array('grid', 'webfonts', 'navigations', 'typography', 'thumbhover', 'projectpanel', 'transitions', 'blog', 'advanced');

// include files
foreach ($customize_settings as $setting) {
	require get_template_directory() . '/admin/atts/customize/' . $setting . '.php';
}

$customize = array(
	
	// grid
	'grid' => $grid,

	// webfonts
	'webfonts' => $webfonts,

	// navigations
	'navigation' => $navigations,

	// typography
	'typography' => $typography,

	// thumbhover
	'thumbhover' => $thumbhover,

	// project panel
	'projectpanel' => $projectpanel,

	// transitions
	'transitions' => $transitions,

	// blog
	'blog' => $blog,

	// advanced
	'advanced' => $advanced,
);

?>