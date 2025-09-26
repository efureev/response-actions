# Response Action

![](https://img.shields.io/badge/php-8.1|8.2-blue.svg)
[![PHP Package](https://github.com/efureev/response-actions/actions/workflows/php.yml/badge.svg)](https://github.com/efureev/response-actions/actions/workflows/php.yml)
[![Build Status](https://travis-ci.org/efureev/response-actions.svg?branch=master)](https://travis-ci.org/efureev/response-actions)
[![Latest Stable Version](https://poser.pugx.org/efureev/response-actions/v/stable?format=flat)](https://packagist.org/packages/efureev/response-actions)
[![Maintainability](https://qlty.sh/gh/efureev/projects/response-actions/maintainability.svg)](https://qlty.sh/gh/efureev/projects/response-actions)
[![Code Coverage](https://qlty.sh/gh/efureev/projects/response-actions/coverage.svg)](https://qlty.sh/gh/efureev/projects/response-actions)
[![codecov](https://codecov.io/github/efureev/response-actions/graph/badge.svg?token=ftgNXhJUxk)](https://codecov.io/github/efureev/response-actions)

## Install

For php >= 8.4

```bash
composer require efureev/response-actions "^2.0"
```

## Action Message Response Structure

```json5
{
  // Action Message block (can be overwritten with a custom key)
  "_responseAction": {
    // Request Execution Status. See: ResponseActions\\StatusEnum
    "status": "success",
    // list of actions: array of ResponseActions\\Actions\\Action
    "actions": [
      {
        // ... some action's body
      }
    ],
    // optional extra payload attached to the response action
    "extra": { }
  }
}
```

### Actions

- Message
- Command
- Download
- Event
- Redirect

#### Common Action's Props

```json5
{
  // Action's Name
  "name": "message",
  // Action order to perform. Default = 0
  "order": 1,
  // Private action. boolean true or string channel name
  "private": true
}
```

#### Action Message

```json5
{
  // message to show to user
  "message": "It's done!",
  // Type of the message (optional when type is empty)
  "type": "info"
}
```

```php
use ResponseActions\ResponseAction;
use ResponseActions\Actions\Message;

ResponseAction::successMessage('Operation has success!');

// Multi-message with different types
ResponseAction::errorMessage('Operation has failed!')
    ->addAction(Message::info('Try to restart page'));
```

#### Action Command

```json5
{
  // pending | done | failed
  "status": "failed",
  // optional description
  "description": "Reason..."
}
```

Helpers:
- ResponseAction::cmd()     // pending
- ResponseAction::cmdDone() // done
- ResponseAction::cmdFailed() // failed

#### Action Download

```json5
{
  "url": "https://example.com/file.pdf",
  "file": "Readme.pdf",
  // optional params passed to the client handler
  "params": {}
}
```

#### Action Event

```json5
{
  "event": "uploadData",
  "params": {}
}
```

#### Action Redirect

```json5
{
  "url": "https://example.com",
  "target": "_blank",
  // native | router
  "type": "native",
  // HTTP code (when applicable)
  "code": 302
}
```

You can also use helpers:
- ResponseAction::redirect('https://example.com')
- ResponseActions\\Actions\\Redirect::router('/route')
- ResponseActions\\Actions\\Redirect::native('https://example.com')

### Private

You can use private props and order:

```php
use ResponseActions\ResponseAction;
use ResponseActions\Actions\{Event, Redirect, Download};

$responseAction = ResponseAction::successMessage('Operation has done!')
    ->addAction(
        new Event('log', ['saved!', 'continue watching...']),
        (new Event('uploadModuleData'))->private(),
        (new Event('uploadData'))->private('menu'),
        (new Event('refreshUser'))->private('authUser')->withOrder(1),
        (new Redirect('https://example.com'))->withOrder(5),
        (new Download('https://example.com/file.pdf', 'Readme.pdf'))->withOrder(2),
    );
```

### ExtraData

You can attach extra data to the whole ResponseAction or to Message actions:

```php
use ResponseActions\ResponseAction;

$responseAction = ResponseAction::cmdDone()
    ->withExtra(['any' => 'thing']);
```