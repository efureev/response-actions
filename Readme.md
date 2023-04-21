# Response Action

## Action Message Response Structure

```json5
{
  // Logic data block
  "data": [],
  // Action Message block (can be overwritten)
  "actionMessage": {
    // Request Execution Status. See: \App\Shared\UI\Response\ActionMessage\Types\StatusEnum::name()
    "status": "success",
    // list of actions \App\Shared\UI\Response\ActionMessage\Actions\Action
    "actions": [
      {
        // ... some action's body
      }
    ]
  }
}
```

### Actions

- Message
- MessageError: Message with Code
- Command
- Download
- Event
- Redirect

#### Common Action's Props

```json5
{
  // Action's Name
  "name": "message",
  // Action Order to perform. Default = 0
  "order": 1,
}
```

#### Action Message

```json5
{
  // message to show to user
  "message": "It's done!",
  // Type of the message
  "type": "info",
}
```

```php
ResponseAction::successMessage('Operation has success!');
```

You can make multi-message with different type:

```php
ResponseAction::errorMessage('Operation has failed!')
    ->addAction(Message::info('Try to restart page'));
```

#### Action MessageError

```json5
{
  // message to show to user
  "message": "It's done!",
  // type: int|string
  "code": 321,
  "type": "error",
}
```

#### Action Command

```json5
{
  // done | failed
  "status": "failed",
  // type: string|null
  "description": "Reason..."
}
```

#### Action Download

```json5
{
  "url": "https://example.com/file.pdf",
  "name": "Readme.pdf",
}
```

#### Action Event

```json5
{
  "event": "uploadData",
  "params": [],
}
```

#### Action Redirect

```json5
{
  "url": "https://example.com",
  "target": "_blank",
}
```

### Private

You can use private props:

```php
$responseAction = ResponseAction::successMessage('Operation has done!')
    ->addAction(
        Event::make('log', ['saved!', 'continue watching...']),
        Event::make('uploadModuleData')->private(),
        Event::make('uploadData')->private('menu'),
        Event::make('refreshUser')->private('authUser')->setOrder(1),
        Redirect::make('https://example.com')->setOrder(5),
        Download::make('https://example.com/file.pdf', 'Readme.pdf')->setOrder(2),
    );
```

### ExtraData

You can use extra data:

```php
$responseAction = ResponseAction::cmdDone()
    ->withExtra([]);
```