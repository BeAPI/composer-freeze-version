<a href="https://beapi.fr">![Be API Github Banner](banner-github.png)</a>

# Composer Freeze Version

Freeze versions of your composer's dependencies.

# What ?

Your dependencies into composer.json will be automatically be changed from :

`"wpackagist-plugin/wordpress-seo":"@stable"`

into :

`"wpackagist-plugin/wordpress-seo":"6.2"`

# How ?

The `FreezeVersionRequires.php` must be placed into `bin/` folder at project's root.

PS: ensure the `bin/` folder is autoloaded :
```<?php
"autoload":{
	"psr-4": {
		"BEA\\ComposerInstaller\\": "bin/"
	},
}
```

Add the following script into composer.json :
```<?php
"scripts":{
    "freeze-version":[
        "BEA\\ComposerInstaller\\FreezeVersionRequires::freezeVersion"
    ]
},
```

Then you can simply launch `composer freeze-version` !

# Who ?

Created by [Be API](https://beapi.fr), the French WordPress leader agency since 2009. Based in Paris, we are more than 30 people and always [hiring](https://beapi.workable.com) some fun and talented guys. So we will be pleased to work with you.

This plugin is only maintained, which means we do not guarantee some free support. If you identify any errors or have an idea for improving this script, feel free to open an [issue](../../issues/new). Please provide as much info as needed in order to help us resolving / approve your request. And .. be patient :)

If you really like what we do or want to thank us for our quick work, feel free to [donate](https://www.paypal.me/BeAPI) as much as you want / can, even 1€ is a great gift for buying cofee :)

## License

Composer Freeze Version is licensed under the [GPLv3 or later](LICENSE.md).
