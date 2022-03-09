Laminas Doctrine QueryBuilder
========================

[![Build Status](https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/actions/workflows/continuous-integration.yml/badge.svg)](https://github.com/laminas-api-tools/api-tools-doctrine-querybuilder/actions/workflows/continuous-integration.yml)

> ## 🇷🇺 Русским гражданам
>
> Мы, участники Laminas, родились и живем в разных странах. У многих из нас есть друзья, родственники и коллеги как в России, так и в Украине. Некоторые из нас родились в России. Некоторые из нас живут в России. У некоторых бабушки и дедушки сражались с фашистами во Второй мировой войне. Здесь никто не поддерживает фашизм.
>
> У одного из нас есть украинская родственница, которая спаслась из дома вместе с сыном. Поезд задержался из-за бомбежки на дороге впереди. У нас есть друзья, которые прячутся в бомбоубежищах. Мы с тревогой ждем весточки от них после воздушных налетов, которые беспорядочно наносят удары и попадают по больницам, школам, детским садам и домам. Мы не берем это из каких-либо СМИ. Мы наблюдаем это напрямую.
>
> Вы доверяете нам достаточно, чтоб использовать наши программы, и мы просим вас довериться нам вновь. Мы нуждаемся в помощи. Выходите и протестуйте против этой бесполезной войны. Остановите кровопролитие. Скажите "Нет войне!"
>
> ## 🇺🇸 To Citizens of Russia
>
> We at Laminas come from all over the world. Many of us have friends, family and colleagues in both Russia and Ukraine. Some of us were born in Russia. Some of us currently live in Russia. Some have grandparents who fought Nazis in World War II. Nobody here supports fascism.
>
> One team member has a Ukrainian relative who fled her home with her son. The train was delayed due to bombing on the road ahead. We have friends who are hiding in bomb shelters. We anxiously follow up on them after the air raids, which indiscriminately fire at hospitals, schools, kindergartens and houses. We're not taking this from any media. These are our actual experiences.
>
> You trust us enough to use our software. We ask that you trust us to say the truth on this. We need your help. Go out and protest this unnecessary war. Stop the bloodshed. Say "stop the war!"

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
$ composer require laminas-api-tools/api-tools-doctrine-querybuilder
```

Once installed, add `Laminas\ApiTools\Doctrine\QueryBuilder` to your list of modules inside
`config/application.config.php`.

> ### laminas-component-installer
>
> If you use [laminas-component-installer](https://github.com/laminas/laminas-component-installer),
> that plugin will install api-tools-doctrine-querybuilder as a module for you.


Configuring the Module
----------------------

Copy `config/api-tools-doctrine-querybuilder.global.php.dist` to `config/autoload/api-tools-doctrine-querybuilder.global.php`
and edit the list of aliases for orm and odm to those you want enabled by default.


Use With Laminas API Tools Doctrine
---------------------------

To enable all filters you may override the default query providers in `api-tools-doctrine`.
Add this to your `api-tools-doctrine-querybuilder.global.php` config file and filters and order-by will be applied
if they are in `$_GET['filter']` or `$_GET['order-by']` request. These `$_GET` keys are customizable
through `api-tools-doctrine-querybuilder-options`:

```php
'api-tools-doctrine-query-provider' => [
    'aliases' => [
        'default_orm' => \Laminas\ApiTools\Doctrine\QueryBuilder\Query\Provider\DefaultOrm::class,
        'default_odm' => \Laminas\ApiTools\Doctrine\QueryBuilder\Query\Provider\DefaultOdm::class,
    ],
    'factories' => [
        \Laminas\ApiTools\Doctrine\QueryBuilder\Query\Provider\DefaultOrm::class => \Laminas\ApiTools\Doctrine\QueryBuilder\Query\Provider\DefaultOrmFactory::class,
        \Laminas\ApiTools\Doctrine\QueryBuilder\Query\Provider\DefaultOdm::class => \Laminas\ApiTools\Doctrine\QueryBuilder\Query\Provider\DefaultOdmFactory::class,
    ],
],
```


Use
---

Configuration example
```php
'api-tools-doctrine-querybuilder-orderby-orm' => [
    'aliases' => [
        'field' => \Laminas\ApiTools\Doctrine\QueryBuilder\OrderBy\ORM\Field::class,
    ],
    'factories' => [
        \Laminas\ApiTools\Doctrine\QueryBuilder\OrderBy\ORM\Field::class => \Laminas\ServiceManager\Factory\InvokableFactory::class,
    ],
],
'api-tools-doctrine-querybuilder-filter-orm' => [
    'aliases' => [
        'eq' => \Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ORM\Equals::class,
    ],
    'factories' => [
        \Laminas\ApiTools\Doctrine\QueryBuilder\Filter\ORM\Equals::class => \Laminas\ServiceManager\Factory\InvokableFactory::class,
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
$serviceLocator = $this->getApplication()->getServiceLocator();
$objectManager = $serviceLocator->get('doctrine.entitymanager.orm_default');

$filterManager = $serviceLocator->get('LaminasDoctrineQueryBuilderFilterManagerOrm');
$orderByManager = $serviceLocator->get('LaminasDoctrineQueryBuilderOrderByManagerOrm');

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


Joining Entities and Aliasing Queries
-------------------------------------

There is an included ORM Query Type for Inner Join so for every filter type there is an optional `alias`.
The default alias is 'row' and refers to the entity at the heart of the REST resource.
There is not a filter to add other entities to the return data. That is, only the original target resource,
by default 'row', will be returned regardless of what filters or order by are applied through this module.

Inner Join is not included by default in the `api-tools-doctrine-querybuilder.global.php.dist`.

This example joins the report field through the inner join already defined on the row entity then filters
for `r.id = 2`:

```php
    ['type' => 'innerjoin', 'field' => 'report', 'alias' => 'r'],
    ['type' => 'eq', 'alias' => 'r', 'field' => 'id', 'value' => '2']
```

You can inner join tables from an inner join using `parentAlias`:

```php
    ['type' => 'innerjoin', 'parentAlias' => 'r', 'field' => 'owner', 'alias' => 'o'],
```

Inner Join is commented by default in the `api-tools-doctrine-querybuilder.global.php.dist`.



There is also an ORM Query Type for LeftJoin.  This join type is commonly used to fetch an empty right side of a relationship.

Left Join is commented by default in the `api-tools-doctrine-querybuilder.global.php.dist`.

```php
    ['type' => 'leftjoin', 'field' => 'report', 'alias' => 'r'],
    ['type' => 'isnull', 'alias' => 'r', 'field' => 'id']
```


Included Filter Types
---------------------

### ORM and ODM

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

### ORM Only

Is Member Of:

```php
['type' => 'ismemberof', 'field' => 'fieldName', 'value' => 1]
```

AndX:

In AndX queries, the `conditions` is an array of filter types for any of those described
here. The join will always be `and` so the `where` parameter inside of conditions is
ignored. The `where` parameter on the AndX filter type is not ignored.

```php
[
    'type' => 'andx',
    'conditions' => [
        ['field' =>'name', 'type'=>'eq', 'value' => 'ArtistOne'],
        ['field' =>'name', 'type'=>'eq', 'value' => 'ArtistTwo'],
    ],
    'where' => 'and',
]
```

OrX:

In OrX queries, the `conditions` is an array of filter types for any of those described
here. The join will always be `or` so the `where` parameter inside of conditions is
ignored. The `where` parameter on the OrX filter type is not ignored.

```php
[
    'type' => 'orx',
    'conditions' => [
        ['field' =>'name', 'type'=>'eq', 'value' => 'ArtistOne'],
        ['field' =>'name', 'type'=>'eq', 'value' => 'ArtistTwo'],
    ],
    'where' => 'and',
]
```

### ODM Only

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

Custom MappingTypes
-------------------

In case you have [custom mapping types](https://www.doctrine-project.org/projects/doctrine-orm/en/latest/cookbook/custom-mapping-types.html)
configured, you can substitute the supplied `Laminas\ApiTools\Doctrine\QueryBuilder\Filter\TypeCastInterface`
implementation with your own implementation.

As an example, given a custom type caster implentation as follows:

```php
namespace My\Custom;

class TypeCaster implements \Laminas\ApiTools\Doctrine\QueryBuilder\Filter\TypeCastInterface
{
    public function typeCastField($metadata, $field, $value, $format = null, $doNotTypecastDatetime = false)
    {
        // implement your type casting logic
    }
}
```

You will then provide a factory for your implementation, and alias the package `TypeCastInterface` to it:

```php
// config/autoload/api-tools-doctrine-querybuilder-global.php

use Laminas\ApiTools\Doctrine\QueryBuilder\Filter\TypeCastInterface;
use Laminas\ServiceManager\Factory\InvokableFactory;
use My\Custom\TypeCaster;

return [
    'service_manager => [
        'aliases' => [
            TypeCastInterface::class => TypeCaster::class,
        ],
        'factories' => [
            TypeCaster::class => InvokableFactory::class,
        ],
    ],
];
```

