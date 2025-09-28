<?php
/**
 * Silly Goose Theme Functions
 * Complete version with all features restored + optimizations
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Theme constants
define('SILLYGOOSE_VERSION', '1.0.4');
define('SILLYGOOSE_THEME_DIR', get_template_directory());
define('SILLYGOOSE_THEME_URI', get_template_directory_uri());

/**
 * Theme Setup - Consolidated and optimized
 */
function sillygoose_setup() {
    // Core theme support
    $supports = [
        'title-tag',
        'post-thumbnails', 
        'custom-logo',
        'wp-block-styles',
        'responsive-embeds',
        'align-wide',
        'editor-styles',
        'customize-selective-refresh-widgets'
    ];
    
    foreach ($supports as $support) {
        add_theme_support($support);
    }
    
    // HTML5 support
    add_theme_support('html5', [
        'search-form',
        'comment-form', 
        'comment-list',
        'gallery',
        'caption'
    ]);
    
    // Navigation menus
    register_nav_menus([
        'primary' => esc_html__('Primary Menu', 'sillygoose'),
        'footer'  => esc_html__('Footer Menu', 'sillygoose'),
    ]);
    
    // Editor styles
    add_editor_style('css/block-editor.css');
    
    // Set up editor settings
    sillygoose_editor_settings();
    
    // Image optimization
    sillygoose_image_optimization();
}
add_action('after_setup_theme', 'sillygoose_setup');

/**
 * Editor color palette and font sizes
 */
function sillygoose_editor_settings() {
    // Custom color palette for block editor
    add_theme_support('editor-color-palette', [
        [
            'name'  => __('Primary Orange', 'sillygoose'),
            'slug'  => 'primary',
            'color' => '#ff6b35',
        ],
        [
            'name'  => __('Secondary Teal', 'sillygoose'),
            'slug'  => 'secondary',
            'color' => '#4ecdc4',
        ],
        [
            'name'  => __('Accent Yellow', 'sillygoose'),
            'slug'  => 'accent',
            'color' => '#ffd23f',
        ],
        [
            'name'  => __('Muted Gray', 'sillygoose'),
            'slug'  => 'muted',
            'color' => '#f8f9fa',
        ],
        [
            'name'  => __('Foreground', 'sillygoose'),
            'slug'  => 'foreground',
            'color' => '#212529',
        ],
        [
            'name'  => __('White', 'sillygoose'),
            'slug'  => 'white',
            'color' => '#ffffff',
        ],
    ]);

    // Custom font sizes
    add_theme_support('editor-font-sizes', [
        [
            'name'      => __('Small', 'sillygoose'),
            'shortName' => __('S', 'sillygoose'),
            'size'      => 14,
            'slug'      => 'small'
        ],
        [
            'name'      => __('Normal', 'sillygoose'),
            'shortName' => __('M', 'sillygoose'),
            'size'      => 16,
            'slug'      => 'normal'
        ],
        [
            'name'      => __('Large', 'sillygoose'),
            'shortName' => __('L', 'sillygoose'),
            'size'      => 24,
            'slug'      => 'large'
        ],
        [
            'name'      => __('Extra Large', 'sillygoose'),
            'shortName' => __('XL', 'sillygoose'),
            'size'      => 32,
            'slug'      => 'extra-large'
        ],
        [
            'name'      => __('Huge', 'sillygoose'),
            'shortName' => __('XXL', 'sillygoose'),
            'size'      => 48,
            'slug'      => 'huge'
        ],
    ]);
}

/**
 * Image optimization and responsive images
 */
function sillygoose_image_optimization() {
    // Add custom image sizes
    add_image_size('hero-large', 1920, 1080, true);
    add_image_size('card-medium', 400, 300, true);
    add_image_size('portfolio-thumb', 350, 250, true);
    
    // Enable lazy loading for images
    add_filter('wp_lazy_loading_enabled', '__return_true');
}

/**
 * Enqueue Scripts and Styles - Optimized loading order
 */
function sillygoose_scripts() {
    // Google Fonts - Load first with font-display swap
    wp_enqueue_style(
        'google-fonts', 
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap', 
        [], 
        null
    );
    
    // Main theme stylesheet with file-based versioning
    wp_enqueue_style(
        'sillygoose-style', 
        get_stylesheet_uri(), 
        ['google-fonts'], 
        filemtime(SILLYGOOSE_THEME_DIR . '/style.css')
    );
    
    // Custom blocks CSS - only if file exists
    $custom_blocks_file = SILLYGOOSE_THEME_DIR . '/css/custom-blocks.css';
    if (file_exists($custom_blocks_file)) {
        wp_enqueue_style(
            'sillygoose-custom-blocks',
            SILLYGOOSE_THEME_URI . '/css/custom-blocks.css',
            ['sillygoose-style'],
            filemtime($custom_blocks_file)
        );
    }
    
    // Theme JavaScript - Load in footer with proper versioning
    $theme_js_file = SILLYGOOSE_THEME_DIR . '/js/theme.js';
    if (file_exists($theme_js_file)) {
        wp_enqueue_script(
            'sillygoose-script', 
            SILLYGOOSE_THEME_URI . '/js/theme.js', 
            [], 
            filemtime($theme_js_file), 
            true // Load in footer
        );
        
        // Localize script for AJAX if needed
        wp_localize_script('sillygoose-script', 'sillygoose_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('sillygoose_nonce')
        ]);
    }
    
    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'sillygoose_scripts');

/**
 * Register Widget Areas
 */
function sillygoose_widgets_init() {
    $widget_areas = [
        [
            'name'          => esc_html__('Sidebar', 'sillygoose'),
            'id'            => 'sidebar-1',
            'description'   => esc_html__('Add widgets here.', 'sillygoose'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ],
        [
            'name'          => esc_html__('Footer Area 1', 'sillygoose'),
            'id'            => 'footer-1',
            'description'   => esc_html__('Footer widget area 1.', 'sillygoose'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        ],
        [
            'name'          => esc_html__('Footer Area 2', 'sillygoose'),
            'id'            => 'footer-2',
            'description'   => esc_html__('Footer widget area 2.', 'sillygoose'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        ],
        [
            'name'          => esc_html__('Footer Area 3', 'sillygoose'),
            'id'            => 'footer-3',
            'description'   => esc_html__('Footer widget area 3.', 'sillygoose'),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        ],
    ];
    
    foreach ($widget_areas as $widget_area) {
        register_sidebar($widget_area);
    }
}
add_action('widgets_init', 'sillygoose_widgets_init');

/**
 * RESTORED: Logo Function
 */
function sillygoose_get_logo() {
    return '<div style="display: flex; align-items: center; gap: 0.75rem;">
        <svg width="40" height="40" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- Goose body -->
            <ellipse cx="32" cy="45" rx="18" ry="12" fill="#ff6b35" opacity="0.8" />
            <!-- Goose head -->
            <circle cx="32" cy="28" r="10" fill="#ff6b35" />
            <!-- Eye -->
            <circle cx="35" cy="26" r="2" fill="white" />
            <circle cx="36" cy="25" r="1" fill="black" />
            <!-- Beak -->
            <path d="M42 30 Q45 29 46 32 Q45 35 42 34 Q40 32 42 30" fill="#ffd23f" />
            <!-- Wing -->
            <path d="M20 40 Q18 35 25 38 Q30 40 28 45 Q25 48 20 45 Q18 42 20 40" fill="#4ecdc4" opacity="0.7" />
            <!-- Neck curve -->
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

/**
 * RESTORED: Custom Post Types for Portfolio and Services
 */
function sillygoose_custom_post_types() {
    // Portfolio Post Type
    register_post_type('portfolio', [
        'labels' => [
            'name'               => esc_html__('Portfolio', 'sillygoose'),
            'singular_name'      => esc_html__('Portfolio Item', 'sillygoose'),
            'add_new'            => esc_html__('Add New', 'sillygoose'),
            'add_new_item'       => esc_html__('Add New Portfolio Item', 'sillygoose'),
            'edit_item'          => esc_html__('Edit Portfolio Item', 'sillygoose'),
            'new_item'           => esc_html__('New Portfolio Item', 'sillygoose'),
            'view_item'          => esc_html__('View Portfolio Item', 'sillygoose'),
            'search_items'       => esc_html__('Search Portfolio', 'sillygoose'),
            'not_found'          => esc_html__('No portfolio items found', 'sillygoose'),
            'not_found_in_trash' => esc_html__('No portfolio items found in trash', 'sillygoose'),
        ],
        'public'             => true,
        'has_archive'        => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'portfolio'],
        'capability_type'    => 'post',
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'show_in_rest'       => true,
    ]);

    // Service Post Type
    register_post_type('service', [
        'labels' => [
            'name'               => esc_html__('Services', 'sillygoose'),
            'singular_name'      => esc_html__('Service', 'sillygoose'),
            'add_new'            => esc_html__('Add New', 'sillygoose'),
            'add_new_item'       => esc_html__('Add New Service', 'sillygoose'),
            'edit_item'          => esc_html__('Edit Service', 'sillygoose'),
            'new_item'           => esc_html__('New Service', 'sillygoose'),
            'view_item'          => esc_html__('View Service', 'sillygoose'),
            'search_items'       => esc_html__('Search Services', 'sillygoose'),
            'not_found'          => esc_html__('No services found', 'sillygoose'),
            'not_found_in_trash' => esc_html__('No services found in trash', 'sillygoose'),
        ],
        'public'             => true,
        'has_archive'        => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => ['slug' => 'services'],
        'capability_type'    => 'post',
        'hierarchical'       => false,
        'menu_position'      => 21,
        'menu_icon'          => 'dashicons-admin-tools',
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'show_in_rest'       => true,
    ]);
}
add_action('init', 'sillygoose_custom_post_types');

/**
 * RESTORED: Customizer Settings
 */
function sillygoose_customize_register($wp_customize) {
    // Contact Information Section
    $wp_customize->add_section('sillygoose_contact', [
        'title'    => esc_html__('Contact Information', 'sillygoose'),
        'priority' => 40,
    ]);

    // Email Setting
    $wp_customize->add_setting('contact_email', [
        'default'           => 'hello@sillygoose.agency',
        'sanitize_callback' => 'sanitize_email',
    ]);

    $wp_customize->add_control('contact_email', [
        'label'   => esc_html__('Email Address', 'sillygoose'),
        'section' => 'sillygoose_contact',
        'type'    => 'email',
    ]);

    // Phone Setting
    $wp_customize->add_setting('contact_phone', [
        'default'           => '+44 1752 SILLY-GOOSE',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('contact_phone', [
        'label'   => esc_html__('Phone Number', 'sillygoose'),
        'section' => 'sillygoose_contact',
        'type'    => 'text',
    ]);

    // Location Setting
    $wp_customize->add_setting('contact_location', [
        'default'           => 'Plymouth, UK',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    $wp_customize->add_control('contact_location', [
        'label'   => esc_html__('Location', 'sillygoose'),
        'section' => 'sillygoose_contact',
        'type'    => 'text',
    ]);

    // Social Media Section
    $wp_customize->add_section('sillygoose_social', [
        'title'    => esc_html__('Social Media', 'sillygoose'),
        'priority' => 41,
    ]);

    // Social media platforms
    $social_platforms = [
        'facebook'  => 'Facebook',
        'twitter'   => 'Twitter', 
        'instagram' => 'Instagram',
        'linkedin'  => 'LinkedIn',
        'youtube'   => 'YouTube'
    ];

    foreach ($social_platforms as $platform => $label) {
        $wp_customize->add_setting('social_' . $platform, [
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ]);

        $wp_customize->add_control('social_' . $platform, [
            'label'   => $label . ' ' . esc_html__('URL', 'sillygoose'),
            'section' => 'sillygoose_social',
            'type'    => 'url',
        ]);
    }
}
add_action('customize_register', 'sillygoose_customize_register');

/**
 * RESTORED: Contact Form Handler
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

        $headers = ['Content-Type: text/plain; charset=UTF-8'];
        
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
 * RESTORED: Get Customizer Setting Helper
 */
function sillygoose_get_option($option, $default = '') {
    return get_theme_mod($option, $default);
}

/**
 * RESTORED: Admin Bar Spacing
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
 * Security improvements
 */
function sillygoose_security() {
    // Remove WordPress version from head
    remove_action('wp_head', 'wp_generator');
    
    // Remove RSD link
    remove_action('wp_head', 'rsd_link');
    
    // Remove wlwmanifest
    remove_action('wp_head', 'wlwmanifest_link');
    
    // Remove shortlink
    remove_action('wp_head', 'wp_shortlink_wp_head');
    
    // Disable XML-RPC if not needed
    add_filter('xmlrpc_enabled', '__return_false');
    
    // Add security headers
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

/**
 * Accessibility improvements
 */
function sillygoose_accessibility() {
    // Skip link
    add_action('wp_body_open', function() {
        echo '<a class="skip-link screen-reader-text" href="#main">' . esc_html__('Skip to content', 'sillygoose') . '</a>';
    });
    
    // Focus management for keyboard users
    add_action('wp_footer', function() {
        if (!is_admin()) {
            ?>
            <script>
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Tab') {
                    document.body.classList.add('keyboard-navigation');
                }
            });
            document.addEventListener('mousedown', function() {
                document.body.classList.remove('keyboard-navigation');
            });
            </script>
            <?php
        }
    });
}
add_action('wp_enqueue_scripts', 'sillygoose_accessibility');

/**
 * Performance monitoring for development
 */
function sillygoose_performance_monitor() {
    if (WP_DEBUG && current_user_can('administrator')) {
        add_action('wp_footer', function() {
            $num_queries = get_num_queries();
            $seconds = timer_stop(0, 3);
            echo "\n<!-- Performance: {$num_queries} queries in {$seconds} seconds -->\n";
        });
    }
}
add_action('init', 'sillygoose_performance_monitor');

/**
 * Optimize WordPress for better performance
 */
function sillygoose_optimize_wordpress() {
    // Remove emoji scripts and styles
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    
    // Limit post revisions
    if (!defined('WP_POST_REVISIONS')) {
        define('WP_POST_REVISIONS', 3);
    }
}
add_action('init', 'sillygoose_optimize_wordpress');

/**
 * Add custom blocks container wrapper
 */
function sillygoose_render_block_wrapper($block_content, $block) {
    // Skip for admin/editor
    if (is_admin()) {
        return $block_content;
    }
    
    $classes = [];
    $styles = [];
    
    // Handle custom blocks
    if (isset($block['blockName']) && strpos($block['blockName'], 'sillygoose/') === 0) {
        if (isset($block['attrs']['containerWidth'])) {
            $width = $block['attrs']['containerWidth'];
            $classes[] = ($width === 'full') ? 'sg-container-full' : 'sg-container-centered';
        }
        
        // Hero block specific handling
        if ($block['blockName'] === 'sillygoose/hero-block') {
            $classes[] = 'sg-hero-block';
            
            if (isset($block['attrs']['heroBackground']) && !empty($block['attrs']['heroBackground'])) {
                $styles[] = 'background-image: url(' . esc_url($block['attrs']['heroBackground']) . ')';
            }
            
            if (isset($block['attrs']['heroOverlay'])) {
                $styles[] = '--overlay-opacity: ' . floatval($block['attrs']['heroOverlay']);
            }
        }
    }
    
    // Apply wrapper if we have classes or styles
    if (!empty($classes) || !empty($styles)) {
        $class_attr = !empty($classes) ? ' class="' . esc_attr(implode(' ', $classes)) . '"' : '';
        $style_attr = !empty($styles) ? ' style="' . esc_attr(implode('; ', $styles)) . '"' : '';
        
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
add_filter('render_block', 'sillygoose_render_block_wrapper', 10, 2);

/**
 * RESTORED: Include organized template files (if they exist)
 */
$template_files = [
    '/templates/custom-posts.php',
    '/templates/homepage-blocks.php', 
    '/includes/statistics-block.php',
    '/includes/card-block.php',
    '/includes/hero-block.php'
];

foreach ($template_files as $file) {
    if (file_exists(SILLYGOOSE_THEME_DIR . $file)) {
        require_once SILLYGOOSE_THEME_DIR . $file;
    }
}

/**
 * MISSING: Enqueue block editor assets
 */
function sillygoose_block_editor_assets() {
    // Main blocks.js
    if (file_exists(get_template_directory() . '/js/blocks.js')) {
        wp_enqueue_script(
            'sillygoose-blocks',
            get_template_directory_uri() . '/js/blocks.js',
            array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n'),
            filemtime(get_template_directory() . '/js/blocks.js'),
            true
        );
        wp_set_script_translations('sillygoose-blocks', 'sillygoose');
    }
    
    // Card block
    if (file_exists(get_template_directory() . '/js/card-block.js')) {
        wp_enqueue_script(
            'sillygoose-card-block',
            get_template_directory_uri() . '/js/card-block.js',
            array('wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n', 'wp-data'),
            filemtime(get_template_directory() . '/js/card-block.js'),
            true
        );
        wp_set_script_translations('sillygoose-card-block', 'sillygoose');
    }
    
    // Hero block
    if (file_exists(get_template_directory() . '/js/hero-block.js')) {
        wp_enqueue_script(
            'sillygoose-hero-block',
            get_template_directory_uri() . '/js/hero-block.js',
            array('wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n'),
            filemtime(get_template_directory() . '/js/hero-block.js'),
            true
        );
        wp_set_script_translations('sillygoose-hero-block', 'sillygoose');
    }
    
    // Statistics block
    if (file_exists(get_template_directory() . '/js/statistics-block.js')) {
        wp_enqueue_script(
            'sillygoose-statistics-block',
            get_template_directory_uri() . '/js/statistics-block.js',
            array('wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n'),
            filemtime(get_template_directory() . '/js/statistics-block.js'),
            true
        );
        wp_set_script_translations('sillygoose-statistics-block', 'sillygoose');
    }
    
    // Block editor extensions
    if (file_exists(get_template_directory() . '/js/block-extensions.js')) {
        wp_enqueue_script(
            'sillygoose-block-extensions',
            get_template_directory_uri() . '/js/block-extensions.js',
            array('wp-hooks', 'wp-edit-post', 'wp-element', 'wp-components', 'wp-compose'),
            filemtime(get_template_directory() . '/js/block-extensions.js'),
            true
        );
        wp_set_script_translations('sillygoose-block-extensions', 'sillygoose');
    }
}
add_action('enqueue_block_editor_assets', 'sillygoose_block_editor_assets');

/**
 * MISSING: Register block categories
 */
function sillygoose_block_categories($categories, $post) {
    return array_merge(
        $categories,
        [
            [
                'slug'  => 'sillygoose',
                'title' => __('Silly Goose Blocks', 'sillygoose'),
                'icon'  => 'admin-customizer',
            ],
        ]
    );
}
add_filter('block_categories_all', 'sillygoose_block_categories', 10, 2);

/**
 * MISSING: Register block attributes for width controls and hero background
 */
function sillygoose_register_block_attributes() {
    // Hero block specific attributes
    register_block_type('sillygoose/hero', array(
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
    
    // Card block attributes
    register_block_type('sillygoose/card-block', array(
        'attributes' => array(
            'postType' => array(
                'type' => 'string',
                'default' => 'portfolio',
            ),
            'numberOfPosts' => array(
                'type' => 'number',
                'default' => 3,
            ),
            'title' => array(
                'type' => 'string',
                'default' => '',
            ),
            'description' => array(
                'type' => 'string',
                'default' => '',
            ),
            'titleTag' => array(
                'type' => 'string',
                'default' => 'h2',
            ),
            'containerWidth' => array(
                'type' => 'string',
                'default' => 'centered',
            ),
        ),
    ));
    
    // Statistics block attributes
    register_block_type('sillygoose/statistics', array(
        'attributes' => array(
            'statistics' => array(
                'type' => 'array',
                'default' => [
                    ['statText' => '150+', 'description' => 'Projects Completed'],
                    ['statText' => '50+', 'description' => 'Happy Clients'],
                    ['statText' => '5★', 'description' => 'Average Rating']
                ],
            ),
            'backgroundColor' => array(
                'type' => 'string',
                'default' => 'muted',
            ),
            'containerWidth' => array(
                'type' => 'string',
                'default' => 'contained',
            ),
        ),
    ));
    
    // Width control for core blocks
    $width_blocks = array(
        'core/group',
        'core/columns',
        'core/cover',
        'core/media-text',
        'core/gallery',
        'core/image',
        'core/video',
        'core/quote',
        'core/table',
        'core/buttons',
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
 * SIMPLE REST API FIX
 * Replace any previous REST API fix code with this
 */

/**
 * Update post type objects directly to ensure REST API support
 */
function sillygoose_force_rest_api_support() {
    global $wp_post_types;
    
    // Force REST API support for portfolio
    if (isset($wp_post_types['portfolio'])) {
        $wp_post_types['portfolio']->show_in_rest = true;
        $wp_post_types['portfolio']->rest_base = 'portfolio';
        $wp_post_types['portfolio']->rest_controller_class = 'WP_REST_Posts_Controller';
    }
    
    // Force REST API support for service
    if (isset($wp_post_types['service'])) {
        $wp_post_types['service']->show_in_rest = true;
        $wp_post_types['service']->rest_base = 'service';
        $wp_post_types['service']->rest_controller_class = 'WP_REST_Posts_Controller';
    }
}
add_action('init', 'sillygoose_force_rest_api_support', 99); // High priority to run last

/**
 * Register custom meta fields for REST API
 */
function sillygoose_register_custom_fields() {
    // Portfolio meta
    register_meta('post', 'portfolio_category', array(
        'post_type' => 'portfolio',
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
    ));
    
    register_meta('post', 'portfolio_result', array(
        'post_type' => 'portfolio',
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
    ));
    
    // Service meta
    register_meta('post', 'service_category', array(
        'post_type' => 'service',
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
    ));
    
    register_meta('post', 'service_result', array(
        'post_type' => 'service',
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
    ));
}
add_action('init', 'sillygoose_register_custom_fields');

/**
 * Debug function - remove after fixing
 */
function sillygoose_debug_post_types() {
    if (current_user_can('administrator') && isset($_GET['debug_rest'])) {
        global $wp_post_types;
        echo '<pre>';
        echo "Portfolio REST settings:\n";
        if (isset($wp_post_types['portfolio'])) {
            echo "show_in_rest: " . ($wp_post_types['portfolio']->show_in_rest ? 'true' : 'false') . "\n";
            echo "rest_base: " . $wp_post_types['portfolio']->rest_base . "\n";
        } else {
            echo "Portfolio post type not found\n";
        }
        
        echo "\nService REST settings:\n";
        if (isset($wp_post_types['service'])) {
            echo "show_in_rest: " . ($wp_post_types['service']->show_in_rest ? 'true' : 'false') . "\n";
            echo "rest_base: " . $wp_post_types['service']->rest_base . "\n";
        } else {
            echo "Service post type not found\n";
        }
        echo '</pre>';
        die();
    }
}
add_action('init', 'sillygoose_debug_post_types');