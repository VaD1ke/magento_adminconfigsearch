# Admin Config Search
The module implements search field for system config fields in admin page, that has suggest and toggle switch for switchable fields.

## Install via composer

Update your `composer.json` like this

```JSON
    "require": {
        ...
        "VaD1ke/oggetto_adminconfigsearch": "*"
        ...
    },
    "repositories": [
    ...
        {
            "type": "vcs",
            "url": "https://github.com/VaD1ke/magento_adminconfigsearch"
        }
    ],
    ...
    "extra":{
        "magento-root-dir": ".",
    }

See more information about composer installer for magento at [github repository](https://github.com/magento-hackathon/magento-composer-installer/blob/master/README.md).