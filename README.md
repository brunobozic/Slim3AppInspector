# Quick run via php from the public folder
 - php -S 0.0.0.0:6666 -t public public/index.php
 
# How to reverse engineer entities from an existing database (Doctrine 2)
 - Run in /home/brunobozic/pac-wisp-lab-healtcheck
 - /home/brunobozic/Projects/ApplicationInspector/vendor/bin/doctrine orm:convert-mapping --from-database annotation /home/brunobozic/Projects/ApplicationInspector/doctrine_reverse_entities -f
 - /home/brunobozic/Projects/ApplicationInspector/vendor/bin/doctrine orm:convert-mapping --from-database annotation /home/brunobozic/Projects/ApplicationInspector/src -f --namespace 'App\Entities\'

# How to create a schema (database)
 - /home/brunobozic/Projects/ApplicationInspector/vendor/bin/doctrine orm:schema-tool:create
 - /home/brunobozic/ToTransplantSave/ApplicationInspector/vendor/bin/doctrine orm:schema-tool:create
 - /home/brunobozic/ToTransplantSave/ApplicationInspector/vendor/bin/doctrine orm:schema-tool:update -f
 
 

SELECT * FROM portal po
INNER JOIN portal_feature pf on pf.portal_id = po.id
INNER JOIN portal_generation pg on  pg.id = pf.portal_generation_id
INNER JOIN portal_health_check_url phcu on pf.id = phcu.portal_feature_id;

SELECT * FROM portal po
INNER JOIN portal_feature pf on pf.portal_id = po.id
INNER JOIN portal_generation pg on  pg.id = pf.portal_generation_id
INNER JOIN portal_health_check_url phcu on pf.id = phcu.portal_feature_id
Inner JOIN portal_health_check_pulse phcp on phcp.portal_health_check_url_id = phcu.id;

SELECT * FROM portal po
INNER JOIN portal_feature pf on pf.portal_id = po.id
INNER JOIN portal_generation pg on  pg.id = pf.portal_generation_id
INNER JOIN portal_version_check_path pvcp on pf.id = pvcp.portal_feature_id;

SELECT * FROM portal po
INNER JOIN portal_feature pf on pf.portal_id = po.id
INNER JOIN portal_generation pg on  pg.id = pf.portal_generation_id
INNER JOIN portal_version_check_path pvcp on pf.id = pvcp.portal_feature_id
Inner JOIN portal_version_check_pulse phcp on pvcp.portal_feature_id = phcp.portal_version_check_path_id;





#
- composer phplint  '**/*.php' '!**/vendor/**' .


#
- composer dump-autoload -o











# Quick run via php from the public folder
 - php -S 0.0.0.0:8888 -t public public/index.php

# PHPUnit tests
 - run "./vendor/bin/phpunit UnitTest.php"
 - ./vendor/bin/phpunit ./src/Tests/Unit/SampleTest.php

# List of routes
 URL                               HTTP Verb    Operation



# Request a token
- curl "http://127.0.0.1:8888/api/v1/token" --request POST --include --insecure --header "Content-Type: application/json" --data '["portal.getAll"]' --user admin:admin 
- curl "http://127.0.0.1:8888/api/v1/token" --request POST --include --insecure --header "Content-Type: application/json" --data '["portal.getAll"]' --user test:test


# List users
- curl "http://127.0.0.1:8888/api/v1/portal" --include --insecure --header "Authorization: Bearer $TOKEN"

