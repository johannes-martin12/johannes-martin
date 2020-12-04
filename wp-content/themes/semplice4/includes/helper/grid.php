<?php

// -----------------------------------------
// grid
// -----------------------------------------

function semplice_grid($mode) {

	// css
	$output = '';
	$gutter = 0;
	$outer_padding = 30;
	$grid_width = 1170;

	// get custom grid values
	$grid = json_decode(get_option('semplice_customize_grid'), true);

	if(is_array($grid)) {

		// outer padding
		if(isset($grid['outer_padding']) && $mode == 'frontend') {
			$outer_padding = $grid['outer_padding'];
			// outer padding only for desktop
			$output .= '
				@media screen and (min-width: 1170px) {
					.container-fluid, .container, .admin-container {
						padding: 0 ' . round($outer_padding / 18, 5) . 'rem 0 ' . round($outer_padding / 18, 5) . 'rem;
					}
				}
			';
		}

		// grid width
		if(isset($grid['width'])) {
			// is < 1170?
			if($grid['width'] < 1170) {
				$grid_width = 1170;
			} else {
				$grid_width = $grid['width'];
			}	
		}

		// css
		$output .= '.container {
			max-width: ' . ($grid_width + ($outer_padding * 2)) . 'px;
		}';
		
		// mobile gutter
		if(isset($grid['responsive_gutter']) && is_numeric($grid['responsive_gutter'])) {
			$output .= semplice_get_grid_breakpoint($grid['responsive_gutter'], $mode, false);
		}

		// xl gutter 
		if(isset($grid['gutter']) && is_numeric($grid['gutter'])) {
			$output .= semplice_get_grid_breakpoint($grid['gutter'], $mode, true);
			$gutter = $grid['gutter'];
		}		
	}

	return $output;
}

// -----------------------------------------
// grid breakpoint
// -----------------------------------------

function semplice_get_grid_breakpoint($gutter, $mode, $is_desktop) {
	// media query open
	$output = '';
	// define prefix
	$prefix = '';
	if($mode == 'editor') {
		if($is_desktop) {
			$prefix = '[data-breakpoint="xl"]';
		}
		// row
		$output .= $prefix . ' .row {
			margin-left: -' . ($gutter / 2) . 'px;
			margin-right: -' . ($gutter / 2) . 'px;
		}';
		// column
		$output .= $prefix . ' .column, .grid-column {
			padding-left: ' . ($gutter / 2) . 'px;
			padding-right: ' . ($gutter / 2) . 'px;
		}';
	} else {
		if($is_desktop) {
			$prefix = '@media screen and (min-width: 1170px) {';
		} else {
			$prefix = '@media screen and (max-width: 1169px) {';
		}

		$output .= $prefix . ' .row {
			margin-left: -' . ($gutter / 2) . 'px;
			margin-right: -' . ($gutter / 2) . 'px;
		}';
		
		$output .= '.column, .grid-column {
			padding-left: ' . ($gutter / 2) . 'px;
			padding-right: ' . ($gutter / 2) . 'px;
		}';

		// close media query
		$output .= '}';
	}

	return $output;
}

// -----------------------------------------
// masonry
// -----------------------------------------

function semplice_masonry($module, $id, $options, $masonry_items, $is_editor, $script_execution) {

	// load more
	$load_more = '';
	if(isset($options['lazy_load']) && is_array($options['lazy_load'])) {
		// short
		$lazy_load = $options['lazy_load'];
		// get button image
		if(is_numeric($lazy_load['button'])) {
			$lazy_load['button'] = semplice_get_image($lazy_load['button'], 'full');
		}
		// only show button if count of projects is > starting offset
		if($options['count'] >= $lazy_load['start_offset']) {
			$load_more = '<div class="load-more-wrapper"><a class="semplice-load-more semplice-event" data-event-type="helper" data-event="lazyLoad" data-type="portfolio-grid" data-load="' . $lazy_load['per_load'] . '" data-offset="' . $lazy_load['start_offset'] . '" data-content-id="' . $id . '"><img src="' . $lazy_load['button'] . '" alt="load-more-button"></a></div>';
		}
	}

	// open masonry
	$masonry_html = '
		<div id="masonry-' . $id . '" class="masonry" data-masonry-init="' . $script_execution . '">
			<div class="masonry-item-width"></div>
	';

	// js tags
	$js_open = '<script type="text/javascript">(function ($) { $(document).ready(function () {';
	$js_close = '});})(jQuery);</script>';

	// instagram sizes
	$instagram_sizes = '';
	if($module == 'instagram') {
		$instagram_sizes = '
			// is instagram?
			if($image.hasClass("semplice-instagram")) {
				var sizes = { width: $image[0].naturalWidth, height: $image[0].naturalHeight };
				$image.attr({ width: sizes.width, height: sizes.height });
				// has video?
				if($item.find("video").length > 0) {
					$item.find("video").attr({ width: sizes.width, height: sizes.height });
					// init video
					$item.find("video").mediaelementplayer({
						pauseOtherPlayers: false,
						stretching: "responsive"
					});
				}
			}
		';
	}

	// masonry javascript
	$masonry_js = $js_open . '
		// define container
		var $container = $(".active-content").find("#masonry-' . $id . '");
		// make jquery object out of items
		var $items = $(".active-content").find(".masonry-' . $id . '-item");

		// fire masmonry
		$container.masonry({
			itemSelector: ".masonry-' . $id . '-item",
			columnWidth: ".masonry-item-width",
			transitionDuration: 0,
			isResizable: true,
			percentPosition: true,
		});

		// show images
		showImages($container, $items);

		// load images and reveal if loaded
		function showImages($container, $items) {
			// get masonry
			var msnry = $container.data("masonry");
			// get item selector
			var itemSelector = msnry.options.itemSelector;
			// append items to masonry container
			//$container.append($items);
			$items.imagesLoaded().progress(function(imgLoad, image) {
				// get item
				var $image = $(image.img);
				var $item = $(image.img).parents(itemSelector);
				' . $instagram_sizes . '
				// layout
				msnry.layout();
				// fade in
				TweenLite.to($item, 1.1, {
					opacity: 1,
					y: 0,
					ease: "Expo.easeOut",
				});
			});
		}

		// remove min height after images are loaded in delayed mode
		$items.imagesLoaded().done(function(imgLoad) {
			if($container.attr("data-masonry-init") == "delayed") {
				$container.attr("data-masonry-init", "loaded");
				// sync scroll reveal if defined
				if(typeof sr != "undefined") {
					sr.sync();
				}
			}
		});
	' . $js_close;

	// script execution
	if($script_execution == 'delayed') {
		// close masonry container first
		$masonry_html .= '</div>';
		// content
		$masonry_content = $masonry_items . $masonry_js;
		// add grid to stack
		$masonry_js = $js_open . '
			sempliceExecuteStack["' . $id . '"] = {
				"type": "masonry",
				"id": "' . $id . '",
				"html": ' . json_encode($masonry_content) . ',
			};
		' . $js_close;
	} else {
		// since not delayed, add items and js to html
		$masonry_html .= $masonry_items . '</div>';
	}

	// add load more
	$masonry_html .= $load_more;

	// add javascript
	$masonry_html .= $masonry_js;

	// output
	return $masonry_html;
}

// -----------------------------------------
// get masonry css
// -----------------------------------------

function semplice_masonry_gutter_css($id, $options, $is_editor, $hor_gutter, $ver_gutter) {
	// mobile gutter css
	$mobile_gutter_css = semplice_mobile_gutter_css($id, $options, $is_editor);

	// masonry css
	$masonry_css = '
			#masonry-'. $id .'{ margin: auto -' . ($hor_gutter / 2) . 'px !important; } 
			.masonry-'. $id .'-item { margin: 0px; padding-left: ' . ($hor_gutter / 2) . 'px; padding-right: ' . ($hor_gutter / 2) . 'px; padding-bottom: ' . $ver_gutter . 'px; }
			' . $mobile_gutter_css . '
	';

	return str_replace(array("\r","\n", "\t"),"",$masonry_css);
}

// -----------------------------------------
// project panel grid html
// -----------------------------------------

function semplice_project_panel_html($is_frontend, $post_id) {

	// vars
	$output = '';

	// get project panel
	$projectpanel = json_decode(get_option('semplice_customize_projectpanel'), true);

	// attributes
	extract(shortcode_atts(
		array(
			'visibility'				=> 'visible',
			'images_per_row'			=> 2,
			'width'						=> 'container',
			'title_visibility'			=> 'visible',
			'meta_visibility'			=> 'both',
			'panel_title_font'			=> 'regular',
			'title_font'				=> 'regular',
			'category_font'				=> 'regular',
			'panel_label'				=> 'Selected Works',
			'gutter'					=> 'yes',
			'hide_active_project'		=> 'no',
		), $projectpanel)
	);

	// get portfolio order
	$portfolio_order = json_decode(get_option('semplice_portfolio_order'));

	// get projects
	$projects = semplice_get_projects($portfolio_order, false, -1, false);

	// items
	$thumbs = '';

	// are there any published projects
	if(!empty($projects)) {
		foreach ($projects as $key => $project) {	

			//show project
			$show_project = true;
			if($hide_active_project == 'yes' && $project['post_id'] == $post_id) {
				$show_project = false;
			}

			// masonry items open
			if(true === $show_project) {
				$thumbs .= '
					<div class="pp-thumb column" data-xl-width="' . $images_per_row . '" data-sm-width="4" data-xs-width="6">
						<a href="' . $project['permalink'] . '" title="' . $project['post_title'] . '"><img src="' . $project['pp_thumbnail']['src'] . '" width="' . $project['pp_thumbnail']['width'] . '" height="' . $project['pp_thumbnail']['height'] . '"></a>
						<p class="pp-title"><a data-font="' . $title_font . '" href="' . $project['permalink'] . '" title="' . $project['post_title'] . '">' . $project['post_title'] . '</a><span data-font="' . $category_font . '">' . $project['project_type'] . '</span></p>
					</div>
				';
			}
		}
	} else {
		$thumbs = '<div class="empty-portfolio"><img src="' . get_template_directory_uri() . '/assets/images/admin/noposts.svg" alt="no-posts"><h3>Looks like you have an empty Portfolio. Please note that only<br />published projects are visible in the project panel.</h3></div>';
	}

	// is visible? if not return nothing
	if($visibility != 'hidden' && true === $is_frontend && get_post_type($post_id) == 'project' || false === $is_frontend) {
		// html
		return '
			<section class="project-panel" data-pp-gutter="' . $gutter . '" data-pn-layout="' . $width . '">
				<div class="container" data-title-visibility="' . $title_visibility . '" data-meta-visibility="' . $meta_visibility . '">
					<div class="row">
						<div class="column" data-xl-width="12">
							<p class="panel-label"><span data-font="' . $panel_title_font . '">' . $panel_label . '</span></p>
						</div>
					</div>
					<div class="row pp-thumbs">
						' . $thumbs . '
					</div>
				</div>
			</section>
		';
	} else {
		return '';
	}
}

// -----------------------------------------
// project panel grid css
// -----------------------------------------

function semplice_project_panel_css($is_frontend) {

	// get project panel
	$projectpanel = json_decode(get_option('semplice_customize_projectpanel'), true);

	// attributes
	extract(shortcode_atts(
		array(
			'background'				=> '#f5f5f5',
			'panel_padding'				=> '2.5rem',
			'panel_title_color'			=> '#000000',
			'panel_title_fontsize'		=> '1.777777777777778rem',
			'panel_title_text_transform'=> 'none',
			'panel_padding_left'		=> '0rem',
			'panel_padding_bottom'		=> '1.666666666666667rem',
			'panel_text_align'			=> 'left',
			'title_padding_bottom'		=> '1.666666666666667rem',
			'title_color'				=> '#000000',
			'title_fontsize'			=> '0.7222222222222222rem',
			'title_text_transform'		=> 'none',
			'title_padding_top'			=> '0.5555555555555556rem',
			'category_color'			=> '#999999',
			'category_fontsize'			=> '0.7222222222222222rem',
			'category_text_transform'	=> 'none',
		), $projectpanel)
	);

	// return css
	return '
		.project-panel {
			background: ' . $background . ';
			padding: ' . $panel_padding . ' 0rem;
		}
		.pp-thumbs {
			margin-bottom: -' . $title_padding_bottom . ';
		}
		#content-holder .panel-label, .projectpanel-preview .panel-label {
			color: ' . $panel_title_color . ';
			font-size: ' . $panel_title_fontsize . ';
			text-transform: ' . $panel_title_text_transform . ';
			padding-left: ' . $panel_padding_left . ';
			padding-bottom: ' . $panel_padding_bottom . ';
			text-align: ' . $panel_text_align . ';
			line-height: 1;
		}
		.project-panel .pp-title {
			padding: ' . $title_padding_top . ' 0rem ' . $title_padding_bottom . ' 0rem;
		}
		.project-panel .pp-title a {
			color: ' . $title_color . '; 
			font-size: ' . $title_fontsize . '; 
			text-transform: ' . $title_text_transform . ';
		} 
		.project-panel .pp-title span {
			color: ' . $category_color . ';
			font-size: ' . $category_fontsize . ';
			text-transform: ' . $category_text_transform . ';
		}
	';
}

// -----------------------------------------
// get mobile gutter
// -----------------------------------------

function semplice_mobile_gutter_css($id, $gutter, $is_editor) {
	// output
	$output = '';

	// get breakpoints
	$breakpoints = semplice_get_breakpoints($is_editor);

	// iterate breakpoints
	foreach ($breakpoints as $breakpoint => $width) {
		if(isset($gutter['hor_gutter_' . $breakpoint]) || isset($gutter['ver_gutter_' . $breakpoint])) {
			// open css
			$css = array(
				'margin'  => '',
				'padding' => '.masonry-'. $id .'-item {',
			);
			// hor gutter
			if(isset($gutter['hor_gutter_' . $breakpoint])) {
				$css['margin'] .= '#masonry-'. $id .'{ margin: auto -' . ($gutter['hor_gutter_' . $breakpoint] / 2) . 'px !important; }';
				$css['padding'] .= 'padding-left: ' . ($gutter['hor_gutter_' . $breakpoint] / 2) . 'px; padding-right: ' . ($gutter['hor_gutter_' . $breakpoint] / 2) . 'px;';

			}
			// ver gutter
			if(isset($gutter['ver_gutter_' . $breakpoint])) {
				$css['padding'] .= 'padding-bottom:  ' . $gutter['ver_gutter_' . $breakpoint] . 'px;';
			}
			// close css
			$css['padding'] .= '}';
			// css
			if(true === $is_editor) {
				// margin?
				if(!empty($css['margin'])) {
					$output .= '[data-breakpoint="' . $breakpoint . '"] ' . $css['margin'] . ' ';
				}
				$output .= '[data-breakpoint="' . $breakpoint . '"] ' . $css['padding'];
			} else {
				$output .= '@media screen' . $width['min'] . $width['max'] . ' {' . $css['margin'] . $css['padding'] . '}';
			}
		}
	}

	// return css
	return $output; 
}

?>