# Sculpin Calendarian Bundle

<table><tr>
<td>日本語</td>
<td><a href="README.md">ENGLISH</a></td>
</tr></table>

## これはなに？

これは、 [Sculpin](https://sculpin.io/) 用のブログの日付ディレクトリにインデックスページを生成する **バンドル** です。

## セットアップ

```sculpin.json``` ファイルに、このバンドルを追加しましょう。

```json
{
    // ...
    "require": {
        // ...
        "sharkpp/sculpin-calendarian-bundle": "dev-master"
    }
}
```

そして、 ```sculpin update``` を実行し、このバンドルをインストールします。

次に ```app/SculpinKernel.php``` ファイルで利用可能な ```SculpinKernel``` クラスでバンドルを登録しましょう。

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

## 使い方

例えば、 ```source/blog/date.html``` ファイルを作りましょう。

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

このような内容で作成することで、 ```http://your.site.url/blog/2015/08/09/hoge.html``` と、このようなページがあったときに、 ```http://your.site.url/blog/2015/``` と ```http://your.site.url/blog/2015/08/``` と ```http://your.site.url/blog/2015/08/09/``` へ作成した内容をもとにページが作られ、アクセスできるようになります。

## ライセンス

&copy; 2015 sharkpp

このソフトウェアは [MIT ライセンス](http://opensource.org/licenses/MIT) の下でリリースされています。
[LICENSE-ja](LICENSE-ja) をご確認ください。
