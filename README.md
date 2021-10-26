# php-filemanager

A very simple PHP File Manager.

Functions: Delete, Copy, Move, View, Edit files/folders in the browser. Also you can execute shell commands on the the server. For that I integrated the Single-file PHP Shell [p0wny-shell](https://github.com/flozz/p0wny-shell) by [flozz](https://github.com/flozz) into my application as shell.php

Usage: `localhost/update.php?p=password&d=.`

If the password is wrong, a 404 page is shown.
The password can be changed with `$pwd`

If you rename the file to something else than `update.php`, you need to change the `$url0` variable.

## Screenshot

![Screenshot](scrn.png)

