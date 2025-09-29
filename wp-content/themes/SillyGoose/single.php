<?php
/**
 * Single Post Template
 */

get_header(); ?>

<main>
    <div class="container py-24">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-thumbnail mb-8">
                        <?php the_post_thumbnail('large', array('class' => 'rounded-lg', 'style' => 'width: 100%; height: 400px; object-fit: cover;')); ?>
                    </div>
                <?php endif; ?>

                <header class="entry-header mb-8 text-center">
                    <h1 class="entry-title mb-4"><?php the_title(); ?></h1>
                    
                    <div class="entry-meta text-muted mb-4" style="font-size: 0.875rem;">
                        <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                        <?php if (get_the_author()) : ?>
                            <span class="sep"> • </span>
                            <span class="author">By <?php the_author(); ?></span>
                        <?php endif; ?>
                        <?php if (get_the_category()) : ?>
                            <span class="sep"> • </span>
                            <?php the_category(', '); ?>
                        <?php endif; ?>
                    </div>

                    <?php if (has_excerpt()) : ?>
                        <div class="entry-excerpt text-muted" style="font-size: 1.125rem; max-width: 48rem; margin: 0 auto;">
                            <?php the_excerpt(); ?>
                        </div>
                    <?php endif; ?>
                </header>

                <div class="entry-content" style="max-width: 48rem; margin: 0 auto;">
                    <?php
                    the_content();

                    wp_link_pages(array(
                        'before' => '<div class="page-links mt-8"><span class="page-links-title">' . esc_html__('Pages:', 'sillygoose') . '</span>',
                        'after'  => '</div>',
                    ));
                    ?>
                </div>

                <?php if (get_the_tags() || get_the_category()) : ?>
                    <footer class="entry-footer mt-12 pt-8" style="border-top: 1px solid var(--border); max-width: 48rem; margin-left: auto; margin-right: auto;">
                        <div class="flex gap-8" style="flex-wrap: wrap;">
                            <?php if (get_the_tags()) : ?>
                                <div class="post-tags">
                                    <strong class="mb-2 block"><?php esc_html_e('Tags:', 'sillygoose'); ?></strong>
                                    <div class="flex gap-2" style="flex-wrap: wrap;">
                                        <?php
                                        $tags = get_the_tags();
                                        foreach ($tags as $tag) {
                                            echo '<a href="' . get_tag_link($tag->term_id) . '" class="badge">' . $tag->name . '</a>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (get_the_category()) : ?>
                                <div class="post-categories">
                                    <strong class="mb-2 block"><?php esc_html_e('Categories:', 'sillygoose'); ?></strong>
                                    <div class="flex gap-2" style="flex-wrap: wrap;">
                                        <?php
                                        $categories = get_the_category();
                                        foreach ($categories as $category) {
                                            echo '<a href="' . get_category_link($category->term_id) . '" class="badge">' . $category->name . '</a>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </footer>
                <?php endif; ?>
            </article>

            <!-- Author Bio -->
            <?php if (get_the_author_meta('description')) : ?>
                <div class="author-bio card mt-12" style="max-width: 48rem; margin-left: auto; margin-right: auto;">
                    <div class="flex gap-4 items-start">
                        <?php echo get_avatar(get_the_author_meta('ID'), 80, '', '', array('class' => 'rounded-full')); ?>
                        <div>
                            <h3 class="mb-2"><?php echo get_the_author(); ?></h3>
                            <p class="text-muted"><?php echo get_the_author_meta('description'); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Post Navigation -->
            <nav class="post-navigation mt-12" style="max-width: 48rem; margin: 0 auto;">
                <div class="grid gap-4" style="grid-template-columns: 1fr 1fr;">
                    <?php
                    $prev_post = get_previous_post();
                    $next_post = get_next_post();
                    ?>
                    
                    <div class="nav-previous">
                        <?php if ($prev_post) : ?>
                            <a href="<?php echo get_permalink($prev_post->ID); ?>" class="card block transition hover:shadow-lg" style="text-decoration: none;">
                                <div class="text-muted mb-2" style="font-size: 0.875rem;">
                                    ← <?php esc_html_e('Previous Post', 'sillygoose'); ?>
                                </div>
                                <h4 class="text-primary"><?php echo get_the_title($prev_post->ID); ?></h4>
                            </a>
                        <?php endif; ?>
                    </div>
                    
                    <div class="nav-next">
                        <?php if ($next_post) : ?>
                            <a href="<?php echo get_permalink($next_post->ID); ?>" class="card block transition hover:shadow-lg text-right" style="text-decoration: none;">
                                <div class="text-muted mb-2" style="font-size: 0.875rem;">
                                    <?php esc_html_e('Next Post', 'sillygoose'); ?> →
                                </div>
                                <h4 class="text-primary"><?php echo get_the_title($next_post->ID); ?></h4>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>

            <!-- Related Posts -->
            <?php
            $related_posts = get_posts(array(
                'category__in' => wp_get_post_categories(get_the_ID()),
                'numberposts'  => 3,
                'post__not_in' => array(get_the_ID()),
            ));

            if ($related_posts) :
            ?>
                <section class="related-posts mt-16">
                    <div class="container">
                        <h2 class="text-center mb-12"><?php esc_html_e('Related Posts', 'sillygoose'); ?></h2>
                        
                        <div class="grid gap-8" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">
                            <?php foreach ($related_posts as $post) : setup_postdata($post); ?>
                                <article class="card">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="post-thumbnail mb-4">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('medium', array('class' => 'rounded-lg', 'style' => 'width: 100%; height: 200px; object-fit: cover;')); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    <header class="entry-header mb-4">
                                        <h3 class="entry-title">
                                            <a href="<?php the_permalink(); ?>" class="text-foreground hover:text-primary transition" style="text-decoration: none;">
                                                <?php the_title(); ?>
                                            </a>
                                        </h3>
                                        
                                        <div class="entry-meta text-muted" style="font-size: 0.875rem;">
                                            <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                                        </div>
                                    </header>

                                    <div class="entry-content">
                                        <?php the_excerpt(); ?>
                                        <p>
                                            <a href="<?php the_permalink(); ?>" class="btn btn-outline">
                                                <?php esc_html_e('Read More', 'sillygoose'); ?>
                                            </a>
                                        </p>
                                    </div>
                                </article>
                            <?php endforeach; wp_reset_postdata(); ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <!-- Comments -->
            <?php if (comments_open() || get_comments_number()) : ?>
                <div class="comments-area mt-16" style="max-width: 48rem; margin-left: auto; margin-right: auto;">
                    <?php comments_template(); ?>
                </div>
            <?php endif; ?>

        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>