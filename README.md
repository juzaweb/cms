JUZACMS - CMS for Laravel Project
=================================

## About
- Juza CMS is a Content Management System (CMS) like Wordpress developed based on Laravel Framework 9 and web platform whose sole purpose is to make your development workflow simple again. 
- Juza CMS was engineered to be easy — for both developers and users. Project develop by Juzaweb.
- You can see the demo here https://theme-default.juzaweb.com

## Requirements
The modules package requires PHP 8.0 or higher.

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

## Contributing
- Contributions are welcome, and are accepted via pull requests. Please review these guidelines before submitting any pull requests.
[https://github.com/juzaweb/juzacms/blob/master/CONTRIBUTING.md](https://github.com/juzaweb/juzacms/blob/master/CONTRIBUTING.md)
- Core cms [juzaweb/cms](https://github.com/juzaweb/cms)
- Core Backend [juzaweb/backend](https://github.com/juzaweb/backend)

## Features
- [x] Fully Ajax load page.
- [x] File manager
- [x] Chunk Upload File manager
- [x] Post Type and Taxonomy support
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

### Plugins
#### Translation
* Git: [juzaweb/translation](https://github.com/juzaweb/translation)
#### Notification
* Git: [juzaweb/notification](https://github.com/juzaweb/notification)
* Features:
- [x] Send mail notification
- [x] Send notification database
- [ ] Send push notifications
#### Seo
* Features:
- [x] Auto render Sitemap
- [x] Seo content custom
- [x] Feed
#### Social login
* Features:
- [x] Google
- [x] Facebook
- [x] Tweater
- [x] Github
- [x] Instagram
#### Subscribes
* Features:
- [x] Paypal
- [ ] Stripe
#### User Permission
* Features:
- [x] Check permisson menu
- [x] Policies
- [ ] Check permisson button in views
#### E-commerce
* Features:
- [x] Product management
- [x] Payment methods
#### Crawler
* Features:
- [x] Content
- [x] Auto crawler
- [ ] Rss
- [ ] Feed
#### Multi languages
* Features:
- [ ] Change language by session
- [ ] Subdomain language
- [ ] Multi Language posts
- [ ] Multi language taxonomy
- [ ] Multi language menu items
### Movie Streaming
- [x] Movie/ TV-Series management
- [x] Import movie from TMDB
- [x] Server and upload management
- [x] Genres/ Countries/ Actors/ Directors/ Writers management
- [x] Player Watermark
- [x] Player Watermark Logo
#### Demo Site
* Features:
- [x] Add user admin demo
- [ ] Autocomplete user demo
### Theme
#### Default

## Backend Javascript libraries
- Jquery
- Bootstrap
- select2
- bootstrap-datepicker
- font-awesome
- sweetalert2
- toastr
