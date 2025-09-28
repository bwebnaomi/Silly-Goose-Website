<?php
/**
 * Template for displaying pages with Gutenberg content
 * Save as: page.php (or create a new template file)
 */

get_header(); ?>

<main id="main" class="site-main">
    <?php
    while (have_posts()) :
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            
            <?php if (!is_front_page()): ?>
                <header class="entry-header container py-16">
                    <?php the_title('<h1 class="entry-title text-4xl font-bold mb-4">', '</h1>'); ?>
                </header>
            <?php endif; ?>

            <div class="entry-content">
                <?php
                // Check if this page has blocks
                if (has_blocks()) {
                    // Output the block content
                    the_content();
                } else {
                    // Fallback for non-block content
                    ?>
                    <div class="container">
                        <?php
                        the_content();
                        
                        wp_link_pages(
                            array(
                                'before' => '<div class="page-links">' . esc_html__('Pages:', 'sillygoose'),
                                'after'  => '</div>',
                            )
                        );
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>

            <?php if (get_edit_post_link() && !is_front_page()): ?>
                <footer class="entry-footer container py-8">
                    <?php
                    edit_post_link(
                        sprintf(
                            wp_kses(
                                __('Edit <span class="screen-reader-text">%s</span>', 'sillygoose'),
                                array(
                                    'span' => array(
                                        'class' => array(),
                                    ),
                                )
                            ),
                            wp_kses_post(get_the_title())
                        ),
                        '<span class="edit-link">',
                        '</span>'
                    );
                    ?>
                </footer>
            <?php endif; ?>
        </article>

        <?php
        // If comments are open or we have at least one comment, load up the comment template.
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;
        ?>

    <?php endwhile; // End of the loop. ?>
</main>

<style>
/* Page-specific styles for Gutenberg content */
.entry-content {
    margin: 0;
    padding: 0;
}

/* Remove default container constraints for full-width blocks */
.entry-content .wp-block-group.alignfull,
.entry-content .wp-block-cover.alignfull,
.entry-content .sillygoose-card-block {
    margin-left: 0;
    margin-right: 0;
    max-width: none;
    width: 100%;
}

/* Add proper spacing for contained blocks */
.entry-content .wp-block-group:not(.alignfull),
.entry-content .wp-block-columns:not(.alignfull),
.entry-content .wp-block-heading:not(.alignfull),
.entry-content .wp-block-paragraph:not(.alignfull) {
    max-width: 1200px;
    margin-left: auto;
    margin-right: auto;
    padding-left: 1rem;
    padding-right: 1rem;
}

/* Hero section should be full width */
.entry-content .sg-hero-block {
    margin-left: 0;
    margin-right: 0;
    max-width: none;
    width: 100%;
}

/* Ensure proper spacing between blocks */
.entry-content > .wp-block {
    margin-top: 0;
    margin-bottom: 2rem;
}

.entry-content > .wp-block:last-child {
    margin-bottom: 0;
}

/* Full-width block adjustments */
.entry-content .alignfull {
    width: 100vw;
    max-width: none;
    margin-left: 50%;
    transform: translateX(-50%);
}

.entry-content .alignwide {
    width: 100%;
    max-width: 1400px;
    margin-left: auto;
    margin-right: auto;
}

/* Button styling consistency */
.entry-content .wp-block-button .wp-block-button__link {
    background-color: var(--primary, #ff6b35);
    border-radius: var(--radius, 0.625rem);
    color: white;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.entry-content .wp-block-button .wp-block-button__link:hover {
    background-color: var(--secondary, #4ecdc4);
    transform: translateY(-2px);
}

.entry-content .wp-block-button.is-style-outline .wp-block-button__link {
    background-color: transparent;
    border: 2px solid var(--primary, #ff6b35);
    color: var(--primary, #ff6b35);
}

.entry-content .wp-block-button.is-style-outline .wp-block-button__link:hover {
    background-color: var(--primary, #ff6b35);
    color: white;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .entry-content .wp-block-group:not(.alignfull),
    .entry-content .wp-block-columns:not(.alignfull),
    .entry-content .wp-block-heading:not(.alignfull),
    .entry-content .wp-block-paragraph:not(.alignfull) {
        padding-left: 1rem;
        padding-right: 1rem;
    }
    
    .entry-content .wp-block-columns {
        flex-direction: column;
    }
    
    .entry-content .wp-block-column {
        flex-basis: 100% !important;
        margin-bottom: 1rem;
    }
    
    .entry-content .wp-block-column:last-child {
        margin-bottom: 0;
    }
}
</style>

<?php get_footer(); ?>