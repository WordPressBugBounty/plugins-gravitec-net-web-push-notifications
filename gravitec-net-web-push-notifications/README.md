# Gravitec.net WP Plugin #

## Development

### Test\Prod ENV
In `wp-config.php` set constant for `TEST` environment
```php
define( 'GRAVITECNET_TEST', true );
``` 

### Folder structure
```
admin/  # admin page, css, images, js
includes/  # core files
languages/  # translations
public/  # front files. There is injecting sdk
sdk_files/  # service worker
gravitecnet.php  # main plugin file
icon-*.png  # icons for https://wordpress.org/plugins/
screenshot-*.png  # screenshots for https://wordpress.org/plugins/
README.txt  # readme for https://wordpress.org/plugins/
```

### Public folder
`class-gravitecnet-public.php`
```php
class Gravitecnet_Public {
    function enqueue_scripts(){} # injecting sdk
}
```

### Admin folder
`class-gravitecnet-admin.php`
```php
class Gravitecnet_Admin {
    function add_gravitecnet_admin_page_to_admin_menu(){}  # add link to WP admin menu
    function enqueue_styles(){}  # inject css files to admin page
    function enqueue_scripts(){}  # inject js files to admin page
    function render_gravitecnet_admin_page_html(){}  # render admin page view
}
```

`views/gravitecnet-admin-page.php`  There are admin page template and credential saving business logic. And yes, it's WP coding style.
```php
$gravitecnet_form->handle_submit();  # handle POST form submit
```
At the end of file JS script for handling tab postMessage `function receiveMessage(event) {}`

### Includes folder
`class-gravitecnet.php`
```php
class Gravitecnet {
    function load_dependencies() {}  # manually injecting php files 
}
```

`class-gravitecnet-form.php`  # form handling class  
`class-gravitecnet-path-helper.php`  # generating sdk path class  
`class-gravitecnet-security-helper.php`  # security form helper class  
`class-gravitecnet-settings.php`  # credential getters, setters; locale, user emails, rss getters;  

## Guidelines

Using Subversion with the WordPress Plugin Directory:
https://developer.wordpress.org/plugins/wordpress-org/how-to-use-subversion/

FAQ about the WordPress Plugin Directory:
https://developer.wordpress.org/plugins/wordpress-org/plugin-developer-faq/

WordPress Plugin Directory readme.txt standard:
https://wordpress.org/plugins/developers/#readme

A readme.txt validator:
https://wordpress.org/plugins/developers/readme-validator/

Plugin Assets (header images, etc):
https://developer.wordpress.org/plugins/wordpress-org/plugin-assets/

WordPress Plugin Directory Guidelines:
https://developer.wordpress.org/plugins/wordpress-org/detailed-plugin-guidelines/

## Deployment

[https://kinsta.com/blog/publish-plugin-wordpress-plugin-directory/](https://kinsta.com/blog/publish-plugin-wordpress-plugin-directory/)

1. Pull repository  
`svn co https://plugins.svn.wordpress.org/gravitec-net-web-push-notifications`    
`ashananin`  
`[password]`  

2. There is Folder structure
```
assets/
trunk/  # development folder
branches/
tags/  # releases
```

3. Put plugin files (from github) to `trunk` folder

4. IMPORTANT!!! Don't forget update Plugin version (example to 1.1.0) in
- in `gravitecnet.php` in phpdoc `* Version:           1.1.0`
- in `readme.txt` `Stable tag: 1.1.0`

5. Validate `readme.txt` [https://wordpress.org/plugins/developers/readme-validator/](https://wordpress.org/plugins/developers/readme-validator/)

6. Copy icon-\*.png and screenshot-\*.png files to assets folder

7. Create realease with new version of plugin to tags folder
`svn cp trunk tags/[VERSION]` 

8. Commit


## SVN
`svn stat` (git status)  
`svn add` and `svn delete` (git add)  
`svn ci -m '[comment]'` (git checkout -m "" and git push)  
`svn cp trunk tags/1.1.0` (git tag) release 1.1.0 version  
