</main><!-- #main -->

    <footer id="colophon" class="site-footer">
        <div class="container">
            <?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3')) : ?>
                <div class="footer-content">
                    <?php if (is_active_sidebar('footer-1')) : ?>
                        <div class="footer-section">
                            <?php dynamic_sidebar('footer-1'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (is_active_sidebar('footer-2')) : ?>
                        <div class="footer-section">
                            <?php dynamic_sidebar('footer-2'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (is_active_sidebar('footer-3')) : ?>
                        <div class="footer-section">
                            <?php dynamic_sidebar('footer-3'); ?>
                        </div>
                    <?php endif; ?>
                </div><!-- .footer-content -->
            <?php else : ?>
                <!-- Default footer content if no widgets -->
                <div class="footer-content">
                    <!-- About Section -->
                    <div class="footer-section">
                        <h4><?php esc_html_e('About Silly Goose', 'sillygoose'); ?></h4>
                        <p><?php esc_html_e('We\'re a wickedly creative digital agency based in Plymouth, UK. We don\'t just adapt to the digital age - we\'re making it our playground.', 'sillygoose'); ?></p>
                        
                        <!-- Social Media Links -->
                        <div class="social-links" style="margin-top: 1rem;">
                            <?php
                            $social_links = [
                                'facebook' => get_theme_mod('facebook_url', '#'),
                                'twitter' => get_theme_mod('twitter_url', '#'),
                                'instagram' => get_theme_mod('instagram_url', '#'),
                                'linkedin' => get_theme_mod('linkedin_url', '#'),
                            ];
                            
                            foreach ($social_links as $platform => $url) :
                                if ($url && $url !== '#') :
                            ?>
                                <a href="<?php echo esc_url($url); ?>" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   aria-label="<?php echo esc_attr(ucfirst($platform)); ?>"
                                   style="display: inline-block; margin-right: 1rem; color: #d1d5db; transition: color 0.3s ease;">
                                    <?php echo sillygoose_get_social_icon($platform); ?>
                                </a>
                            <?php 
                                endif;
                            endforeach; 
                            ?>
                        </div>
                    </div>

                    <!-- Services Section -->
                    <div class="footer-section">
                        <h4><?php esc_html_e('Services', 'sillygoose'); ?></h4>
                        <ul style="list-style: none; margin: 0; padding: 0;">
                            <li style="margin-bottom: 0.5rem;">
                                <a href="<?php echo esc_url(home_url('/#services')); ?>" 
                                   style="color: #d1d5db; text-decoration: none; font-size: 0.875rem; transition: color 0.3s ease;"
                                   onmouseover="this.style.color='var(--primary)'" 
                                   onmouseout="this.style.color='#d1d5db'">
                                    <?php esc_html_e('Web Design', 'sillygoose'); ?>
                                </a>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <a href="<?php echo esc_url(home_url('/#services')); ?>" 
                                   style="color: #d1d5db; text-decoration: none; font-size: 0.875rem; transition: color 0.3s ease;"
                                   onmouseover="this.style.color='var(--primary)'" 
                                   onmouseout="this.style.color='#d1d5db'">
                                    <?php esc_html_e('Web Development', 'sillygoose'); ?>
                                </a>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <a href="<?php echo esc_url(home_url('/#services')); ?>" 
                                   style="color: #d1d5db; text-decoration: none; font-size: 0.875rem; transition: color 0.3s ease;"
                                   onmouseover="this.style.color='var(--primary)'" 
                                   onmouseout="this.style.color='#d1d5db'">
                                    <?php esc_html_e('SEO', 'sillygoose'); ?>
                                </a>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <a href="<?php echo esc_url(home_url('/#services')); ?>" 
                                   style="color: #d1d5db; text-decoration: none; font-size: 0.875rem; transition: color 0.3s ease;"
                                   onmouseover="this.style.color='var(--primary)'" 
                                   onmouseout="this.style.color='#d1d5db'">
                                    <?php esc_html_e('Digital Marketing', 'sillygoose'); ?>
                                </a>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <a href="<?php echo esc_url(home_url('/#services')); ?>" 
                                   style="color: #d1d5db; text-decoration: none; font-size: 0.875rem; transition: color 0.3s ease;"
                                   onmouseover="this.style.color='var(--primary)'" 
                                   onmouseout="this.style.color='#d1d5db'">
                                    <?php esc_html_e('E-commerce', 'sillygoose'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo esc_url(home_url('/#services')); ?>" 
                                   style="color: #d1d5db; text-decoration: none; font-size: 0.875rem; transition: color 0.3s ease;"
                                   onmouseover="this.style.color='var(--primary)'" 
                                   onmouseout="this.style.color='#d1d5db'">
                                    <?php esc_html_e('Brand Strategy', 'sillygoose'); ?>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Company Section -->
                    <div class="footer-section">
                        <h4><?php esc_html_e('Company', 'sillygoose'); ?></h4>
                        <ul style="list-style: none; margin: 0; padding: 0;">
                            <li style="margin-bottom: 0.5rem;">
                                <a href="<?php echo esc_url(home_url('/#about')); ?>" 
                                   style="color: #d1d5db; text-decoration: none; font-size: 0.875rem; transition: color 0.3s ease;"
                                   onmouseover="this.style.color='var(--primary)'" 
                                   onmouseout="this.style.color='#d1d5db'">
                                    <?php esc_html_e('About Us', 'sillygoose'); ?>
                                </a>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <a href="<?php echo esc_url(home_url('/#work')); ?>" 
                                   style="color: #d1d5db; text-decoration: none; font-size: 0.875rem; transition: color 0.3s ease;"
                                   onmouseover="this.style.color='var(--primary)'" 
                                   onmouseout="this.style.color='#d1d5db'">
                                    <?php esc_html_e('Our Work', 'sillygoose'); ?>
                                </a>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <a href="<?php echo esc_url(home_url('/blog')); ?>" 
                                   style="color: #d1d5db; text-decoration: none; font-size: 0.875rem; transition: color 0.3s ease;"
                                   onmouseover="this.style.color='var(--primary)'" 
                                   onmouseout="this.style.color='#d1d5db'">
                                    <?php esc_html_e('Blog', 'sillygoose'); ?>
                                </a>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <a href="<?php echo esc_url(home_url('/#contact')); ?>" 
                                   style="color: #d1d5db; text-decoration: none; font-size: 0.875rem; transition: color 0.3s ease;"
                                   onmouseover="this.style.color='var(--primary)'" 
                                   onmouseout="this.style.color='#d1d5db'">
                                    <?php esc_html_e('Contact', 'sillygoose'); ?>
                                </a>
                            </li>
                            <li style="margin-bottom: 0.5rem;">
                                <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>" 
                                   style="color: #d1d5db; text-decoration: none; font-size: 0.875rem; transition: color 0.3s ease;"
                                   onmouseover="this.style.color='var(--primary)'" 
                                   onmouseout="this.style.color='#d1d5db'">
                                    <?php esc_html_e('Privacy Policy', 'sillygoose'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo esc_url(home_url('/terms-of-service')); ?>" 
                                   style="color: #d1d5db; text-decoration: none; font-size: 0.875rem; transition: color 0.3s ease;"
                                   onmouseover="this.style.color='var(--primary)'" 
                                   onmouseout="this.style.color='#d1d5db'">
                                    <?php esc_html_e('Terms of Service', 'sillygoose'); ?>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Contact Section -->
                    <div class="footer-section">
                        <h4><?php esc_html_e('Get In Touch', 'sillygoose'); ?></h4>
                        <div style="margin-bottom: 1rem;">
                            <strong style="color: white; display: block; margin-bottom: 0.5rem;"><?php esc_html_e('Email:', 'sillygoose'); ?></strong>
                            <a href="mailto:<?php echo esc_attr(get_theme_mod('contact_email', 'hello@sillygoose.agency')); ?>" 
                               style="color: #d1d5db; text-decoration: none; font-size: 0.875rem; transition: color 0.3s ease;"
                               onmouseover="this.style.color='var(--primary)'" 
                               onmouseout="this.style.color='#d1d5db'">
                                <?php echo esc_html(get_theme_mod('contact_email', 'hello@sillygoose.agency')); ?>
                            </a>
                        </div>
                        
                        <div style="margin-bottom: 1rem;">
                            <strong style="color: white; display: block; margin-bottom: 0.5rem;"><?php esc_html_e('Phone:', 'sillygoose'); ?></strong>
                            <a href="tel:<?php echo esc_attr(str_replace(' ', '', get_theme_mod('contact_phone', '+44 1752 123456'))); ?>" 
                               style="color: #d1d5db; text-decoration: none; font-size: 0.875rem; transition: color 0.3s ease;"
                               onmouseover="this.style.color='var(--primary)'" 
                               onmouseout="this.style.color='#d1d5db'">
                                <?php echo esc_html(get_theme_mod('contact_phone', '+44 1752 123456')); ?>
                            </a>
                        </div>
                        
                        <div>
                            <strong style="color: white; display: block; margin-bottom: 0.5rem;"><?php esc_html_e('Location:', 'sillygoose'); ?></strong>
                            <span style="color: #d1d5db; font-size: 0.875rem;">
                                <?php echo esc_html(get_theme_mod('contact_location', 'Plymouth, United Kingdom')); ?>
                            </span>
                        </div>

                        <!-- Newsletter Signup -->
                        <div style="margin-top: 1.5rem;">
                            <h5 style="color: white; margin-bottom: 0.75rem; font-size: 1rem;"><?php esc_html_e('Newsletter', 'sillygoose'); ?></h5>
                            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" style="display: flex; gap: 0.5rem;">
                                <?php wp_nonce_field('sillygoose_newsletter', 'newsletter_nonce'); ?>
                                <input type="hidden" name="action" value="sillygoose_newsletter_signup">
                                <input type="email" 
                                       name="newsletter_email" 
                                       placeholder="<?php esc_attr_e('Your email', 'sillygoose'); ?>" 
                                       required
                                       style="flex: 1; padding: 0.5rem; border: 1px solid #374151; border-radius: 0.375rem; background: #1f2937; color: white; font-size: 0.875rem;">
                                <button type="submit" 
                                        style="padding: 0.5rem 1rem; background: var(--primary); color: white; border: none; border-radius: 0.375rem; cursor: pointer; font-weight: 600; font-size: 0.875rem; transition: background 0.3s ease;"
                                        onmouseover="this.style.background='var(--secondary)'" 
                                        onmouseout="this.style.background='var(--primary)'">
                                    <?php esc_html_e('Subscribe', 'sillygoose'); ?>
                                </button>
                            </form>
                        </div>
                    </div>
                </div><!-- .footer-content -->
            <?php endif; ?>

            <div class="footer-bottom">
                <p style="margin: 0; text-align: center;">
                    &copy; <?php echo esc_html(date('Y')); ?> 
                    <a href="<?php echo esc_url(home_url('/')); ?>" style="color: inherit; text-decoration: none;">
                        <?php bloginfo('name'); ?>
                    </a>. 
                    <?php esc_html_e('All rights reserved.', 'sillygoose'); ?>
                    <?php esc_html_e('Made with', 'sillygoose'); ?> 
                    <span style="color: var(--primary);">♥</span> 
                    <?php esc_html_e('in Plymouth, UK', 'sillygoose'); ?>
                </p>
                
                <?php
                // Footer navigation menu
                if (has_nav_menu('footer')) {
                    wp_nav_menu([
                        'theme_location' => 'footer',
                        'menu_class'     => 'footer-menu',
                        'container'      => 'nav',
                        'container_class' => 'footer-navigation',
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    ]);
                }
                ?>
            </div><!-- .footer-bottom -->
        </div><!-- .container -->
    </footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

<!-- Performance monitoring for admins in debug mode -->
<?php if (WP_DEBUG && current_user_can('administrator')) : ?>
    <script>
    // Performance monitoring
    window.addEventListener('load', function() {
        if ('performance' in window) {
            const navigation = performance.getEntriesByType('navigation')[0];
            const loadTime = navigation.loadEventEnd - navigation.loadEventStart;
            const domContentLoaded = navigation.domContentLoadedEventEnd - navigation.domContentLoadedEventStart;
            
            console.log('🦆 Silly Goose Performance:', {
                'Load Time': loadTime + 'ms',
                'DOM Content Loaded': domContentLoaded + 'ms',
                'First Paint': performance.getEntriesByName('first-paint')[0]?.startTime + 'ms',
                'First Contentful Paint': performance.getEntriesByName('first-contentful-paint')[0]?.startTime + 'ms'
            });
        }
    });
    </script>
<?php endif; ?>

</body>
</html>

<?php
/**
 * Get social media icon SVG
 */
function sillygoose_get_social_icon($platform) {
    $icons = [
        'facebook' => '<svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
        'twitter' => '<svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>',
        'instagram' => '<svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>',
        'linkedin' => '<svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
    ];
    
    return isset($icons[$platform]) ? $icons[$platform] : '';
}

/**
 * Handle newsletter signup
 */
function sillygoose_handle_newsletter_signup() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['newsletter_nonce'], 'sillygoose_newsletter')) {
        wp_die(__('Security check failed', 'sillygoose'));
    }
    
    $email = sanitize_email($_POST['newsletter_email']);
    
    if (!is_email($email)) {
        wp_redirect(add_query_arg('newsletter', 'invalid', wp_get_referer()));
        exit;
    }
    
    // Store email in database or send to mail service
    // For now, we'll just send an admin notification
    $admin_email = get_option('admin_email');
    $subject = sprintf(__('New newsletter signup: %s', 'sillygoose'), $email);
    $message = sprintf(__('New newsletter signup from: %s', 'sillygoose'), $email);
    
    wp_mail($admin_email, $subject, $message);
    
    // Redirect with success message
    wp_redirect(add_query_arg('newsletter', 'success', wp_get_referer()));
    exit;
}
add_action('admin_post_sillygoose_newsletter_signup', 'sillygoose_handle_newsletter_signup');
add_action('admin_post_nopriv_sillygoose_newsletter_signup', 'sillygoose_handle_newsletter_signup');

/**
 * Display newsletter signup messages
 */
function sillygoose_newsletter_messages() {
    if (isset($_GET['newsletter'])) {
        $message_type = sanitize_text_field($_GET['newsletter']);
        
        switch ($message_type) {
            case 'success':
                echo '<div class="newsletter-message success" style="background: #4ade80; color: white; padding: 1rem; border-radius: 0.5rem; margin: 1rem 0; text-align: center;">';
                echo esc_html__('Thank you for subscribing to our newsletter!', 'sillygoose');
                echo '</div>';
                break;
                
            case 'invalid':
                echo '<div class="newsletter-message error" style="background: #ef4444; color: white; padding: 1rem; border-radius: 0.5rem; margin: 1rem 0; text-align: center;">';
                echo esc_html__('Please enter a valid email address.', 'sillygoose');
                echo '</div>';
                break;
        }
    }
}
add_action('wp_footer', 'sillygoose_newsletter_messages');