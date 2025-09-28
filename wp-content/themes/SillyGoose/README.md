# Silly Goose WordPress Theme

A wickedly creative WordPress theme for digital agencies based in Plymouth, UK. We're not going to be beaten by AI, we're making it our bitch.

## Features

- **Custom Goose Logo**: Beautiful SVG logo with realistic goose design
- **Bright Color Scheme**: Orange (#ff6b35), Teal (#4ecdc4), and Yellow (#ffd23f)
- **Fully Responsive**: Works perfectly on all devices
- **Plymouth, UK Localized**: British English and UK-specific contact information
- **Contact Form**: Built-in contact form with email handling
- **Portfolio Support**: Custom post type for showcasing work
- **Service Showcase**: Built-in services section
- **Newsletter Signup**: Footer newsletter subscription
- **Custom Post Types**: Portfolio and Services post types
- **Theme Customizer**: Easy customization through WordPress Customizer
- **SEO Friendly**: Clean, semantic HTML structure

## Installation

1. Download the theme files
2. Upload to your WordPress `/wp-content/themes/` directory
3. Activate the theme through the WordPress admin
4. Customize through Appearance > Customize

## Theme Structure

```
sillygoose/
├── style.css           # Main stylesheet with theme info
├── functions.php       # Theme functions and features
├── header.php         # Site header template
├── footer.php         # Site footer template
├── front-page.php     # Homepage template
├── index.php          # Main template file
├── single.php         # Single post template
├── js/
│   └── theme.js       # Theme JavaScript
└── README.md          # This file
```

## Customization

### Theme Customizer Options

Access through **Appearance > Customize**:

- **Hero Section**: Customize hero title, subtitle, and description
- **Contact Information**: Set email, phone, and location
- **Social Media**: Add social media URLs

### Custom Post Types

#### Portfolio
- Create portfolio items through **Portfolio** in the admin menu
- Add custom fields:
  - `portfolio_category`: Project category (e.g., "E-commerce")
  - `portfolio_result`: Project result (e.g., "300% increase in sales")
  - `portfolio_tags`: Comma-separated tags

#### Services
- Create service items through **Services** in the admin menu
- Use for additional services beyond the built-in ones

### Color Scheme

The theme uses CSS custom properties for easy color customization:

```css
:root {
  --primary: #ff6b35;    /* Orange */
  --secondary: #4ecdc4;  /* Teal */
  --accent: #ffd23f;     /* Yellow */
  --background: #ffffff;
  --foreground: #212529;
  --muted: #f8f9fa;
  --muted-foreground: #6c757d;
}
```

### Services Configuration

The theme includes 6 built-in services:
1. Web Design
2. Web Development  
3. SEO
4. Paid Media Marketing
5. E-commerce
6. Brand Strategy

To modify services, edit the `$services` array in `front-page.php`.

## Features In Detail

### Contact Form

The theme includes a built-in contact form that:
- Sends emails to the site admin
- Includes form validation
- Shows success/error messages
- Uses WordPress nonces for security

### Hero Section

Fully customizable hero section with:
- Animated floating elements
- Gradient text effects
- Statistics counters
- Call-to-action buttons

### Portfolio Section

Dynamic portfolio section that:
- Pulls from Portfolio custom post type
- Falls back to sample projects if none exist
- Includes project categories and results
- Responsive grid layout

### About Section

Features company information with:
- Team statistics
- Company description
- Team photo placeholder
- Client rating badge

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Performance

The theme is optimized for performance with:
- Minimal JavaScript footprint
- Optimized CSS
- Responsive images
- Smooth animations using CSS transitions

## SEO Features

- Semantic HTML5 structure
- Clean URL structure
- Meta tag support
- Open Graph ready
- Schema.org markup ready

## Accessibility

- ARIA labels where appropriate
- Keyboard navigation support
- Screen reader friendly
- High contrast color scheme
- Focus indicators

## WordPress Features

- Custom logo support
- Featured image support
- Widget areas (sidebar and footer)
- Navigation menus
- Post thumbnails
- Comment system
- Search functionality

## Development

### File Structure

- `style.css` - Main stylesheet with theme header
- `functions.php` - Theme setup and functionality
- `header.php` - Site header and navigation
- `footer.php` - Site footer with social links
- `front-page.php` - Homepage template with all sections
- `index.php` - Blog and archive template
- `single.php` - Single post template
- `js/theme.js` - Theme JavaScript for interactions

### Hooks and Filters

The theme uses standard WordPress hooks:
- `after_setup_theme` - Theme setup
- `wp_enqueue_scripts` - Enqueue styles and scripts
- `widgets_init` - Register widget areas
- `customize_register` - Add customizer options

## Support

For support and customization requests, contact Silly Goose Digital Agency:

- **Email**: hello@sillygoose.agency
- **Phone**: +44 1752 SILLY-GOOSE
- **Location**: Plymouth, UK

## License

This theme is proprietary to Silly Goose Digital Agency. All rights reserved.

## Changelog

### Version 1.0
- Initial release
- Homepage design with all sections
- Contact form functionality
- Portfolio custom post type
- Theme customizer options
- Responsive design
- Plymouth, UK localization