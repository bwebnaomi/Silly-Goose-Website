<?php
/**
 * Silly Goose Hero Block Server-side Rendering
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the Hero Block
 */
function sillygoose_register_hero_block() {
    // Check if function exists (WordPress 5.0+)
    if (!function_exists('register_block_type')) {
        return;
    }

    register_block_type('sillygoose/hero', array(
        'attributes' => array(
            'title' => array(
                'type' => 'string',
                'default' => 'Welcome to Silly Goose'
            ),
            'titleTag' => array(
                'type' => 'string',
                'default' => 'h1'
            ),
            'subtitle' => array(
                'type' => 'string',
                'default' => 'Digital Agency'
            ),
            'subtitleTag' => array(
                'type' => 'string',
                'default' => 'h2'
            ),
            'description' => array(
                'type' => 'string',
                'default' => 'We\'re not going to be beaten by AI, we\'re making it our bitch.'
            ),
            'primaryButtonText' => array(
                'type' => 'string',
                'default' => 'Get Started Today'
            ),
            'primaryButtonUrl' => array(
                'type' => 'string',
                'default' => '#contact'
            ),
            'secondaryButtonText' => array(
                'type' => 'string',
                'default' => 'View Our Work'
            ),
            'secondaryButtonUrl' => array(
                'type' => 'string',
                'default' => '#portfolio'
            ),
            'containerWidth' => array(
                'type' => 'string',
                'default' => 'contained'
            ),
            'showPrimaryButton' => array(
                'type' => 'boolean',
                'default' => true
            ),
            'showSecondaryButton' => array(
                'type' => 'boolean',
                'default' => true
            )
        ),
        'render_callback' => 'sillygoose_render_hero_block'
    ));
}
add_action('init', 'sillygoose_register_hero_block');

/**
 * Render the Hero Block on the frontend
 */
function sillygoose_render_hero_block($attributes) {
    // Extract attributes with defaults
    $title = isset($attributes['title']) ? $attributes['title'] : 'Welcome to Silly Goose';
    $title_tag = isset($attributes['titleTag']) ? $attributes['titleTag'] : 'h1';
    $subtitle = isset($attributes['subtitle']) ? $attributes['subtitle'] : 'Digital Agency';
    $subtitle_tag = isset($attributes['subtitleTag']) ? $attributes['subtitleTag'] : 'h2';
    $description = isset($attributes['description']) ? $attributes['description'] : '';
    $primary_button_text = isset($attributes['primaryButtonText']) ? $attributes['primaryButtonText'] : '';
    $primary_button_url = isset($attributes['primaryButtonUrl']) ? $attributes['primaryButtonUrl'] : '';
    $secondary_button_text = isset($attributes['secondaryButtonText']) ? $attributes['secondaryButtonText'] : '';
    $secondary_button_url = isset($attributes['secondaryButtonUrl']) ? $attributes['secondaryButtonUrl'] : '';
    $container_width = isset($attributes['containerWidth']) ? $attributes['containerWidth'] : 'contained';
    $show_primary_button = isset($attributes['showPrimaryButton']) ? $attributes['showPrimaryButton'] : true;
    $show_secondary_button = isset($attributes['showSecondaryButton']) ? $attributes['showSecondaryButton'] : true;

    // Validate HTML tags
    $allowed_tags = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'span', 'div');
    if (!in_array($title_tag, $allowed_tags)) {
        $title_tag = 'h1';
    }
    if (!in_array($subtitle_tag, $allowed_tags)) {
        $subtitle_tag = 'h2';
    }

    // Validate container width
    $container_class = $container_width === 'full' ? 'hero-full-width' : 'hero-contained';

    // Start building output
    ob_start();
    ?>
    <section class="sillygoose-hero-block <?php echo esc_attr($container_class); ?>">
        <div class="hero-content">
            <div class="hero-text">
                <?php if (!empty($title)): ?>
                    <<?php echo esc_html($title_tag); ?> class="hero-title gradient-text">
                        <?php echo wp_kses_post($title); ?>
                    </<?php echo esc_html($title_tag); ?>>
                <?php endif; ?>

                <?php if (!empty($subtitle)): ?>
                    <<?php echo esc_html($subtitle_tag); ?> class="hero-subtitle">
                        <?php echo wp_kses_post($subtitle); ?>
                    </<?php echo esc_html($subtitle_tag); ?>>
                <?php endif; ?>

                <?php if (!empty($description)): ?>
                    <p class="hero-description">
                        <?php echo wp_kses_post($description); ?>
                    </p>
                <?php endif; ?>
            </div>

            <?php if (($show_primary_button && !empty($primary_button_text)) || ($show_secondary_button && !empty($secondary_button_text))): ?>
                <div class="hero-buttons">
                    <?php if ($show_primary_button && !empty($primary_button_text)): ?>
                        <a href="<?php echo esc_url($primary_button_url); ?>" class="hero-button hero-button-primary">
                            <?php echo esc_html($primary_button_text); ?>
                        </a>
                    <?php endif; ?>

                    <?php if ($show_secondary_button && !empty($secondary_button_text)): ?>
                        <a href="<?php echo esc_url($secondary_button_url); ?>" class="hero-button hero-button-secondary">
                            <?php echo esc_html($secondary_button_text); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    
    <?php
    return ob_get_clean();
}

/**
 * Enqueue hero block assets
 */
function sillygoose_enqueue_hero_block_assets() {
    // Enqueue block script for editor
    if (is_admin()) {
        wp_enqueue_script(
            'sillygoose-hero-block',
            get_template_directory_uri() . '/js/hero-block.js',
            array('wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-i18n'),
            '1.0.0',
            true
        );

        // Add translations
        wp_set_script_translations('sillygoose-hero-block', 'sillygoose');
    }
}
add_action('enqueue_block_editor_assets', 'sillygoose_enqueue_hero_block_assets');