JUZACMS - Laravel CMS for Your Project
=====================================

## About
![https://buymeacoffee.com/juzaweb](https://i.imgur.com/toObY8s.png)
[![Total Downloads](https://img.shields.io/packagist/dt/juzaweb/juzacms.svg?style=social)](https://packagist.org/packages/juzaweb/juzacms)
[![GitHub Repo stars](https://img.shields.io/github/stars/juzaweb/juzacms?style=social)](https://github.com/juzaweb/juzacms)
[![GitHub followers](https://img.shields.io/github/followers/juzaweb?style=social)](github.com/juzaweb)
[![YouTube Channel Subscribers](https://img.shields.io/youtube/channel/subscribers/UCo6Dz9HjjBOJpgWsxkln0-A?style=social)](https://www.youtube.com/@juzaweb)

- JuzaWeb CMS is a Content Management System ([Laravel CMS](https://juzaweb.com)) like WordPress developed based on Laravel Framework 9 and web platform whose sole purpose is to make your development workflow simple again. 
- Juza CMS was engineered to be easy — for both developers and users. Project develop by Juzaweb.
- Demo Site: 
    - Frontend: https://cms.juzaweb.com
    - Admin: 
        - https://cms.juzaweb.com/admin-cp 
        - User/Pass: demo@juzaweb.com / demo@juzaweb.com
- Video Tutorial: https://www.youtube.com/@juzaweb/videos

## Requirements
- The modules package requires:
    - PHP 8.0 or higher
    - MySql 5.7 or higher

## Install
### Create project with composer
```
composer create-project --prefer-dist juzaweb/juzacms blog
```
### Install

Config database in your `.env` file, and run:

```
php artisan juzacms:install
```
- Publish config
```
php artisan vendor:publish --tag=cms_config
```

## Documentation
View all documentation [https://juzaweb.com/documentation](https://juzaweb.com/documentation)
Github: [https://github.com/juzaweb/docs](https://github.com/juzaweb/docs)

## Contributing
- Contributions are welcome, and are accepted via pull requests. Please review these guidelines before submitting any pull requests.
[https://github.com/juzaweb/juzacms/blob/master/CONTRIBUTING.md](https://github.com/juzaweb/juzacms/blob/master/CONTRIBUTING.md)

## Features
- [x] Fully Ajax load page.
- [x] File manager
- [x] Post Type support
- [x] Taxonomy support
- [x] Email service
- [x] Email templates
- [x] Email Log
- [x] Plugins
- [x] Themes
- [x] Theme Widgets
- [x] Menu builder by post type
- [x] Logs view
- [x] Added default theme
- [x] Page block
- [x] Permalinks
- [x] Upload themes
- [x] Upload plugins
- [x] Per page paginate config
- [x] **Network (multisite) support**
- [x] Backup setting
- [x] Seo setting
  - Sitemap
  - SEO content
  - Feed
- [x] Social login
  - [x] Google
  - [x] Facebook
  - [x] Tweater
  - [x] Github
  - [x] Instagram
- [x] User Permission
  - [x] Check permisson menu
  - [x] Policies
  - [ ] Check permisson button in views
- [ ] Media manager admin page
- [ ] Short Code
- [ ] Add image from url
- [ ] Quick edit
- [ ] Preview post
- [ ] Activity logs
- [ ] **Api Support**
  - [ ] Auth api
  - [x] Post Type api
  - [ ] Taxonomy api
  - [ ] User api
  - [ ] Media api

## Plugins
* [E-Commerce](https://github.com/juzaweb/ecommerce) (developing)
* [Notification](https://github.com/juzaweb/notification)
* [Movie](https://github.com/juzaweb/movie)
* [Image Slider](https://github.com/juzaweb/image-slider)
* [Ads Manager](https://github.com/juzaweb/ads-manager)
* [Demo Site](https://github.com/juzaweb/demo-site)

## Theme
### Default
### Gamxo

## Backend Javascript libraries
- Jquery
- Bootstrap 4
- select2
- font-awesome

## Change Logs
[https://juzaweb.com/documentation/changelog](https://juzaweb.com/documentation/changelog)

## Buy me coffee
[![Juzaweb Buy me coffee](https://i.imgur.com/MAqboRu.png)](https://buymeacoffee.com/juzaweb)
