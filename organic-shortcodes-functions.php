<?php

/*
-------------------------------------------------------------------------------------------------------
	Toggle Box
-------------------------------------------------------------------------------------------------------
*/

function organic_toggle( $atts, $content = null ) {

	$args = shortcode_atts(
		array(
		  'title'	=> 'Toggle Item',
		),
		$atts
	);
	$title = esc_attr( $args['title'] );

	$output = '
		<div class="toggle-box">
		<p class="toggle-trigger"><a href="javascript:void(0);">' .html_entity_decode( $title ). '</a></p>
		<div class="toggle-section">' .do_shortcode( $content ). '</div>
		</div>';

	return force_balance_tags( $output );
}
add_shortcode( 'toggle', 'organic_toggle' );

/*
-------------------------------------------------------------------------------------------------------
	Horizontal Bar Rating
-------------------------------------------------------------------------------------------------------
*/

function organic_rating( $atts ) {

	$args = shortcode_atts(
		array(
		  'title'	=> '',
			'number' => '50',
		),
		$atts
	);
	$title = esc_attr( $args['title'] );
	$number = (int) $args['number'];

	return
	'<div class="rating-container">
    	<p class="rating-title">'.$title.'</p>
    	<div class="bar-rating"><span style="width:'.$number.'%;"></span></div>
    </div>';
}
add_shortcode( 'rating', 'organic_rating' );

/*
-------------------------------------------------------------------------------------------------------
	Modal Box
-------------------------------------------------------------------------------------------------------
*/

function organic_modal( $atts, $content = null ) {

	$args = shortcode_atts(
		array(
			'title'	=> 'Open Modal',
			'tag'	=> 'organic-modal',
			'color'	=> '',
			'size'	=> '',
			'align'	=> '',
		),
		$atts
	);
	$title = esc_attr( $args['title'] );
	$tag = esc_attr( $args['tag'] );
	$color = esc_attr( $args['color'] );
	$size = esc_attr( $args['size'] );
	$align = esc_attr( $args['align'] );
	$style = ($color) ? ' '.$color.'-btn' : '';
	$position = ($align) ? ' align-'.$align : '';

	$output = '
		<div class="modal-btn '.$position.'"><a class="organic-btn '.$style.' '.$size.'-btn '.$position.'" href="#'.$tag.'" rel="modal:open"><span class="btn-holder">' .$title. '</span></a></div>
		<div id="' .$tag. '" class="organic-modal" style="display: none;"><span class="modal-title">' .$title. '</span>' .do_shortcode( $content ). '</div>';

	return $output;
}
add_shortcode( 'modal', 'organic_modal' );

/*
-------------------------------------------------------------------------------------------------------
	Accordion
-------------------------------------------------------------------------------------------------------
*/

function organic_accordion( $atts, $content = null ) {

	$args = shortcode_atts(
		array(
		  'collapsible' => 'false',
		),
		$atts
	);
	$collapse = esc_attr( $args['collapsible'] );

	$GLOBALS['section_count'] = 0;
	// Get the content.
	do_shortcode( $content );
	// Generate output.
	if ( is_array( $GLOBALS['sections'] ) ) {
		foreach ( $GLOBALS['sections'] as $section ) {
			$panes[] = '<p><a href="#'. str_replace( ' ', '-', strtolower( $section['name'] ) ) .'">'. $section['name'] .'</a></p>
            <div id="'. str_replace( ' ', '-', strtolower( $section['name'] ) ) .'">
            	'. do_shortcode( $section['content'] ) .'
            </div>';
		}
	}
	$output = "\n".'<div class="organic-accordion">'. implode( "\n", $panes ) .'</div>'."\n";

	unset( $GLOBALS['sections'] ); // Clear array fix for multiple shorcodes.
	return force_balance_tags( $output );
}
add_shortcode( 'accordion', 'organic_accordion' );

function organic_accordion_section( $atts, $content = null ) {

	$args = shortcode_atts(
		array(
		  'name' => 'Accordion Section Name',
		),
		$atts
	);
	$name = esc_attr( $args['name'] );

	$x = $GLOBALS['section_count'];
	$GLOBALS['sections'][ $x ] = array(
		'name'   => sprintf( html_entity_decode( $name ), $GLOBALS['section_count'] ),
		'content' => do_shortcode( $content ),
	);
	$GLOBALS['section_count'] += 1;
}
add_shortcode( 'section', 'organic_accordion_section' );

/*
-------------------------------------------------------------------------------------------------------
	Tabs
-------------------------------------------------------------------------------------------------------
*/

function organic_tab_group( $atts, $content ) {

	$GLOBALS['tab_count'] = 0;

	do_shortcode( $content );

	if ( is_array( $GLOBALS['tabs'] ) ) {
		$int = '1';
		foreach ( $GLOBALS['tabs'] as $tab ) {

			$tabs[] = '<li><a href="#panel-'.$int.'">'.$tab['title'].'</a></li>';

			$panes[] = '
			<div class="ui-tabs-hide" id="panel-'.$int.'">
				<h3>'.$tab['title'].'</h3>
				'.$tab['content'].'
			</div>';

			$int++;
		}

		$output = "\n".'
		<div class="organic-tabs">
			<ul id="tabs">'.implode( "\n", $tabs ).'</ul>
			'."\n".' '.implode( "\n", $panes ).'
		</div>'."\n";
	}

	unset( $GLOBALS['tabs'] ); // Clear array fix for multiple shorcodes.
	return force_balance_tags( $output );
}
add_shortcode( 'tabs', 'organic_tab_group' );

function organic_tab( $atts, $content ) {

	$args = shortcode_atts(
		array(
		  'title' => 'Tab %d',
		),
		$atts
	);
	$title = esc_attr( $args['title'] );

	$x = $GLOBALS['tab_count'];
	$GLOBALS['tabs'][ $x ] = array( 'title' => sprintf( html_entity_decode( $title ), $GLOBALS['tab_count'] ), 'content' => do_shortcode( $content ) );

	$GLOBALS['tab_count']++;
}
add_shortcode( 'tab', 'organic_tab' );


/*
-------------------------------------------------------------------------------------------------------
	Icons
-------------------------------------------------------------------------------------------------------
*/

function organic_icons( $atts, $content = null ) {

	$args = shortcode_atts(
		array(
			'style'	=> '',
			'color'	=> '',
		),
		$atts
	);
	$style = esc_attr( $args['style'] );
	$color = esc_attr( $args['color'] );

	$output = '<span class="organic-icon"><i class="fa fa-'.$style.'" style="color: #'.$color.';"></i> ' .do_shortcode( $content ). '</span>';

	return $output;
}
add_shortcode( 'icon', 'organic_icons' );

/*
-------------------------------------------------------------------------------------------------------
	Headlines
-------------------------------------------------------------------------------------------------------
*/

function organic_headline( $atts, $content = null ) {

	$args = shortcode_atts(
		array(
			'align'	=> 'left',
			'color'	=> '000000',
			'size'	=> 'large',
		),
		$atts
	);
	$align = esc_attr( $args['align'] );
	$color = esc_attr( $args['color'] );
	$size = esc_attr( $args['size'] );

	$output = '<h2 class="organic-headline '.$size.'-headline" style="text-align: '.$align.'; color: #'.$color.';">' .do_shortcode( $content ). '</h2>';

	return $output;
}
add_shortcode( 'headline', 'organic_headline' );

/*
-------------------------------------------------------------------------------------------------------
	Buttons
-------------------------------------------------------------------------------------------------------
*/

function organic_button( $atts, $content = null ) {

	$args = shortcode_atts(
		array(
			'link'	=> '#',
			'target' => '',
			'color'	=> '',
			'size'	=> '',
			'align'	=> 'left',
		),
		$atts
	);
	$link = esc_url( $args['link'] );
	$target = esc_attr( $args['target'] );
	$color = esc_attr( $args['color'] );
	$size = esc_attr( $args['size'] );
	$align = esc_attr( $args['align'] );

	$style = ($color) ? ' '.$color.'-btn' : '';
	$position = ($align) ? ' align-'.$align : '';
	$location = ('blank' === $target) ? ' target="_blank"' : '';

	$output = '<div class="btn-container '.$position.'"><a' .$location. ' class="organic-btn '.$style.' '.$size.'-btn '.$position.'" href="' .$link. '"><span class="btn-holder">' .do_shortcode( $content ). '</span></a></div>';

	return $output;
}
add_shortcode( 'button', 'organic_button' );

/*
-------------------------------------------------------------------------------------------------------
	Alert Box
-------------------------------------------------------------------------------------------------------
*/

function organic_box( $atts, $content = null ) {

	$args = shortcode_atts(
		array(
			'color'	=> '',
	    'align'	=> '',
		),
		$atts
	);
	$align = esc_attr( $args['align'] );
	$color = esc_attr( $args['color'] );
	$style = ($color) ? ' '.$color.'-box' : '';
	$position = ($align) ? ' text-'.$align : '';

	$output = '<div class="organic-box '.$style.$position.'"><a href="#blank" class="close"><i class="fa fa-times"></i></a><div class="box-content">' .do_shortcode( $content ). '</div></div>';

	return $output;
}
add_shortcode( 'box', 'organic_box' );

/*
-------------------------------------------------------------------------------------------------------
	Columns
-------------------------------------------------------------------------------------------------------
*/

function organic_one_third( $atts, $content = null ) {
	return '<div class="organic-column one-third">' . do_shortcode( $content ) . '</div>';
}
add_shortcode( 'one_third', 'organic_one_third' );

function organic_one_third_last( $atts, $content = null ) {
	return '<div class="organic-column one-third last">' . do_shortcode( $content ) . '</div><div class="clearboth"></div>';
}
add_shortcode( 'one_third_last', 'organic_one_third_last' );

function organic_two_third( $atts, $content = null ) {
	return '<div class="organic-column two-third">' . do_shortcode( $content ) . '</div>';
}
add_shortcode( 'two_third', 'organic_two_third' );

function organic_two_third_last( $atts, $content = null ) {
	return '<div class="organic-column two-third last">' . do_shortcode( $content ) . '</div><div class="clearboth"></div>';
}
add_shortcode( 'two_third_last', 'organic_two_third_last' );

function organic_one_half( $atts, $content = null ) {
	return '<div class="organic-column one-half">' . do_shortcode( $content ) . '</div>';
}
add_shortcode( 'one_half', 'organic_one_half' );

function organic_one_half_last( $atts, $content = null ) {
	return '<div class="organic-column one-half last">' . do_shortcode( $content ) . '</div><div class="clearboth"></div>';
}
add_shortcode( 'one_half_last', 'organic_one_half_last' );

function organic_one_fourth( $atts, $content = null ) {
	return '<div class="organic-column one-fourth">' . do_shortcode( $content ) . '</div>';
}
add_shortcode( 'one_fourth', 'organic_one_fourth' );

function organic_one_fourth_last( $atts, $content = null ) {
	return '<div class="organic-column one-fourth last">' . do_shortcode( $content ) . '</div><div class="clearboth"></div>';
}
add_shortcode( 'one_fourth_last', 'organic_one_fourth_last' );

function organic_three_fourth( $atts, $content = null ) {
	return '<div class="organic-column three-fourth">' . do_shortcode( $content ) . '</div>';
}
add_shortcode( 'three_fourth', 'organic_three_fourth' );

function organic_three_fourth_last( $atts, $content = null ) {
	return '<div class="organic-column three-fourth last">' . do_shortcode( $content ) . '</div><div class="clearboth"></div>';
}
add_shortcode( 'three_fourth_last', 'organic_three_fourth_last' );

function organic_one_fifth( $atts, $content = null ) {
	return '<div class="organic-column one-fifth">' . do_shortcode( $content ) . '</div>';
}
add_shortcode( 'one_fifth', 'organic_one_fifth' );

function organic_one_fifth_last( $atts, $content = null ) {
	return '<div class="organic-column one-fifth last">' . do_shortcode( $content ) . '</div><div class="clearboth"></div>';
}
add_shortcode( 'one_fifth_last', 'organic_one_fifth_last' );

function organic_two_fifth( $atts, $content = null ) {
	return '<div class="organic-column two-fifth">' . do_shortcode( $content ) . '</div>';
}
add_shortcode( 'two_fifth', 'organic_two_fifth' );

function organic_two_fifth_last( $atts, $content = null ) {
	return '<div class="organic-column two-fifth last">' . do_shortcode( $content ) . '</div><div class="clearboth"></div>';
}
add_shortcode( 'two_fifth_last', 'organic_two_fifth_last' );

function organic_three_fifth( $atts, $content = null ) {
	return '<div class="organic-column three-fifth">' . do_shortcode( $content ) . '</div>';
}
add_shortcode( 'three_fifth', 'organic_three_fifth' );

function organic_three_fifth_last( $atts, $content = null ) {
	return '<div class="organic-column three-fifth last">' . do_shortcode( $content ) . '</div><div class="clearboth"></div>';
}
add_shortcode( 'three_fifth_last', 'organic_three_fifth_last' );

function organic_four_fifth( $atts, $content = null ) {
	return '<div class="organic-column four-fifth">' . do_shortcode( $content ) . '</div>';
}
add_shortcode( 'four_fifth', 'organic_four_fifth' );

function organic_four_fifth_last( $atts, $content = null ) {
	return '<div class="organic-column four-fifth last">' . do_shortcode( $content ) . '</div><div class="clearboth"></div>';
}
add_shortcode( 'four_fifth_last', 'organic_four_fifth_last' );

function organic_one_sixth( $atts, $content = null ) {
	return '<div class="organic-column one-sixth">' . do_shortcode( $content ) . '</div>';
}
add_shortcode( 'one_sixth', 'organic_one_sixth' );

function organic_one_sixth_last( $atts, $content = null ) {
	return '<div class="organic-column one-sixth last">' . do_shortcode( $content ) . '</div><div class="clearboth"></div>';
}
add_shortcode( 'one_sixth_last', 'organic_one_sixth_last' );

function organic_five_sixth( $atts, $content = null ) {
	return '<div class="organic-column five-sixth">' . do_shortcode( $content ) . '</div>';
}
add_shortcode( 'five_sixth', 'organic_five_sixth' );

function organic_five_sixth_last( $atts, $content = null ) {
	return '<div class="organic-column five-sixth last">' . do_shortcode( $content ) . '</div><div class="clearboth"></div>';
}
add_shortcode( 'five_sixth_last', 'organic_five_sixth_last' );

/*
-------------------------------------------------------------------------------------------------------
	Empty paragraph, line break and content formatting fixes.
-------------------------------------------------------------------------------------------------------
*/

if ( ! function_exists( 'organic_shortcodes_init' ) ) {

	function shortcode_empty_paragraph_fix( $content ) {
		$array = array(
			'<p>[' => '[',
			']</p>' => ']',
			']<br />' => ']',
	    );

	    $content = strtr( $content, $array );
	    return $content;
	}
	add_filter( 'the_content', 'shortcode_empty_paragraph_fix' );

	function the_content_filter( $content ) {

		$block = join( '|', array( 'tab', 'toggle', 'section' ) );
		$rep = preg_replace( "/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", '[$2$3]', $content );
		$rep = preg_replace( "/(<p>)?\[\/($block)](<\/p>|<br \/>)?/", '[/$2]', $rep );
		return $rep;
	}
	add_filter( 'the_content', 'the_content_filter' );

}
