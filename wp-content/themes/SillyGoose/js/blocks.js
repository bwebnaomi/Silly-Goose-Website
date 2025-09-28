<?php
/**
 * Silly Goose Theme Functions
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function sillygoose_setup() {
    // Add theme support for various features
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('custom-logo');
    add_theme_support('customize-selective-refresh-widgets');

    // Block editor support
    add_theme_support('wp-block-styles');
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');
    add_theme_support('editor-styles');
    add_editor_style('css/block-editor.css');

    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'sillygoose'),
        'footer' => esc_html__('Footer Menu', 'sillygoose'),
    ));

    // Custom color palette for block editor
    add_theme_support('editor-color-palette', array(
        array(
            'name'  => __('Primary Orange', 'sillygoose'),
            'slug'  => 'primary',
            'color' => '#ff6b35',
        ),
        array(
            'name'  => __('Secondary Teal', 'sillygoose'),
            'slug'  => 'secondary',
            'color' => '#4ecdc4',
        ),
        array(
            'name'  => __('Accent Yellow', 'sillygoose'),
            'slug'  => 'accent',
            'color' => '#ffd23f',
        ),
        array(
            'name'  => __('Muted Gray', 'sillygoose'),
            'slug'  => 'muted',
            'color' => '#f8f9fa',
        ),
        array(
            'name'  => __('Foreground', 'sillygoose'),
            'slug'  => 'foreground',
            'color' => '#212529',
        ),
    ));

    // Custom font sizes
    add_theme_support('editor-font-sizes', array(
        array(
            'name' => __('Small', 'sillygoose'),
            'size' => 14,
            'slug' => 'small'
        ),
        array(
            'name' => __('Normal', 'sillygoose'),
            'size' => 16,
            'slug' => 'normal'
        ),
        array(
            'name' => __('Large', 'sillygoose'),
            'size' => 24,
            'slug' => 'large'
        ),
        array(
            'name' => __('Huge', 'sillygoose'),
            'size' => 48,
            'slug' => 'huge'
        )
    ));
}
add_action('after_setup_theme', 'sillygoose_setup');

/**
 * Enqueue Scripts and Styles
 */
function sillygoose_scripts() {
    // Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap', array(), null);
    
    // Main theme stylesheet
    wp_enqueue_style('sillygoose-style', get_stylesheet_uri(), array('google-fonts'), '1.0.1');
    
    // Theme JavaScript (only if file exists)
    if (file_exists(get_template_directory() . '/js/theme.js')) {
        wp_enqueue_script('sillygoose-script', get_template_directory_uri() . '/js/theme.js', array(), '1.0.1', true);
    }
    
    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'sillygoose_scripts');

/**
 * Add CSS Variables in Header
 */
function sillygoose_add_css_variables() {
    ?>
    <style>
        :root {
            --primary: #ff6b35;
            --secondary: #4ecdc4;
            --accent: #ffd23f;
            --muted: #f8f9fa;
            --muted-foreground: #6c757d;
            --foreground: #212529;
            --background: #ffffff;
            --card: #ffffff;
            --border: #dee2e6;
            --radius: 0.5rem;
        }
        
        /* Block width utilities */
        .sg-container-centered {
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .sg-container-full {
            width: 100%;
            max-width: none;
        }
        
        /* Hero block styles */
        .sg-hero-block {
            position: relative;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        
        .sg-hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, var(--overlay-opacity, 0.1));
        }
        
        .sg-hero-content {
            position: relative;
            z-index: 2;
        }
    </style>
    <?php
}
add_action('wp_head', 'sillygoose_add_css_variables', 1);

/**
 * Register Widget Areas
 */
function sillygoose_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Sidebar', 'sillygoose'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here.', 'sillygoose'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'sillygoose_widgets_init');

/**
 * Custom Logo Function
 */
function sillygoose_get_logo() {
    if (has_custom_logo()) {
        return get_custom_logo();
    } else {
        return sillygoose_default_logo();
    }
}

/**
 * Default Goose Logo SVG
 */
function sillygoose_default_logo() {
    return '
    <div class="flex items-center gap-2">
        <svg viewBox="0 0 60 60" style="height: 2rem; width: 2rem;" fill="none" xmlns="http://www.w3.org/2000/svg">
            <ellipse cx="30" cy="38" rx="12" ry="18" fill="#4ecdc4" />
            <path d="M30 20 Q25 15 22 12 Q20 10 18 12 Q16 14 18 16 Q20 18 25 20 Q28 22 30 20" fill="#4ecdc4" />
            <ellipse cx="18" cy="14" rx="6" ry="8" fill="#4ecdc4" />
            <path d="M12 14 L6 13 L12 12 Q14 13 12 14" fill="#ff6b35" />
            <circle cx="20" cy="12" r="1.5" fill="#000" />
            <circle cx="20.5" cy="11.5" r="0.5" fill="#fff" />
            <path d="M35 32 Q42 28 44 35 Q42 42 35 40 Q32 36 35 32" fill="#ffd23f" />
            <path d="M36 34 Q40 32 41 36 Q40 38 36 37" fill="#ff6b35" />
            <path d="M18 45 Q15 50 12 48 Q15 46 18 45" fill="#ffd23f" />
            <path d="M20 46 Q17 51 14 49 Q17 47 20 46" fill="#4ecdc4" />
            <path d="M24 52 L22 58 M26 58 L24 52 M28 58 M25 57 Q26 58 27 57" stroke="#ff6b35" stroke-width="2" fill="none" />
            <path d="M32 52 L30 58 M34 58 L32 52 M36 58 M33 57 Q34 58 35 57" stroke="#ff6b35" stroke-width="2" fill="none" />
            <path d="M15 55 Q25 53 35 55 Q30 57 25 56 Q20 57 15 55" stroke="#4ecdc4" stroke-width="1" fill="none" opacity="0.6" />
        </svg>
        <div>
            <div style="font-weight: 900; font-size: 1.25rem; color: var(--primary);">Silly Goose</div>
            <div style="font-size: 0.75rem; color: var(--muted-foreground); margin-top: -0.25rem;">Digital Agency</div>
        </div>
    </div>';
}

/**
 * Get Customizer Setting
 */
function sillygoose_get_option($option, $default = '') {
    return get_theme_mod($option, $default);
}

/**
 * Customizer Settings
 */
function sillygoose_customize_register($wp_customize) {
    // Contact Information
    $wp_customize->add_section('sillygoose_contact', array(
        'title'    => esc_html__('Contact Information', 'sillygoose'),
        'priority' => 40,
    ));

    $wp_customize->add_setting('contact_email', array(
        'default'           => 'hello@sillygoose.agency',
        'sanitize_callback' => 'sanitize_email',
    ));

    $wp_customize->add_control('contact_email', array(
        'label'   => esc_html__('Email Address', 'sillygoose'),
        'section' => 'sillygoose_contact',
        'type'    => 'email',
    ));

    $wp_customize->add_setting('contact_phone', array(
        'default'           => '+44 1752 SILLY-GOOSE',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('contact_phone', array(
        'label'   => esc_html__('Phone Number', 'sillygoose'),
        'section' => 'sillygoose_contact',
        'type'    => 'text',
    ));

    $wp_customize->add_setting('contact_location', array(
        'default'           => 'Plymouth, UK',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('contact_location', array(
        'label'   => esc_html__('Location', 'sillygoose'),
        'section' => 'sillygoose_contact',
        'type'    => 'text',
    ));
}
add_action('customize_register', 'sillygoose_customize_register');

/**
 * Admin Bar Spacing
 */
function sillygoose_admin_bar_style() {
    if (is_admin_bar_showing()) {
        echo '<style>
            .admin-bar .header { top: 32px; }
            @media (max-width: 782px) { 
                .admin-bar .header { top: 46px; } 
            }
        </style>';
    }
}
add_action('wp_head', 'sillygoose_admin_bar_style');

/**
 * Contact Form Handler
 */
function sillygoose_handle_contact_form() {
    if (isset($_POST['sillygoose_contact_nonce']) && wp_verify_nonce($_POST['sillygoose_contact_nonce'], 'sillygoose_contact_form')) {
        $name = sanitize_text_field($_POST['contact_name']);
        $email = sanitize_email($_POST['contact_email']);
        $project = sanitize_text_field($_POST['contact_project']);
        $budget = sanitize_text_field($_POST['contact_budget']);
        $message = sanitize_textarea_field($_POST['contact_message']);

        $to = get_option('admin_email');
        $subject = 'New Contact Form Submission from ' . $name;
        $body = "Name: $name\n";
        $body .= "Email: $email\n";
        $body .= "Project Type: $project\n";
        $body .= "Budget: $budget\n";
        $body .= "Message: $message\n";

        $headers = array('Content-Type: text/plain; charset=UTF-8');
        
        if (wp_mail($to, $subject, $body, $headers)) {
            wp_redirect(add_query_arg('contact', 'success', home_url()));
            exit;
        } else {
            wp_redirect(add_query_arg('contact', 'error', home_url()));
            exit;
        }
    }
}
add_action('admin_post_nopriv_sillygoose_contact', 'sillygoose_handle_contact_form');
add_action('admin_post_sillygoose_contact', 'sillygoose_handle_contact_form');

/**
 * Include organized template files
 */
require_once get_template_directory() . '/templates/custom-posts.php';
require_once get_template_directory() . '/templates/homepage-blocks.php';

/**
 * Enqueue block editor assets
 */
function sillygoose_block_editor_assets() {
    wp_enqueue_script(
        'sillygoose-blocks',
        get_template_directory_uri() . '/js/blocks.js',
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n'),
        '1.0.3',
        true
    );
    
    // Enqueue block editor extensions
    wp_enqueue_script(
        'sillygoose-block-extensions',
        get_template_directory_uri() . '/js/block-extensions.js',
        array('wp-hooks', 'wp-edit-post', 'wp-element', 'wp-components', 'wp-compose'),
        '1.0.1',
        true
    );
    
    // Add translations
    wp_set_script_translations('sillygoose-blocks', 'sillygoose');
    wp_set_script_translations('sillygoose-block-extensions', 'sillygoose');
}
add_action('enqueue_block_editor_assets', 'sillygoose_block_editor_assets');

/**
 * Register block attributes for typography, hero background, and width controls
 */
function sillygoose_register_block_attributes() {
    // Typography attributes for heading blocks
    $typography_blocks = array(
        'core/heading',
        'core/paragraph',
        'sillygoose/hero', // Your custom hero block
    );
    
    foreach ($typography_blocks as $block_name) {
        register_block_type($block_name, array(
            'attributes' => array(
                'titleTag' => array(
                    'type' => 'string',
                    'default' => 'h1',
                ),
                'subtitleTag' => array(
                    'type' => 'string',
                    'default' => 'h2',
                ),
                'heroBackground' => array(
                    'type' => 'string',
                    'default' => '',
                ),
                'heroOverlay' => array(
                    'type' => 'number',
                    'default' => 0.1,
                ),
                'containerWidth' => array(
                    'type' => 'string',
                    'default' => 'centered',
                ),
            ),
        ));
    }
    
    // Width control for all other blocks (excluding hero)
    $width_blocks = array(
        'core/group',
        'core/columns',
        'core/cover',
        'core/media-text',
        'core/gallery',
        'core/image',
        'core/video',
        'core/audio',
        'core/file',
        'core/quote',
        'core/pullquote',
        'core/table',
        'core/verse',
        'core/code',
        'core/preformatted',
        'core/embed',
        'core/separator',
        'core/spacer',
        'core/buttons',
        'core/list',
        'sillygoose/projects',
        'sillygoose/services',
        'sillygoose/testimonials',
        'sillygoose/contact-form',
    );
    
    foreach ($width_blocks as $block_name) {
        register_block_type($block_name, array(
            'attributes' => array(
                'containerWidth' => array(
                    'type' => 'string',
                    'default' => 'centered',
                ),
            ),
        ));
    }
}
add_action('init', 'sillygoose_register_block_attributes');

/**
 * Add block wrapper classes based on attributes
 */
function sillygoose_add_block_wrapper_classes($block_content, $block) {
    // Skip if no content or not supported block
    if (empty($block_content) || empty($block['blockName'])) {
        return $block_content;
    }
    
    $classes = array();
    $styles = array();
    
    // Handle custom sillygoose blocks with blockWidth attribute
    if (strpos($block['blockName'], 'sillygoose/') === 0) {
        if (isset($block['attrs']['blockWidth'])) {
            $width = $block['attrs']['blockWidth'];
            if ($width === 'full') {
                $classes[] = 'sg-container-full';
            } else {
                $classes[] = 'sg-container-centered';
            }
        }
        
        // Add hero background styles for hero block
        if ($block['blockName'] === 'sillygoose/hero') {
            if (isset($block['attrs']['heroBackground']) && !empty($block['attrs']['heroBackground'])) {
                $classes[] = 'sg-hero-block';
                $styles[] = 'background-image: url(' . esc_url($block['attrs']['heroBackground']) . ')';
                
                if (isset($block['attrs']['heroOverlay'])) {
                    $styles[] = '--overlay-opacity: ' . floatval($block['attrs']['heroOverlay']);
                }
            }
        }
    } 
    // Handle core WordPress blocks with containerWidth attribute (from extensions)
    else {
        if (isset($block['attrs']['containerWidth'])) {
            $width = $block['attrs']['containerWidth'];
            if ($width === 'full') {
                $classes[] = 'sg-container-full';
            } else {
                $classes[] = 'sg-container-centered';
            }
        }
    }
    
    // Apply classes and styles if any
    if (!empty($classes) || !empty($styles)) {
        $class_attr = !empty($classes) ? ' class="' . esc_attr(implode(' ', $classes)) . '"' : '';
        $style_attr = !empty($styles) ? ' style="' . esc_attr(implode('; ', $styles)) . '"' : '';
        
        // Wrap the block content with our container
        $block_content = '<div' . $class_attr . $style_attr . '>' . $block_content . '</div>';
        
        // Add overlay for hero blocks
        if (in_array('sg-hero-block', $classes)) {
            $block_content = str_replace(
                '<div' . $class_attr . $style_attr . '>',
                '<div' . $class_attr . $style_attr . '><div class="sg-hero-overlay"></div><div class="sg-hero-content">',
                $block_content
            );
            $block_content .= '</div>';
        }
    }
    
    return $block_content;
}
add_filter('render_block', 'sillygoose_add_block_wrapper_classes', 10, 2);

/**
 * Ensure custom post types are available
 */
function sillygoose_ensure_custom_posts_available() {
    // Make sure custom post types are available in REST API for blocks
    global $wp_post_types;
    
    if (isset($wp_post_types['projects'])) {
        $wp_post_types['projects']->show_in_rest = true;
    }
    
    if (isset($wp_post_types['services'])) {
        $wp_post_types['services']->show_in_rest = true;
    }
    
    if (isset($wp_post_types['testimonials'])) {
        $wp_post_types['testimonials']->show_in_rest = true;
    }
}
add_action('init', 'sillygoose_ensure_custom_posts_available', 20);

/**
 * Add block editor styles
 */
function sillygoose_add_editor_styles() {
    add_theme_support('editor-styles');
    add_editor_style('style.css');
}
add_action('after_setup_theme', 'sillygoose_add_editor_styles');

/**
 * Remove "Edit Home Page" from admin bar
 */
function sillygoose_remove_admin_bar_edit_link() {
    global $wp_admin_bar;
    if (is_front_page() || is_home()) {
        $wp_admin_bar->remove_node('edit');
    }
}
add_action('wp_before_admin_bar_render', 'sillygoose_remove_admin_bar_edit_link');

// REMOVED: Page-level meta boxes for hero background and typography
// These settings are now handled at the block level

/**
 * Helper functions for backward compatibility
 */
function sillygoose_get_title_tag($post_id = null) {
    // This is now handled at block level
    return 'h1';
}

function sillygoose_get_subtitle_tag($post_id = null) {
    // This is now handled at block level
    return 'h2';
}

function sillygoose_get_hero_bg_image($post_id = null) {
    // This is now handled at block level
    return '';
}

function sillygoose_get_hero_bg_overlay($post_id = null) {
    // This is now handled at block level
    return '0.1';
}