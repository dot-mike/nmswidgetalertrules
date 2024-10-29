# nmswidgetalertrules

nmswidgetalertrules - A LibreNMS plugin that adds a new widget to the Overview page that displays alert rules with number of alerts.

## Installation

### Without Docker

Go to the LibreNMS base directory and run the following commands as librenms user:

```bash
./lnms plugin:add dot-mike/nmswidgetalertrules
php artisan route:clear
```

### With Docker

If you are using LibreNMS with Docker, you can install the plugin by customizing the Dockerfile.

Example Dockerfile:

```Dockerfile
ARG VERSION=librenms:24.9.1
FROM librenms/$VERSION

RUN apk --update --no-cache add -t build-dependencies php-xmlwriter
RUN mkdir -p "${LIBRENMS_PATH}/vendor"

RUN echo $'#!/usr/bin/with-contenv sh\n\
set -e\n\
if [ "$SIDECAR_DISPATCHER" = "1" ] || [ "$SIDECAR_SYSLOGNG" = "1" ] || [ "$SIDECAR_SNMPTRAPD" = "1" ]; then\n\
  exit 0\n\
fi\n\
chown -R librenms:librenms "${LIBRENMS_PATH}/composer.json" "${LIBRENMS_PATH}/composer.lock" "${LIBRENMS_PATH}/vendor"\n\
lnms plugin:add dot-mike/nmswidgetalertrules\n\
php artisan route:clear\n\
php lnms --force -n migrate\n\
' > /etc/cont-init.d/99-nmswidgetalertrules.sh
```

## Usage

To get started, open LibreNMS and enable the plugin by navigating to Overview->Plugins->Plugins Admin and enable the `nmswidgetalertrules` plugin.


## Screenshots

![widget](/screenshots/widget.png?raw=true)
