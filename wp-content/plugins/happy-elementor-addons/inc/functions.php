<?php
/**
 * Helper functions
 *
 * @package Happy_Addons
 */
defined( 'ABSPATH' ) || die();

/**
 * Call a shortcode function by tag name.
 *
 * @since  1.0.0
 *
 * @param string $tag     The shortcode whose function to call.
 * @param array  $atts    The attributes to pass to the shortcode function. Optional.
 * @param array  $content The shortcode's content. Default is null (none).
 *
 * @return string|bool False on failure, the result of the shortcode on success.
 */
function ha_do_shortcode( $tag, array $atts = array(), $content = null ) {
    global $shortcode_tags;
    if ( ! isset( $shortcode_tags[ $tag ] ) ) {
        return false;
    }
    return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
}

/**
 * Sanitize html class string
 *
 * @param $class
 * @return string
 */
function ha_sanitize_html_class_param( $class ) {
    $classes = ! empty( $class ) ? explode( ' ', $class ) : [];
    $sanitized = [];
    if ( ! empty( $classes ) ) {
        $sanitized = array_map( function( $cls ) {
            return sanitize_html_class( $cls );
        }, $classes );
    }
    return implode( ' ', $sanitized );
}

function ha_is_script_debug_enabled() {
    return ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG );
}

function ha_prepare_data_prop_settings( &$settings, $field_map = [] ) {
    $data = [];
    foreach ( $field_map as $key => $data_key ) {
        $setting_value = ha_get_setting_value( $settings, $key );
        list( $data_field_key, $data_field_type ) = explode( '.', $data_key );
        $validator = $data_field_type . 'val';

        if ( is_callable( $validator ) ) {
            $val = call_user_func( $validator, $setting_value );
        } else {
            $val = $setting_value;
        }
        $data[ $data_field_key ] = $val;
    }
    return wp_json_encode( $data );
}

function ha_get_setting_value( &$settings, $keys ) {
    if ( ! is_array( $keys ) ) {
        $keys = explode( '.', $keys );
    }
    if ( is_array( $settings[ $keys[0] ] ) ) {
        return ha_get_setting_value( $settings[ $keys[0] ], array_slice( $keys, 1 ) );
    }
    return $settings[ $keys[0] ];
}

function ha_is_localhost() {
    return isset( $_SERVER['REMOTE_ADDR'] ) && in_array( $_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'] );
}

function ha_get_css_cursors() {
    return [
        'default' => __( 'Default', 'happy-elementor-addons' ),
        'alias' => __( 'Alias', 'happy-elementor-addons' ),
        'all-scroll' => __( 'All scroll', 'happy-elementor-addons' ),
        'auto' => __( 'Auto', 'happy-elementor-addons' ),
        'cell' => __( 'Cell', 'happy-elementor-addons' ),
        'context-menu' => __( 'Context menu', 'happy-elementor-addons' ),
        'col-resize' => __( 'Col-resize', 'happy-elementor-addons' ),
        'copy' => __( 'Copy', 'happy-elementor-addons' ),
        'crosshair' => __( 'Crosshair', 'happy-elementor-addons' ),
        'e-resize' => __( 'E-resize', 'happy-elementor-addons' ),
        'ew-resize' => __( 'EW-resize', 'happy-elementor-addons' ),
        'grab' => __( 'Grab', 'happy-elementor-addons' ),
        'grabbing' => __( 'Grabbing', 'happy-elementor-addons' ),
        'help' => __( 'Help', 'happy-elementor-addons' ),
        'move' => __( 'Move', 'happy-elementor-addons' ),
        'n-resize' => __( 'N-resize', 'happy-elementor-addons' ),
        'ne-resize' => __( 'NE-resize', 'happy-elementor-addons' ),
        'nesw-resize' => __( 'NESW-resize', 'happy-elementor-addons' ),
        'ns-resize' => __( 'NS-resize', 'happy-elementor-addons' ),
        'nw-resize' => __( 'NW-resize', 'happy-elementor-addons' ),
        'nwse-resize' => __( 'NWSE-resize', 'happy-elementor-addons' ),
        'no-drop' => __( 'No-drop', 'happy-elementor-addons' ),
        'not-allowed' => __( 'Not-allowed', 'happy-elementor-addons' ),
        'pointer' => __( 'Pointer', 'happy-elementor-addons' ),
        'progress' => __( 'Progress', 'happy-elementor-addons' ),
        'row-resize' => __( 'Row-resize', 'happy-elementor-addons' ),
        's-resize' => __( 'S-resize', 'happy-elementor-addons' ),
        'se-resize' => __( 'SE-resize', 'happy-elementor-addons' ),
        'sw-resize' => __( 'SW-resize', 'happy-elementor-addons' ),
        'text' => __( 'Text', 'happy-elementor-addons' ),
        'url' => __( 'URL', 'happy-elementor-addons' ),
        'w-resize' => __( 'W-resize', 'happy-elementor-addons' ),
        'wait' => __( 'Wait', 'happy-elementor-addons' ),
        'zoom-in' => __( 'Zoom-in', 'happy-elementor-addons' ),
        'zoom-out' => __( 'Zoom-out', 'happy-elementor-addons' ),
        'none' => __( 'None', 'happy-elementor-addons' ),
    ];
}

function ha_get_css_blend_modes() {
    return [
        'normal' => __( 'Normal', 'happy-elementor-addons' ),
        'multiply' => __( 'Multiply', 'happy-elementor-addons' ),
        'screen' => __( 'Screen', 'happy-elementor-addons' ),
        'overlay' => __( 'Overlay', 'happy-elementor-addons' ),
        'darken' => __( 'Darken', 'happy-elementor-addons' ),
        'lighten' => __( 'Lighten', 'happy-elementor-addons' ),
        'color-dodge' => __( 'Color Dodge', 'happy-elementor-addons' ),
        'color-burn' => __( 'Color Burn', 'happy-elementor-addons' ),
        'saturation' => __( 'Saturation', 'happy-elementor-addons' ),
        'difference' => __( 'Difference', 'happy-elementor-addons' ),
        'exclusion' => __( 'Exclusion', 'happy-elementor-addons' ),
        'hue' => __( 'Hue', 'happy-elementor-addons' ),
        'color' => __( 'Color', 'happy-elementor-addons' ),
        'luminosity' => __( 'Luminosity', 'happy-elementor-addons' ),
    ];
}

/**
 * Check elementor version
 *
 * @param string $version
 * @param string $operator
 * @return bool
 */
function ha_is_elementor_version( $operator = '<', $version = '2.6.0' ) {
    return defined( 'ELEMENTOR_VERSION' ) && version_compare( ELEMENTOR_VERSION, $version, $operator );
}

/**
 * Render icon html with backward compatibility
 *
 * @param array $settings
 * @param string $old_icon_id
 * @param string $new_icon_id
 * @param array $attributes
 */
function ha_render_icon( $settings = [], $old_icon_id = 'icon', $new_icon_id = 'selected_icon', $attributes = [] ) {
    // Check if its already migrated
    $migrated = isset( $settings['__fa4_migrated'][ $new_icon_id ] );
    // Check if its a new widget without previously selected icon using the old Icon control
    $is_new = empty( $settings[ $old_icon_id ] );

    $attributes['aria-hidden'] = 'true';

    if ( ha_is_elementor_version( '>=', '2.6.0' ) && ( $is_new || $migrated ) ) {
        \Elementor\Icons_Manager::render_icon( $settings[ $new_icon_id ], $attributes );
    } else {
        if ( empty( $attributes['class'] ) ) {
            $attributes['class'] = $settings[ $old_icon_id ];
        } else {
            if ( is_array( $attributes['class'] ) ) {
                $attributes['class'][] = $settings[ $old_icon_id ];
            } else {
                $attributes['class'] .= ' ' . $settings[ $old_icon_id ];
            }
        }
        printf( '<i %s></i>', \Elementor\Utils::render_html_attributes( $attributes ) );
    }
}

/**
 * List of happy icons
 *
 * @return array
 */
function ha_get_happy_icons() {
    return \Happy_Addons\Elementor\Icons_Manager::get_happy_icons();
}

/**
 * @return bool
 */
function ha_is_happy_mode_enabled() {
    return apply_filters( 'happyaddons_is_happy_mode_enabled', true );
}

/**
 * Get elementor instance
 *
 * @return \Elementor\Plugin
 */
function ha_elementor() {
    return \Elementor\Plugin::instance();
}

/**
 * Get a list of all the allowed html tags.
 *
 * @param string $level Allowed levels are basic and intermediate
 * @return array
 */
function ha_get_allowed_html_tags( $level = 'basic' ) {
    $allowed_html = [
        'b' => [],
        'i' => [],
        'u' => [],
        'em' => [],
        'br' => [],
        'abbr' => [
            'title' => [],
        ],
        'span' => [
            'class' => [],
        ],
        'strong' => [],
    ];

    if ( $level === 'intermediate' ) {
        $allowed_html['a'] = [
            'href' => [],
            'title' => [],
            'class' => [],
            'id' => [],
        ];
    }

    return $allowed_html;
}

/**
 * Strip all the tags except allowed html tags
 *
 * The name is based on inline editing toolbar name
 *
 * @param string $string
 * @return string
 */
function ha_kses_intermediate( $string = '' ) {
    return wp_kses( $string, ha_get_allowed_html_tags( 'intermediate' ) );
}

/**
 * Strip all the tags except allowed html tags
 *
 * The name is based on inline editing toolbar name
 *
 * @param string $string
 * @return string
 */
function ha_kses_basic( $string = '' ) {
    return wp_kses( $string, ha_get_allowed_html_tags( 'basic' ) );
}

/**
 * Get a translatable string with allowed html tags.
 *
 * @param string $level Allowed levels are basic and intermediate
 * @return string
 */
function ha_get_allowed_html_desc( $level = 'basic' ) {
    if ( ! in_array( $level, [ 'basic', 'intermediate' ] ) ) {
        $level = 'basic';
    }

    $tags_str = '<' . implode( '>,<', array_keys( ha_get_allowed_html_tags( $level ) ) ) . '>';
    return sprintf( __( 'This input field has support for the following HTML tags: %1$s', 'happy-elementor-addons' ), '<code>' . esc_html( $tags_str ) . '</code>' );
}

function ha_has_pro() {
    return defined( 'HAPPY_ADDONS_PRO_VERSION' );
}

function ha_get_b64_icon() {
    return 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzMiAzMiI+PGcgZmlsbD0iI0ZGRiI+PHBhdGggZD0iTTI4LjYgNy44aC44Yy41IDAgLjktLjUuOC0xIDAtLjUtLjUtLjktMS0uOC0zLjUuMy02LjgtMS45LTcuOC01LjMtLjEtLjUtLjYtLjctMS4xLS42cy0uNy42LS42IDEuMWMxLjIgMy45IDQuOSA2LjYgOC45IDYuNnoiLz48cGF0aCBkPSJNMzAgMTEuMWMtLjMtLjYtLjktMS0xLjYtMS0uOSAwLTEuOSAwLTIuOC0uMi00LS44LTctMy42LTguNC03LjEtLjMtLjYtLjktMS4xLTEuNi0xQzguMyAxLjkgMS44IDcuNC45IDE1LjEuMSAyMi4yIDQuNSAyOSAxMS4zIDMxLjIgMjAgMzQuMSAyOSAyOC43IDMwLjggMTkuOWMuNy0zLjEuMy02LjEtLjgtOC44em0tMTEuNiAxLjFjLjEtLjUuNi0uOCAxLjEtLjdsMy43LjhjLjUuMS44LjYuNyAxLjFzLS42LjgtMS4xLjdsLTMuNy0uOGMtLjQtLjEtLjgtLjYtLjctMS4xek0xMC4xIDExYy4yLTEuMSAxLjQtMS45IDIuNS0xLjYgMS4xLjIgMS45IDEuNCAxLjYgMi41LS4yIDEuMS0xLjQgMS45LTIuNSAxLjYtMS0uMi0xLjgtMS4zLTEuNi0yLjV6bTE0LjYgMTAuNkMyMi44IDI2IDE3LjggMjguNSAxMyAyN2MtMy42LTEuMi02LjItNC41LTYuNS04LjItLjEtMSAuOC0xLjcgMS43LTEuNmwxNS40IDIuNWMuOSAwIDEuNCAxIDEuMSAxLjl6Ii8+PHBhdGggZD0iTTE3LjEgMjIuOGMtMS45LS40LTMuNy4zLTQuNyAxLjctLjIuMy0uMS43LjIuOS42LjMgMS4yLjUgMS45LjcgMS44LjQgMy43LjEgNS4xLS43LjMtLjIuNC0uNi4yLS45LS43LS45LTEuNi0xLjUtMi43LTEuN3oiLz48L2c+PC9zdmc+';
}

function ha_get_dashboard_link( $suffix = '#home' ) {
    return add_query_arg( [ 'page' => 'happy-addons' . $suffix ], admin_url( 'admin.php' ) );
}

function ha_get_current_user_display_name() {
    $user = wp_get_current_user();
    $name = 'user';
    if ( $user->exists() && $user->display_name ) {
        $name = $user->display_name;
    }
    return $name;
}

/**
 * Twitter Feed Ajax call
 */
function ha_twitter_feed_ajax() {

	define( 'HA_TWEETS_TOKEN', '_tweet_token' );
	define( 'HA_TWEETS_CASH', '_tweet_cash' );

	$security = check_ajax_referer('happy_addons_twitter_nonce', 'security');

	if ( true == $security && isset( $_POST['query_settings'] ) ) :
		$settings = $_POST['query_settings'];
		$loaded_item = $_POST['loaded_item'];

		$user_name = trim($settings['user_name']);

		$transient_key = $settings['id'] . '_' . $user_name . HA_TWEETS_CASH;
		$twitter_data = get_transient($transient_key);
		$credentials = $settings['credentials'];

		$auth_response = wp_remote_post('https://api.twitter.com/oauth2/token',
			array(
				'method' => 'POST',
				'httpversion' => '1.1',
				'blocking' => true,
				'headers' => [
					'Authorization' => 'Basic ' . $credentials,
					'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8',
				],
				'body' => ['grant_type' => 'client_credentials'],
			));

		$body = json_decode( wp_remote_retrieve_body( $auth_response ) );
		$token = $body->access_token;

		$tweets_response = wp_remote_get('https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=' . $settings['user_name'] . '&count=999&tweet_mode=extended',
			array(
				'httpversion' => '1.1',
				'blocking' => true,
				'headers' => ['Authorization' => "Bearer $token",],
			));

		if ( !is_wp_error( $tweets_response ) ) {
			$twitter_data = json_decode( wp_remote_retrieve_body( $tweets_response ), true );
			set_transient($settings['id'] . '_' . $settings['user_name'] . HA_TWEETS_CASH, $twitter_data, 0); // 2 * MINUTE_IN_SECONDS
		}

		switch ($settings['sort_by']) {
			case 'old-posts':
				usort($twitter_data, function ($a,$b) {
					if ( $a['created_at'] == $b['created_at'] ) return 0;
					return ( $a['created_at'] < $b['created_at'] ) ? -1 : 1 ;
				});
				break;
			case 'favorite_count':
				usort($twitter_data, function ($a,$b){
					if ($a['favorite_count'] == $b['favorite_count']) return 0;
					return ($a['favorite_count'] > $b['favorite_count']) ? -1 : 1 ;
				});
				break;
			case 'retweet_count':
				usort($twitter_data, function ($a,$b){
					if ($a['retweet_count'] == $b['retweet_count']) return 0;
					return ($a['retweet_count'] > $b['retweet_count']) ? -1 : 1 ;
				});
				break;
			default:
				$twitter_data;
		}

		$items = array_splice($twitter_data, $loaded_item, $settings['tweets_limit'] );

		foreach ($items as $item) :
			?>
			<div class="ha-tweet-item">

				<?php if ( $settings['show_twitter_logo'] == 'yes' ) : ?>
					<div class="ha-tweeter-feed-icon">
						<i class="fa fa-twitter"></i>
					</div>
				<?php endif; ?>

				<div class="ha-tweet-inner-wrapper">

					<div class="ha-tweet-author">
						<?php if ( $settings['show_user_image'] == 'yes' ) : ?>
							<a href="<?php echo esc_url( 'https://twitter.com/'.$user_name ); ?>">
								<img
									src="<?php echo esc_url( $item['user']['profile_image_url_https'] ); ?>"
									alt="<?php echo esc_attr( $item['user']['name'] ); ?>"
									class="ha-tweet-avatar"
								>
							</a>
						<?php endif; ?>

						<div class="ha-tweet-user">
							<?php if ( $settings['show_name'] == 'yes' ) : ?>
								<a href="<?php echo esc_url( 'https://twitter.com/'.$user_name ); ?>" class="ha-tweet-author-name">
									<?php echo esc_html( $item['user']['name'] ); ?>
								</a>
							<?php endif; ?>

							<?php if ( $settings['show_user_name'] == 'yes' ) : ?>
								<a href="<?php echo esc_url( 'https://twitter.com/'.$user_name ); ?>" class="ha-tweet-username">
									<?php echo esc_html( $settings['user_name'] ); ?>
								</a>
							<?php endif; ?>
						</div>
					</div>

					<div class="ha-tweet-content">
						<p><?php echo esc_html( $item['full_text'] ); ?></p>

						<?php if ( $settings['show_date'] == 'yes' ) : ?>
							<div class="ha-tweet-date">
								<?php echo esc_html( date("M d Y", strtotime( $item['created_at'] ) ) );?>
							</div>
						<?php endif; ?>
					</div>

				</div>

				<?php if ( $settings['show_favorite'] == 'yes' || $settings['show_retweet'] == 'yes' ) : ?>
					<div class="ha-tweet-footer-wrapper">
						<div class="ha-tweet-footer">

							<?php if ( $settings['show_favorite'] == 'yes' ) : ?>
								<div class="ha-tweet-favorite">
									<?php echo esc_html( $item['favorite_count'] ); ?>
									<i class="fa fa-heart-o"></i>
								</div>
							<?php endif; ?>

							<?php if ( $settings['show_retweet'] == 'yes' ) : ?>
								<div class="ha-tweet-retweet">
									<?php echo esc_html( $item['retweet_count'] ); ?>
									<i class="fa fa-retweet"></i>
								</div>
							<?php endif; ?>

						</div>
					</div>
				<?php endif; ?>

			</div>
		<?php
		endforeach;
	endif;
	wp_die();

}
add_action( 'wp_ajax_ha_twitter_feed_action', 'ha_twitter_feed_ajax' );
add_action( 'wp_ajax_nopriv_ha_twitter_feed_action', 'ha_twitter_feed_ajax' );

function ha_get_icon_for_label() {
    return '<i style="position: relative; top: 1px" class="hm hm-happyaddons"></i> ';
}
