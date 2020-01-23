# Apollo Content Publisher

## About
As a content creator, you must have some understanding of web development and be able to maintain your website. Apollo is a CMS for both people that aren't very familiar with web technologies and those with technical experience that just want to publish their content online without a complicated or bloated CMS like Wordpress with a confusing setup and configuration.
Apollo is meant to be simple for beginners, yet extendable by anyone with modules and fully-customizable themes.

## I don't know much about servers!
Don't worry! We have many tutorials written on our wiki tab.
From basic web concepts to resources where you can learn more.
We provide all the information needed to operate Apollo and more.

## Installing (Quick Start)
Apollo uses Composer for dependencies but they are pre-installed in releases.
1. Head to the releases tab and download the latest version
2. Open the zip and place all the files onto your web server
3. Rename `default.htaccess` to simply `.htaccess`
4. Navigate to your domain and you should be redirected to `https://example.com/install` where you will follow the on-screen prompts to install the application.
5. You're done! Go to `https://example.com/`

## Developing

### Modules
Apollo uses a hook system.
To add your module, place a class extending the `ModuleTemplate.php` interface and place it in the `./system/modules` folder and it will automatically be loaded.
To register hooks view the wiki for the list of names, actions and locations.
### Themes
Apollo uses the Twig templating system. Multiple themes can be installed on one instance and switched. Templates and styles are stored in the database and may be edited and exported/flattened in the Control Center.

## Contributing

### Code Style
Apollo follows the PSR-12 standard
### Issues
Issues that are questions on how to use the program should instead be posted to `#apollo-support` in the [SinCentral](https://sincentral.net/discord) discord server.
Issues on GitHub should be reserved for bugs, feature requests or anything else regarding the Apollo source code.

### Pull Requests
Apollo is open to almost any pull request as long as it keeps the core application simple for the end user.
If you want to add functionality to Apollo that doesn't follow core needs please consider creating a module. 

## License
Apollo is licensed under the MIT License
