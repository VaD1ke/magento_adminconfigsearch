# Admin Config Search

The module implements search field for system config fields in admin page, that has suggest and toggle switch for switchable fields.

## Install via composer

Update your `composer.json` like this

```JSON
    "require": {
        ...
        "oggettoweb/ajax": "1.*",
        "vad1ke/oggetto_adminconfigsearch": "dev-master"
        ...
    },
    "repositories": [
    ...
        {
            "type": "vcs",
            "url": "https://github.com/OggettoWeb/ajax"
        },
        {
            "type": "vcs",
            "url": "https://github.com/VaD1ke/magento_adminconfigsearch"
        }
    ],
    ...
    "extra":{
        "magento-root-dir": "."
    }
```

See more information about composer installer for magento at [github repository](https://github.com/magento-hackathon/magento-composer-installer/blob/master/README.md).

Don't forget to set *Allow Symlink* to *Yes* in *system->configuration->Advanced->Developer->Template settings* in admin of your magento. 

## Features

- The minimum number of characters a user must type before a search is performed is 3.
- Module searchs by config setting's (field) name (label) and comment.
- Search is performed in Russian (if you have translations) and English languages.
- If setting's value not set suggest displaying 'Not set'
- Module is using jQuery Autocomplete for suggest.