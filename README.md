# Drop_DisableChildCategories
A Magento 2 module that disables child categories when parent category is disabled on admin

## Installation
- Install module through composer (recommended):
```sh
$ composer config repositories.drop.dcc vcs https://github.com/DevelopersDrop/Drop_DisableChildCategories
$ composer require drop/module-disablechildcategories
```

- Install module manually:
    - Copy these files in app/code/Drop/DisableChildCategories/

- After installing the extension, run the following commands:
```sh
$ php bin/magento module:enable Drop_DisableChildCategories
$ php bin/magento setup:upgrade
$ php bin/magento setup:di:compile
$ php bin/magento setup:static-content:deploy
$ php bin/magento cache:clear
```

## Requirements
- PHP >= 7.0.0

## Compatibility
- Magento >= 2.2
- Not tested on 2.1 and 2.0

## Support
If you encounter any problems or bugs, please create an issue on [Github](https://github.com/DevelopersDrop/Drop_DisableChildCategories/issues) 

## License
[GNU General Public License, version 3 (GPLv3)] http://opensource.org/licenses/gpl-3.0

## Copyright
(C) 2019 Drop S.R.L.
