<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>

    <!-- Naomi Testing Visual Studio 2 -->
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#main"><?php esc_html_e('Skip to content', 'sillygoose'); ?></a>

    <header id="masthead" class="site-header">
        <div class="header-content">
            <div class="site-branding">
                <?php
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo" rel="home">
                        <svg width="32" height="32" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 0.5rem; vertical-align: middle;">
                            <!-- Simplified SVG goose logo -->
                            <circle cx="100" cy="100" r="90" fill="currentColor" opacity="0.1"/>
                            <path d="M60 120 Q80 80 120 90 Q140 95 150 110 Q155 120 145 130 Q130 140 110 135 Q90 130 80 140 Q70 130 60 120Z" fill="currentColor"/>
                            <circle cx="125" cy="105" r="3" fill="white"/>
                            <path d="M145 110 Q155 108 160 115" stroke="currentColor" stroke-width="2" fill="none"/>
                        </svg>
                        <?php bloginfo('name'); ?>
                    </a>
                    <?php
                }
                
                $description = get_bloginfo('description', 'display');
                if ($description || is_customize_preview()) {
                    ?>
                    <p class="site-description screen-reader-text"><?php echo esc_html($description); ?></p>
                    <?php
                }
                ?>
            </div><!-- .site-branding -->

            <nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e('Primary Menu', 'sillygoose'); ?>">
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation menu', 'sillygoose'); ?>">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                    <span class="screen-reader-text"><?php esc_html_e('Menu', 'sillygoose'); ?></span>
                </button>

                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'menu_class'     => 'nav-menu',
                    'container'      => false,
                    'fallback_cb'    => 'sillygoose_fallback_menu',
                    'depth'          => 2,
                    // Remove the walker - this was causing the error
                ]);
                ?>
            </nav><!-- #site-navigation -->
        </div><!-- .header-content -->
    </header><!-- #masthead -->

    <main id="main" class="site-main">

<?php
/**
 * Fallback menu function
 */
function sillygoose_fallback_menu() {
    ?>
    <ul id="primary-menu" class="nav-menu">
        <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'sillygoose'); ?></a></li>
        <li><a href="<?php echo esc_url(home_url('/#about')); ?>"><?php esc_html_e('About', 'sillygoose'); ?></a></li>
        <li><a href="<?php echo esc_url(home_url('/#services')); ?>"><?php esc_html_e('Services', 'sillygoose'); ?></a></li>
        <li><a href="<?php echo esc_url(home_url('/#work')); ?>"><?php esc_html_e('Work', 'sillygoose'); ?></a></li>
        <li><a href="<?php echo esc_url(home_url('/#contact')); ?>"><?php esc_html_e('Contact', 'sillygoose'); ?></a></li>
    </ul>
    <?php
}
?>