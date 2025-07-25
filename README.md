# Hope Loans

A WordPress-based crowdfunding platform that connects donors with community development projects and provides hope through sustainable giving.

## Overview

Hope Loans is a charitable crowdfunding platform built on WordPress that enables individuals and organizations to:
- Fund community development projects in areas like health, education, clean water, and agriculture
- Create personal fundraising campaigns for specific Hope Projects
- Provide microloans to help communities become self-sustaining
- Share stories of impact and transformation

## Technical Stack

- **WordPress**: 4.8.x
- **PHP**: 5.6+ 
- **MySQL**: 5.x
- **Framework**: Custom JMVC (Model-View-Controller) framework
- **Theme**: Child theme of Visual Composer Starter
- **Key Plugins**:
  - Charitable (donation management)
  - WooCommerce (e-commerce functionality)
  - Advanced Custom Fields Pro (content management)
  - Visual Composer (page builder)
  - Formidable Pro (forms)
  - Admin Columns Pro
  - Stripe (payment processing)

## Architecture

### JMVC Framework
The site uses a custom MVC framework located in `/jmvc/` with the following structure:
- **Models**: `HopeCampaign`, `Story` (formerly `HopeProject`)
- **Views**: Template files for campaigns and maps
- **Controllers**: API and Map controllers
- **Libraries**: Custom plugins and modifications

### Campaign Types
1. **Hope Projects** (`CAMPAIGN_IS_A_HOPE_PROJECT`) - Direct community development projects
2. **Earmarked for Hope Project** (`CAMPAIGN_EARMARKED_FOR_HOPE_PROJECT`) - Personal fundraisers for specific projects
3. **Earmarked for Hope Loan** (`CAMPAIGN_EARMARKED_FOR_HOPE_LOAN`) - Fundraisers for microloans
4. **Non-earmarked Donation** (`CAMPAIGN_NON_EARMARKED_DONATION`) - General donations

### Project Categories
- Health
- Education
- Clean Water
- Agriculture

## Installation

### Prerequisites
- PHP 5.6 or higher
- MySQL 5.x
- Apache/Nginx web server
- Composer

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone [repository-url]
   cd hopeloans
   ```

2. **Configure WordPress**
   - Copy `wp-config-sample.php` to `wp-config.php`
   - Update database credentials
   - Set authentication keys

3. **Install JMVC dependencies**
   ```bash
   cd jmvc
   composer dump-autoload
   ```

4. **Database Setup**
   - Create MySQL database named `hopeloans`
   - Import database dump (if provided)
   - Run WordPress installation if starting fresh

5. **Enable JMVC Framework**
   - Ensure `functions.php` includes: `require_once(ABSPATH . '/jmvc/app/start.php');`

## Development

### File Structure
```
hopeloans/
├── jmvc/                    # Custom MVC framework
│   ├── app/                 # Application bootstrap
│   ├── models/              # Data models
│   ├── views/               # View templates
│   ├── controllers/         # Request handlers
│   └── assets/              # JS/CSS assets
├── wp-content/
│   ├── themes/
│   │   └── hope-loans/      # Child theme
│   ├── plugins/             # WordPress plugins
│   └── uploads/             # Media files
└── wp-admin/                # WordPress admin
```

### Key Models

#### HopeCampaign
Main model for all campaign types with features:
- Progress tracking with starting funds
- Goal management
- Geolocation support
- Category assignment
- Parent/child campaign relationships
- Automatic completion detection

#### Story
Model for user testimonials and impact stories

### Shortcodes

Campaign display:
- `[hope-campaign-progressbar]` - Shows funding progress
- `[hope-campaign-category-icon-img]` - Category icon
- `[hope-campaign-donate-btn]` - Donation button
- `[hope-campaign-goal]` - Campaign goal amount
- `[hope-campaign-amount-left-to-raise]` - Remaining funding needed

Story display:
- `[story-random-headshot]` - Random story profile image
- `[story-random-name]` - Random story name
- `[story-random-excerpt]` - Random story excerpt

### AJAX Endpoints
```
/wp-admin/admin-ajax.php?action=pub_controller&path=ControllerName/method/param1/param2
```

## Configuration

### Theme Settings
- Logo and branding: Customizer settings
- Color scheme: Defined in `scss/elements/colors.scss`
- Typography: Lato font family

### Campaign Settings
Default campaign IDs (defined in `HopeCampaign.php`):
- Hope Loan Campaign: 1727
- Donation Campaign: 1728  
- Standalone Campaign: 1760

### Payment Processing
- Stripe integration via Charitable Stripe addon
- SSL verification disabled for local development (`CURLOPT_SSL_VERIFYPEER`)

## Security

- WordPress Fail2Ban integration
- User enumeration blocking
- Spam logging
- Comment/pingback protection

## Maintenance

### Debug Mode
Enable in `wp-config.php`:
```php
define('WP_DEBUG', 1);
```

### Asset Versioning
Update `JMVC_ASSETS_VER` in `/jmvc/app/start.php` to bust cache

### Database Optimization
- Post revisions limited to 10
- Regular cleanup of transients recommended

## Contributing

1. Follow WordPress coding standards
2. Use the JMVC framework for new features
3. Test on PHP 5.6 and 7.x
4. Create shortcodes for reusable components
5. Document new models and controllers

## License

[License information to be added]

## Support

For issues and questions:
- Check `/jmvc/README.md` for framework-specific guidance
- Review theme documentation in `/wp-content/themes/hope-loans/README.md`
- Contact the development team

---

*Hope Loans - Bringing hope through sustainable community development*