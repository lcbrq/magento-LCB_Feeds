# LCB_Feeds

OpenMage / Magento 1 product datafeeds for external services

### Changelog

1.3.0 - Add caches, additional models and composer file

1.2.2 - Separate Google Feed model from controller and add basic attributes map

1.2.1 - Make feeds cache lifetime configurable from admin area

1.1.0 - Changed url from xml to datafeeds, possible server rewrite if you don't want to update url given in external service is (.htaccess)

RewriteRule ^xml/(.*)$ /datafeeds/$1 [R=301,NC,L]
