#!/bin/bash

set -e

JOB=$3
PHP_VERSION=$(echo "${JOB}" | jq -r '.php')

if [[ "$PHP_VERSION" =~ 8. ]];then
    composer require --ignore-platform-req=php --dev --no-interaction --prefer-dist alcaeus/mongo-php-adapter
else
    composer require --dev --no-interaction --prefer-dist alcaeus/mongo-php-adapter
fi

