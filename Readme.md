# Response Action

## Response types

### Query

**Methods**

- GET

**Result**

- Success: 20x
- Error: 5xx
- Warning: 4xx (422: Validation)

### Command

**Methods**

- POST
- PUT
- DELETE

**Result**

- Success: 20x
- Error: 5xx
- Warning: 4xx (422: Validation)

## Action Message Response Structure

```json5
{
  // Logic data block
  "data": [],
  // Action Message block
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

### Actions

- Message
- MessageError: Message with Code
- Command
- Download
- Event
- Redirect
  