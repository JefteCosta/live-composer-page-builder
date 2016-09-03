<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

class DSLC_Accordion extends DSLC_Module {

	var $module_id;
	var $module_title;
	var $module_icon;
	var $module_category;
	var $handle_like;

	function __construct() {

		$this->module_id = 'DSLC_Accordion';
		$this->module_title = __( 'Accordion', 'live-composer-page-builder' );
		$this->module_icon = 'reorder';
		$this->module_category = 'General';
		$this->handle_like = 'accordion';
	}

	function options() {

		$dslc_options = array(

			array(
				'label' => __( 'Show On', 'live-composer-page-builder' ),
				'id' => 'css_show_on',
				'std' => 'desktop tablet phone',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Desktop', 'live-composer-page-builder' ),
						'value' => 'desktop',
					),
					array(
						'label' => __( 'Tablet', 'live-composer-page-builder' ),
						'value' => 'tablet',
					),
					array(
						'label' => __( 'Phone', 'live-composer-page-builder' ),
						'value' => 'phone',
					),
				),
			),
			array(
				'label' => __( '(hidden) Accordion Content', 'live-composer-page-builder' ),
				'id' => 'accordion_content',
				'std' => '',
				'type' => 'textarea',
				'visibility' => 'hidden',
				'section' => 'styling',
			),
			array(
				'label' => __( '(hidden) Accordion Nav', 'live-composer-page-builder' ),
				'id' => 'accordion_nav',
				'std' => '',
				'type' => 'textarea',
				'visibility' => 'hidden',
				'section' => 'styling',
			),

			array(
				'label' => __( 'Open by default', 'live-composer-page-builder' ),
				'id' => 'open_by_default',
				'std' => '1',
				'type' => 'text',
			),

			/**
			 * General
			 */

			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Wrapper border group', 'live-composer-page-builder' ),
				'id' => 'wrapper_border',
				'type' => 'group_border',
				'tab' => __( 'general', 'live-composer-page-builder' ),
				'section' => 'styling',
				'affect_on_change_el' => '.dslc-accordion',
				'values' => array(
					'border_color' => 'css_border_color',
					'border_width' => 'css_border_width',
					'border_trbl' => 'css_border_trbl',
				),
				'std' => array(
					'border_width' => '0'
				),
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_border_width',
				'min' => 0,
				'max' => 10,
				'increment' => 1,

				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_border_trbl',
				'std' => 'top right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Top', 'live-composer-page-builder' ),
						'value' => 'top'
					),
					array(
						'label' => __( 'Right', 'live-composer-page-builder' ),
						'value' => 'right'
					),
					array(
						'label' => __( 'Bottom', 'live-composer-page-builder' ),
						'value' => 'bottom'
					),
					array(
						'label' => __( 'Left', 'live-composer-page-builder' ),
						'value' => 'left'
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_margin_bottom',
				'min' => -1000,
				'max' => 1000,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Minimum Height', 'live-composer-page-builder' ),
				'id' => 'css_min_height',
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion',
				'affect_on_change_rule' => 'min-height',
				'section' => 'styling',
				'ext' => 'px',
				'min' => 0,
				'max' => 2000,
				'increment' => 5,
			),

			array(
				'label' => __( 'Wrapper padding', 'live-composer-page-builder' ),
				'id' => 'padding_group',
				'type' => 'group_padding',
				'tab' => __( 'general', 'live-composer-page-builder' ),
				'section' => 'styling',
				'affect_on_change_el' => '.dslc-accordion',
				'values' => array(
					'padding_top' => 'css_padding_vertical',
					'padding_bottom' => 'css_padding_vertical',
					'padding_right' => 'css_padding_horizontal',
					'padding_left' => 'css_padding_horizontal',
				),
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_padding_vertical',
				'min' => 0,
				'max' => 600,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_padding_horizontal',
				'min' => 0,
				'max' => 1000,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
			),
			array(
				'label' => __( 'Spacing', 'live-composer-page-builder' ),
				'id' => 'css_spacing',
				'std' => '20',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-item',
				'affect_on_change_rule' => 'margin-top',
				'section' => 'styling',
				'ext' => 'px',
				'min' => -5,
			),

			/**
			 * Header
			 */

			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_header_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-header',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Header', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Header border', 'live-composer-page-builder' ),
				'id' => 'header_group',
				'type' => 'group_border',
				'tab' => __( 'general', 'live-composer-page-builder' ),
				'section' => 'styling',
				'affect_on_change_el' => '.dslc-accordion-header',
				'values' => array(
					'border_color' => 'css_header_border_color',
					'border_width' => 'css_header_border_width',
					'border_trbl' => 'css_header_border_trbl',
				),
				'std' => array(
					'border_color' => '#e8e8e8',
					'border_width' => 1,
				),
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_header_border_color',
				'std' => '#e8e8e8',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-header',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Header', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_header_border_width',
				'min' => 0,
				'max' => 10,
				'increment' => 1,

				'std' => '1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-header',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Header', 'live-composer-page-builder' )
			),
			array(
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_header_border_trbl',
				'std' => 'top right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Top', 'live-composer-page-builder' ),
						'value' => 'top'
					),
					array(
						'label' => __( 'Right', 'live-composer-page-builder' ),
						'value' => 'right'
					),
					array(
						'label' => __( 'Bottom', 'live-composer-page-builder' ),
						'value' => 'bottom'
					),
					array(
						'label' => __( 'Left', 'live-composer-page-builder' ),
						'value' => 'left'
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-header',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Header', 'live-composer-page-builder' )
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_header_margin_bottom',
				'min' => -1000,
				'max' => 1000,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-header',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Header', 'live-composer-page-builder' )
			),
			array(
				'label' => __( 'Header padding', 'live-composer-page-builder' ),
				'id' => 'header_padding',
				'type' => 'group_padding',
				'tab' => __( 'Header', 'live-composer-page-builder' ),
				'section' => 'styling',
				'affect_on_change_el' => '.dslc-accordion-header',
				'values' => array(
					'padding_top' => 'css_header_padding_vertical'
					'padding_bottom' => 'css_header_padding_vertical'
					'padding_left' => 'css_header_padding_horizontal',
					'padding_right' => 'css_header_padding_horizontal',
				),
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_header_padding_vertical',
				'min' => 0,
				'max' => 600,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-header',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Header', 'live-composer-page-builder' )
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_header_padding_horizontal',
				'min' => 0,
				'max' => 1000,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-header',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Header', 'live-composer-page-builder' )
			),

			/**
			 * Title
			 */

			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_title_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-title',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' )
			),
			array(
				'label' => __( 'Title border', 'live-composer-page-builder' ),
				'id' => 'title_border',
				'type' => 'group_border',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'section' => 'styling',
				'affect_on_change_el' => '.dslc-accordion-title',
				'values' => array(
					'border_color' => 'css_title_border_color',
					'border_width' => 'css_title_border_width',
					'border_trbl' => 'css_title_border_trbl',
				),
				'std' => array(
					'border_color' => '#e8e8e8',
					'border_width' => 1,
				),
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_title_border_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-title',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_title_border_width',
				'min' => 0,
				'max' => 10,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-title',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_title_border_trbl',
				'std' => 'top right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Top', 'live-composer-page-builder' ),
						'value' => 'top',
					),
					array(
						'label' => __( 'Right', 'live-composer-page-builder' ),
						'value' => 'right',
					),
					array(
						'label' => __( 'Bottom', 'live-composer-page-builder' ),
						'value' => 'bottom',
					),
					array(
						'label' => __( 'Left', 'live-composer-page-builder' ),
						'value' => 'left',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-title',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Title typo', 'live-composer-page-builder' ),
				'id' => 'title_typo',
				'type' => 'group_text',
				'tab' => __( 'Typography', 'live-composer-page-builder' ),
				'section' => 'styling',
				'affect_on_change_el' => '.dslc-accordion-title',
				'values' => array(
					'color' => 'css_title_color',
					'font_size' => 'css_title_font_size',
					'font_weight' => 'css_title_font_weight',
					'font_family' => 'css_title_font_family',
					'letter_spacing' => 'css_title_lheight',
				),
			),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_title_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-title',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' )
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_title_font_size',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-title',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_title_font_weight',
				'std' => '700',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => '100 - Thin',
						'value' => '100',
					),
					array(
						'label' => '200 - Extra Light',
						'value' => '200',
					),
					array(
						'label' => '300 - Light',
						'value' => '300',
					),
					array(
						'label' => '400 - Normal',
						'value' => '400',
					),
					array(
						'label' => '500 - Medium',
						'value' => '500',
					),
					array(
						'label' => '600 - Semi Bold',
						'value' => '600',
					),
					array(
						'label' => '700 - Bold',
						'value' => '700',
					),
					array(
						'label' => '800 - Extra Bold',
						'value' => '800',
					),
					array(
						'label' => '900 - Black',
						'value' => '900',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-title',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => '',
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_title_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-title',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Line Height', 'live-composer-page-builder' ),
				'id' => 'css_title_lheight',
				'std' => '16',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-title',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Title padding', 'live-composer-page-builder' ),
				'id' => 'button_t_padding',
				'type' => 'group_padding',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'section' => 'styling',
				'affect_on_change_el' => '.dslc-accordion-title',
				'values' => array(
					'padding_top' => 'css_title_padding_vertical',
					'padding_bottom' => 'css_title_padding_vertical',
					'padding_left' => 'css_title_padding_horizontal',
					'padding_right' => 'css_title_padding_horizontal',
				),
				'std' => array(
					'padding_top' => 15,
					'padding_left' => 15,
					'padding_bottom' => 15,
					'padding_right' => 15,
				),
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_title_padding_vertical',
				'min' => 0,
				'max' => 600,
				'increment' => 1,
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-title',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_title_padding_horizontal',
				'min' => 0,
				'max' => 1000,
				'increment' => 1,
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-title',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Text Align', 'live-composer-page-builder' ),
				'id' => 'css_title_text_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-title',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'Title', 'live-composer-page-builder' ),
			),

			/**
			 * Content
			 */

			array(
				'label' => __( 'BG Color', 'live-composer-page-builder' ),
				'id' => 'css_content_bg_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-content',
				'affect_on_change_rule' => 'background-color',
				'section' => 'styling',
				'tab' => __( 'Content', 'live-composer-page-builder' ),
			),

			array(
				'label' => __( 'Content border', 'live-composer-page-builder' ),
				'id' => 'content_border',
				'type' => 'group_border',
				'tab' => __( 'Content', 'live-composer-page-builder' ),
				'section' => 'styling',
				'affect_on_change_el' => '.dslc-accordion-content',
				'values' => array(
					'border_color' => 'css_content_border_color',
					'border_width' => 'css_content_border_width',
					'border_trbl' => 'css_content_border_trbl',
				),
			),
			array(
				'label' => __( 'Border Color', 'live-composer-page-builder' ),
				'id' => 'css_content_border_color',
				'std' => '#e8e8e8',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-content',
				'affect_on_change_rule' => 'border-color',
				'section' => 'styling',
				'tab' => __( 'Content', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Border Width', 'live-composer-page-builder' ),
				'id' => 'css_content_border_width',
				'min' => 0,
				'max' => 10,
				'increment' => 1,

				'std' => '1',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-content',
				'affect_on_change_rule' => 'border-width',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Content', 'live-composer-page-builder' )
			),
			array(
				'label' => __( 'Borders', 'live-composer-page-builder' ),
				'id' => 'css_content_border_trbl',
				'std' => 'right bottom left',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Top', 'live-composer-page-builder' ),
						'value' => 'top',
					),
					array(
						'label' => __( 'Right', 'live-composer-page-builder' ),
						'value' => 'right',
					),
					array(
						'label' => __( 'Bottom', 'live-composer-page-builder' ),
						'value' => 'bottom',
					),
					array(
						'label' => __( 'Left', 'live-composer-page-builder' ),
						'value' => 'left',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-content',
				'affect_on_change_rule' => 'border-style',
				'section' => 'styling',
				'tab' => __( 'Content', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Content typo', 'live-composer-page-builder' ),
				'id' => 'content_typo',
				'type' => 'group_text',
				'tab' => __( 'Content', 'live-composer-page-builder' ),
				'section' => 'styling',
				'affect_on_change_el' => '.dslc-accordion-content',
				'values' => array(
					'color' => 'css_content_color',
					'font_size' => 'css_content_font_size',
					'font_weight' => 'css_content_font_weight',
					'font_family' => 'css_content_font_family',
					'letter_spacing' => 'css_content_line_height',
				),
				'std' => array(
					'letter_spacing' => 22
				)
			),
			array(
				'label' => __( 'Color', 'live-composer-page-builder' ),
				'id' => 'css_content_color',
				'std' => '',
				'type' => 'color',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-content',
				'affect_on_change_rule' => 'color',
				'section' => 'styling',
				'tab' => __( 'Content', 'live-composer-page-builder' )
			),
			array(
				'label' => __( 'Font Size', 'live-composer-page-builder' ),
				'id' => 'css_content_font_size',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-content',
				'affect_on_change_rule' => 'font-size',
				'section' => 'styling',
				'tab' => __( 'Content', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Font Weight', 'live-composer-page-builder' ),
				'id' => 'css_content_font_weight',
				'std' => '400',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => '100 - Thin',
						'value' => '100',
					),
					array(
						'label' => '200 - Extra Light',
						'value' => '200',
					),
					array(
						'label' => '300 - Light',
						'value' => '300',
					),
					array(
						'label' => '400 - Normal',
						'value' => '400',
					),
					array(
						'label' => '500 - Medium',
						'value' => '500',
					),
					array(
						'label' => '600 - Semi Bold',
						'value' => '600',
					),
					array(
						'label' => '700 - Bold',
						'value' => '700',
					),
					array(
						'label' => '800 - Extra Bold',
						'value' => '800',
					),
					array(
						'label' => '900 - Black',
						'value' => '900',
					),
				),
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-content',
				'affect_on_change_rule' => 'font-weight',
				'section' => 'styling',
				'tab' => __( 'Content', 'live-composer-page-builder' ),
				'ext' => '',
			),
			array(
				'label' => __( 'Font Family', 'live-composer-page-builder' ),
				'id' => 'css_content_font_family',
				'std' => 'Open Sans',
				'type' => 'font',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-content',
				'affect_on_change_rule' => 'font-family',
				'section' => 'styling',
				'tab' => __( 'Content', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Line Height', 'live-composer-page-builder' ),
				'id' => 'css_content_line_height',
				'min' => 0,
				'max' => 120,
				'increment' => 1,
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-content',
				'affect_on_change_rule' => 'line-height',
				'section' => 'styling',
				'tab' => __( 'Content', 'live-composer-page-builder' ),
				'ext' => 'px'
			),

			array(
				'label' => __( 'Content padding', 'live-composer-page-builder' ),
				'id' => 'content_padding',
				'type' => 'group_padding',
				'tab' => __( 'Content', 'live-composer-page-builder' ),
				'section' => 'styling',
				'affect_on_change_el' => '.dslc-accordion-content',
				'values' => array(
					'padding_top' => 'css_content_padding_vertical',
					'padding_bottom' => 'css_content_padding_vertical',
					'padding_left' => 'css_content_padding_horizontal',
					'padding_right' => 'css_content_padding_horizontal',
				),
				'std' => array(
					'padding_top' => 25,
					'padding_bottom' => 25,
					'padding_left' => 25,
					'padding_right' => 25,
				)
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_content_padding_vertical',
				'min' => 0,
				'max' => 600,
				'increment' => 1,
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-content',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Content', 'live-composer-page-builder' )
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_content_padding_horizontal',
				'min' => 0,
				'max' => 1000,
				'increment' => 1,
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-content',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'styling',
				'ext' => 'px',
				'tab' => __( 'Content', 'live-composer-page-builder' )
			),
			array(
				'label' => __( 'Text Align', 'live-composer-page-builder' ),
				'id' => 'css_content_text_align',
				'std' => 'left',
				'type' => 'text_align',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-content',
				'affect_on_change_rule' => 'text-align',
				'section' => 'styling',
				'tab' => __( 'Content', 'live-composer-page-builder' ),
			),

			/**
			 * Responsive Tablet
			 */

			array(
				'label' => __( 'Responsive Styling', 'live-composer-page-builder' ),
				'id' => 'css_res_t',
				'std' => 'disabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Disabled', 'live-composer-page-builder' ),
						'value' => 'disabled',
					),
					array(
						'label' => __( 'Enabled', 'live-composer-page-builder' ),
						'value' => 'enabled',
					),
				),
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_margin_bottom',
				'min' => -1000,
				'max' => 1000,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Content padding', 'live-composer-page-builder' ),
				'id' => 'content_t_padding',
				'type' => 'group_padding',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'section' => 'responsive',
				'affect_on_change_el' => '.dslc-button',
				'values' => array(
					'padding_top' => 'css_res_t_padding_vertical',
					'padding_bottom' => 'css_res_t_padding_vertical',
					'padding_left' => 'css_res_t_padding_horizontal',
					'padding_right' => 'css_res_t_padding_horizontal',
				),
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_padding_vertical',
				'min' => 0,
				'max' => 600,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_padding_horizontal',
				'min' => 0,
				'max' => 1000,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Header - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_t_header_margin_bottom',
				'min' => -1000,
				'max' => 1000,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-header',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Header padding', 'live-composer-page-builder' ),
				'id' => 'header_t_padding',
				'type' => 'group_padding',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'section' => 'responsive',
				'affect_on_change_el' => '.dslc-accordion-header',
				'values' => array(
					'padding_top' => 'css_res_t_header_padding_vertical',
					'padding_bottom' => 'css_res_t_header_padding_vertical',
					'padding_left' => 'css_t_header_padding_horizontal',
					'padding_right' => 'css_t_header_padding_horizontal',
				),
			),
			array(
				'label' => __( 'Header - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_header_padding_vertical',
				'min' => 0,
				'max' => 600,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-header',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Header - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_header_padding_horizontal',
				'min' => 0,
				'max' => 1000,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-header',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Title - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_title_font_size',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-title',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Title - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_t_title_lheight',
				'std' => '16',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-title',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),

			array(
				'label' => __( 'Title padding', 'live-composer-page-builder' ),
				'id' => 'title_t_padding',
				'type' => 'group_padding',
				'tab' => __( 'Table', 'live-composer-page-builder' ),
				'section' => 'responsive',
				'affect_on_change_el' => '.dslc-accordion-title',
				'values' => array(
					'padding_top' => 'css_res_t_title_padding_vertical',
					'padding_bottom' => 'css_res_t_title_padding_vertical',
					'padding_left' => 'css_res_t_title_padding_horizontal',
					'padding_right' => 'css_res_t_title_padding_horizontal',
				),
				'std' => array(
					'padding_right' => 15,
					'padding_left' => 15,
					'padding_top' => 15,
					'padding_bottom' => 15,
				)
			),
			array(
				'label' => __( 'Title - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_title_padding_vertical',
				'min' => 0,
				'max' => 600,
				'increment' => 1,
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-title',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Title - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_title_padding_horizontal',
				'min' => 0,
				'max' => 1000,
				'increment' => 1,
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-title',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Content - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_t_content_font_size',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-content',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Content - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_t_content_line_height',
				'min' => 0,
				'max' => 120,
				'increment' => 1,
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-content',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),

			array(
				'label' => __( 'Content padding', 'live-composer-page-builder' ),
				'id' => 'content_t_padding',
				'type' => 'group_padding',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'section' => 'responsive',
				'affect_on_change_el' => '.dslc-accordion-content',
				'values' => array(
					'padding_top' => 'css_res_t_content_padding_vertical',
					'padding_bottom' => 'css_res_t_content_padding_vertical',
					'padding_left' => 'css_res_t_content_padding_horizontal',
					'padding_right' => 'css_res_t_content_padding_horizontal',
				),
				'std' => array(
					'padding_right' => 25,
					'padding_left' => 25,
					'padding_top' => 25,
					'padding_bottom' => 25,
				),
			),
			array(
				'label' => __( 'Content - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_t_content_padding_vertical',
				'min' => 0,
				'max' => 600,
				'increment' => 1,
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-content',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Content - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_t_content_padding_horizontal',
				'min' => 0,
				'max' => 1000,
				'increment' => 1,
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-content',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'ext' => 'px',
			),

			/**
			 * Responsive phone
			 */

			array(
				'label' => __( 'Responsive Styling', 'live-composer-page-builder' ),
				'id' => 'css_res_p',
				'std' => 'disabled',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => __( 'Disabled', 'live-composer-page-builder' ),
						'value' => 'disabled',
					),
					array(
						'label' => __( 'Enabled', 'live-composer-page-builder' ),
						'value' => 'enabled',
					),
				),
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
			),
			array(
				'label' => __( 'Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_margin_bottom',
				'min' => -1000,
				'max' => 1000,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Wrapper padding', 'live-composer-page-builder' ),
				'id' => 'content_p_padding',
				'type' => 'group_padding',
				'tab' => __( 'Tablet', 'live-composer-page-builder' ),
				'section' => 'responsive',
				'affect_on_change_el' => '.dslc-accordion',
				'values' => array(
					'padding_top' => 'css_res_p_padding_vertical',
					'padding_bottom' => 'css_res_p_padding_vertical',
					'padding_left' => 'css_res_p_padding_horizontal',
					'padding_right' => 'css_res_p_padding_horizontal',
				),
			),
			array(
				'label' => __( 'Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_padding_vertical',
				'min' => 0,
				'max' => 600,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_padding_horizontal',
				'min' => 0,
				'max' => 1000,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Header - Margin Bottom', 'live-composer-page-builder' ),
				'id' => 'css_res_p_header_margin_bottom',
				'min' => -1000,
				'max' => 1000,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-header',
				'affect_on_change_rule' => 'margin-bottom',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Header padding', 'live-composer-page-builder' ),
				'id' => 'header_p_padding',
				'type' => 'group_padding',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'section' => 'styling',
				'affect_on_change_el' => '.dslc-accordion-header',
				'values' => array(
					'padding_top' => 'css_res_p_header_padding_vertical',
					'padding_bottom' => 'css_res_p_header_padding_vertical',
					'padding_left' => 'css_res_p_header_padding_horizontal',
					'padding_right' => 'css_res_p_header_padding_horizontal',
				),
			),
			array(
				'label' => __( 'Header - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_header_padding_vertical',
				'min' => 0,
				'max' => 600,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-header',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Header - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_header_padding_horizontal',
				'min' => 0,
				'max' => 1000,
				'increment' => 1,
				'std' => '0',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-header',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Title - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_title_font_size',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-title',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_p_title_lheight',
				'std' => '16',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-title',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px'
			),
			array(
				'label' => __( 'Title padding', 'live-composer-page-builder' ),
				'id' => 'title_p_padding',
				'type' => 'group_padding',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'section' => 'responsive',
				'affect_on_change_el' => '.dslc-accordion-title',
				'values' => array(
					'padding_top' => 'css_res_p_title_padding_vertical',
					'padding_bottom' => 'css_res_p_title_padding_vertical',
					'padding_left' => 'css_res_p_title_padding_horizontal',
					'padding_right' => 'css_res_p_title_padding_horizontal',
				),
				'std' => array(
					'padding_right' => 15,
					'padding_left' => 15,
					'padding_top' => 15,
					'padding_bottom' => 15,
				),
			),
			array(
				'label' => __( 'Title - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_title_padding_vertical',
				'min' => 0,
				'max' => 600,
				'increment' => 1,
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-title',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Title - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_title_padding_horizontal',
				'min' => 0,
				'max' => 1000,
				'increment' => 1,
				'std' => '15',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-title',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Content - Font Size', 'live-composer-page-builder' ),
				'id' => 'css_res_p_content_font_size',
				'min' => 0,
				'max' => 100,
				'increment' => 1,
				'std' => '12',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-content',
				'affect_on_change_rule' => 'font-size',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Content - Line Height', 'live-composer-page-builder' ),
				'id' => 'css_res_p_content_line_height',
				'min' => 0,
				'max' => 120,
				'increment' => 1,
				'std' => '22',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-content',
				'affect_on_change_rule' => 'line-height',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Content padding', 'live-composer-page-builder' ),
				'id' => 'content_p_padding',
				'type' => 'group_padding',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'section' => 'responsive',
				'affect_on_change_el' => '.dslc-accordion-content',
				'values' => array(
					'padding_top' => 'css_res_p_content_padding_vertical',
					'padding_bottom' => 'css_res_p_content_padding_vertical',
					'padding_left' => 'css_wrapper_padding_horizontal',
					'padding_right' => 'css_wrapper_padding_horizontal',
				),
				'std' => array(
					'padding_right' => 25,
					'padding_left' => 25,
					'padding_top' => 25,
					'padding_bottom' => 25,
				),
			),
			array(
				'label' => __( 'Content - Padding Vertical', 'live-composer-page-builder' ),
				'id' => 'css_res_p_content_padding_vertical',
				'min' => 0,
				'max' => 600,
				'increment' => 1,
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-content',
				'affect_on_change_rule' => 'padding-top,padding-bottom',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),
			array(
				'label' => __( 'Content - Padding Horizontal', 'live-composer-page-builder' ),
				'id' => 'css_res_p_content_padding_horizontal',
				'min' => 0,
				'max' => 1000,
				'increment' => 1,
				'std' => '25',
				'type' => 'slider',
				'refresh_on_change' => false,
				'affect_on_change_el' => '.dslc-accordion-content',
				'affect_on_change_rule' => 'padding-left,padding-right',
				'section' => 'responsive',
				'tab' => __( 'Phone', 'live-composer-page-builder' ),
				'ext' => 'px',
			),

		);

		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'animation_options', array('hover_opts' => false) ) );
		$dslc_options = array_merge( $dslc_options, $this->presets_options() );

		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

	}

	function output( $options ) {

		global $dslc_active;

		if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) )
			$dslc_is_admin = true;
		else
			$dslc_is_admin = false;

		$this->module_start( $options );

		/* Module output stars here */

			$accordion_nav = explode( '(dslc_sep)', trim( $options['accordion_nav'] ) );

			if ( empty( $options['accordion_content'] ) )
				$accordion_contents = false;
			else
				$accordion_contents = explode( '(dslc_sep)', trim( $options['accordion_content'] ) );

			$count = 0;

		?>

				<div class="dslc-accordion" data-open="<?php echo $options['open_by_default']; ?>">

					<?php if ( is_array( $accordion_contents ) && count( $accordion_contents ) > 0 ) : ?>

						<?php foreach ( $accordion_contents as $accordion_content ) : ?>

							<div class="dslc-accordion-item">

								<div class="dslc-accordion-header dslc-accordion-hook">
									<span class="dslc-accordion-title" <?php if ( $dslc_is_admin ) echo 'contenteditable data-exportable-content="h3"'; ?>><?php echo stripslashes( $accordion_nav[$count] ); ?></span>
									<?php if ( $dslc_is_admin ) : ?>
										<div class="dslca-accordion-action-hooks">
											<span class="dslca-move-up-accordion-hook"><span class="dslca-icon dslc-icon-arrow-up"></span></span>
											<span class="dslca-move-down-accordion-hook"><span class="dslca-icon dslc-icon-arrow-down"></span></span>
											<span class="dslca-delete-accordion-hook"><span class="dslca-icon dslc-icon-remove"></span></span>
										</div>
									<?php endif; ?>
								</div>

								<div class="dslc-accordion-content">
									<div class="dslca-editable-content"<?php if ( $dslc_is_admin ) echo ' data-exportable-content'; ?>>
										<?php
											$accordion_content_output = stripslashes( $accordion_content );
											$accordion_content_output = str_replace( '<lctextarea', '<textarea', $accordion_content_output );
											$accordion_content_output = str_replace( '</lctextarea', '</textarea', $accordion_content_output );
											echo do_shortcode( $accordion_content_output );
										?>
									</div>
									<?php if ( $dslc_is_admin ) : ?>
										<textarea class="dslca-accordion-plain-content"><?php echo trim( $accordion_content_output ); ?></textarea>
										<div class="dslca-wysiwyg-actions-edit"><span class="dslca-wysiwyg-actions-edit-hook"><?php _e( 'Open in WP Editor', 'live-composer-page-builder' ); ?></span></div>
									<?php endif; ?>
								</div><!-- .dslc-accordion-content -->

							</div><!-- .dslc-accordion-item -->

						<?php $count++; endforeach; ?>

					<?php else : ?>

						<div class="dslc-accordion-item">

							<div class="dslc-accordion-header dslc-accordion-hook">
								<span class="dslc-accordion-title" <?php if ( $dslc_is_admin ) echo 'contenteditable'; ?>><?php _e( 'CLICK TO EDIT', 'live-composer-page-builder' ); ?></span>
								<?php if ( $dslc_is_admin ) : ?>
									<div class="dslca-accordion-action-hooks">
										<span class="dslca-move-up-accordion-hook"><span class="dslca-icon dslc-icon-arrow-up"></span></span>
										<span class="dslca-move-down-accordion-hook"><span class="dslca-icon dslc-icon-arrow-down"></span></span>
										<span class="dslca-delete-accordion-hook"><span class="dslca-icon dslc-icon-remove"></span></span>
									</div>
								<?php endif; ?>
							</div>

							<div class="dslc-accordion-content">
								<div class="dslca-editable-content">
									Placeholder content. Lorem ipsum dolor sit amet, consectetur
									tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
									quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
									consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
									cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
									proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
								</div>
								<?php if ( $dslc_is_admin ) : ?>
									<textarea class="dslca-accordion-plain-content">Placeholder content. Lorem ipsum dolor sit amet, consectetur tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</textarea>
									<div class="dslca-wysiwyg-actions-edit"><span class="dslca-wysiwyg-actions-edit-hook"><?php _e( 'Open in WP Editor', 'live-composer-page-builder' ); ?></span></div>
								<?php endif; ?>
							</div><!-- .dslc-accordion-content -->

						</div><!-- .dslc-accordion-item -->

					<?php endif; ?>

					<?php if ( $dslc_is_admin ) : ?>
						<div class="dslca-add-accordion">
							<span class="dslca-add-accordion-hook"><span class="dslca-icon dslc-icon-plus"></span></span>
						</div>
					<?php endif; ?>

				</div><!-- .dslc-accordion -->

		<?php /* Module output ends here */

		$this->module_end( $options );

	}
}
