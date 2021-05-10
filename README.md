# Parsed
A generic content parser based on the devto post format, with front matter and liquid tag support. 
Parsed uses [league/commonmark](https://packagist.org/packages/league/commonmark) as base markdown parser.

Current liquid tags implemented:

- HTML Video embed (mp4): `{% video path_to_video.mp4 %}`
- HTML Audio embed (mp3): `{% audio path_to_audio.mp3 %}`
- Twitter embed: `{% twitter tweet_id %}`
- Youtube video embed: `{% youtube video_id %}`
- GitHub File: `{% github full_path_to_repo_file %}`

More to come, contributions welcome.

## Installation

```bash
composer require librarianphp/parsed
```

## Usage Examples

```php
<?php
use Parsed\Content;
use Parsed\ContentParser;

$content = "---\n";
$content .= "title: Content Title\n";
$content .= "description: My Description\n";
$content .= "custom: custom\n";
$content .= "---\n";
$content .= "## Testing";

$article = new Content($content);
$article->parse(new ContentParser(), true);

print_r($article);
```

```
Parsed\Content Object
(
    [raw] => ---
title: Content Title
description: My Description
custom: custom
---
## Testing
    [front_matter] => Array
        (
            [title] => Content Title
            [description] => My Description
            [custom] => custom
        )

    [body_markdown] => ## Testing
    [body_html] => <h2>Testing</h2>
)
```

## Obtaining Front Matter

There are two methods to work with the front matter: `frontMatterHas` and `frontMatterGet`:

```php
$article = new Content($content);
$article->parse(new ContentParser(), true);

if ($article->frontMatterHas('title')) {
    return $article->frontMatterGet('title');
}
```

## Creating Custom Liquid Tags

Liquid tags are classes that implement the `CustomTagParserInterface`. They need to implement a method named `parse`, which receives the string provided to the liquid tag when called from the markdown file. 
For instance, this is the full code for the `video` liquid tag parser class:

```php
<?php
#src/CustomTagParser/VideoTagParser.php

namespace Parsed\CustomTagParser;

use Parsed\CustomTagParserInterface;

class VideoTagParser implements CustomTagParserInterface
{
    public function parse($tag_value, array $params = [])
    {
        return "<video controls>" .
         "<source src=\"$tag_value\" type=\"video/mp4\">" .
         "Your browser does not support the video tag." .
         "</video>";
    }
}
```

You'll have to include your custom tag parser class within the ContentParser:

```php
$parser = new \Parsed\ContentParser();
$parser->addCustomTagParser('video', new VideoTagParser());
```
_Note: The built-in tag parsers are already registered within ContentParser. These are: `video`, `audio`, `twitter`, `youtube` and `github`._


For instance, if you have in your markdown:

```
{% video /videos/test.mp4 %}
```

It will convert to the tag into the following code:

```html
<video controls>
   <source src="/videos/test.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>
```
## Tests

Parsed uses [Pest](https://github.com/pestphp/pest) as testing framework. To run the tests:

```command
./vendor/bin/pest
```