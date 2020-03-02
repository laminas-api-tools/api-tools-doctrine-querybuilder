Laminas Doctrine ODM QueryBuilder
========================

[![Build Status](https://travis-ci.com/laminas-api-tools/api-tools-doctrine-querybuilder.svg?branch=master)](https://travis-ci.com/laminas-api-tools/api-tools-doctrine-querybuilder)
[![Coverage Status](https://coveralls.io/repos/github/laminas-api-tools/api-tools-doctrine-querybuilder/badge.svg?branch=master)](https://coveralls.io/github/laminas-api-tools/api-tools-doctrine-querybuilder?branch=master)
[![Total Downloads](https://poser.pugx.org/laminas-api-tools/api-tools-doctrine-querybuilder/downloads)](https://packagist.org/packages/laminas-api-tools/api-tools-doctrine-querybuilder)

This library provides query builder directives from array parameters. This library was designed
to apply filters from an HTTP request to give an API fluent filter and order-by dialects.


Philosophy
----------

Given developers identified A and B: A == B with respect to ability and desire to filter and sort the entity data.

The Doctrine entity to share contains
```
id integer,
name string,
startAt datetime,
endAt datetime,
```

Developer A or B writes the API. The resource is a single Doctrine Entity and the data
is queried using a Doctrine QueryBuilder `$objectManager->createQueryBuilder()`.
This module gives the other developer the same filtering and sorting ability to the
Doctrine query builder, but accessed through request parameters, as the API author.
For instance, `startAt between('2015-01-09', '2015-01-11');` and `name like ('%arlie')`
are not common API filters for hand rolled APIs and perhaps without this module the API
author would choose not to implement it for their reason(s). With the help of this
module the API developer can implement complex queryability to resources without
complicated effort thereby maintaining A == B.


Installation
------------

Installation of this module uses composer. For composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).

```bash
$ composer require laminas-api-tools/api-tools-doctrine-odm-querybuilder
```

Once installed, add `Laminas\ApiTools\Doctrine\ODM\QueryBuilder` to your list of modules inside
`config/application.config.php`.

> ### laminas-component-installer
>
> If you use [laminas-component-installer](https://github.com/laminas/laminas-component-installer),
> that plugin will install api-tools-doctrine-querybuilder as a module for you.


Configuring the Module
----------------------

Copy `config/api-tools-doctrine-odm-querybuilder.global.php.dist` to `config/autoload/api-tools-doctrine-odm-querybuilder.global.php`
and edit the list of aliases for orm and odm to those you want enabled by default.


Use
---

Configuration example
```php
'api-tools-doctrine-querybuilder-odm-orderby' => [
    'aliases' => [
        'field' => \Laminas\ApiTools\Doctrine\QueryBuilder\ODM\OrderBy\Field::class,
    ],
    'factories' => [
        \Laminas\ApiTools\Doctrine\QueryBuilder\ODM\OrderBy\Field::class => \Laminas\ServiceManager\Factory\InvokableFactory::class,
    ],
],
'api-tools-doctrine-odm-querybuilder-filter' => [
    'aliases' => [
        'eq' => \Laminas\ApiTools\Doctrine\QueryBuilder\ODM\Filter\Equals::class,
    ],
    'factories' => [
        \Laminas\ApiTools\Doctrine\QueryBuilder\ODM\Filter\Equals::class => \Laminas\ServiceManager\Factory\InvokableFactory::class,
    ],
],
```

Request example
```php
$_GET = [
    'filter' => [
        [
            'type'  => 'eq',
            'field' => 'name',
            'value' => 'Tom',
        ],
    ],
    'order-by' => [
        [
            'type'      => 'field',
            'field'     => 'startAt',
            'direction' => 'desc',
        ],
    ],
];
```

Resource example
```php

use Laminas\ApiTools\Doctrine\ODM\QueryBuilder;

$serviceLocator = $this->getApplication()->getServiceLocator();
$objectManager = $serviceLocator->get('doctrine.documentmanager.odm_default');

$filterManager = $serviceLocator->get(FilterManager::class);
$orderByManager = $serviceLocator->get(OrderByManager::class);

$queryBuilder = $objectManager->createQueryBuilder();
$queryBuilder->select('row')
    ->from($entity, 'row')
;

$metadata = $objectManager->getMetadataFactory()->getMetadataFor(ENTITY_NAME); // $e->getEntity() using doctrine resource event
$filterManager->filter($queryBuilder, $metadata, $_GET['filter']);
$orderByManager->orderBy($queryBuilder, $metadata, $_GET['order-by']);

$result = $queryBuilder->getQuery()->getResult();
```


Filters
-------

Filters are not simple key/value pairs. Filters are a key-less array of filter definitions.
Each filter definition is an array and the array values vary for each filter type.

Each filter definition requires at a minimum a 'type'.
A type references the configuration key such as 'eq', 'neq', 'between'.

Each filter definition requires at a minimum a 'field'. This is the name of a field on the target entity.

Each filter definition may specify 'where' with values of either 'and', 'or'.

Embedded logic such as and(x or y) is supported through AndX and OrX filter types.

### Building HTTP GET query:

Javascript Example:

```javascript
$(function () {
    $.ajax({
        url: "http://localhost:8081/api/db/entity/user_data",
        type: "GET",
        data: {
            'filter': [
                {
                    'field': 'cycle',
                    'where': 'or',
                    'type': 'between',
                    'from': '1',
                    'to': '100'
                },
                {
                    'field': 'cycle',
                    'where': 'or',
                    'type': 'gte',
                    'value': '1000'
                }
            ]
        },
        dataType: "json"
    });
});
```


Querying Relations
------------------

### Single valued
It is possible to query collections by relations - just supply the relation name as `fieldName` and
identifier as `value`.

Assuming we have defined 2 entities, `User` and `UserGroup`...

```php
/**
 * @Entity
 */
class User {
    /**
     * @ManyToOne(targetEntity="UserGroup")
     * @var UserGroup
     */
    protected $group;
}
```

```php
/**
 * @Entity
 */
class UserGroup {}
```

find all users that belong to UserGroup id #1 by querying the user resource with the following filter:

```php
['type' => 'eq', 'field' => 'group', 'value' => '1']
```

### Collection valued
To match entities A that have entity B in a collection use `ismemberof`.
Assuming `User` has a ManyToMany (or OneToMany) association with `UserGroup`...

```php
/**
 * @Entity
 */
class User {
    /**
     * @ManyToMany(targetEntity="UserGroup")
     * @var UserGroup[]|ArrayCollection
     */
    protected $groups;
}
```
find all users that belong to UserGroup id #1 by querying the user resource with the following filter:

```php
['type' => 'ismemberof', 'field' => 'groups', 'value' => '1']
```

Format of Date Fields
---------------------

When a date field is involved in a filter you may specify the format of the date using PHP date
formatting options. The default date format is `Y-m-d H:i:s` If you have a date field which is
just `Y-m-d`, then add the format to the filter. For complete date format options see
[DateTime::createFromFormat](http://php.net/manual/en/datetime.createfromformat.php)

```php
[
    'format' => 'Y-m-d',
    'value' => '2014-02-04',
]
```


Included Filter Types
---------------------

Equals:

```php
['type' => 'eq', 'field' => 'fieldName', 'value' => 'matchValue']
```

Not Equals:

```php
['type' => 'neq', 'field' => 'fieldName', 'value' => 'matchValue']
```

Less Than:

```php
['type' => 'lt', 'field' => 'fieldName', 'value' => 'matchValue']
```

Less Than or Equals:

```php
['type' => 'lte', 'field' => 'fieldName', 'value' => 'matchValue']
```

Greater Than:

```php
['type' => 'gt', 'field' => 'fieldName', 'value' => 'matchValue']
```

Greater Than or Equals:

```php
['type' => 'gte', 'field' => 'fieldName', 'value' => 'matchValue']
```

Is Null:

```php
['type' => 'isnull', 'field' => 'fieldName']
```

Is Not Null:

```php
['type' => 'isnotnull', 'field' => 'fieldName']
```

Note: Dates in the In and NotIn filters are not handled as dates.
It is recommended you use multiple Equals statements instead of these filters for date datatypes.

In:

```php
['type' => 'in', 'field' => 'fieldName', 'values' => [1, 2, 3]]
```

NotIn:

```php
['type' => 'notin', 'field' => 'fieldName', 'values' => [1, 2, 3]]
```

Between:

```php
['type' => 'between', 'field' => 'fieldName', 'from' => 'startValue', 'to' => 'endValue']
```

Like (`%` is used as a wildcard):

```php
['type' => 'like', 'field' => 'fieldName', 'value' => 'like%search']
```

Regex:

```php
['type' => 'regex', 'field' => 'fieldName', 'value' => '/.*search.*/i']
```


Included Order By Type
----------------------

Field:

```php
['type' => 'field', 'field' => 'fieldName', 'direction' => 'desc']
```


Development
===========

This package uses Docker for testing.  To run all unit tests execute:

```
docker-compose run --rm php composer test
```

Running unit tests with code coverage requires you build the docker
composer with XDEBUG=1

```
docker-compose build --build-arg XDEBUG=1
```

To change docker to a different php version

```
docker-compose build --build-arg PHP_VERSION=7.3
```

then run the unit tests as 

```
docker-compose run --rm php composer test-coverage
```

Run phpcs as 
```
docker-compose run --rm php composer cs-check src test config
```
