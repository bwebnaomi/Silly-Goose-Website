<?php
/**
 * Silly Goose Statistics Block Server-side Rendering
 * Fixed version without function redeclaration errors
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the Statistics Block
 */
function sillygoose_register_statistics_block() {
    // Check if function exists (WordPress 5.0+)
    if (!function_exists('register_block_type')) {
        return;
    }

    register_block_type('sillygoose/statistics', array(
        'attributes' => array(
            'statistics' => array(
                'type' => 'array',
                'default' => array(
                    array('statText' => '150+', 'description' => 'Projects Completed'),
                    array('statText' => '50+', 'description' => 'Happy Clients'),
                    array('statText' => '5★', 'description' => 'Average Rating')
                )
            ),
            'backgroundColor' => array(
                'type' => 'string',
                'default' => 'muted'
            ),
            'containerWidth' => array(
                'type' => 'string',
                'default' => 'contained'
            )
        ),
        'render_callback' => 'sillygoose_render_statistics_block'
    ));
}
add_action('init', 'sillygoose_register_statistics_block');

/**
 * Helper function to get color class for statistics (defined only once)
 */
if (!function_exists('sillygoose_get_stat_color_class')) {
    function sillygoose_get_stat_color_class($index) {
        $colors = array('primary', 'secondary', 'accent');
        return $colors[$index % count($colors)];
    }
}

/**
 * Render the Statistics Block on the frontend
 */
function sillygoose_render_statistics_block($attributes) {
    // Extract attributes with defaults
    $statistics = isset($attributes['statistics']) ? $attributes['statistics'] : array(
        array('statText' => '150+', 'description' => 'Projects Completed'),
        array('statText' => '50+', 'description' => 'Happy Clients'),
        array('statText' => '5★', 'description' => 'Average Rating')
    );
    $background_color = isset($attributes['backgroundColor']) ? $attributes['backgroundColor'] : 'muted';
    $container_width = isset($attributes['containerWidth']) ? $attributes['containerWidth'] : 'contained';

    // Validate background color
    $allowed_bg_colors = array('muted', 'white', 'primary', 'foreground');
    if (!in_array($background_color, $allowed_bg_colors)) {
        $background_color = 'muted';
    }

    // Container class
    $container_class = $container_width === 'full' ? 'stats-full-width' : 'stats-contained';

    // Start building output
    ob_start();
    ?>
    <section class="sillygoose-statistics-block <?php echo esc_attr($container_class); ?> bg-<?php echo esc_attr($background_color); ?>">
        <div class="statistics-content">
            <div class="statistics-grid">
                <?php foreach ($statistics as $index => $stat): ?>
                    <?php 
                    $stat_text = isset($stat['statText']) ? $stat['statText'] : '';
                    $description = isset($stat['description']) ? $stat['description'] : '';
                    $color_class = sillygoose_get_stat_color_class($index);
                    ?>
                    <?php if (!empty($stat_text) || !empty($description)): ?>
                        <div class="statistic-item">
                            <div class="statistic-number stat-color-<?php echo esc_attr($color_class); ?>">
                                <?php echo esc_html($stat_text); ?>
                            </div>
                            <?php if (!empty($description)): ?>
                                <div class="statistic-description">
                                    <?php echo esc_html($description); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    
    <?php
    return ob_get_clean();
}