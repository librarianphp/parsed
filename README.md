# Parsed
A generic content parser based on the devto post format, with front matter and liquid tag support. 
Parsed uses [erusev/parsedown](https://packagist.org/packages/erusev/parsedown) as base markdown parser.

Current liquid tags implemented:

- Twitter embed: `{% twitter tweet_id %}`
- Youtube video embed: `{% youtube video_id %}`
- GitHub File: `{% github full_path_to_repo_file %}`

More to come, contributions welcome.

## Installation

```bash
composer require erikaheidi/parsed
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
