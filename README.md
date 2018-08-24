<a href="https://beapi.fr">![Be API Github Banner](banner-github.png)</a>

# Composer Freeze Version

Freeze versions of your composer's dependencies.

This command is especially useful while making a site live. It allows you to grab latest versions of your composer.lock which you tested you site against.
If you would like to go back to a staging status, use another command : [Make Stable](https://github.com/BeAPI/composer-make-stable) to set versions stable.

# What ?

Your dependencies into composer.json will be automatically be changed from :

`"wpackagist-plugin/wordpress-seo":"@stable"`

into :

`"wpackagist-plugin/wordpress-seo":"6.2"`

![Composer Freeze Vesrion : how to)](https://blog.beapi.fr/wp-content/uploads/2018/06/bea-composer-freeze-version.gif)

# How ?

## 1 - Add to [Composer](http://composer.rarst.net/)

- Add repository source : `{ "type": "vcs", "url": "https://github.com/BeAPI/composer-freeze-version" }`.
- Include `"bea/composer/freeze-version": "dev-master"` into your composer.json file as require dev.
- Then `composer update` before use.

## 2 - Run command 

Then you can simply launch `composer freeze-version` !

# Who ?

Created by [Be API](https://beapi.fr), the French WordPress leader agency since 2009. Based in Paris, we are more than 30 people and always [hiring](https://beapi.workable.com) some fun and talented guys. So we will be pleased to work with you.

This plugin is only maintained, which means we do not guarantee some free support. If you identify any errors or have an idea for improving this script, feel free to open an [issue](../../issues/new). Please provide as much info as needed in order to help us resolving / approve your request. And .. be patient :)

If you really like what we do or want to thank us for our quick work, feel free to [donate](https://www.paypal.me/BeAPI) as much as you want / can, even 1€ is a great gift for buying cofee :)

## License

Composer Freeze Version is licensed under the [GPLv3 or later](LICENSE.md).
