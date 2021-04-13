# Parsed
A generic content parser based on the devto post format, with liquid tag support, using erusev/parsedown as base markdown parser.


## Usage

```bash
composer require erikaheidi/parsed
```

```php
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
