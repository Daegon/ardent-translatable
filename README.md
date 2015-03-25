Ardent Translatable
======
[![Build Status](https://travis-ci.org/mvdstam/ardent-translatable.svg)](https://travis-ci.org/mvdstam/ardent-translatable)

**Please note that this package should be considered alpha; use at your own risk!**

In a lot of cases, you may want to be able to use both the awesome functionality brought by the `laravelbook/ardent` package but also the trait provided by `dimsav/laravel-translatable`. When using those two combined, some issues would occur at the time of writing.

This package provides a base model class **ArdentTranslatable** for your Laravel projects, which brings the functionalities provided by [laravelbook/ardent](https://github.com/laravelbook/ardent) and [dimsav/laravel-translatable](https://github.com/dimsav/laravel-translatable) together in one class.
Aside from that, all `rules` can be designated in the main model class for each entity, even for fields that are actually translated (and thus handled by a `{$model_name}Translation` instead of the main model).

## Installation

Add `mvdstam/ardent-translatable` as a requirement to `composer.json`:

```
{
    "require": {
        "mvdstam/ardent-translatable": "~1.0"
    }
}
```

Explicitly requiring both `laravelbook/ardent` and `dimsav/laravel-translatable` isn't necessary when using this package, as they are specified as dependencies.

After that, make sure to add the service provider for `dimsav/laravel-translatable` to `app/config/app.php`:

```
'Dimsav\Translatable\TranslatableServiceProvider',
```

Finally, as an optional step, add the `ArdentTranslatable` alias to `app/config/app.php` so you can use it easily within your models:

```
'ArdentTranslatable' => 'Mvdstam\ArdentTranslatable\ArdentTranslatable',
```

## Documentation

* [Example](#example)

## Example

Consider a simple model called `Post` which has some translatable fields called `title` and `body`, as well as some non-localized fields called `author` and `author_email`:

```php
class Post extends ArdentTranslatable {
	
	public $translatedAttributes = ['title', 'body'];

	protected $fillable = ['title', 'body', 'author', 'author_email'];

	public static $rules = [
		'author'       => 'required',
		'author_email' => 'required|email',
		'title'        => 'required',
		'body'         => 'required'
	];
}

class PostTranslation extends Eloquent {

	public $timestamps  = false;
	protected $fillable = ['title', 'body'];	
}
```

Please note that the `Post` class extends `ArdentTranslatable`, thus providing access to the full `Ardent` rule-based system as well the localization functionality provided by the `Translatable` trait. The `PostTranslation` class still extends the regular `Eloquent` class.

When writing models that do not need translated fields, you should just extend the regular `Ardent` class to avoid unnecessary overhead.

Using the models above and running all necessary migrations, one can simply use the `Post` model:

```php
$post = new Post();

$post->save(); // Returns false	

```


## Todo
* ~~Tests~~
* Expand upon this documentation :smiley: