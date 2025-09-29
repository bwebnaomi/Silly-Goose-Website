<?php
/**
 * Silly Goose Theme Functions
 * Version: 1.0.4
 */

if (!defined('ABSPATH')) exit;

define('SILLYGOOSE_VERSION', '1.0.4');
define('SILLYGOOSE_THEME_DIR', get_template_directory());
define('SILLYGOOSE_THEME_URI', get_template_directory_uri());

function sillygoose_setup() {
    $supports = ['title-tag', 'post-thumbnails', 'custom-logo', 'wp-block-styles', 'responsive-embeds', 'align-wide', 'editor-styles', 'customize-selective-refresh-widgets'];
    foreach ($supports as $support) add_theme_support($support);

    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
    register_nav_menus(['primary' => esc_html__('Primary Menu', 'sillygoose'), 'footer' => esc_html__('Footer Menu', 'sillygoose')]);
    add_editor_style('css/block-editor.css');

    add_theme_support('editor-color-palette', [
        ['name' => __('Primary Orange', 'sillygoose'), 'slug' => 'primary', 'color' => '#ff6b35'],
        ['name' => __('Secondary Teal', 'sillygoose'), 'slug' => 'secondary', 'color' => '#4ecdc4'],
        ['name' => __('Accent Yellow', 'sillygoose'), 'slug' => 'accent', 'color' => '#ffd23f'],
        ['name' => __('Muted Gray', 'sillygoose'), 'slug' => 'muted', 'color' => '#f8f9fa'],
        ['name' => __('Foreground', 'sillygoose'), 'slug' => 'foreground', 'color' => '#212529'],
        ['name' => __('White', 'sillygoose'), 'slug' => 'white', 'color' => '#ffffff'],
    ]);

    add_theme_support('editor-font-sizes', [
        ['name' => __('Small', 'sillygoose'), 'shortName' => __('S', 'sillygoose'), 'size' => 14, 'slug' => 'small'],
        ['name' => __('Normal', 'sillygoose'), 'shortName' => __('M', 'sillygoose'), 'size' => 16, 'slug' => 'normal'],
        ['name' => __('Large', 'sillygoose'), 'shortName' => __('L', 'sillygoose'), 'size' => 24, 'slug' => 'large'],
        ['name' => __('Extra Large', 'sillygoose'), 'shortName' => __('XL', 'sillygoose'), 'size' => 32, 'slug' => 'extra-large'],
        ['name' => __('Huge', 'sillygoose'), 'shortName' => __('XXL', 'sillygoose'), 'size' => 48, 'slug' => 'huge'],
    ]);

    add_image_size('hero-large', 1920, 1080, true);
    add_image_size('card-medium', 400, 300, true);
    add_image_size('portfolio-thumb', 350, 250, true);
    add_filter('wp_lazy_loading_enabled', '__return_true');
}
add_action('after_setup_theme', 'sillygoose_setup');

function sillygoose_scripts() {
    $use_min = !WP_DEBUG;
    $suffix = $use_min ? '.min' : '';

    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap', [], null);

    $style_file = SILLYGOOSE_THEME_DIR . '/style' . $suffix . '.css';
    wp_enqueue_style('sillygoose-style', SILLYGOOSE_THEME_URI . '/style' . $suffix . '.css', ['google-fonts'], file_exists($style_file) ? filemtime($style_file) : SILLYGOOSE_VERSION);

    $blocks_file = SILLYGOOSE_THEME_DIR . '/css/custom-blocks' . $suffix . '.css';
    if (file_exists($blocks_file)) {
        wp_enqueue_style('sillygoose-custom-blocks', SILLYGOOSE_THEME_URI . '/css/custom-blocks' . $suffix . '.css', ['sillygoose-style'], filemtime($blocks_file));
    }

    $theme_js = SILLYGOOSE_THEME_DIR . '/js/theme' . $suffix . '.js';
    if (file_exists($theme_js)) {
        wp_enqueue_script('sillygoose-script', SILLYGOOSE_THEME_URI . '/js/theme' . $suffix . '.js', [], filemtime($theme_js), true);
        wp_localize_script('sillygoose-script', 'sillygoose_ajax', ['ajax_url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('sillygoose_nonce')]);
    }

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'sillygoose_scripts');

function sillygoose_widgets_init() {
    $areas = [
        ['name' => esc_html__('Sidebar', 'sillygoose'), 'id' => 'sidebar-1', 'description' => esc_html__('Add widgets here.', 'sillygoose'), 'before_widget' => '<section id="%1$s" class="widget %2$s">', 'after_widget' => '</section>', 'before_title' => '<h2 class="widget-title">', 'after_title' => '</h2>'],
        ['name' => esc_html__('Footer Area 1', 'sillygoose'), 'id' => 'footer-1', 'description' => esc_html__('Footer widget area 1.', 'sillygoose'), 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'],
        ['name' => esc_html__('Footer Area 2', 'sillygoose'), 'id' => 'footer-2', 'description' => esc_html__('Footer widget area 2.', 'sillygoose'), 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'],
        ['name' => esc_html__('Footer Area 3', 'sillygoose'), 'id' => 'footer-3', 'description' => esc_html__('Footer widget area 3.', 'sillygoose'), 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>', 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'],
    ];
    foreach ($areas as $area) register_sidebar($area);
}
add_action('widgets_init', 'sillygoose_widgets_init');

function sillygoose_get_logo() {
    return '<div style="display: flex; align-items: center; gap: 0.75rem;">
        <svg width="40" height="40" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
            <ellipse cx="32" cy="45" rx="18" ry="12" fill="#ff6b35" opacity="0.8" />
            <circle cx="32" cy="28" r="10" fill="#ff6b35" />
            <circle cx="35" cy="26" r="2" fill="white" />
            <circle cx="36" cy="25" r="1" fill="black" />
            <path d="M42 30 Q45 29 46 32 Q45 35 42 34 Q40 32 42 30" fill="#ffd23f" />
            <path d="M20 40 Q18 35 25 38 Q30 40 28 45 Q25 48 20 45 Q18 42 20 40" fill="#4ecdc4" opacity="0.7" />
            <path d="M25 35 Q28 32 32 38" stroke="#ff6b35" stroke-width="2" fill="none" />
            <path d="M32 52 L30 58 M34 58 L32 52 M36 58 M33 57 Q34 58 35 57" stroke="#ff6b35" stroke-width="2" fill="none" />
            <path d="M15 55 Q25 53 35 55 Q30 57 25 56 Q20 57 15 55" stroke="#4ecdc4" stroke-width="1" fill="none" opacity="0.6" />
        </svg>
        <div>
            <div style="font-weight: 900; font-size: 1.25rem; color: var(--primary);">Silly Goose</div>
            <div style="font-size: 0.75rem; color: var(--muted-foreground); margin-top: -0.25rem;">Digital Agency</div>
        </div>
    </div>';
}

function sillygoose_custom_post_types() {
    register_post_type('portfolio', [
        'labels' => ['name' => esc_html__('Portfolio', 'sillygoose'), 'singular_name' => esc_html__('Portfolio Item', 'sillygoose'), 'add_new' => esc_html__('Add New', 'sillygoose'), 'add_new_item' => esc_html__('Add New Portfolio Item', 'sillygoose'), 'edit_item' => esc_html__('Edit Portfolio Item', 'sillygoose')],
        'public' => true, 'has_archive' => true, 'show_in_rest' => true, 'menu_icon' => 'dashicons-portfolio', 'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'], 'rewrite' => ['slug' => 'portfolio']
    ]);

    register_post_type('service', [
        'labels' => ['name' => esc_html__('Services', 'sillygoose'), 'singular_name' => esc_html__('Service', 'sillygoose'), 'add_new' => esc_html__('Add New', 'sillygoose'), 'add_new_item' => esc_html__('Add New Service', 'sillygoose'), 'edit_item' => esc_html__('Edit Service', 'sillygoose')],
        'public' => true, 'has_archive' => true, 'show_in_rest' => true, 'menu_icon' => 'dashicons-admin-tools', 'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'], 'rewrite' => ['slug' => 'services']
    ]);
}
add_action('init', 'sillygoose_custom_post_types');

function sillygoose_customize_register($wp_customize) {
    $wp_customize->add_section('sillygoose_contact', ['title' => esc_html__('Contact Information', 'sillygoose'), 'priority' => 40]);

    $contacts = [
        'contact_email' => ['default' => 'hello@sillygoose.agency', 'sanitize' => 'sanitize_email', 'type' => 'email', 'label' => 'Email Address'],
        'contact_phone' => ['default' => '+44 1752 123456', 'sanitize' => 'sanitize_text_field', 'type' => 'text', 'label' => 'Phone Number'],
        'contact_location' => ['default' => 'Plymouth, United Kingdom', 'sanitize' => 'sanitize_text_field', 'type' => 'text', 'label' => 'Location']
    ];

    foreach ($contacts as $key => $contact) {
        $wp_customize->add_setting($key, ['default' => $contact['default'], 'sanitize_callback' => $contact['sanitize']]);
        $wp_customize->add_control($key, ['label' => esc_html__($contact['label'], 'sillygoose'), 'section' => 'sillygoose_contact', 'type' => $contact['type']]);
    }

    $wp_customize->add_section('sillygoose_social', ['title' => esc_html__('Social Media', 'sillygoose'), 'priority' => 41]);
    foreach (['facebook', 'twitter', 'instagram', 'linkedin', 'youtube'] as $platform) {
        $wp_customize->add_setting('social_' . $platform, ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
        $wp_customize->add_control('social_' . $platform, ['label' => ucfirst($platform) . ' ' . esc_html__('URL', 'sillygoose'), 'section' => 'sillygoose_social', 'type' => 'url']);
    }
}
add_action('customize_register', 'sillygoose_customize_register');

function sillygoose_handle_contact_form() {
    if (isset($_POST['sillygoose_contact_nonce']) && wp_verify_nonce($_POST['sillygoose_contact_nonce'], 'sillygoose_contact_form')) {
        $to = get_option('admin_email');
        $name = sanitize_text_field($_POST['contact_name']);
        $email = sanitize_email($_POST['contact_email']);
        $subject = 'New Contact Form Submission from ' . $name;
        $body = "Name: $name\nEmail: $email\nProject Type: " . sanitize_text_field($_POST['contact_project']) . "\nBudget: " . sanitize_text_field($_POST['contact_budget']) . "\nMessage: " . sanitize_textarea_field($_POST['contact_message']);

        wp_redirect(add_query_arg('contact', wp_mail($to, $subject, $body, ['Content-Type: text/plain; charset=UTF-8']) ? 'success' : 'error', home_url()));
        exit;
    }
}
add_action('admin_post_nopriv_sillygoose_contact', 'sillygoose_handle_contact_form');
add_action('admin_post_sillygoose_contact', 'sillygoose_handle_contact_form');

function sillygoose_get_option($option, $default = '') {
    return get_theme_mod($option, $default);
}

function sillygoose_fallback_menu() {
    echo '<ul id="primary-menu" class="nav-menu">';
    foreach (['' => 'Home', '/#about' => 'About', '/#services' => 'Services', '/#work' => 'Work', '/#contact' => 'Contact'] as $url => $label) {
        echo '<li><a href="' . esc_url(home_url($url)) . '">' . esc_html__($label, 'sillygoose') . '</a></li>';
    }
    echo '</ul>';
}

function sillygoose_admin_bar_style() {
    if (is_admin_bar_showing()) {
        echo '<style>.admin-bar .header{top:32px}@media(max-width:782px){.admin-bar .header{top:46px}}</style>';
    }
}
add_action('wp_head', 'sillygoose_admin_bar_style');

function sillygoose_security() {
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    add_filter('xmlrpc_enabled', '__return_false');
    add_action('send_headers', function() {
        if (!is_admin()) {
            header('X-Content-Type-Options: nosniff');
            header('X-Frame-Options: SAMEORIGIN');
            header('X-XSS-Protection: 1; mode=block');
            header('Referrer-Policy: strict-origin-when-cross-origin');
        }
    });
}
add_action('init', 'sillygoose_security');

function sillygoose_accessibility() {
    add_action('wp_footer', function() {
        if (!is_admin()) echo '<script>document.addEventListener("keydown",e=>{"Tab"===e.key&&document.body.classList.add("keyboard-navigation")});document.addEventListener("mousedown",()=>document.body.classList.remove("keyboard-navigation"));</script>';
    });
}
add_action('wp_enqueue_scripts', 'sillygoose_accessibility');

function sillygoose_optimize_wordpress() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    if (!defined('WP_POST_REVISIONS')) define('WP_POST_REVISIONS', 3);
}
add_action('init', 'sillygoose_optimize_wordpress');

function sillygoose_render_block_wrapper($block_content, $block) {
    if (is_admin() || empty($block_content)) return $block_content;

    $classes = $styles = [];

    if (isset($block['blockName']) && strpos($block['blockName'], 'sillygoose/') === 0) {
        if (isset($block['attrs']['containerWidth'])) {
            $classes[] = ($block['attrs']['containerWidth'] === 'full') ? 'sg-container-full' : 'sg-container-centered';
        }

        if ($block['blockName'] === 'sillygoose/hero-block') {
            $classes[] = 'sg-hero-block';
            if (!empty($block['attrs']['heroBackground'])) {
                $styles[] = 'background-image: url(' . esc_url($block['attrs']['heroBackground']) . ')';
                if (isset($block['attrs']['heroOverlay'])) $styles[] = '--overlay-opacity: ' . floatval($block['attrs']['heroOverlay']);
            }
        }
    }

    if (!empty($classes) || !empty($styles)) {
        $class_attr = !empty($classes) ? ' class="' . esc_attr(implode(' ', $classes)) . '"' : '';
        $style_attr = !empty($styles) ? ' style="' . esc_attr(implode('; ', $styles)) . '"' : '';
        $block_content = '<div' . $class_attr . $style_attr . '>' . $block_content . '</div>';

        if (in_array('sg-hero-block', $classes)) {
            $block_content = str_replace('<div' . $class_attr . $style_attr . '>', '<div' . $class_attr . $style_attr . '><div class="sg-hero-overlay"></div><div class="sg-hero-content">', $block_content) . '</div>';
        }
    }

    return $block_content;
}
add_filter('render_block', 'sillygoose_render_block_wrapper', 10, 2);

$includes = ['/templates/custom-posts.php', '/templates/homepage-blocks.php', '/includes/statistics-block.php', '/includes/card-block.php', '/includes/hero-block.php'];
foreach ($includes as $file) {
    if (file_exists(SILLYGOOSE_THEME_DIR . $file)) require_once SILLYGOOSE_THEME_DIR . $file;
}

function sillygoose_block_editor_assets() {
    $blocks = ['blocks' => ['wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n'], 'card-block' => ['wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n', 'wp-data'], 'hero-block' => ['wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n'], 'statistics-block' => ['wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n'], 'block-extensions' => ['wp-hooks', 'wp-edit-post', 'wp-element', 'wp-components', 'wp-compose']];

    foreach ($blocks as $name => $deps) {
        $file = get_template_directory() . '/js/' . $name . '.js';
        if (file_exists($file)) {
            wp_enqueue_script('sillygoose-' . $name, get_template_directory_uri() . '/js/' . $name . '.js', $deps, filemtime($file), true);
            wp_set_script_translations('sillygoose-' . $name, 'sillygoose');
        }
    }
}
add_action('enqueue_block_editor_assets', 'sillygoose_block_editor_assets');

function sillygoose_block_categories($categories) {
    return array_merge($categories, [['slug' => 'sillygoose', 'title' => __('Silly Goose Blocks', 'sillygoose'), 'icon' => 'admin-customizer']]);
}
add_filter('block_categories_all', 'sillygoose_block_categories', 10, 2);

function sillygoose_register_block_attributes() {
    register_block_type('sillygoose/hero', ['attributes' => ['titleTag' => ['type' => 'string', 'default' => 'h1'], 'subtitleTag' => ['type' => 'string', 'default' => 'h2'], 'heroBackground' => ['type' => 'string', 'default' => ''], 'heroOverlay' => ['type' => 'number', 'default' => 0.1], 'containerWidth' => ['type' => 'string', 'default' => 'centered']]]);
    register_block_type('sillygoose/card-block', ['attributes' => ['postType' => ['type' => 'string', 'default' => 'portfolio'], 'numberOfPosts' => ['type' => 'number', 'default' => 3], 'title' => ['type' => 'string', 'default' => ''], 'description' => ['type' => 'string', 'default' => ''], 'titleTag' => ['type' => 'string', 'default' => 'h2'], 'containerWidth' => ['type' => 'string', 'default' => 'centered']]]);
    register_block_type('sillygoose/statistics', ['attributes' => ['statistics' => ['type' => 'array', 'default' => [['statText' => '150+', 'description' => 'Projects Completed'], ['statText' => '50+', 'description' => 'Happy Clients'], ['statText' => '5★', 'description' => 'Average Rating']]], 'backgroundColor' => ['type' => 'string', 'default' => 'muted'], 'containerWidth' => ['type' => 'string', 'default' => 'contained']]]);

    foreach (['core/group', 'core/columns', 'core/cover', 'core/media-text', 'core/gallery', 'core/image', 'core/video', 'core/quote', 'core/table', 'core/buttons'] as $block) {
        register_block_type($block, ['attributes' => ['containerWidth' => ['type' => 'string', 'default' => 'centered']]]);
    }
}
add_action('init', 'sillygoose_register_block_attributes');

function sillygoose_force_rest_api_support() {
    global $wp_post_types;
    if (isset($wp_post_types['portfolio'])) {
        $wp_post_types['portfolio']->show_in_rest = true;
        $wp_post_types['portfolio']->rest_base = 'portfolio';
    }
    if (isset($wp_post_types['service'])) {
        $wp_post_types['service']->show_in_rest = true;
        $wp_post_types['service']->rest_base = 'service';
    }
}
add_action('init', 'sillygoose_force_rest_api_support', 99);

function sillygoose_register_custom_fields() {
    foreach (['portfolio', 'service'] as $type) {
        register_meta('post', $type . '_category', ['post_type' => $type, 'type' => 'string', 'single' => true, 'show_in_rest' => true]);
        register_meta('post', $type . '_result', ['post_type' => $type, 'type' => 'string', 'single' => true, 'show_in_rest' => true]);
    }
}
add_action('init', 'sillygoose_register_custom_fields');

function sillygoose_get_social_icon($platform) {
    $icons = [
        'facebook' => '<svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
        'twitter' => '<svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>',
        'instagram' => '<svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>',
        'linkedin' => '<svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
    ];
    return isset($icons[$platform]) ? $icons[$platform] : '';
}

function sillygoose_handle_newsletter_signup() {
    if (!wp_verify_nonce($_POST['newsletter_nonce'], 'sillygoose_newsletter')) wp_die(__('Security check failed', 'sillygoose'));
    $email = sanitize_email($_POST['newsletter_email']);
    if (!is_email($email)) {
        wp_redirect(add_query_arg('newsletter', 'invalid', wp_get_referer()));
        exit;
    }
    wp_mail(get_option('admin_email'), sprintf(__('New newsletter signup: %s', 'sillygoose'), $email), sprintf(__('New newsletter signup from: %s', 'sillygoose'), $email));
    wp_redirect(add_query_arg('newsletter', 'success', wp_get_referer()));
    exit;
}
add_action('admin_post_sillygoose_newsletter_signup', 'sillygoose_handle_newsletter_signup');
add_action('admin_post_nopriv_sillygoose_newsletter_signup', 'sillygoose_handle_newsletter_signup');

function sillygoose_newsletter_messages() {
    if (isset($_GET['newsletter'])) {
        $type = sanitize_text_field($_GET['newsletter']);
        $class = $type === 'success' ? 'success' : 'error';
        $bg = $type === 'success' ? '#4ade80' : '#ef4444';
        $msg = $type === 'success' ? __('Thank you for subscribing to our newsletter!', 'sillygoose') : __('Please enter a valid email address.', 'sillygoose');
        echo '<div class="newsletter-message ' . $class . '" style="background:' . $bg . ';color:white;padding:1rem;border-radius:0.5rem;margin:1rem 0;text-align:center">' . esc_html($msg) . '</div>';
    }
}
add_action('wp_footer', 'sillygoose_newsletter_messages');

if (WP_DEBUG && function_exists('current_user_can') && current_user_can('administrator')) {
    add_action('wp_footer', function() {
        echo "\n<!-- " . get_num_queries() . " queries in " . timer_stop(0, 3) . "s -->\n";
        if (isset($_GET['debug_perf']) && 'performance' in window) {
            echo '<script>window.addEventListener("load",()=>{const n=performance.getEntriesByType("navigation")[0];console.log("🦆 Performance:",{LoadTime:(n.loadEventEnd-n.loadEventStart)+"ms",DOMContentLoaded:(n.domContentLoadedEventEnd-n.domContentLoadedEventStart)+"ms"})});</script>';
        }
    });
}