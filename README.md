phpstorm-deb
============

Skeleton to easily create a .deb package for phpstorm


How to create new phpstorm debian package based on this project
===============================================================

* Download the .tar.gz file from this webpage http://www.jetbrains.com/phpstorm/download/index.html
* Move the file into the directory where this file is in.

* See if version number the top entry in file debian/changelog is the same as the version you've downloaded. If it's not, execute 
 dch -v <new-version-number> -m "New upstream version"

* Build the package with this command:
 debuild -us -uc -b

