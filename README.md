[![Latest Stable Version](https://poser.pugx.org/pmvc-plugin/guid/v/stable)](https://packagist.org/packages/pmvc-plugin/guid) 
[![Latest Unstable Version](https://poser.pugx.org/pmvc-plugin/guid/v/unstable)](https://packagist.org/packages/pmvc-plugin/guid) 
[![CircleCI](https://circleci.com/gh/pmvc-plugin/guid/tree/master.svg?style=svg)](https://circleci.com/gh/pmvc-plugin/guid/tree/master)
[![License](https://poser.pugx.org/pmvc-plugin/guid/license)](https://packagist.org/packages/pmvc-plugin/guid)
[![Total Downloads](https://poser.pugx.org/pmvc-plugin/guid/downloads)](https://packagist.org/packages/pmvc-plugin/guid) 

Id of things  
===============

## GetModel Sample
   * Algolia
      * https://github.com/pmvc-plugin/algolia/blob/master/algolia.php
   * Ssdb
      * https://github.com/pmvc-plugin/ssdb/blob/master/ssdb.php
   * Others
      * https://github.com/search?q=topic:pmvc-guid


## Global Table
   * GlobalKey
       * format: guid->key
       * https://github.com/pmvc-plugin/guid/blob/master/src/models/GlobalGuidKey.php
       * Get Key
          ```
          \PMVC\plug('guid')->manager()->getKey($guid);
          ```
   * GlobalGuid
       * format: key->guid
       * https://github.com/pmvc-plugin/guid/blob/master/src/models/GlobalKeyGuid.php
       * Get Guid
          ```
          \PMVC\plug('guid')->manager()->getGuid($key);
          ```




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

