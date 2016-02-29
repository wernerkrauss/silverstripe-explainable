silverstripe-explainable
==========================

Silverstripe module for managing Abbreviations and unusal words using shortcodes. Good for web accesibility.

See https://www.wuhcag.com/abbreviations/ and https://www.wuhcag.com/unusual-words/ for the corresponding guidelines.

## Requirements

* [`Silverstripe 3.1.* framework`](https://github.com/silverstripe/silverstripe-framework)
* [`Silverstripe 3.1.* CMS`](https://github.com/silverstripe/cms)
* [`Shortcodable module`](https://github.com/sheadawson/silverstripe-shortcodable)

## Installation

Download and install manually or use composer.

```
composer require wernerkrauss/explainable
```

## Configuration

Add a page of type "AbbrevationPage" or "ExplanationPage" to your CMS. There you can add new abbreviations or explanations
in the gridfield.

You can link to this abbreviations in the CMS using the bundled shortcodes, use the UI for selecting the abbreviation.

The listings page lists all abbreviations or explanations in alphabetical order, grouped by first letter. You might update 
the templates to fit your needs.

### Adding to Google Sitemap

You can add the abbreviations and explanations to google sitemap if you have the GoogleSitemap module installed. Just 
add to your `mysite/_config.php`: 

```
GoogleSitemap::register_dataobject('Abbreviation', 'weekly', '0.5');
GoogleSitemap::register_dataobject('Explanation', 'weekly', '0.5');
```

## TODO
* create new abbreviation or explanation directly in shortcode UI? Using AddNew button this could be possible.
  Maybe we have to tweak shortcodable controller for that?
