# Ads Manager Module

This advertising management module for Juzaweb CMS supports both banner and video ads, with flexible display placement management capabilities.

## Features

- **Banner Ads Management**: Manage banner advertisements with two types:
  - Image Banner: Display images with clickable links
  - HTML Banner: Custom HTML code support
- **Video Ads Management**: Manage video advertisements with VAST support
- **Position Management**: Manage ad positions by theme
- **Statistics Tracking**: Track views and clicks
- **Frontend Integration**: Helper functions for displaying ads on frontend

## Installation

This module is part of Juzaweb CMS. To install:

```bash
composer require juzaweb/ads-manager
```

## Usage

### Registering Ad Positions

Register ad positions in your theme or module:

```php
use Juzaweb\Modules\AdsManagement\Facades\Ads;

// Register banner position
Ads::position('header-banner', function () {
    return [
        'name' => 'Header Banner',
        'type' => 'banner',
    ];
});

// Register video position
Ads::position('video-preroll', function () {
    return [
        'name' => 'Video Pre-roll',
        'type' => 'video',
    ];
});
```

### Displaying Ads in Frontend

#### Using Helper Function

```php
// In Blade template
{!! ads_position('header-banner') !!}
```

#### Using Facade

```php
use Juzaweb\Modules\AdsManagement\Facades\Ads;

$banner = Ads::getBanner('header-banner');
if ($banner) {
    echo $banner->getBody();
}
```

### Managing Ads Programmatically

#### Create Banner Ad

```php
use Juzaweb\Modules\AdsManagement\Models\BannerAds;
use Juzaweb\Modules\AdsManagement\Enums\BannerAdsType;

$banner = BannerAds::create([
    'name' => 'Homepage Banner',
    'body' => 'uploads/banner.jpg', // For image type
    'url' => 'https://example.com',
    'type' => BannerAdsType::TYPE_BANNER,
    'active' => true,
]);

// Assign to position
$banner->positions()->create([
    'position' => 'header-banner',
    'theme' => 'default',
]);
```

#### Create Video Ad

```php
use Juzaweb\Modules\AdsManagement\Models\VideoAds;

$videoAd = VideoAds::create([
    'name' => 'Pre-roll Ad',
    'title' => 'Watch this ad',
    'url' => 'https://example.com',
    'video' => 'https://example.com/ad-video.mp4',
    'position' => 'pre-roll',
    'offset' => 0,
    'active' => true,
]);
```

### Querying Ads

```php
use Juzaweb\Modules\AdsManagement\Models\BannerAds;

// Get active banners for specific position
$banners = BannerAds::whereFrontend()
    ->wherePosition('header-banner')
    ->get();

// Get all banner positions
$positions = Ads::bannerPositions();

// Get all video positions
$positions = Ads::videoPositions();
```

## Admin Panel

The module automatically registers menus in the admin panel:

- **Ad Management** (parent menu)
  - **Banner Ads**: Manage banner advertisements
  - **Video Ads**: Manage video advertisements

### Permissions

- `banner-ads.index`: View banner ads list
- `video-ads.index`: View video ads list

## API Endpoints

### Admin Routes
- `GET /admin-cp/banner-ads` - List banner ads
- `GET /admin-cp/banner-ads/create` - Create banner ad form
- `POST /admin-cp/banner-ads` - Store new banner ad
- `GET /admin-cp/banner-ads/{id}/edit` - Edit banner ad form
- `PUT /admin-cp/banner-ads/{id}` - Update banner ad
- `DELETE /admin-cp/banner-ads/{id}` - Delete banner ad

Similar routes for video ads at `/admin-cp/video-ads`

## VAST Support

The module supports VAST (Video Ad Serving Template) for serving video ads:

- `Juzaweb\Modules\AdsManagement\Vast\Document` - VAST document builder
- `Juzaweb\Modules\AdsManagement\Vast\Factory` - Factory for creating VAST elements
- Support for InLine and Wrapper ads
- Linear and Non-linear creatives

## Configuration

Publish config file:

```bash
php artisan vendor:publish --tag=ad-management-config
```

Config file location: `config/ad-management.php`

## Translations

The module supports multiple languages including:
- English (en)
- Vietnamese (vi)
- Spanish (es)
- French (fr)
- German (de)
- Czech (cs)
- Portuguese (pt)
- Russian (ru)

## Development

### Running Tests

```bash
composer test
```

### Code Style

The module follows PSR-2 coding standards.

## License

MIT License

## Author

The Anh Dang - [Juzaweb CMS](https://juzaweb.com)

## Support

For issues and feature requests, please use the [GitHub issue tracker](https://github.com/juzaweb/cms).
