# mailgun-utils

Utils for working with Mailgun

## How to

First, you MUST set API info:

```php
\nkkollaw\Utils\Mailgun::setApiKey(MAILGUN_API_KEY);
\nkkollaw\Utils\Mailgun::setBaseUrl(MAILGUN_API_URL);
```

### Events

The events method retrieves every single event. The cool thing is that it handles pagination, so that you don't have to worry about it.

```php
$events = \nkkollaw\Utils\Mailgun::getEvents();
```

### Bounces

Will get to it.