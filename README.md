WebFS - Web File Storage
====
This is simple PHP-based implementation of file storage service.

It uses .htpasswd authentication and allows to use HTTP methods PUT and DELETE.

This solution can be used as simple Maven Repository.

Check http://repo.shamanland.com for example.

Installation
----

1. Configure Apache + PHP server.
2. Enabled mod_rewrite for Apache.
3. Clone content of this repo to your host's root dir.
4. Search and replace /path/to/.htpasswd in .htaccess file.
5. Open your site in browser.
