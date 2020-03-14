<?php
/**
 * Back Button Widget - Functions.
 *
 * @version 1.2.0
 * @since   1.0.0
 * @author  Algoritmika Ltd.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'alg_back_button' ) ) {
	/**
	 * alg_back_button.
	 *
	 * @version 1.2.0
	 * @since   1.0.0
	 * @todo    [dev] disable button on no history
	 * @todo    [dev] (maybe) option to output `<button>` (instead of `<input type="button">`)
	 * @todo    [dev] (maybe) color picker
	 * @todo    [feature] predefined CSS styles
	 * @todo    [feature] (maybe) option to enable/disable confirmation (and option for confirmation text)
	 */
	function alg_back_button( $label, $class = '', $style = '', $type = 'input', $js_func = 'back', $hide_on_front_page = 'no' ) {
		if ( apply_filters( 'alg_back_button_widget_do_hide', false, $hide_on_front_page ) ) {
			return '';
		}
		$label       = ( '' == $label ? __( 'Back', 'back-button-widget' ) : do_shortcode( $label ) );
		$js_function = ( 'back' === $js_func ? 'back()' : 'go(-1)' );
		switch ( $type ) {
			case 'simple':
				return sprintf( '<a href="javascript:history.%s" class="alg_back_button_simple %s" style="%s">%s</a>', $js_function, $class, $style, $label );
			default: // 'input'
				return sprintf( '<input type="button" value="%s" class="alg_back_button_input %s" style="%s" onclick="window.history.%s" />', $label, $class, $style, $js_function );
		}
	}
}

if ( ! function_exists( 'alg_back_button_shortcode' ) ) {
	/**
	 * alg_back_button_shortcode.
	 *
	 * @version 1.2.0
	 * @since   1.0.0
	 */
	function alg_back_button_shortcode( $atts ) {
		$defaults = array(
			'label'              => __( 'Back', 'back-button-widget' ),
			'class'              => '',
			'style'              => '',
			'type'               => 'input',
			'js_func'            => 'back',
			'hide_on_front_page' => 'no',
		);
		$atts = shortcode_atts( $defaults, $atts, 'alg_back_button' );
		return alg_back_button( $atts['label'], $atts['class'], $atts['style'], $atts['type'], $atts['js_func'], $atts['hide_on_front_page'] );
	}
}
add_shortcode( 'alg_back_button', 'alg_back_button_shortcode' );

if ( ! function_exists( 'alg_back_button_translate_shortcode' ) ) {
	/**
	 * alg_back_button_translate_shortcode.
	 *
	 * @version 1.1.0
	 * @since   1.1.0
	 */
	function alg_back_button_translate_shortcode( $atts, $content = '' ) {
		// E.g.: `[alg_back_button_translate lang="FR" lang_text="Retour" not_lang_text="Back"]`
		if ( isset( $atts['lang_text'] ) && isset( $atts['not_lang_text'] ) && ! empty( $atts['lang'] ) ) {
			return ( ! defined( 'ICL_LANGUAGE_CODE' ) || ! in_array( strtolower( ICL_LANGUAGE_CODE ), array_map( 'trim', explode( ',', strtolower( $atts['lang'] ) ) ) ) ) ?
				$atts['not_lang_text'] : $atts['lang_text'];
		}
		// E.g.: `[alg_back_button_translate lang="FR"]Retour[/alg_back_button_translate][alg_back_button_translate lang="DE"]Zurück[/alg_back_button_translate][alg_back_button_translate not_lang="FR,DE"]Back[/alg_back_button_translate]`
		return (
			( ! empty( $atts['lang'] )     && ( ! defined( 'ICL_LANGUAGE_CODE' ) || ! in_array( strtolower( ICL_LANGUAGE_CODE ), array_map( 'trim', explode( ',', strtolower( $atts['lang'] ) ) ) ) ) ) ||
			( ! empty( $atts['not_lang'] ) &&     defined( 'ICL_LANGUAGE_CODE' ) &&   in_array( strtolower( ICL_LANGUAGE_CODE ), array_map( 'trim', explode( ',', strtolower( $atts['not_lang'] ) ) ) ) )
		) ? '' : $content;
	}
}
add_shortcode( 'alg_back_button_translate', 'alg_back_button_translate_shortcode' );
