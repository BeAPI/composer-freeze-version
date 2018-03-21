# Composer Freeze Version
Freeze versions of your composer's dependencies.

# What ?
Your dependencies into composer.json will be automatically be changed from :

`"wpackagist-plugin/wordpress-seo":"@stable"`

into :

`"wpackagist-plugin/wordpress-seo":"6.2"`

# How ?
The `FreezeVersionRequires.php` must be placed into `/bin/` folder at project's root.

With the following script into composer.json :
```<?php
"scripts":{
    "freeze-version":[
        "BEA\\ComposerInstaller\\FreezeVersionRequires::freezeVersion"
    ]
},
```

Then you can simply launch `composer freeze-version` !
