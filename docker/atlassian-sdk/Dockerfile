FROM translucent/atlassian-plugin-sdk

MAINTAINER Cédric Michaux<cedric@adlogix.eu>

EXPOSE 1990

RUN atlas-run-standalone --container tomcat7x --product confluence --version 6.0.0-OD-2016.13.3-1129 --data-version 6.0.0-OD-2016.13.3-1129 --bundled-plugins com.atlassian.bundles:json-schema-validator-atlassian-bundle:1.0.4,com.atlassian.upm:atlassian-universal-plugin-manager-plugin:2.21-D20160128T024330,com.atlassian.jwt:jwt-plugin:1.5.9-0019,com.atlassian.plugins:atlassian-connect-plugin:1.1.84 --jvmargs -Datlassian.upm.on.demand=true
