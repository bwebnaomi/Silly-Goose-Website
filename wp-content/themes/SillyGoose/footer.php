</main>

<footer id="colophon" class="site-footer">
    <div class="container">
        <?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3')) : ?>
            <div class="footer-content">
                <?php foreach (['footer-1', 'footer-2', 'footer-3'] as $sidebar) :
                    if (is_active_sidebar($sidebar)) : ?>
                        <div class="footer-section"><?php dynamic_sidebar($sidebar); ?></div>
                    <?php endif;
                endforeach; ?>
            </div>
        <?php else : ?>
            <div class="footer-content">
                <div class="footer-section">
                    <h4><?php esc_html_e('About Silly Goose', 'sillygoose'); ?></h4>
                    <p><?php esc_html_e('We\'re a wickedly creative digital agency based in Plymouth, UK. We don\'t just adapt to the digital age - we\'re making it our playground.', 'sillygoose'); ?></p>
                    <div class="social-links">
                        <?php foreach (['facebook', 'twitter', 'instagram', 'linkedin'] as $platform) :
                            $url = get_theme_mod($platform . '_url');
                            if ($url && $url !== '#') : ?>
                                <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr(ucfirst($platform)); ?>" class="social-link">
                                    <?php echo sillygoose_get_social_icon($platform); ?>
                                </a>
                            <?php endif;
                        endforeach; ?>
                    </div>
                </div>

                <div class="footer-section">
                    <h4><?php esc_html_e('Services', 'sillygoose'); ?></h4>
                    <ul>
                        <?php foreach (['Web Design', 'Web Development', 'SEO', 'Digital Marketing', 'E-commerce', 'Brand Strategy'] as $service) : ?>
                            <li><a href="<?php echo esc_url(home_url('/#services')); ?>" class="footer-link"><?php esc_html_e($service, 'sillygoose'); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="footer-section">
                    <h4><?php esc_html_e('Company', 'sillygoose'); ?></h4>
                    <ul>
                        <?php foreach ([['url' => '/#about', 'label' => 'About Us'], ['url' => '/#work', 'label' => 'Our Work'], ['url' => '/blog', 'label' => 'Blog'], ['url' => '/#contact', 'label' => 'Contact'], ['url' => '/privacy-policy', 'label' => 'Privacy Policy'], ['url' => '/terms-of-service', 'label' => 'Terms of Service']] as $link) : ?>
                            <li><a href="<?php echo esc_url(home_url($link['url'])); ?>" class="footer-link"><?php esc_html_e($link['label'], 'sillygoose'); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="footer-section">
                    <h4><?php esc_html_e('Get In Touch', 'sillygoose'); ?></h4>
                    <div class="contact-item">
                        <strong><?php esc_html_e('Email:', 'sillygoose'); ?></strong>
                        <a href="mailto:<?php echo esc_attr(get_theme_mod('contact_email', 'hello@sillygoose.agency')); ?>" class="footer-link"><?php echo esc_html(get_theme_mod('contact_email', 'hello@sillygoose.agency')); ?></a>
                    </div>
                    <div class="contact-item">
                        <strong><?php esc_html_e('Phone:', 'sillygoose'); ?></strong>
                        <a href="tel:<?php echo esc_attr(str_replace(' ', '', get_theme_mod('contact_phone', '+44 1752 123456'))); ?>" class="footer-link"><?php echo esc_html(get_theme_mod('contact_phone', '+44 1752 123456')); ?></a>
                    </div>
                    <div class="contact-item">
                        <strong><?php esc_html_e('Location:', 'sillygoose'); ?></strong>
                        <span><?php echo esc_html(get_theme_mod('contact_location', 'Plymouth, United Kingdom')); ?></span>
                    </div>

                    <div class="newsletter-form">
                        <h5><?php esc_html_e('Newsletter', 'sillygoose'); ?></h5>
                        <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                            <?php wp_nonce_field('sillygoose_newsletter', 'newsletter_nonce'); ?>
                            <input type="hidden" name="action" value="sillygoose_newsletter_signup">
                            <input type="email" name="newsletter_email" placeholder="<?php esc_attr_e('Your email', 'sillygoose'); ?>" required class="newsletter-input">
                            <button type="submit" class="newsletter-btn"><?php esc_html_e('Subscribe', 'sillygoose'); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="footer-bottom">
            <p>&copy; <?php echo esc_html(date('Y')); ?> <a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>. <?php esc_html_e('All rights reserved. Made with', 'sillygoose'); ?> <span class="heart">♥</span> <?php esc_html_e('in Plymouth, UK', 'sillygoose'); ?></p>
            <?php if (has_nav_menu('footer')) {
                wp_nav_menu(['theme_location' => 'footer', 'menu_class' => 'footer-menu', 'container' => 'nav', 'container_class' => 'footer-navigation', 'depth' => 1, 'fallback_cb' => false]);
            } ?>
        </div>
    </div>
</footer>

</div>

<?php wp_footer(); ?>

</body>
</html>