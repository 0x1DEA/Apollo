<p align="center">
    <img src="https://apollo.cafe/assets/apollo_logo.svg" height="130" />
</p>
<p align="center">
  <a href="https://github.com/SeeBeyondDev/Apollo/blob/master/LICENSE" alt="License">
    <img src="https://img.shields.io/github/license/SeeBeyondDev/Apollo">
  </a>
  <a href="https://github.com/SeeBeyondDev/Apollo/releases" alt="Release">
    <img src="https://img.shields.io/github/v/release/SeeBeyondDev/Apollo?include_prereleases">
  </a>
  <a href="https://github.com/SeeBeyondDev/Apollo/issues" alt="Issues">
    <img src="https://img.shields.io/github/issues/SeeBeyondDev/Apollo">
  </a>
  <a href="https://github.com/SeeBeyondDev/Apollo/graphs/contributors" alt="Contributors">
    <img src="https://img.shields.io/github/contributors/SeeBeyondDev/Apollo" />
  </a>
  <a href="#" alt="PHP Version">
    <img src="https://img.shields.io/badge/php-%5E7.4-informational" />
  </a>
  <a href="#" alt="Travis Build">>
    <img src="https://img.shields.io/travis/SeeBeyondDev/Apollo"
  </a>
  <a href="https://discord.gg/fxF8MPm" alt="Chat on Discord">
    <img src="https://img.shields.io/discord/673330782357422091?logo=discord">
  </a>   
</p>

Apollo is a decoupled CMS for easily publishing different types content on the web. It's official modules include:
- Comics
- Videos
- Forums
- Blog

It's core modules include:
- Pages
- Template Manager

## About
As a content creator, you must have some understanding of web development and be able to maintain your website. Apollo is a CMS for both people that aren't very familiar with web technologies and those with technical experience that just want to publish their content online without a complicated or bloated CMS like Wordpress with a confusing setup and configuration.
Apollo is meant to be simple for beginners, yet extendable by anyone with modules and fully-customizable themes.

## I don't know much about servers!
Don't worry! We have many tutorials written on our wiki tab from basic web concepts to resources where you can learn more.
We provide all the information needed to operate Apollo and more.

## Installing (Quick Start)
Apollo uses Composer for dependencies but they are pre-installed in releases.
1. Head to the releases tab and download the latest version.
2. Open the zip and place all the files onto your web server (Apollo currently does not support sub-directories and should only be installed in root directories).
3. Rename `htaccess.txt` to simply `.htaccess` (Sometimes .dotfiles cannot be seen in directories be default).
4. Navigate to your domain and you should be redirected to `https://example.com/install` where you will follow the on-screen prompts to install and configure the application.
5. You're done! Go to `https://example.com/` to view your site and `https://example.com/control/` to get started.

## Developing

### Modules
Apollo uses a hook system.
To add your module, place a class implementing the `Module.php` interface and place it in the `./system/modules` folder and it will automatically be loaded. Any other files used by your module should be included in a directory of the same name in the directory.
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
