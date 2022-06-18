JUZACMS - Laravel CMS for Your Project
=====================================

## About
- JuzaWeb CMS (JuzaCMS) is a Content Management System ([Laravel CMS](https://juzaweb.com)) like WordPress developed based on Laravel Framework 9 and web platform whose sole purpose is to make your development workflow simple again. 
- Juza CMS was engineered to be easy — for both developers and users. Project develop by Juzaweb.
- Demo site: 
    - Frontend: https://theme-default.juzaweb.com
    - Admin: 
        - https://theme-default.juzaweb.com/admin-cp 
        - User/Pass: demo@juzaweb.com / demo@juzaweb.com

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
- [x] Chunk Upload File manager
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
- [ ] Upload themes
- [ ] Short Code
- [ ] Add image from url
- [ ] Quick edit
- [ ] Response cache
- [ ] Preview post
- [ ] Activity logs
- [ ] Per page paginate config
- [ ] Api Support

## Plugins
* [E-Commerce](https://github.com/juzaweb/ecommerce) (developing)
* [Translation](https://github.com/juzaweb/translation)
* [Notification](https://github.com/juzaweb/notification)
* [Movie](https://github.com/juzaweb/movie)
* [Image Slider](https://github.com/juzaweb/image-slider)
* [Ads Manager](https://github.com/juzaweb/ads-manager)
* [Demo Site](https://github.com/juzaweb/demo-site)
* [Crawler](https://github.com/juzaweb/crawler) (developing)

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
