Symfony Polyfill / Php72
========================

This component provides functions added to PHP 7.2 core:

- [`spl_object_id`](http://php.net/spl_object_id)
- [`stream_isatty`](http://php.net/stream_isatty)

And also functions added to PHP 7.2 mbstring:

- [`mb_ord`](http://php.net/mb_ord)
- [`mb_chr`](http://php.net/mb_chr)
- [`mb_scrub`](http://php.net/mb_scrub)

On Windows only:

- [`sapi_windows_vt100_support`](http://php.net/sapi_windows_vt100_support)

Moved to core since 7.2 (was in the optional XML extension earlier):

- [`utf8_encode`](http://php.net/utf8_encode)
- [`utf8_decode`](http://php.net/utf8_decode)

Also, it provides constants added to PHP 7.2:

- [`PHP_FLOAT_*`](http://php.net/reserved.constants#constant.php-float-dig)
- [`PHP_OS_FAMILY`](http://php.net/reserved.constants#constant.php-os-family)

More information can be found in the
[main Polyfill README](http://github.com/symfony/polyfill/blob/main/README.md).

License
=======

This library is released under the [MIT license](LICENSE).
