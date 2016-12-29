[![Latest Stable Version](https://poser.pugx.org/pmvc-plugin/guid/v/stable)](https://packagist.org/packages/pmvc-plugin/guid) 
[![Latest Unstable Version](https://poser.pugx.org/pmvc-plugin/guid/v/unstable)](https://packagist.org/packages/pmvc-plugin/guid) 
[![Build Status](https://travis-ci.org/pmvc-plugin/guid.svg?branch=master)](https://travis-ci.org/pmvc-plugin/guid)
[![License](https://poser.pugx.org/pmvc-plugin/guid/license)](https://packagist.org/packages/pmvc-plugin/guid)
[![Total Downloads](https://poser.pugx.org/pmvc-plugin/guid/downloads)](https://packagist.org/packages/pmvc-plugin/guid) 

Id of things  
===============

## GetDb Sample
   * Algolia
      * https://github.com/pmvc-plugin/algolia/blob/master/algolia.php
   * Ssdb
      * https://github.com/pmvc-plugin/ssdb/blob/master/ssdb.php

## Global Table
   * GlobalGuid
       * format: guid->key
       * https://github.com/pmvc-plugin/guid/blob/master/src/dbs/GlobalGuid.php
   * GlobalKey
       * format: key->guid
       * https://github.com/pmvc-plugin/guid/blob/master/src/dbs/GlobalKey.php


## Install with Composer
### 1. Download composer
   * mkdir test_folder
   * curl -sS https://getcomposer.org/installer | php

### 2. Install by composer.json or use command-line directly
#### 2.1 Install GUID by adding a dependency to pmvc-plugin/guid to the require section of your project's composer.json configuration file. 
   * vim composer.json
```
{
    "require": {
        "pmvc-plugin/guid": "dev-master"
    }
}
```
   * php composer.phar install

#### 2.2 Or use composer command-line
   * php composer.phar require pmvc-plugin/guid

