### v5.0.0 
* build(deps): update composer dependencies and regenerate the lock file.
* refactor(ci): move create-project-test job to a new workflow triggered on release publication
* feat(ci): add job to test fresh project installation across PHP versions
* feat: enable Juzaweb core, translations, and permission service providers by uncommenting their registrations.
* feat: register new AppServiceProvider and comment out core module providers in bootstrap.
* ci(composer): optimize composer install in CI with `--no-progress` and `--prefer-dist` flags.
* ci(workflow): run tests against multiple PHP versions
* ci(workflow): Simplify composer install command in test workflow.
* feat(ads-manager, blog): implement video ad testing and configure blog module frontend assets
* feat(readme): update features list to reflect multisite language support
* docs(README): update project title capitalization and refine feature list
* docs(readme): remove outdated documentation link and detailed API support checklist
* feat(core): Add Juzaweb core initialization logic and update default environment variables in example configuration.
* feat(s3): add `stream_route` configuration option to serve media files through an application route.
* docs: update README with documentation links, system requirements, and remove demo site information.
* docs(readme): Update JuzaWeb and documentation links, and remove obsolete sections for plugins, themes, and changelogs.
* chore(composer): Remove imagick extension from required dependencies
* chore(composer): remove composer.lock file
* chore(composer): add local path repository for admin module and update lock file
* refactor(admin): make Guest model extend Core Guest model for shared implementation.
* ci: Adjust CI workflow to publish theme and remove local path Composer repositories.
* chore(ci): Add database migration and installation steps to the test workflow.
* refactor(ci): rename workflow job from laravel-tests to tests
* chore(composer): Add Juzaweb API repository.
* chore: Update composer dependencies to include `juzaweb/story-sharing` and centralize PHPUnit test directories.
* feat: add juzaweb/story-sharing package, new composer repository, and example unit/feature tests.
* feat: add juzaweb/story-sharing module and remove unused member authentication configurations.
* feat: add Ads Manager and Blog modules, and iTech theme
* chore(dependencies): remove composer.lock file
* Update the required version for juzaweb/blog and adjust the autoload configuration.
* Remove unused components and routes from Itech theme
* Update composer.json description and add .gitkeep files for modules and themes
* Add test workflow configuration
* Update PHP version in Laravel workflow
* tada: Version 5.x
* Update README.md
* Update require extention
* :bug: Fix app path
* :+1: Update CMS
* :memo: Update readme
* Update create-project.yml
* Update README.md
* Update create-project.yml
* Update README.md
* Update create-project.yml
* :+1: Update CMS
* :+1: Testing env
* :+1: Update modules
* :+1: Update gitignore
* Update create-project.yml
* :bug: Fix test project
* :+1: Disable test update
* :tada: Update modules 1.0.3
* :bug: Fix tests path
* :memo: Update readme
* :bug: Fix path test ci/cd
* :truck: Update .gitignore
* :+1: Update readme
* :truck: Remove example plugin
* :bug: Fix unit test autoload
* :+1: Import ckeditor
* :+1: Show breadcrumb
* :truck: Controller truck
* :+1: Stats builder
* :+1: Left menu inertia
* :+1: Import bootstrap
* :+1: Import js for old js
* :+1: Compile plugin react with vite
* :truck: Move resource js
* :truck: Update gitignore
* :truck: Move modules folder
* :truck: Remove resources views
* :truck: Move folder modules

