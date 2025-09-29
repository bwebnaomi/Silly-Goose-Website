<?php
/**
 * Custom Post Types and Taxonomy
 * Save as: templates/custom-posts.php
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Custom Post Types
 */
function sillygoose_register_custom_post_types() {
    
    // Projects Post Type
    register_post_type('project', array(
        'labels' => array(
            'name'               => __('Projects', 'sillygoose'),
            'singular_name'      => __('Project', 'sillygoose'),
            'menu_name'          => __('Projects', 'sillygoose'),
            'add_new'           => __('Add New', 'sillygoose'),
            'add_new_item'      => __('Add New Project', 'sillygoose'),
            'edit_item'         => __('Edit Project', 'sillygoose'),
            'new_item'          => __('New Project', 'sillygoose'),
            'view_item'         => __('View Project', 'sillygoose'),
            'view_items'        => __('View Projects', 'sillygoose'),
            'search_items'      => __('Search Projects', 'sillygoose'),
            'not_found'         => __('No projects found', 'sillygoose'),
            'not_found_in_trash'=> __('No projects found in trash', 'sillygoose'),
            'all_items'         => __('All Projects', 'sillygoose'),
            'archives'          => __('Project Archives', 'sillygoose'),
            'attributes'        => __('Project Attributes', 'sillygoose'),
            'insert_into_item'  => __('Insert into project', 'sillygoose'),
            'uploaded_to_this_item' => __('Uploaded to this project', 'sillygoose'),
        ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'show_in_rest'      => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'projects'),
        'capability_type'   => 'post',
        'has_archive'       => true,
        'hierarchical'      => false,
        'menu_position'     => 20,
        'menu_icon'         => 'dashicons-portfolio',
        'supports'          => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'taxonomies'        => array('service_type'),
    ));

    // Services Post Type
    register_post_type('service', array(
        'labels' => array(
            'name'               => __('Services', 'sillygoose'),
            'singular_name'      => __('Service', 'sillygoose'),
            'menu_name'          => __('Services', 'sillygoose'),
            'add_new'           => __('Add New', 'sillygoose'),
            'add_new_item'      => __('Add New Service', 'sillygoose'),
            'edit_item'         => __('Edit Service', 'sillygoose'),
            'new_item'          => __('New Service', 'sillygoose'),
            'view_item'         => __('View Service', 'sillygoose'),
            'view_items'        => __('View Services', 'sillygoose'),
            'search_items'      => __('Search Services', 'sillygoose'),
            'not_found'         => __('No services found', 'sillygoose'),
            'not_found_in_trash'=> __('No services found in trash', 'sillygoose'),
            'all_items'         => __('All Services', 'sillygoose'),
            'archives'          => __('Service Archives', 'sillygoose'),
            'attributes'        => __('Service Attributes', 'sillygoose'),
            'insert_into_item'  => __('Insert into service', 'sillygoose'),
            'uploaded_to_this_item' => __('Uploaded to this service', 'sillygoose'),
        ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'show_in_rest'      => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'services'),
        'capability_type'   => 'post',
        'has_archive'       => true,
        'hierarchical'      => false,
        'menu_position'     => 21,
        'menu_icon'         => 'dashicons-admin-tools',
        'supports'          => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes'),
        'taxonomies'        => array('service_type'),
    ));

    // Client Testimonials Post Type
    register_post_type('testimonial', array(
        'labels' => array(
            'name'               => __('Client Testimonials', 'sillygoose'),
            'singular_name'      => __('Testimonial', 'sillygoose'),
            'menu_name'          => __('Testimonials', 'sillygoose'),
            'add_new'           => __('Add New', 'sillygoose'),
            'add_new_item'      => __('Add New Testimonial', 'sillygoose'),
            'edit_item'         => __('Edit Testimonial', 'sillygoose'),
            'new_item'          => __('New Testimonial', 'sillygoose'),
            'view_item'         => __('View Testimonial', 'sillygoose'),
            'view_items'        => __('View Testimonials', 'sillygoose'),
            'search_items'      => __('Search Testimonials', 'sillygoose'),
            'not_found'         => __('No testimonials found', 'sillygoose'),
            'not_found_in_trash'=> __('No testimonials found in trash', 'sillygoose'),
            'all_items'         => __('All Testimonials', 'sillygoose'),
            'archives'          => __('Testimonial Archives', 'sillygoose'),
            'attributes'        => __('Testimonial Attributes', 'sillygoose'),
            'insert_into_item'  => __('Insert into testimonial', 'sillygoose'),
            'uploaded_to_this_item' => __('Uploaded to this testimonial', 'sillygoose'),
        ),
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'show_in_nav_menus' => false,
        'show_in_admin_bar' => true,
        'show_in_rest'      => true,
        'query_var'         => false,
        'rewrite'           => false,
        'capability_type'   => 'post',
        'has_archive'       => false,
        'hierarchical'      => false,
        'menu_position'     => 22,
        'menu_icon'         => 'dashicons-format-quote',
        'supports'          => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'taxonomies'        => array('service_type'),
    ));
}
add_action('init', 'sillygoose_register_custom_post_types');

/**
 * Register Service Type Taxonomy
 */
function sillygoose_register_service_type_taxonomy() {
    register_taxonomy('service_type', array('project', 'service', 'testimonial'), array(
        'labels' => array(
            'name'              => __('Service Types', 'sillygoose'),
            'singular_name'     => __('Service Type', 'sillygoose'),
            'menu_name'         => __('Service Types', 'sillygoose'),
            'all_items'         => __('All Service Types', 'sillygoose'),
            'edit_item'         => __('Edit Service Type', 'sillygoose'),
            'view_item'         => __('View Service Type', 'sillygoose'),
            'update_item'       => __('Update Service Type', 'sillygoose'),
            'add_new_item'      => __('Add New Service Type', 'sillygoose'),
            'new_item_name'     => __('New Service Type Name', 'sillygoose'),
            'parent_item'       => __('Parent Service Type', 'sillygoose'),
            'parent_item_colon' => __('Parent Service Type:', 'sillygoose'),
            'search_items'      => __('Search Service Types', 'sillygoose'),
            'popular_items'     => __('Popular Service Types', 'sillygoose'),
            'separate_items_with_commas' => __('Separate service types with commas', 'sillygoose'),
            'add_or_remove_items' => __('Add or remove service types', 'sillygoose'),
            'choose_from_most_used' => __('Choose from the most used service types', 'sillygoose'),
            'not_found'         => __('No service types found', 'sillygoose'),
        ),
        'public'            => true,
        'publicly_queryable'=> true,
        'hierarchical'      => true,
        'show_ui'          => true,
        'show_in_menu'     => true,
        'show_in_nav_menus'=> true,
        'show_in_rest'     => true,
        'show_tagcloud'    => true,
        'show_in_quick_edit'=> true,
        'show_admin_column'=> true,
        'query_var'        => true,
        'rewrite'          => array(
            'slug'         => 'service-type',
            'with_front'   => false,
            'hierarchical' => true,
        ),
    ));
}
add_action('init', 'sillygoose_register_service_type_taxonomy');

/**
 * Add Custom Meta Boxes for Projects
 */
function sillygoose_add_project_meta_boxes() {
    add_meta_box(
        'project_details',
        __('Project Details', 'sillygoose'),
        'sillygoose_project_meta_box_callback',
        'project',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'sillygoose_add_project_meta_boxes');

function sillygoose_project_meta_box_callback($post) {
    wp_nonce_field('sillygoose_project_meta', 'sillygoose_project_nonce');
    
    $client = get_post_meta($post->ID, '_project_client', true);
    $url = get_post_meta($post->ID, '_project_url', true);
    $result = get_post_meta($post->ID, '_project_result', true);
    $technologies = get_post_meta($post->ID, '_project_technologies', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="project_client"><?php _e('Client Name', 'sillygoose'); ?></label></th>
            <td><input type="text" id="project_client" name="project_client" value="<?php echo esc_attr($client); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="project_url"><?php _e('Project URL', 'sillygoose'); ?></label></th>
            <td><input type="url" id="project_url" name="project_url" value="<?php echo esc_attr($url); ?>" class="regular-text" placeholder="https://example.com" /></td>
        </tr>
        <tr>
            <th><label for="project_result"><?php _e('Project Result', 'sillygoose'); ?></label></th>
            <td><input type="text" id="project_result" name="project_result" value="<?php echo esc_attr($result); ?>" class="regular-text" placeholder="e.g., 300% increase in sales" /></td>
        </tr>
        <tr>
            <th><label for="project_technologies"><?php _e('Technologies Used', 'sillygoose'); ?></label></th>
            <td><textarea id="project_technologies" name="project_technologies" rows="3" class="large-text"><?php echo esc_textarea($technologies); ?></textarea>
            <p class="description"><?php _e('Separate technologies with commas (e.g., React, WordPress, Node.js)', 'sillygoose'); ?></p></td>
        </tr>
    </table>
    <?php
}

/**
 * Save Project Meta Data
 */
function sillygoose_save_project_meta($post_id) {
    if (!isset($_POST['sillygoose_project_nonce']) || !wp_verify_nonce($_POST['sillygoose_project_nonce'], 'sillygoose_project_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['project_client'])) {
        update_post_meta($post_id, '_project_client', sanitize_text_field($_POST['project_client']));
    }

    if (isset($_POST['project_url'])) {
        update_post_meta($post_id, '_project_url', esc_url_raw($_POST['project_url']));
    }

    if (isset($_POST['project_result'])) {
        update_post_meta($post_id, '_project_result', sanitize_text_field($_POST['project_result']));
    }

    if (isset($_POST['project_technologies'])) {
        update_post_meta($post_id, '_project_technologies', sanitize_textarea_field($_POST['project_technologies']));
    }
}
add_action('save_post', 'sillygoose_save_project_meta');

/**
 * Add Custom Meta Boxes for Services
 */
function sillygoose_add_service_meta_boxes() {
    add_meta_box(
        'service_details',
        __('Service Details', 'sillygoose'),
        'sillygoose_service_meta_box_callback',
        'service',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'sillygoose_add_service_meta_boxes');

function sillygoose_service_meta_box_callback($post) {
    wp_nonce_field('sillygoose_service_meta', 'sillygoose_service_nonce');
    
    $icon = get_post_meta($post->ID, '_service_icon', true);
    $price = get_post_meta($post->ID, '_service_price', true);
    $timeline = get_post_meta($post->ID, '_service_timeline', true);
    $features = get_post_meta($post->ID, '_service_features', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="service_icon"><?php _e('Service Icon', 'sillygoose'); ?></label></th>
            <td>
                <select id="service_icon" name="service_icon">
                    <option value="palette" <?php selected($icon, 'palette'); ?>><?php _e('Design (Palette)', 'sillygoose'); ?></option>
                    <option value="code" <?php selected($icon, 'code'); ?>><?php _e('Development (Code)', 'sillygoose'); ?></option>
                    <option value="search" <?php selected($icon, 'search'); ?>><?php _e('SEO (Search)', 'sillygoose'); ?></option>
                    <option value="target" <?php selected($icon, 'target'); ?>><?php _e('Marketing (Target)', 'sillygoose'); ?></option>
                    <option value="globe" <?php selected($icon, 'globe'); ?>><?php _e('E-commerce (Globe)', 'sillygoose'); ?></option>
                    <option value="zap" <?php selected($icon, 'zap'); ?>><?php _e('Strategy (Zap)', 'sillygoose'); ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="service_price"><?php _e('Starting Price (£)', 'sillygoose'); ?></label></th>
            <td><input type="number" id="service_price" name="service_price" value="<?php echo esc_attr($price); ?>" class="regular-text" min="0" step="100" /></td>
        </tr>
        <tr>
            <th><label for="service_timeline"><?php _e('Typical Timeline', 'sillygoose'); ?></label></th>
            <td><input type="text" id="service_timeline" name="service_timeline" value="<?php echo esc_attr($timeline); ?>" class="regular-text" placeholder="e.g., 2-4 weeks" /></td>
        </tr>
        <tr>
            <th><label for="service_features"><?php _e('Key Features', 'sillygoose'); ?></label></th>
            <td><textarea id="service_features" name="service_features" rows="4" class="large-text"><?php echo esc_textarea($features); ?></textarea>
            <p class="description"><?php _e('One feature per line', 'sillygoose'); ?></p></td>
        </tr>
    </table>
    <?php
}

/**
 * Save Service Meta Data
 */
function sillygoose_save_service_meta($post_id) {
    if (!isset($_POST['sillygoose_service_nonce']) || !wp_verify_nonce($_POST['sillygoose_service_nonce'], 'sillygoose_service_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['service_icon'])) {
        update_post_meta($post_id, '_service_icon', sanitize_text_field($_POST['service_icon']));
    }

    if (isset($_POST['service_price'])) {
        update_post_meta($post_id, '_service_price', intval($_POST['service_price']));
    }

    if (isset($_POST['service_timeline'])) {
        update_post_meta($post_id, '_service_timeline', sanitize_text_field($_POST['service_timeline']));
    }

    if (isset($_POST['service_features'])) {
        update_post_meta($post_id, '_service_features', sanitize_textarea_field($_POST['service_features']));
    }
}
add_action('save_post', 'sillygoose_save_service_meta');

/**
 * Add Custom Meta Boxes for Testimonials
 */
function sillygoose_add_testimonial_meta_boxes() {
    add_meta_box(
        'testimonial_details',
        __('Client Details', 'sillygoose'),
        'sillygoose_testimonial_meta_box_callback',
        'testimonial',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'sillygoose_add_testimonial_meta_boxes');

function sillygoose_testimonial_meta_box_callback($post) {
    wp_nonce_field('sillygoose_testimonial_meta', 'sillygoose_testimonial_nonce');
    
    $client_name = get_post_meta($post->ID, '_client_name', true);
    $client_position = get_post_meta($post->ID, '_client_position', true);
    $client_company = get_post_meta($post->ID, '_client_company', true);
    $rating = get_post_meta($post->ID, '_rating', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="client_name"><?php _e('Client Name', 'sillygoose'); ?></label></th>
            <td><input type="text" id="client_name" name="client_name" value="<?php echo esc_attr($client_name); ?>" class="regular-text" required /></td>
        </tr>
        <tr>
            <th><label for="client_position"><?php _e('Client Position', 'sillygoose'); ?></label></th>
            <td><input type="text" id="client_position" name="client_position" value="<?php echo esc_attr($client_position); ?>" class="regular-text" placeholder="e.g., CEO" /></td>
        </tr>
        <tr>
            <th><label for="client_company"><?php _e('Company Name', 'sillygoose'); ?></label></th>
            <td><input type="text" id="client_company" name="client_company" value="<?php echo esc_attr($client_company); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="rating"><?php _e('Rating', 'sillygoose'); ?></label></th>
            <td>
                <select id="rating" name="rating">
                    <option value="5" <?php selected($rating, '5'); ?>><?php _e('5 Stars', 'sillygoose'); ?></option>
                    <option value="4" <?php selected($rating, '4'); ?>><?php _e('4 Stars', 'sillygoose'); ?></option>
                    <option value="3" <?php selected($rating, '3'); ?>><?php _e('3 Stars', 'sillygoose'); ?></option>
                    <option value="2" <?php selected($rating, '2'); ?>><?php _e('2 Stars', 'sillygoose'); ?></option>
                    <option value="1" <?php selected($rating, '1'); ?>><?php _e('1 Star', 'sillygoose'); ?></option>
                </select>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Save Testimonial Meta Data
 */
function sillygoose_save_testimonial_meta($post_id) {
    if (!isset($_POST['sillygoose_testimonial_nonce']) || !wp_verify_nonce($_POST['sillygoose_testimonial_nonce'], 'sillygoose_testimonial_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['client_name'])) {
        update_post_meta($post_id, '_client_name', sanitize_text_field($_POST['client_name']));
    }

    if (isset($_POST['client_position'])) {
        update_post_meta($post_id, '_client_position', sanitize_text_field($_POST['client_position']));
    }

    if (isset($_POST['client_company'])) {
        update_post_meta($post_id, '_client_company', sanitize_text_field($_POST['client_company']));
    }

    if (isset($_POST['rating'])) {
        update_post_meta($post_id, '_rating', sanitize_text_field($_POST['rating']));
    }
}
add_action('save_post', 'sillygoose_save_testimonial_meta');

/**
 * Add default service types on theme activation
 */
function sillygoose_add_default_service_types() {
    $default_types = array(
        'Web Design',
        'Web Development',
        'SEO',
        'Paid Media Marketing',
        'E-commerce',
        'Brand Strategy',
        'Mobile Apps',
        'Content Marketing'
    );

    foreach ($default_types as $type) {
        if (!term_exists($type, 'service_type')) {
            wp_insert_term($type, 'service_type');
        }
    }
}
add_action('after_switch_theme', 'sillygoose_add_default_service_types');