
# simple-rest #
version 0.0.1a

It responses a DB table with field names in JSON format from RESTful request.

# NOTE:
The following .htaccess setting is necessary

DirectoryIndex index.php
<IfModule mod_rewrite.c>
  RewriteEngine On
  RewriteOptions inherit
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteRule your-api/version-number/(.*)$ /your/file/dir/index.php?request=$1 [QSA,NC,L]
</IfModule>


The request pattern is:
http://localhost/api/v1/<endpoint>/<verb>/<arg0>/<arg1>

This interprets as following:
http://localhost/api/v1/{request_type}/{request_resources}/{api_user}/{api_key}

For example:
http://localhost/api/v1/mydb/mytable/restuser/{api_key}

For auth:
auth: http:/localhost/api/v1/auth/login/{api_user}/{api_key}

# TODO LIST
- Documentation
- Creating token process to already logged in user
- Creating support different request type (XML, Soap)
- Rewrite code with namespace support
- Better structure of the classes
- Better error handling complying the standard