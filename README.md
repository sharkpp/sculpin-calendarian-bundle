# Sculpin Calendarian Bundle

<table><tr>
<td><a href="README-ja.md">日本語</a></td>
<td>ENGLISH</td>
</tr></table>

## What is this?

This is a **Bundle** that generates the index page to blog date directory for [Sculpin](https://sculpin.io/).

## Setup

Add this bundle in your ```sculpin.json``` file:

```json
{
    // ...
    "require": {
        // ...
        "sharkpp/sculpin-calendarian-bundle": "dev-master"
    }
}
```

and install this bundle running ```sculpin update```.

Now you can register the bundle in ```SculpinKernel``` class available on ```app/SculpinKernel.php``` file:

```php
<?php

class SculpinKernel extends \Sculpin\Bundle\SculpinBundle\HttpKernel\AbstractKernel
{
    protected function getAdditionalSculpinBundles()
    {
        return array(
           'Sharkpp\Sculpin\Bundle\CalendarianBundle\SculpinCalendarianBundle'
        );
    }
}
```

## How to use

For example, create a ```source/blog/date.html``` file:

```markdown
---
generator: calendarian
---

<h2>
{% if page.calendarian.year %}{{ page.calendarian.year }}-{% endif %}
{% if page.calendarian.month %}{{ page.calendarian.month }}-{% endif %}
{% if page.calendarian.day %}{{ page.calendarian.day }}-{% endif %}
</h2>

<ul>
    {% for item in page.calendarian.items %}
        <li><a href="{{ item.url }}">{{ item.title }}</a></li>
    {% endfor %}
</ul>
```

By creating in such content, and ```http://your.site.url/blog/2015/08/09/hoge.html```, when there is such a page, the page is created based on the content that was created to ```http://your.site.url/blog/2015/``` and ```http://your.site.url/blog/2015/08/``` and ```http://your.site.url/blog/2015/08/09/```, it can be accessed.

## License

&copy; 2015 sharkpp

This software is released under the [MIT License](http://opensource.org/licenses/MIT), see [LICENSE](LICENSE).
