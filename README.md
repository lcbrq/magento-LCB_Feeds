# LCB_Feeds

Product datafeeds for external services

### Changelog

1.1.0 - Changed url from xml to datafeeds, possible server rewrite if you don't want to update url given in external service is (.htaccess)

RewriteRule ^xml/(.*)$ /datafeeds/$1 [R=301,NC,L]

1.2.1 - Make feeds cache lifetime configurable from admin area