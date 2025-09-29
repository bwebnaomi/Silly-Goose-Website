<?php
/**
 * Silly Goose Card Block Server-side Rendering
 * Add this to your functions.php or create as a separate file and include it
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register the Card Block
 */
function sillygoose_register_card_block() {
    // Check if function exists (WordPress 5.0+)
    if (!function_exists('register_block_type')) {
        return;
    }

    register_block_type('sillygoose/card-block', array(
        'attributes' => array(
            'postType' => array(
                'type' => 'string',
                'default' => 'project'
            ),
            'numberOfPosts' => array(
                'type' => 'number',
                'default' => 3
            ),
            'title' => array(
                'type' => 'string',
                'default' => ''
            ),
            'description' => array(
                'type' => 'string',
                'default' => ''
            ),
            'titleTag' => array(
                'type' => 'string',
                'default' => 'h2'
            ),
            'orderBy' => array(
                'type' => 'string',
                'default' => 'date'
            ),
            'order' => array(
                'type' => 'string',
                'default' => 'DESC'
            )
        ),
        'render_callback' => 'sillygoose_render_card_block'
    ));
}
add_action('init', 'sillygoose_register_card_block');

/**
 * Render the Card Block on the frontend
 */
function sillygoose_render_card_block($attributes) {
    // Extract attributes with defaults
    $post_type = isset($attributes['postType']) ? $attributes['postType'] : 'project';
    $number_of_posts = isset($attributes['numberOfPosts']) ? intval($attributes['numberOfPosts']) : 3;
    $title = isset($attributes['title']) ? $attributes['title'] : '';
    $description = isset($attributes['description']) ? $attributes['description'] : '';
    $title_tag = isset($attributes['titleTag']) ? $attributes['titleTag'] : 'h2';
    $order_by = isset($attributes['orderBy']) ? $attributes['orderBy'] : 'date';
    $order = isset($attributes['order']) ? $attributes['order'] : 'DESC';

    // Validate title tag
    $allowed_title_tags = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6');
    if (!in_array($title_tag, $allowed_title_tags)) {
        $title_tag = 'h2';
    }

    // Validate post type
    $allowed_post_types = array('project', 'service');
    if (!in_array($post_type, $allowed_post_types)) {
        $post_type = 'project';
    }

    // Build query arguments
    $query_args = array(
        'post_type' => $post_type,
        'posts_per_page' => $number_of_posts,
        'post_status' => 'publish',
        'orderby' => $order_by,
        'order' => $order
    );

    // Get posts
    $posts_query = new WP_Query($query_args);

    if (!$posts_query->have_posts()) {
        wp_reset_postdata();
        return '<div class="sillygoose-card-block"><p>' . __('No items found.', 'sillygoose') . '</p></div>';
    }

    // Start building output
    ob_start();
    ?>
    <div class="sillygoose-card-block">
        <?php if (!empty($title) || !empty($description)): ?>
            <div class="card-block-header mb-8">
                <?php if (!empty($title)): ?>
                    <<?php echo esc_html($title_tag); ?> class="card-block-title"><?php echo esc_html($title); ?></<?php echo esc_html($title_tag); ?>>
                <?php endif; ?>
                
                <?php if (!empty($description)): ?>
                    <p class="card-block-description"><?php echo esc_html($description); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="card-grid">
            <?php while ($posts_query->have_posts()): $posts_query->the_post(); ?>
                <div class="card">
                    <?php if (has_post_thumbnail()): ?>
                        <div class="card-image">
                            <?php the_post_thumbnail('medium_large', array(
                                'alt' => get_the_title(),
                                'loading' => 'lazy'
                            )); ?>
                        </div>
                    <?php else: ?>
                        <div class="card-image card-image-placeholder">
                            <span><?php _e('No Image', 'sillygoose'); ?></span>
                        </div>
                    <?php endif; ?>

                    <div class="card-content">
                        <h3 class="card-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>

                        <?php if (has_excerpt()): ?>
                            <div class="card-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                        <?php endif; ?>

                        <?php 
                        // Display custom fields based on post type
                        if ($post_type === 'project'): 
                            $category = get_post_meta(get_the_ID(), 'portfolio_category', true);
                            $result = get_post_meta(get_the_ID(), 'portfolio_result', true);
                            
                            if ($category || $result):
                        ?>
                            <div class="card-meta">
                                <?php if ($category): ?>
                                    <span class="card-category"><?php echo esc_html($category); ?></span>
                                <?php endif; ?>
                                <?php if ($result): ?>
                                    <span class="card-result"><?php echo esc_html($result); ?></span>
                                <?php endif; ?>
                            </div>
                        <?php 
                            endif;
                        endif; 
                        ?>

                        <a href="<?php the_permalink(); ?>" class="card-link">
                            <?php _e('Learn More', 'sillygoose'); ?> →
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>


    <?php
    wp_reset_postdata();
    return ob_get_clean();
}

/**
 * Enqueue block assets for the card block
 */
function sillygoose_enqueue_card_block_assets() {
    // Enqueue block script for editor
    if (is_admin()) {
        wp_enqueue_script(
            'sillygoose-card-block',
            get_template_directory_uri() . '/js/card-block.js',
            array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-i18n', 'wp-data'),
            '1.0.0',
            true
        );

        // Add translations
        wp_set_script_translations('sillygoose-card-block', 'sillygoose');
    }
}
add_action('enqueue_block_editor_assets', 'sillygoose_enqueue_card_block_assets');

/**
 * Add block category for Silly Goose blocks
 */
function sillygoose_add_block_categories($categories) {
    return array_merge(
        $categories,
        array(
            array(
                'slug'  => 'sillygoose',
                'title' => __('Silly Goose Blocks', 'sillygoose'),
                'icon'  => 'grid-view'
            )
        )
    );
}
add_filter('block_categories_all', 'sillygoose_add_block_categories', 10, 2);