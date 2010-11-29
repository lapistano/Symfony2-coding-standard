OpenSky phpcs Coding Standard
=============================

Installation
------------

1. Install phpcs:

       pear install PHP_CodeSniffer-beta

2. Find your PEAR directory:

       pear config-show | grep php_dir

3. Copy, symlink or check out this repo to a folder called OpenSky inside the
   phpcs `Standards` directory:

       cd /path/to/pear/PHP/CodeSniffer/Standards
       git clone git@github.com:opensky/coding-standard.git OpenSky

4. Set OpenSky as your default coding standard:

       phpcs --config-set default_standard OpenSky

5. ...

6. Profit!

       cd /path/to/my/project
       phpcs
       phpcs path/to/my/file.php
