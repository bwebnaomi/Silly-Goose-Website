<?php
/**
 * Main Template File
 */

get_header(); ?>

<main>
    <div class="container py-24">
        <?php if (have_posts()) : ?>
            <header class="page-header mb-16">
                <?php if (is_home() && !is_front_page()) : ?>
                    <h1 class="page-title"><?php single_post_title(); ?></h1>
                <?php elseif (is_archive()) : ?>
                    <h1 class="page-title"><?php the_archive_title(); ?></h1>
                    <?php the_archive_description('<div class="archive-description">', '</div>'); ?>
                <?php elseif (is_search()) : ?>
                    <h1 class="page-title">
                        <?php printf(esc_html__('Search Results for: %s', 'sillygoose'), '<span>' . get_search_query() . '</span>'); ?>
                    </h1>
                <?php else : ?>
                    <h1 class="page-title"><?php esc_html_e('Latest Posts', 'sillygoose'); ?></h1>
                <?php endif; ?>
            </header>

            <div class="grid gap-8" style="grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));">
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('card'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail mb-6">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('large', array('class' => 'rounded-lg', 'style' => 'width: 100%; height: 200px; object-fit: cover;')); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <header class="entry-header mb-4">
                            <?php if (is_singular()) : ?>
                                <h1 class="entry-title"><?php the_title(); ?></h1>
                            <?php else : ?>
                                <h2 class="entry-title">
                                    <a href="<?php the_permalink(); ?>" class="text-foreground hover:text-primary transition" style="text-decoration: none;">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>
                            <?php endif; ?>

                            <div class="entry-meta text-muted" style="font-size: 0.875rem;">
                                <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                                <?php if (get_the_category()) : ?>
                                    <span class="sep"> • </span>
                                    <?php the_category(', '); ?>
                                <?php endif; ?>
                            </div>
                        </header>

                        <div class="entry-content">
                            <?php if (is_singular()) : ?>
                                <?php the_content(); ?>
                            <?php else : ?>
                                <?php the_excerpt(); ?>
                                <p>
                                    <a href="<?php the_permalink(); ?>" class="btn btn-outline">
                                        <?php esc_html_e('Read More', 'sillygoose'); ?>
                                    </a>
                                </p>
                            <?php endif; ?>
                        </div>

                        <?php if (is_singular() && (get_the_tags() || get_the_category())) : ?>
                            <footer class="entry-footer mt-8 pt-6" style="border-top: 1px solid var(--border);">
                                <?php if (get_the_tags()) : ?>
                                    <div class="post-tags mb-4">
                                        <strong><?php esc_html_e('Tags:', 'sillygoose'); ?></strong>
                                        <?php the_tags('', ' '); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (get_the_category()) : ?>
                                    <div class="post-categories">
                                        <strong><?php esc_html_e('Categories:', 'sillygoose'); ?></strong>
                                        <?php the_category(', '); ?>
                                    </div>
                                <?php endif; ?>
                            </footer>
                        <?php endif; ?>
                    </article>
                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <div class="pagination-wrapper mt-16 text-center">
                <?php
                the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => esc_html__('← Previous', 'sillygoose'),
                    'next_text' => esc_html__('Next →', 'sillygoose'),
                ));
                ?>
            </div>

        <?php else : ?>
            <div class="no-posts text-center py-24">
                <h1><?php esc_html_e('Nothing Found', 'sillygoose'); ?></h1>
                <p class="text-muted mb-8">
                    <?php if (is_search()) : ?>
                        <?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'sillygoose'); ?>
                    <?php else : ?>
                        <?php esc_html_e('It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'sillygoose'); ?>
                    <?php endif; ?>
                </p>
                <?php get_search_form(); ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>