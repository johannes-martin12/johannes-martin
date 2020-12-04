<?php

// -----------------------------------------
// semplice
// admin/editor/modules/code.php
// -----------------------------------------

if(!class_exists('sm_advancedportfoliogrid')) {
	class sm_advancedportfoliogrid {

		public $output;
		public $is_editor;
		public $detect;

		// constructor
		public function __construct() {
			// define output
			$this->output = array(
				'html' => '',
				'css'  => '',
			);
			// set is editor
			$this->is_editor = true;
			// mobile detect
			global $detect;
			$this->detect = $detect;
		}

		// output frontend
		public function output_editor($values, $id) {

			// get grid
			$this->output = $this->get($values, $id);

			// output
			return $this->output;
		}

		// output frontend
		public function output_frontend($values, $id) {

			// set editor to false
			$this->is_editor = false;
			// get grid
			$this->output = $this->get($values, $id);

			// output
			return $this->output;
		}

		// get grid
		public function get($content, $id) {

			// output
			$output = array(
				'html' => '',
				'css'  => '',
			);

			// status
			$has_posts = true;

			// preset set?
			$preset = 'horizontal-fullscreen';
			if(isset($content['options']['preset']) && !empty($content['options']['preset'])) {
				$preset = $content['options']['preset'];
			}

			// are there posts?
			if(isset($content['options']['order']) && !empty($content['options']['order']) && is_array($content['options']['order'])) {
				// get posts
				$posts = semplice_get_apg_posts('content', $content['options']['order']);
				// grids
				switch($preset) {
					case 'horizontal-fullscreen':
						$output = $this->horizontal_fullscreen($content, $posts, $id);
					break;
					case 'text':
						$output = $this->text($content, $posts, $id);
					break;
				}
			} else {
				$output['html'] = '
					<div class="empty-apg">
						' . get_svg('backend', 'icons/module_advancedportfoliogrid') . '
						<h3>Your grid is empty!<br />Start adding content to your grid.</h3>
						<a class="semplice-button apg-add-content" data-content-id="' . $id . '">Add pages / projects</a>
					</div>
				';
				// set status to false
				$has_posts = false;
				// set posts
				$posts = false;
			}

			return array(
				'html' 			=> $output['html'],
				'css' 			=> $output['css'],
				'hasProjects' 	=> $has_posts,
				'preset' 		=> $preset,
			);
		}

		// basic grid
		public function horizontal_fullscreen($content, $posts, $id) {

			// output
			$output = array(
				'html' => '',
				'css'  => '',
			);

			// section element
			$section_element = '';
			// is normal loadout?
			if(isset($content['section_element'])) {
				$section_element = $content['section_element'];
			}

			// attributes
			extract(shortcode_atts(
				array(
					'hor_full_width'				=> '6',
					'hor_full_width_lg'				=> '6',
					'hor_full_width_md'				=> '6',
					'hor_full_width_sm'				=> '12',
					'hor_full_width_xs'				=> '12',
					'hor_full_object_fit'			=> 'cover',
					'hor_full_bg_even'				=> '#000000',
					'hor_full_bg_odd'				=> '#cccccc',
					'hor_full_transition'			=> 'disabled',
					'hor_full_title_position'		=> 'bottom-center',
					'hor_full_title_visibility'		=> 'both',
					'hor_full_title_padding'		=> '4rem',
					'hor_full_title_offset'			=> '0rem',
					'hor_full_title_color'			=> 'white',
					'hor_full_title_font_family'	=> 'bold',
					'hor_full_title_fontsize'		=> '2.333333333333333rem',
					'hor_full_title_letter_spacing'	=> '0rem',
					'hor_full_title_text_transform' => 'none',
					'hor_full_type_color'			=> 'white',
					'hor_full_type_font_family'		=> 'regúlar',
					'hor_full_type_fontsize'		=> '2.333333333333333rem',
					'hor_full_type_text_transform' 	=> 'none',
					'hor_full_type_padding_top'		=> '0.5555555555555556rem',
					'hor_full_arrow'				=> 'default',
					'hor_full_arrow_custom'			=> false,
					'hor_full_arrow_size'			=> 'small',
					'hor_full_arrow_color'			=> '#ffffff',
					'hor_full_arrow_bg_color'		=> '#000000',
					'hor_full_arrow_bg_opacity'		=> 0,
					'hor_full_hover'				=> 'scale-opacity',
					'hor_full_hover_so_opacity'		=> 40,
					'hor_full_hover_so_scale'		=> 7,
					'hor_full_hover_dimdown_opacity'=> 40,
					'hor_full_hover_border_width'	=> '0.8333333333333333rem',
					'hor_full_hover_border_color'	=> '#ffffff',
					'hor_full_hover_title_fade'		=> 'none',
				), $content['options'] )
			);

			// group cells
			$group_cells = array(
				'6' => 2,
				'4' => 3,
			);

			// custom transition
			if($hor_full_transition == 'enabled') {
				$custom_transition = ' data-custom-transition="horizontal-fullscreen"';
			} else {
				$custom_transition = '';
			}

			// create apg wrapper
			$output['html'] .= '<div class="apg apg-hor-full" data-object-fit="' . $hor_full_object_fit . '" data-title-visibility="' . $hor_full_title_visibility . '" data-arrow-size="' . $hor_full_arrow_size . '" data-mouseover="' . $hor_full_hover . '">';

			// css open (even odd needs to be defined earlier to be able to get overwritten without important statement)
			$selector = '#' . $id . ' .apg-hor-full';
			$output['css'] .= $selector . ' .even { background-color: ' . $hor_full_bg_even . '; }' . $selector . ' .odd { background-color: ' . $hor_full_bg_odd . '; }';

			// remove hover on mobile
			if(true === $this->detect->isMobile()) {
				$hor_full_hover = 'none';
				$hor_full_hover_title_fade = 'none';
			}

			// iterate projects
			foreach ($posts as $key => $post) {
				// bg color class
				$bg_color_class = 'odd';
				// is even?
				if ($key % 2 == 0) {
					$bg_color_class = 'even';
				}
				// options
				$values = $this->get_custom_options($post['post_id'], $post['thumbnail']['src'], $content['options']);
				// project type
				$project_type = '';
				if($post['post_type'] == 'project') {
					$project_type = '<div class="type" data-font="' . $hor_full_type_font_family . '">' . $post['project_type'] . '</div>';
				}
				// output
				$output['html'] .= '
					<div class="post-' . $post['post_id'] . ' apg-post apg-post-hor-full carousel-cell ' . $bg_color_class . $values['custom_class'] . '" data-xl-width="' . $hor_full_width . '" data-lg-width="' . $hor_full_width_lg . '" data-md-width="' . $hor_full_width_md . '" data-sm-width="' . $hor_full_width_sm . '" data-xs-width="' . $hor_full_width_xs . '">
						' . $this->set_custom_styles($id, 'hor-full', $post, $values) . '
						<a class="apg-link" href="' . $post['permalink'] . '"' . $custom_transition . ' data-transition-element="' . 'transition_' . substr(md5(rand()), 0, 9) . '"></a>
						<div class="apg-grid-item">
							<div class="post-thumbnail" data-scale="' . $hor_full_hover_so_scale . '">
								' . $this->get_thumbnail($values['thumbnail'], 'hor-full', $id, $post) . '
							</div>
							<div class="apg-post-title ' . $hor_full_hover_title_fade . '" data-title-align="' . $hor_full_title_position . '">
								<div class="title" data-font="' . $hor_full_title_font_family . '">' . $post['post_title'] . '</div>
								' . $project_type . '
							</div>
						</div>
					</div>
				';

				// css output for background color
				if(isset($values['background-color']) && false !== $values['background-color']) {
					$output['css'] .= $selector . ' .post-' . $post['post_id'] . ' { background-color: ' . $values['background-color'] . '; }';
				}
			}

			// arrows
			$default_arrows = array(
				'default'	  => 'M95.849,46.323H14.1L40.364,20.15a4.166,4.166,0,0,0-5.9-5.881L1.076,47.537a4.162,4.162,0,0,0,0,5.891L34.462,86.7a4.166,4.166,0,0,0,5.9-5.881L14.1,54.642H95.849A4.159,4.159,0,1,0,95.849,46.323Z',
				'alternative' => 'M67.37,100L28.195,50,67.37,0,71.8,5.5,37.581,50,71.8,94.5Z',
			);
			if($hor_full_arrow == 'custom') {
				if(!empty($hor_full_arrow_custom)) {
					$arrow = htmlentities($hor_full_arrow_custom);	
				} else {
					$arrow = $default_arrows['default'];
				}
			} else {
				$arrow = $default_arrows[$hor_full_arrow];
			}

			// arrow color
			if($hor_full_arrow_bg_color != 'transparent') {
				$arrow_bg_color = semplice_hex_to_rgb($hor_full_arrow_bg_color);
				$arrow_bg_color = 'rgba(' . $arrow_bg_color['r'] . ', ' . $arrow_bg_color['g'] . ', ' . $arrow_bg_color['b'] . ', ' . ($hor_full_arrow_bg_opacity / 100) . ')';
			} else {
				$arrow_bg_color = 'transparent';
			}

			// css
			$output['css'] .= '
				' . $section_element . ' .row, ' . $section_element . ' .row .column { height: 100% !important; } ' . $section_element . ' .column-content { height: 100vh; }
				' . $selector . ' .apg-post .apg-post-title, #apg-transition-' . $id . ' .apg-grid-item .apg-post-title { padding: ' . $hor_full_title_padding . '; margin: ' . $hor_full_title_offset . ' 0; }
				' . $selector . ' .apg-post .apg-post-title .title, #apg-transition-' . $id . ' .apg-grid-item .apg-post-title .title { font-size: ' . $hor_full_title_fontsize . '; color: ' . $hor_full_title_color . '; text-transform: ' . $hor_full_title_text_transform . '; letter-spacing: ' . $hor_full_title_letter_spacing . ';}
				' . $selector . ' .apg-post .apg-post-title .type, #apg-transition-' . $id . ' .apg-grid-item .apg-post-title .type { font-size: ' . $hor_full_type_fontsize . '; color: ' . $hor_full_type_color . '; text-transform: ' . $hor_full_type_text_transform . '; padding-top: ' . $hor_full_type_padding_top . ';}
				' . $selector . ' .flickity-button-icon path { fill: ' . $hor_full_arrow_color . ';}
				' . $selector . ' .flickity-prev-next-button { background-color: ' . $arrow_bg_color . ';}
			';

			// responsive css and mouseover
			if(false === $this->is_editor) {
				//mouseover
				if(false === $this->detect->isMobile()) {
					switch($hor_full_hover) {
						case 'scale-opacity':
							$output['css'] .= '
								' . $selector . ' .flickity-slider:hover .apg-post .apg-grid-item { opacity: ' . ($hor_full_hover_so_opacity / 100) . '; }
								' . $selector . ' .flickity-slider .apg-post:hover .apg-grid-item .post-thumbnail img { transform: scale(' . (($hor_full_hover_so_scale / 100) + 1) . '); }
							';
						break;
						case 'dim-down':
							$output['css'] .= '
								' . $selector . ' .apg-post:hover .post-thumbnail { opacity: ' . ($hor_full_hover_dimdown_opacity / 100) . '; }
							';
						break;
						case 'border':
							$output['css'] .= '
								' . $selector . ' .apg-grid-item:hover:after { border-width: ' . $hor_full_hover_border_width . '; border-color: ' . $hor_full_hover_border_color . '; }
							';
						break;
					}
				}
				$output['css'] .= $this->get_breakpoints_css($id, 'hor-full', $content['options'], false);
			}

			// close apg wrapper
			$output['html'] .= '</div>';

			// frontend options
			$frontend_options = '';
			if(false === $this->is_editor) {
				$frontend_options .= 'draggable: true,';
				$click_handler = '
					$("#' . $id . '").on("staticClick.flickity", function(event, pointer, cellElement, cellIndex) {
						var $el = $(cellElement);
						if(semplice.frontend_mode == "static" && semplice.static_transitions == "disabled") {
							history.replaceState({
								apg: sempliceSetApgHistory()
							}, "", window.location.href);
							window.location = $el.find(".apg-link").attr("href");
						} else {
							$el.find(".apg-link").click();
						}
					});
				';
			} else {
				$frontend_options .= 'draggable: false,';
				$click_handler = '';
			}

			// flickity
			$output['html'] .= '
				<script>
					(function($) {
						$(document).ready(function () {
							$("#' . $id . '").find(".apg").flickity({
								prevNextButtons: true,
								contain: true,
								pageDots: false,
								groupCells: true,
								percentPosition: true,
								setGallerySize: false,
								wrapAround: true,
								imagesLoaded: true,
								' . $frontend_options . '
								cellAlign: "left",
								arrowShape: "' . $arrow . '",
								pauseAutoPlayOnHover: false,
							});
							' . $click_handler. '
						});
					})(jQuery);
				</script>
			';

			// ret
			return $output;
		}

		// text grid
		public function text($content, $posts, $id) {

			// output
			$output = array(
				'html' => '',
				'css'  => '',
			);

			// section element
			$section_element = '';
			if(isset($content['section_element'])) {
				$section_element = $content['section_element'];
			}

			// attributes
			extract(shortcode_atts(
				array(
					'text_transition'				=> 'enabled',
					'text_hover_image_mode'			=> 'cover',
					'text_hover_image_width'		=> '60',
					'text_hover_effect'				=> 'fade_both',
					'text_hover_title_opacity'		=> '20',
					'text_hover_title_mask'			=> 'disabled',
					'text_hover_title_mask_color'	=> '#ffffff',
					'text_title_direction'			=> 'column-dir',
					'text_title_position'			=> 'middle-center',
					'text_title_padding'			=> '4rem',
					'text_title_item_padding_ver'	=> '0.5555555555555556rem',
					'text_title_item_padding_hor'	=> '1rem',
					'text_title_color'				=> 'white',
					'text_title_font_family'		=> 'bold',
					'text_title_fontsize'			=> '5',
					'text_title_text_transform'		=> 'none',
					'text_title_letter_spacing'		=> '0',
					'text_seperator_color'			=> 'white',
					'text_seperator_font_family'	=> 'bold',
					'text_seperator_fontsize'		=> '5',
					'text_seperator_text_transform'	=> 'none',
					'text_seperator'				=> '/',
				), $content['options'] )
			);

			// custom transition
			if($text_transition == 'enabled') {
				$custom_transition = ' data-custom-transition="text"';
			} else {
				$custom_transition = '';
			}

			// get item padding
			$text_title_item_padding_ver = floatval(str_replace('rem', '', $text_title_item_padding_ver)) / 2;
			$text_title_item_padding_hor = floatval(str_replace('rem', '', $text_title_item_padding_hor)) / 2;

			// create apg wrapper
			$output['html'] .= '<div class="apg apg-text ' . $text_title_direction . '" data-image-mode="' . $text_hover_image_mode . '" data-mask-effect="' . $text_hover_title_mask . '" data-mouseover-effect="' . $text_hover_effect . '" data-title-align="' . $text_title_position . '">';

			// count
			$max = count($posts);
			$i = 1;

			// seperator
			$seperator = '<div class="apg-text-seperator" data-font="' . $text_seperator_font_family . '">' . $text_seperator . '</div>';

			// iterate projects
			foreach ($posts as $key => $post) {
				// options
				$values = $this->get_custom_options($post['post_id'], $post['thumbnail']['src'], $content['options']);
				// add seperator
				if($i == $max) {
					$seperator = '';
				}
				// output
				$output['html'] .= '
					<div class="post-' . $post['post_id'] . ' apg-post apg-post-text ' . $values['custom_class'] . '" data-post-id="' . $post['post_id'] . '">
						' . $this->set_custom_styles($id, 'text', $post, $values) . '
						<a class="apg-grid-item" href="' . $post['permalink'] . '">
							<div class="post-thumbnail" data-image-width="' . $text_hover_image_width . '">
								' . $this->get_thumbnail($values['thumbnail'], 'hor-full', $id, $post) . '
							</div>
							<div class="apg-post-title">
								<div class="title" data-font="' . $text_title_font_family . '">' . $post['post_title'] . '</div>
							</div>
						</a>
						' . $seperator . '
					</div>
				';
				
				// inc
				$i++;
			}		

			// css
			$selector = '#' . $id . ' .apg-text';
			$output['css'] .= '
				' . $section_element . ' .row, ' . $section_element . ' .row .column { height: 100% !important; } ' . $section_element . ' .column-content { min-height: 100vh; height: auto; }
				' . $selector . ' { padding: ' . $text_title_padding . '; }
				' . $selector . ' .apg-post .apg-post-title .title, #' . $id . ' .apg-text-seperator { font-size: ' . $text_title_fontsize . '; color: ' . $text_title_color . '; text-transform: ' . $text_title_text_transform . '; letter-spacing: ' . $text_title_letter_spacing . '; }
				' . $selector . ' .apg-text-seperator { color: ' . $text_seperator_color . '; }
				' . $selector . ' .apg-text-active .apg-post-title .title, #' . $id . ' .apg-text .apg-text-active .apg-text-active.apg-text-seperator { opacity: ' . ($text_hover_title_opacity / 100) . '; }
				' . $selector . ' .apg-post-title .title-hover { color: ' . $text_hover_title_mask_color . ' !important; }
				#' . $id . ' .row-dir { margin: -' . $text_title_item_padding_ver . 'rem -' . $text_title_item_padding_hor . 'rem; }
			';

			// padding
			if($text_title_direction == 'column-dir') {
				$output['css'] .= $selector . ' .apg-post-title { padding-top: ' . $text_title_item_padding_ver . 'rem; padding-bottom: ' . $text_title_item_padding_ver . 'rem; }';
			} else {
				$output['css'] .= $selector . ' .apg-post-text { padding-top: ' . $text_title_item_padding_ver . 'rem; padding-bottom: ' . $text_title_item_padding_ver . 'rem; }';
				$output['css'] .= $selector . ' .apg-grid-item { padding-left: ' . $text_title_item_padding_hor . 'rem; padding-right: ' . $text_title_item_padding_hor . 'rem; }';
			}

			// responsive css
			if(false === $this->is_editor) {
				$output['css'] .= $this->get_breakpoints_css($id, 'text', $content['options'], $text_title_direction);
			}

			// close apg wrapper
			$output['html'] .= '</div>';

			// ret
			return $output;
		}

		// get breakpoints css
		public function get_breakpoints_css($id, $grid, $options, $gridDir) {
			// css
			$css = '';
			// define atts
			switch($grid) {
				case 'hor-full':
					$selector = '#' . $id . ' .apg-hor-full ';
					$atts = array(
						'hor_full_title_padding' => array('attribute' => 'padding', 'target' => '.apg-post-title'),
						'hor_full_title_fontsize' => array('attribute' => 'font-size', 'target' => '.apg-post-title .title, #' . $id . ' .apg-text-seperator'),
						'hor_full_title_letter_spacing' => array('attribute' => 'letter-spacing', 'target' => '.apg-post-title .title'),
						'hor_full_type_fontsize' => array('attribute' => 'font-size', 'target' => '.apg-post-title .type'),
						'hor_full_type_padding_top' => array('attribute' => 'padding-top', 'target' => '.apg-post-title .type'),
					);
				break;
				case 'text':
					$selector = '#' . $id . ' ';
					$atts = array(
						'text_title_padding' => array('attribute' => 'padding', 'target' => '.apg-text'),
						'text_title_fontsize' => array('attribute' => 'font-size', 'target' => '.apg-text .apg-post-title .title, #' . $id . ' .apg-text-seperator'),
						'text_title_letter_spacing' => array('attribute' => 'letter-spacing', 'target' => '.apg-text .apg-post-title .title'),
					);
				break;
			}
			// breakpoints
			$breakpoints = semplice_get_breakpoints();
			// iterate breakpoints
			foreach ($breakpoints as $breakpoint => $width) {
				// iterate atts for this breakpoint
				$breakpoint_css = '';
				foreach ($atts as $attribute => $data) {
					if(isset($options[$attribute . '_' . $breakpoint])) {
						$breakpoint_css .= $selector . $data['target'] . ' { ' . $data['attribute'] . ': ' . $options[$attribute . '_' . $breakpoint] . ' !important; }';
					}
				}
				// special cases
				switch($grid) {
					case 'hor-full':
						// arrow size
						if(isset($options['hor_full_arrow_size_' . $breakpoint])) {
							$size = $options['hor_full_arrow_size_' . $breakpoint];
							$sizes = array('small' => 52, 'medium' => 64, 'large' => 78, 'insane' => 100);
							$breakpoint_css .= $selector . '.flickity-prev-next-button { width: ' . $sizes[$size] . 'px; height: ' . $sizes[$size] . 'px; }';
						}
						// offset
						if(isset($options['hor_full_title_offset_' . $breakpoint])) {
							$breakpoint_css .= $selector . '.apg-post-title { margin: ' . $options['hor_full_title_offset_' . $breakpoint] . ' 0 !important;}';
						}
					break;
					case 'text':
						// get paddings
						$paddings = array('ver' => '0.5555555555555556rem', 'hor' => '1rem');
						$prefix = 'text_title_item_padding_';
						foreach ($paddings as $dir => $value) {
							if(isset($options[$prefix . $dir . '_' . $breakpoint])) {
								$paddings[$dir] = $options[$prefix . $dir . '_' . $breakpoint];
							} else if(isset($options[$prefix . $dir])) {
								$paddings[$dir] = $options[$prefix . $dir];
							}
							// divide by 2
							$paddings[$dir] = (floatval(str_replace('rem', '', $paddings[$dir])) / 2) . 'rem';
						}
						// apply paddings
						if($gridDir == 'column-dir') {
							$breakpoint_css .= $selector . ' .apg-text .apg-post-title { padding-top: ' . $paddings['ver'] . '; padding-bottom: ' . $paddings['ver'] . '; }';
						} else {
							$breakpoint_css .= $selector . ' .apg-text .apg-post-text { padding-top: ' . $paddings['ver'] . '; padding-bottom: ' . $paddings['ver'] . '; }';
							$breakpoint_css .= $selector . ' .apg-text .apg-grid-item { padding-left: ' . $paddings['hor'] . '; padding-right: ' . $paddings['hor'] . '; }';
						}
						// negative margin
						$breakpoint_css .= '#' . $id . ' .row-dir { margin: -' . $paddings['ver'] . ' -' . $paddings['hor'] . '; }';
					break;
				}
				// only add breakpoint if css is not empty
				if(!empty($breakpoint_css)) {
					// breakpoint open
					$css .= '@media screen' . $width['min'] . $width['max'] . ' { ' . $breakpoint_css . ' }';
				}	
			}
			// return
			return $css;
		}

		// set custom styles
		public function set_custom_styles($id, $grid, $post, $values) {

			// is editor?
			if(true === $this->is_editor) {
				// defaults
				if(isset($values['background-color']) && false !== $values['background-color']) {
					$bg_color = $values['background-color'];
				} else {
					$bg_color = 'transparent';
				}

				// thumb
				$upload_visibility = '';
				if(isset($values['thumbnail']) && false !== $values['has_custom_thumb']) {
					$thumb_src = '..' . substr($values['thumbnail'], -12);
				} else {
					$thumb_src = 'Upload Thumbnail';
					$upload_visibility = ' show-upload';
				}

				return '
					<div class="apg-custom-styles">
						<div class="acs-bgcolor">
							<div class="wp-color">
								<input type="text" value="' . $bg_color . '" data-input-type="color" class="color-picker admin-listen-handler" data-handler="colorPicker" data-picker="apgHorFull" name="background-color" data-unique-name="background-color" data-content-id="' . $id . '" data-target="' . $post['post_id'] . '">
							</div>
						</div>
						<div class="apg-custom-thumbnail" data-default-thumb="' . $post['thumbnail']['src'] . '">
							<div class="apg-thumb-icon no-ep">' . get_svg('backend', '/icons/apg_image_upload') . '</div>
							<div class="option apg-thumbnail-upload">

								<div class="media-upload-box' . $upload_visibility . '" data-upload-box="' . $id . '">
									<div class="upload-button admin-click-handler no-ep" data-handler="execute" data-action="upload" data-action-type="media" data-media-type="image" data-media-type="image" data-upload="epPostThumbnail" name="post_thumbnail" data-content-id="' . $id . '" data-post-id="' . $post['post_id'] . '"></div>
									<div class="image-preview-wrapper">
										<img class="image image-preview" src="' . $values['thumbnail'] . '">
										<div class="edit-image">
											<ul>
												<li><a class="admin-click-handler" data-handler="execute" data-action="upload" data-action-type="media" data-media-type="image" data-media-type="image" data-upload="epPostThumbnail" name="post_thumbnail" data-content-id="' . $id . '" data-post-id="' . $post['post_id'] . '">' . get_svg('backend', '/icons/icon_edit') . '</a></li>
												<li><a class="admin-click-handler" data-handler="execute" data-action="image" data-action-type="delete" data-content-id="' . $id . '" name="post_thumbnail" data-post-id="' . $post['post_id'] . '">' . get_svg('backend', '/icons/icon_delete') . '</a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				';
			}
		}

		// get custom options
		public function get_custom_options($post_id, $thumbnail, $options) {
			// output
			$values = array(
				'thumbnail' => $thumbnail,
				'has_custom_thumb' => false,
				'background-color' => false,
				'custom_class' => '',
			);
			// posts set already?
			if(isset($options['posts']) && is_array($options['posts'])) {
				$posts = $options['posts'];
				// is post set?
				if(isset($posts[$post_id]) && is_array($posts[$post_id])) {
					foreach ($values as $attribute => $value) {
						if(isset($posts[$post_id][$attribute])) {
							// is thumbnail?
							if($attribute == 'thumbnail') {
								$values[$attribute] = semplice_get_image($posts[$post_id][$attribute], 'full');
								$values['has_custom_thumb'] = true;
							} else if($attribute == 'custom_class') {
								$values[$attribute] = ' ' . $posts[$post_id][$attribute];
							} else {
								$values[$attribute] = $posts[$post_id][$attribute];
							}
						}
					}
				}
			}
			// ret values
			return $values;
		}

		// get thumbnail
		public function get_thumbnail($thumbnail, $grid, $id, $post) {
			// no thumbnail?
			if (strpos($thumbnail, 'no_thumbnail') !== false) {
				// return button
				if(true === $this->is_editor) {
					return '<div class="missing-thumbnail"><p>Missing thumbnail for<br />"' . $post['post_title'] . '"</p><div class="semplice-button admin-click-handler no-ep trigger-apg-thumb-upload" data-handler="execute" data-action="upload" data-action-type="media" data-media-type="image" data-media-type="image" data-upload="epPostThumbnail" name="post_thumbnail" data-content-id="' . $id . '" data-post-id="' . $post['post_id'] . '">Upload Thumbnail</div><img alt="missing-thumbnail" src="https://www.semplice.com/images/s4_missing_thumbnail.jpg"></div>';
				} else {
					return '<div class="missing-thumbnail"><p>Missing thumbnail for<br />"' . $post['post_title'] . '"</p></div>';
				}
			} else {
				// return image
				return '<img src="' . $thumbnail . '">';
			}
		}
	}
	// instance
	$this->module['advancedportfoliogrid'] = new sm_advancedportfoliogrid;
}