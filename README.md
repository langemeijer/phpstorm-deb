phpstorm-deb
=============

Build scripts to easily create a `.deb` package for PhpStorm.


Dependencies
------------

You will need the `devscripts` and the `debhelper` packages installed in order to build the PhpStorm `.deb` file:

```sh
apt-get install devscripts debhelper
```


Building
--------

* Download the `.tar.gz` file from [PhpStorm's download page](https://www.jetbrains.com/phpstorm/download/index.html) and place it in the root directory of this repo.

* Build the package with the following command:

```sh
debuild -us -uc -b
```


Installing
----------

Install the package with the `dpkg` command:

```sh
dpkg -i PhpStorm...
```

Alternatively, you can [create your own repo](https://wiki.debian.org/DebianRepository/HowTo/TrivialRepository) to host your custom `deb` packages.


New PhpStorm Versions
---------------------

If the latest version of PhpStorm is newer than the version listed in `debian/changelog`, you'll need to run the following command command to update the file:

```sh
dch -v <new-version-number> -m "New upstream version"
```

For example, if the latest version is 9.10.3, run the following:

```sh
dch -v 9.10.3-1 -m "New upstream version"
```

You can then commit the change to `debian/changelog` and submit a pull request.

