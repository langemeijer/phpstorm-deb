phpstorm-deb
=============

Build scripts to easily create a `.deb` package for PhpStorm.


Dependencies
------------

You will need the `devscripts` `debhelper` `php` and `php-curl` packages installed in order to build the PhpStorm `.deb` file:

```sh
apt-get install devscripts debhelper php php-curl
```

Build (Automatic)
----------------
* Run the `download_latest.php` file
```sh
php download_latest.php
```

This will execute all steps described below.


Building (Manuallly)
--------------------

* Download the `.tar.gz` file from [PhpStorm's download page](https://www.jetbrains.com/phpstorm/download/index.html) and place it in the root directory of this repo.

* Create a new debian/changelog file using the provided update.sh script:
```sh
./update.sh
```

* Build the package with the following command:

```sh
debuild -us -uc -b
```

* Please 'Star' or 'Watch' the repo on github: https://github.com/langemeijer/phpstorm-deb/stargazers

Installing
----------

Install the package with the `dpkg` command:

```sh
dpkg -i PhpStorm...
```

Alternatively, you can create your own [simple repo](https://wiki.debian.org/DebianRepository/HowTo/TrivialRepository) or 
[more professional one](https://wiki.debian.org/SettingUpSignedAptRepositoryWithReprepro) to host your custom `deb` packages.
