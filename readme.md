# Birmingham Sports Awards website

The starting place for building a website on the WordPress platform.

## Project URLS

- [GitHub Readme](https://github.com/trinitymirror/birminghamsportsawards/blob/master/README.md)
- [Continuous Integration](https://codeship.com/projects/152209/)
- [Local](http://www.birminghamsportsawards.local/)
- [QA](#)
- [Production](http://www.birminghamsportsawards.co.uk/)

## Dependencies

- [GIT](https://git-scm.com/downloads)
- [VirtualBox](https://www.virtualbox.org/)
- [Vagrant](https://www.vagrantup.com/downloads.html)
 - [Hosts Updater](https://github.com/cogitatio/vagrant-hostsupdater)

## On-boarding – Getting Started

The section assumes you have GIT, VirtualBox and Vagrant set up. You may need to adjust as needed for your local development system.

### Install

Clone this repository into your development area:

```
git clone https://github.com/trinitymirror/birminghamsportsawards.co.uk.git birminghamsportsawards.co.uk
cd birminghamsportsawards.co.uk
```

Copy the `sample.env` file and rename it to `.env`.

```
cp ./sample.env ./.env
```

Run Vagrant:

```
vagrant up
```

### View your development site

Visit [http://www.birminghamsportsawards.local](http://www.birminghamsportsawards.local/) to view the development site.

### Accessing the MySQL database

Vagrant's MySQL database can be accessed through SSH using the following credentials:

- SSH Host: 192.168.33.60
- SSH User: vagrant
- SSH Password: vagrant
- MySQL Host: 127.0.0.1
- MySQL User: root
- MySQL Password: root
- MySQL Database: birminghamsportsawards

### Testing Your Changes

Our test suite is run on every commit pushed to this repository.

### Updating WordPress and Plugins

To upgrade to the latest PATCH versions of WordPress or its plugins re-provision Vagrant by running `vagrant provision` from your command line.

Upgrading to a MAJOR or MINOR version you will need to manually update `require` and `require-dev` sections of the `composer.json` file and re-provision Vagrant by running `vagrant provision` from your command line.

After testing the new version(s) commit the updated `composer.json` and `composer.lock` files back the the repository for deployment.

### Making Your Changes

Make your changes locally on a new branch based off `origin/master`. Commit your changes to your new branch. Push your changes to this repository run our test suite.

### Deploying to our Staging Server

Once our tests are passed, create a pull request to merge into our `develop` branch. After approval and merging this will be deployed to our staging server.

### Deploying to our Live Server

If you are happy with your changes. Create a pull request to merge your original branch into `master` (not `develop`). On merge this will start the deployment process to our live server.

## Documentation

During the Alpha/Beta stages, due to constant changes, documentation will be mainly written in-line. With a dedicated section being created at the first major release.

## Folder Structure

```
├── composer.json
├── config
│   ├── application.php
│   └── environments
│       ├── development.php
│       ├── staging.php
│       └── production.php
├── html
│   ├── app
│   │   ├── plugins
│   │   ├── plugins-mu
│   │   ├── themes
│   │   └── languages
│   ├── media
│   ├── wp-config.php
│   ├── index.php
│   └── wp
├── scripts
└── vendor
```

- In order not to expose sensitive files in the webroot, we move what's required into a `html/` directory including the vendor's `wp/` source, and the `wp-content` source.
- `wp-content` has been named `app` to better reflect its contents. It contains application code and not just "static content". It also matches up with other frameworks such as Symfony and Rails.
- `wp-config.php` remains in the `web/` because it's required by WordPress, but it only acts as a loader. The actual configuration files have been moved to `config/` for better separation.
- `vendor/` is where the Composer managed dependencies are installed to.
- `wp/` is where the WordPress core lives. It's also managed by Composer but can't be put under `vendor` due to WP limitations.
- `uploads` has been named `media` and moved outside the `app` folder to better separate code and "static" content.
- `scripts/` hold the bash scripts used for setting up and running tasks on the environment.

## Reporting Issues

If you spot any issues please create a ticket via GitHub's Issue Tracker. Including the issue, the browser and operating system, and how to replicate it. If the issue is security related please use the contact information below.

## Contributing to this project

This project follow the WordPress Coding Standard for [PHP](https://make.wordpress.org/core/handbook/best-practices/coding-standards/php/), [HTML](https://make.wordpress.org/core/handbook/best-practices/coding-standards/html/), [CSS](https://make.wordpress.org/core/handbook/best-practices/coding-standards/css/) and [JavaScript](https://make.wordpress.org/core/handbook/best-practices/coding-standards/javascript/).

## Contact

Trinity Mirror Creative - [tmcreative@trinitymirror.com](tmcreative@trinitymirror.com)

## Copyright

Unless otherwise stated © Trinity Mirror. All rights reserved.
