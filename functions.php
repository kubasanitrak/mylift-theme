<?php
add_action( 'after_setup_theme', 'mylift_theme_setup' );
function mylift_theme_setup() {
	load_theme_textdomain( 'mylift_theme', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	global $content_width;
	if ( ! isset( $content_width ) ) $content_width = 640;

	register_nav_menus( array(
		'main-menu'    => __( 'Hlavni Menu', 'mylift_theme' ),
		'lang-menu'    => __( 'Languages Switch', 'mylift_theme' ),
		'sos-link' => __( 'SOS helpline', 'mylift_theme' ),
		// 'index-menu'    => __( 'Index Menu', 'mylift_theme' ),
	) );
}

add_action( 'comment_form_before', 'mylift_theme_enqueue_comment_reply_script' );
function mylift_theme_enqueue_comment_reply_script() {
	if ( get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
}
add_filter( 'the_title', 'mylift_theme_title' );
function mylift_theme_title( $title ) {
	if ( $title == '' ) {
		return '&rarr;';
	} else {
		return $title;
	}
}

/* / — / — / — / — / — / — / — / — / — */
/* / — / — / — / — / — / — / — / — / — */
/* RESPONSIVE IMG LAZYLOAD RELATED SCRIPTS */
add_action( 'wp_enqueue_scripts', 'mylift_theme_scripts' );
function mylift_theme_scripts() {
    wp_register_script('mylift_theme_lazysizes', get_template_directory_uri() . '/assets/js/libs/lazysizes.min.js', array(), '1.0.1', true);
    wp_enqueue_script('mylift_theme_lazysizes');
    wp_register_script('mylift_theme_picturefill', get_template_directory_uri() . '/assets/js/libs/picturefill.min.js', array(), '1.0.1', true);
    wp_enqueue_script('mylift_theme_picturefill');
    wp_register_script('mylift_theme_gsap', get_template_directory_uri() . '/assets/js/libs/gsap.min.js', array(), '1.0.1', true);
    wp_enqueue_script('mylift_theme_gsap');
    wp_register_script('mylift_theme_scrollTrigger', get_template_directory_uri() . '/assets/js/libs/ScrollTrigger.min.js', array(), '1.0.1', true);
    wp_enqueue_script('mylift_theme_scrollTrigger');
    // wp_register_script('mylift_theme_scrollTo', get_template_directory_uri() . '/assets/js/libs/ScrollToPlugin.min.js', array(), '1.0.1', true);
    // wp_enqueue_script('mylift_theme_scrollTo');

    /*
    wp_register_script('mylift_theme_flickity', get_template_directory_uri() . '/assets/js/libs/flickity.pkgd.min.js', array(), '1.0.1', true);
    wp_enqueue_script('mylift_theme_flickity');
    wp_register_script('mylift_theme_gsap-scrollto', get_template_directory_uri() . '/assets/js/libs/ScrollToPlugin.min.js', array(), '1.0.1', true);
    wp_enqueue_script('mylift_theme_gsap-scrollto');
    wp_register_script('mylift_theme_img-carousel', get_template_directory_uri() . '/assets/js/img-carousel-script.js', array(), '1.0.1', true);
    wp_enqueue_script('mylift_theme_img-carousel');
    wp_register_script('mylift_theme_store-utility', get_template_directory_uri() . '/assets/js/ci-store-utility-script.js', array(), '1.0.1', true);
    wp_enqueue_script('mylift_theme_store-utility');
    wp_register_script('mylift_theme_cart-custom-input', get_template_directory_uri() . '/assets/js/cart-custom-input.js', array(), '1.0.1', true);
    wp_enqueue_script('mylift_theme_cart-custom-input');
    */
}

function wp_example_excerpt_length( $length ) {
    return 12;
}
add_filter( 'excerpt_length', 'wp_example_excerpt_length');

// REMOVE HARDCODED WIDTH & HEIGHT INLINE IN THUMBNAIL
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10, 3 );

function remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}
// END REMOVE WIDTH & HEIGHT

add_filter( 'wp_title', 'mylift_theme_filter_wp_title' );
function mylift_theme_filter_wp_title( $title ) {
	return $title . esc_attr( get_bloginfo( 'name' ) );
}
add_action( 'widgets_init', 'mylift_theme_widgets_init' );
function mylift_theme_widgets_init() {
	// Arguments used in all register_sidebar() calls.
	$shared_args = array(
		'before_title'  => '<!-- ',
		'after_title'   => ' -->',
		// 'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
		'before_widget' => ' ',
		// 'after_widget'  => '</div></div>',
		'after_widget'  => ' ',
	);

	register_sidebar( 
		array_merge(
			$shared_args,
			array (
				'name' => __( 'Footer', 'mylift_theme' ),
				'id' => 'footer-widget-area',
				// 'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
				// 'after_widget' => "</li>",
				// 'before_title' => '<h3 class="widget-title">',
				// 'after_title' => '</h3>',
			)
		)
	);
	/*
	register_sidebar( 
		array_merge(
			$shared_args,
			array (
				'name' => __( 'Rezervace', 'mylift_theme' ),
				'id' => 'rezervace-widget-area',
				// 'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
				// 'after_widget' => "</li>",
				// 'before_title' => '<h3 class="widget-title">',
				// 'after_title' => '</h3>',
			)
		)
	);
	*/
}
function mylift_theme_custom_pings( $comment ) {
	$GLOBALS['comment'] = $comment;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo comment_author_link(); ?></li>
	<?php 
}
add_filter( 'get_comments_number', 'mylift_theme_comments_number' );

function mylift_theme_comments_number( $count ) {
	if ( !is_admin() ) {
		global $id;
		$temp_comments = get_comments( 'status=approve&post_id=' . $id );
		$comments_by_type = separate_comments( $temp_comments );
		return count( $comments_by_type['comment'] );
	} else {
		return $count;
	}
}
/* / — / — / — / — / — / — / — / — / — */
/* / — / — / — / — / — / — / — / — / — */
/* WRAP THE POST CONTENT IN CUSTOM DIV */
/* / — / — / — / — / — / — / — / — / — */
/* / — / — / — / — / — / — / — / — / — */
// function wrap_content_in_div($content) {
//     global $post;
//     return '<div class="flow">'.$content.'</div>';
// }
// add_filter('the_content', 'wrap_content_in_div');

/* / — / — / — / — / — / — / — / — / — */
/* / — / — / — / — / — / — / — / — / — */
/* / — / — / — / — / — / — / — / — / — */
/* / — / — / — / — / — / — / — / — / — */


/*   — — —  — — — — — — — — — — — — */
/*   — — —  — — — — — — — — — — — — */
/*   — — —  — — — — — — — — — — — — */
/*   — — —  — — — — — — — — — — — — */
/* ACF CUSTOM BLOCKS
/*   — — —  — — — — — — — — — — — — */
add_action( 'init', 'register_acf_blocks', 5 );
function register_acf_blocks() {
    foreach ( glob( __DIR__ . '/blocks/block-*' ) as $block_path ) {
        register_block_type( $block_path );
    }
    // $globals = $GLOBALS;
    // foreach ($globals as $key => $value) {
    //     $GLOBALS[$key] = $value;
    // }
    // Register js files in block directories
    // You'll have to name your js file "josh-my-block-name.js" so that it adds the right name space for the block.
    foreach ( glob(__DIR__ . '/blocks/block-*/*.js') as $path) {
        $file_name = pathinfo($path, PATHINFO_FILENAME);
        // wp_register_script( $file_name, get_stylesheet_directory_uri() . '/blocks/' . $file_name . '/' . $file_name . '.js', '', $GLOBALS['version']);
        wp_register_script( $file_name, get_stylesheet_directory_uri() . '/blocks/' . $file_name . '/' . $file_name . '.js', '');
    }
}

require_once get_template_directory() . '/includes/acf-contact.php';
// REMOVE INNER DIV WRAPPER INSIDE ACF-BLOCKS
add_filter( 'acf/blocks/wrap_frontend_innerblocks', 'acf_should_wrap_innerblocks', 10, 2 );
function acf_should_wrap_innerblocks( $wrap, $name ) {
    // if ( $name == 'acf/test-block' ) {
        // return true;
    // }
    return false;
}

add_filter( 'acf/blocks/default_block_version', function() {
    return 3;
});

// Gutenberg custom stylesheet
function custom_gutenberg_editor_styles() {
    wp_enqueue_style(
        'admin-styles',
        get_stylesheet_directory_uri().'/assets/css/style-editor.css?v16-09-2026.01'
    );
}
add_action( 'admin_enqueue_scripts', 'custom_gutenberg_editor_styles' );


/* / — / — / — / — / — / – */
/* / — / — / — / — / — / – */
/* CUSTOMIZE WP LOGIN PAGE */
/* / — / — / — / — / — / – */

function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 300 300'%3E%3Cpath fill='%23032AFF' d='M0 190.348c.58-.484 1.207-.924 1.737-1.457 24.58-24.548 49.15-49.104 73.719-73.66 1.894-1.893 2.059-1.893 3.989.036 24.741 24.724 49.486 49.441 74.195 74.197.591.59 1.103 1.585 1.103 2.394.053 35.38.046 70.761.046 106.145v1.55c-.902-.283-1.797-.297-2.274-.752-4.859-4.638-9.633-9.365-14.478-14.02-.981-.942-1.361-1.936-1.357-3.293.032-27.279.032-54.561-.011-81.84 0-.844-.308-1.932-.877-2.501-19.219-19.288-38.489-38.53-57.751-57.775-.168-.168-.355-.315-.59-.53-.398.369-.792.705-1.161 1.074-18.926 18.909-37.84 37.828-56.791 56.712-.96.955-1.361 1.896-1.358 3.253.043 18.404.029 36.812.029 55.216v2.347c.83-.783 1.379-1.274 1.902-1.792 18.463-18.448 36.92-36.898 55.401-55.324.495-.494 1.304-1.034 1.916-.981 1.34.115.849 1.346.853 2.14.032 6.789.057 13.581-.03 20.369-.01.873-.465 1.958-1.084 2.58-24.577 24.635-49.203 49.219-73.787 73.846-1.006 1.006-1.909 1.671-3.33 1.077V190.344l-.011.004Z'/%3E%3Cpath fill='%23032AFF' d='M176.612 283.26h13.028v-2.333c0-25.494.007-50.983-.025-76.476 0-1.217.358-2.051 1.188-2.956 5.196-5.672 10.303-11.419 15.449-17.138.476-.529 1.01-1.012 1.504-1.528.87-.909 1.715-.894 2.6-.007 7.878 7.88 15.778 15.735 23.606 23.661.576.583.899 1.671.909 2.527.079 5.836-.014 11.673.079 17.509.022 1.449-.329 2.341-2.034 2.691l-22.879-22.981c-2.245 1.875-3.864 3.546-3.842 6.907.179 28.051.103 56.107.103 84.159 0 2.68-.025 2.705-2.7 2.705h-41.482c-2.256 0-2.514-.258-2.514-2.587 0-35.023-.014-70.046.054-105.065 0-1.038.569-2.326 1.307-3.07 15.67-15.76 31.402-31.455 47.122-47.165 1.454-1.453 2.278-1.464 3.703-.039 7.252 7.243 14.485 14.5 21.758 21.718.946.937 1.404 1.914 1.393 3.274-.057 5.897-.089 11.795.029 17.688.025 1.171-.627 1.682-1.293 2.094-.275.172-1.21-.433-1.654-.877a5137.07 5137.07 0 0 1-20.365-20.333c-.502-.501-.881-1.124-1.827-2.34-1.214 1.528-2.037 2.77-3.065 3.818-8.584 8.75-17.067 17.61-25.894 26.109-3.162 3.045-4.401 6.073-4.362 10.478.222 25.668.107 51.34.107 77.013v2.537l-.003.007Z'/%3E%3Cpath fill='%23032AFF' d='M157.385 160.532c.563-.534.999-.927 1.418-1.342 18.754-18.741 37.501-37.492 56.283-56.208 1.01-1.005 1.418-1.986 1.415-3.41-.047-18.344-.033-36.69-.033-55.034v-2.415c-.752.7-1.249 1.138-1.718 1.606-18.547 18.53-37.093 37.06-55.642 55.582-.405.404-1.049 1.095-1.325.987-.559-.218-1.336-.884-1.343-1.374a967.9 967.9 0 0 1-.011-21.621c.007-.634.591-1.367 1.092-1.868 15.7-15.728 31.424-31.434 47.144-47.143 9.103-9.097 18.199-18.204 27.334-27.269.516-.511 1.365-.69 2.059-1.023.287.712.82 1.428.82 2.14.04 34.905.047 69.806-.018 104.71 0 1.038-.562 2.33-1.299 3.071-24.863 24.935-49.78 49.82-74.69 74.708-1.446 1.446-1.897 1.446-3.351-.007-24.785-24.763-49.562-49.53-74.36-74.275-.956-.956-1.34-1.958-1.336-3.296.025-34.962.015-69.928.05-104.89 0-.697.466-1.395.713-2.093.738.322 1.65.465 2.188.991 4.641 4.541 9.192 9.176 13.826 13.727.97.952 1.354 1.94 1.354 3.296-.032 27.161-.036 54.322.018 81.483 0 .884.397 2.004 1.01 2.619 19.09 19.167 38.227 38.279 57.36 57.403.29.29.605.551 1.046.955l-.004-.01Z'/%3E%3Cpath fill='%23032AFF' d='M274.374 266.527c-4-1.077-7.546-1.997-11.073-2.988a1952.261 1952.261 0 0 1-21.439-6.127c-.448-.132-1.025-.848-1.028-1.295-.065-6.667-.047-13.334-.047-20.151h54.077v15.606h-34.567c11.692 2.906 23.137 5.747 34.696 8.617 0 3.89.036 7.694-.054 11.494-.01.401-.677 1.017-1.146 1.142-10.331 2.784-20.68 5.511-31.24 8.306h32.304v15.895h-54.073v-2.133c0-5.893.018-11.791-.015-17.684-.003-.956.197-1.468 1.243-1.747 10.184-2.702 20.351-5.464 30.517-8.223.491-.133.956-.369 1.841-.712h.004Z'/%3E%3Cpath fill='%23032AFF' d='M240.787 231.407c0-6.301-.025-12.37.05-18.443.008-.494.598-1.181 1.093-1.442 5.582-2.931 11.197-5.794 17.067-8.811-1.891-.994-3.56-1.893-5.25-2.759-3.936-2.014-7.896-3.986-11.807-6.051-.501-.265-1.099-.962-1.106-1.467-.079-5.894-.05-11.788-.05-17.968 2.807 1.596 5.446 3.099 8.086 4.599 8.139 4.627 16.257 9.293 24.444 13.831 1.217.676 2.764 1.019 4.168 1.052 5.3.121 10.607.046 15.91.05.466 0 .931.039 1.497.068v17.291h-1.83c-5.421 0-10.847-.036-16.268.032-.949.011-2.006.272-2.822.748-10.682 6.22-21.329 12.496-31.986 18.755-.293.172-.63.272-1.199.512l.003.003Z'/%3E%3Cpath fill='%23032AFF' d='M240.93 152.505h39.513v-23.783h14.45v41.085h-53.959v-17.302h-.004Z'/%3E%3Cpath fill='%23032AFF' d='M294.914 103.669v17.492h-54.012v-17.492h54.012Z'/%3E%3Cpath fill='%23032AFF' d='M294.9 94.93h-53.973V53.706h5.07c2.264 0 4.53.078 6.79-.029 1.447-.068 1.834.458 1.823 1.854-.061 6.549-.029 13.094-.029 19.642v2.019h8.022V72.4c0-4.047-.036-8.095.043-12.142.01-.519.59-1.464.924-1.47 4.093-.104 8.186-.069 12.436-.069v18.526h18.89V94.93h.004Z'/%3E%3Cpath fill='%23032AFF' d='M255.298 34.032v15.666h-14.364V1.128h14.288V16.27h39.653v17.76h-39.581.004Z'/%3E%3C/svg%3E") center center no-repeat;
                width: calc(96px + (132 - 96) * ((100vw - 320px) / (2560 - 320)));
                height: calc(96px + (132 - 96) * ((100vw - 320px) / (2560 - 320)));
				background-size: contain;
				padding-bottom: 30px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return esc_attr( get_bloginfo( 'name' ) );
}
add_filter( 'login_headertext', 'my_login_logo_url_title' );

/* / — / — / — / — / — / – */
/* END CUSTOMIZE WP LOGIN PAGE */
/* / — / — / — / — / — / – */
/* / — / — / — / — / — / – */



/* / — / — / — / — / — / – / — / — / — / */
/* / — / — / — / — / — / – / — / — / — / */
/* ADDS SUPPORT FOR EDITOR COLOR PALETTE */
/* / — / — / — / — / — / – / — / — / — / */

function my_theme_color_features() {

    // The new colors we are going to add
    $newColorPalette = [
        [
            'name'  => __( 'Černá', 'mylift_theme' ),
			'slug'  => 'black',
			'color'	=> '#000000',
        ],
        [
            'name'  => __( 'Modrá', 'mylift_theme' ),
			'slug'  => 'modra',
			'color' => '#1414c8',
        ],
        // [
        //     'name'  => __( 'Oranžová', 'mylift_theme' ),
		// 	'slug'  => 'oranzova',
		// 	'color' => '#EB5F23',
        // ],
    ];

    // Apply the color palette containing the original colors and 2 new colors:
    add_theme_support( 'editor-color-palette', $newColorPalette);
    // Disables color picker in block color palette.
    add_theme_support( 'disable-custom-colors' );
}
add_action( 'after_setup_theme', 'my_theme_color_features' );

/* / — / — / — / — / — / – / — / — / — / — / – */
/* / — / — / — / — / — / – / — / — / — / — / – */
/* KEEP TAGS ORDER AS INSERTED IN POST DETAILS */
/* / — / — / — / — / — / – / — / — / — / — / – */
/* / — / — / — / — / — / – / — / — / — / — / – */
#require_once('includes/SlashAdmin.php');
#$class = new TaxonomyOrder();

/* / — / — / — / —  / — / — / — / — / — / – / — / — / — / — / – */
/* / — / — / — / —  / — / — / — / — / — / – / — / — / — / — / – */
/* WORKAROUND WP NASTY BUG PREPENDING AUTO TO SIZES ATTR */
/* / — / — / — / —  / — / — / — / — / — / – / — / — / — / — / – */
/* / — / — / — / —  / — / — / — / — / — / – / — / — / — / — / – */
add_filter(
    'wp_content_img_tag',
    static function ( $image ) {
	    return str_replace( ' sizes="auto, ', ' sizes="', $image );
    }
);
add_filter(
    'wp_get_attachment_image_attributes',
    static function ( $attr ) {
		if ( isset( $attr['sizes'] ) ) {
			$attr['sizes'] = preg_replace( '/^auto, /', '', $attr['sizes'] );
		}
		return $attr;
    }
);
/* / — / — / — / —  / — / — / — / — / — / – / — / — / — / — / – */
/* / — / — / — / —  / — / — / — / — / — / – / — / — / — / — / – */
/* END WORKAROUND WP NASTY BUG PREPENDING AUTO TO SIZES ATTR */
/* / — / — / — / —  / — / — / — / — / — / – / — / — / — / — / – */
/* / — / — / — / —  / — / — / — / — / — / – / — / — / — / — / – */


/* / — / — / — / —  / — / — / — / — / — / – / — / — / — / — / – */
/* / — / — / — / —  / — / — / — / — / — / – / — / — / — / — / – */
/* DYNAMIC SCROLL NAVIGATION FROM ACF BLOCKS
 * Scans the current page for ACF blocks that have:
 * - Field name: add-link-to-main-nav (True/False or Checkbox)
 * - Field name: menu text (Menu Text)
 * - Field name: id (Section ID / anchor)
/* / — / — / — / —  / — / — / — / — / — / – / — / — / — / — / – */
/* / — / — / — / —  / — / — / — / — / — / – / — / — / — / — / – */
function get_dynamic_scroll_nav() {
    $post = get_queried_object();
    if ( ! $post || ! is_a( $post, 'WP_Post' ) ) {
        return '';
    }

    $blocks = parse_blocks( $post->post_content );
    $items  = [];

    foreach ( $blocks as $block ) {
        // Only process ACF blocks
        if ( empty( $block['blockName'] ) || strpos( $block['blockName'], 'acf/' ) !== 0 ) {
            continue;
        }

        $data = $block['attrs']['data'] ?? [];

        // Match the exact Field Names you set in ACF (case-sensitive)
        $add_to_nav = $data['add-link-to-main-nav'] ?? $data['add_link_to_main_nav'] ?? 0;
        if ( ! $add_to_nav ) {
            continue;
        }

        $menu_text = $data['menu text'] ?? $data['menu_text'] ?? $data['menu-text'] ?? '';
        $section_id = $data['id_to_scroll'] ?? '';

        if ( ! empty( $menu_text ) && ! empty( $section_id ) ) {
            $items[] = [
                'text' => trim( $menu_text ),
                'id'   => sanitize_title_with_dashes( $section_id ), // clean anchor
            ];
        }
    }

    if ( empty( $items ) ) {
        return '';
    }

    // Build the exact menu-item HTML you asked for
    $output = '<ul id="menu-hlavni-menu-cz" class="main-nav-list nav-list list-none accord">';
    $counter = 19; // starts like your example "menu-item-19"

    foreach ( $items as $item ) {
        $li_id = 'menu-item-' . $counter;

        $output .= sprintf(
            '<li id="%s" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-%d"><a href="#%s">%s</a></li>',
            esc_attr( $li_id ),
            $counter,
            esc_attr( $item['id'] ),
            esc_html( $item['text'] )
        );

        $counter++;
    }

    $output .= '</ul>';

    return $output;
}

/* / — / — / — / —  / — / — / — / — / — / – / — / — / — / — / – */
/* / — / — / — / —  / — / — / — / — / — / – / — / — / — / — / – */
/* END DYNAMIC SCROLL NAVIGATION FROM ACF BLOCKS */
/* / — / — / — / —  / — / — / — / — / — / – / — / — / — / — / – */
/* / — / — / — / —  / — / — / — / — / — / – / — / — / — / — / – */