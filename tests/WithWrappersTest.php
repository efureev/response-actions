<?php

namespace ResponseActions\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ResponseActions\Actions\Command;
use ResponseActions\Actions\CommandStatus;
use ResponseActions\Actions\Download;
use ResponseActions\Actions\Message;
use ResponseActions\Actions\MessageTypeEnum;
use ResponseActions\Actions\Redirect;
use ResponseActions\ResponseAction;
use ResponseActions\StatusEnum;
use ResponseActions\Actions\Event;

class WithWrappersTest extends TestCase
{
    /**
     * Tests that the static 'event' method creates a ResponseAction
     * with the expected event name and parameters.
     */
    #[Test]
    public function eventCreatesResponseAction()
    {
        $eventName   = 'user.logged_in';
        $eventParams = [
            'user_id'   => 123,
            'timestamp' => '2025-09-26T10:30:00Z',
        ];

        $response = ResponseAction::event($eventName, $eventParams);

        $this->assertInstanceOf(ResponseAction::class, $response);
        $this->assertTrue($response->is(StatusEnum::NOTHING));

        $actions = $response->actions();
        $this->assertCount(1, $actions);

        $action = $actions->first();
        $this->assertInstanceOf(Event::class, $action);
        $this->assertEquals('event', $action->name());
        $this->assertEquals($eventParams, $action->toArray()['params']);
    }

    /**
     * Tests that the static 'event' method works correctly when
     * no parameters are provided.
     */
    #[Test]
    public function eventCreatesResponseActionWithoutParams()
    {
        $eventName = 'app.started';

        $response = ResponseAction::event($eventName);

        $this->assertInstanceOf(ResponseAction::class, $response);
        $this->assertTrue($response->is(StatusEnum::NOTHING));

        $actions = $response->actions();
        $this->assertCount(1, $actions);

        $action = $actions->first();
        $this->assertInstanceOf(Event::class, $action);
        $this->assertEquals('event', $action->name());
        $this->assertEmpty($action->toArray()['params']);
    }

    /**
     * Tests that the static 'download' method creates a ResponseAction
     * with the expected URL, name, and parameters.
     */
    #[Test]
    public function downloadCreatesResponseAction()
    {
        $url    = 'https://example.com/file.zip';
        $name   = 'file.zip';
        $params = ['access_token' => 'abc123'];

        $response = ResponseAction::download($url, $name, $params);

        $this->assertInstanceOf(ResponseAction::class, $response);
        $this->assertTrue($response->is(StatusEnum::NOTHING));

        $actions = $response->actions();
        $this->assertCount(1, $actions);

        $action = $actions->first();
        $this->assertInstanceOf(Download::class, $action);
        $this->assertEquals('download', $action->name());
        $this->assertEquals($url, $action->toArray()['url']);
        $this->assertEquals($name, $action->toArray()['file']);
        $this->assertEquals('download', $action->toArray()['name']);
        $this->assertEquals($params, $action->toArray()['params']);
    }

    /**
     * Tests that the static 'download' method works correctly when
     * no parameters are provided.
     */
    #[Test]
    public function downloadCreatesResponseActionWithoutParams()
    {
        $url  = 'https://example.com/file.zip';
        $name = 'file.zip';

        $response = ResponseAction::download($url, $name);

        $this->assertInstanceOf(ResponseAction::class, $response);
        $this->assertTrue($response->is(StatusEnum::NOTHING));

        $actions = $response->actions();
        $this->assertCount(1, $actions);

        $action = $actions->first();
        $this->assertInstanceOf(Download::class, $action);
        $this->assertEquals('download', $action->name());
        $this->assertEquals($url, $action->toArray()['url']);
        $this->assertEquals($name, $action->toArray()['file']);
        $this->assertEquals('download', $action->toArray()['name']);
        $this->assertArrayNotHasKey('params', $action->toArray());
    }

    /**
     * Tests that the static 'redirect' method creates a ResponseAction
     * with the expected URL, target, and HTTP code.
     */
    #[Test]
    public function redirectCreatesResponseAction()
    {
        $url    = 'https://example.com';
        $target = Redirect::TARGET_TOP;
        $code   = 301;

        $response = ResponseAction::redirect($url, $target, $code);

        $this->assertInstanceOf(ResponseAction::class, $response);
        $this->assertTrue($response->is(StatusEnum::NOTHING));

        $actions = $response->actions();
        $this->assertCount(1, $actions);

        $action = $actions->first();
        $this->assertInstanceOf(Redirect::class, $action);
        $this->assertEquals('redirect', $action->name());
        $this->assertEquals($url, $action->toArray()['url']);
        $this->assertEquals($target, $action->toArray()['target']);
        $this->assertEquals($code, $action->toArray()['code']);
    }

    /**
     * Tests that the static 'redirect' method works correctly when
     * no target or HTTP code is provided.
     */
    #[Test]
    public function redirectCreatesResponseActionWithDefaultTargetAndCode()
    {
        $url = 'https://example.com';

        $response = ResponseAction::redirect($url);

        $this->assertInstanceOf(ResponseAction::class, $response);
        $this->assertTrue($response->is(StatusEnum::NOTHING));

        $actions = $response->actions();
        $this->assertCount(1, $actions);

        $action = $actions->first();
        $this->assertInstanceOf(Redirect::class, $action);
        $this->assertEquals('redirect', $action->name());
        $this->assertEquals($url, $action->toArray()['url']);
        $this->assertEquals(Redirect::TARGET_BLANK, $action->toArray()['target']);
        $this->assertEquals(302, $action->toArray()['code']);
    }


    /**
     * Tests that the static 'cmdDone' method creates a ResponseAction
     * with the expected status and a Command action marked as 'done'.
     */
    #[Test]
    public function cmdDoneCreatesResponseActionWithDescription()
    {
        $description = 'Task completed successfully';

        $response = ResponseAction::cmdDone($description);

        $this->assertInstanceOf(ResponseAction::class, $response);
        $this->assertTrue($response->is(StatusEnum::SUCCESS));

        $actions = $response->actions();
        $this->assertCount(1, $actions);

        $action = $actions->first();
        $this->assertInstanceOf(Command::class, $action);
        $this->assertEquals('cmd', $action->name());
        $this->assertEquals($description, $action->toArray()['description']);
        $this->assertEquals(CommandStatus::Done, $action->toArray()['status']);
    }

    /**
     * Tests that the static 'cmdDone' method creates a ResponseAction
     * with a 'done' Command action when no description is provided.
     */
    #[Test]
    public function cmdDoneCreatesResponseActionWithoutDescription()
    {
        $response = ResponseAction::cmdDone();

        $this->assertInstanceOf(ResponseAction::class, $response);
        $this->assertTrue($response->is(StatusEnum::SUCCESS));

        $actions = $response->actions();
        $this->assertCount(1, $actions);

        $action = $actions->first();
        $this->assertInstanceOf(Command::class, $action);
        $this->assertEquals('cmd', $action->name());
        $this->assertArrayNotHasKey('description', $action->toArray());

        $this->assertEquals(CommandStatus::Done, $action->toArray()['status']);
    }

    /**
     * Tests that the static 'cmdFailed' method creates a ResponseAction
     * with the expected status and a Command action marked as 'failed'.
     */
    #[Test]
    public function cmdFailedCreatesResponseActionWithDescription()
    {
        $description = 'Task failed due to an error';

        $response = ResponseAction::cmdFailed($description);

        $this->assertInstanceOf(ResponseAction::class, $response);
        $this->assertTrue($response->is(StatusEnum::ERROR));

        $actions = $response->actions();
        $this->assertCount(1, $actions);

        $action = $actions->first();
        $this->assertInstanceOf(Command::class, $action);
        $this->assertEquals('cmd', $action->name());
        $this->assertEquals($description, $action->toArray()['description']);
        $this->assertEquals(CommandStatus::Failed, $action->toArray()['status']);
    }

    /**
     * Tests that the static 'cmdFailed' method creates a ResponseAction
     * with a 'failed' Command action when no description is provided.
     */
    #[Test]
    public function cmdFailedCreatesResponseActionWithoutDescription()
    {
        $response = ResponseAction::cmdFailed();

        $this->assertInstanceOf(ResponseAction::class, $response);
        $this->assertTrue($response->is(StatusEnum::ERROR));

        $actions = $response->actions();
        $this->assertCount(1, $actions);

        $action = $actions->first();
        $this->assertInstanceOf(Command::class, $action);
        $this->assertEquals('cmd', $action->name());
        $this->assertArrayNotHasKey('description', $action->toArray());
        $this->assertEquals(CommandStatus::Failed, $action->toArray()['status']);
    }

    /**
     * Tests that the static 'infoMessage' method creates a ResponseAction
     * with the 'INFO' status and a Message action of correct type.
     */
    #[Test]
    public function infoMessageCreatesResponseAction()
    {
        $message = 'This is an informational message';

        $response = ResponseAction::infoMessage($message);

        $this->assertInstanceOf(ResponseAction::class, $response);
        $this->assertTrue($response->is(StatusEnum::INFO));

        $actions = $response->actions();
        $this->assertCount(1, $actions);

        $action = $actions->first();
        $this->assertInstanceOf(Message::class, $action);
        $this->assertEquals($message, $action->toArray()['message']);
        $this->assertEquals(MessageTypeEnum::INFO, $action->toArray()['type']);
    }

    /**
     * Tests that the static 'warningMessage' method creates a ResponseAction
     * with the 'WARNING' status and a Message action of correct type.
     */
    #[Test]
    public function warningMessageCreatesResponseAction()
    {
        $message = 'This is a warning message';

        $response = ResponseAction::warningMessage($message);

        $this->assertInstanceOf(ResponseAction::class, $response);
        $this->assertTrue($response->is(StatusEnum::WARNING));

        $actions = $response->actions();
        $this->assertCount(1, $actions);

        $action = $actions->first();
        $this->assertInstanceOf(Message::class, $action);
        $this->assertEquals($message, $action->toArray()['message']);
        $this->assertEquals(MessageTypeEnum::WARNING, $action->toArray()['type']);
    }

    /**
     * Tests that the static 'errorMessage' method creates a ResponseAction
     * with the 'ERROR' status and a Message action of correct type.
     */
    #[Test]
    public function errorMessageCreatesResponseAction()
    {
        $message = 'This is an error message';

        $response = ResponseAction::errorMessage($message);

        $this->assertInstanceOf(ResponseAction::class, $response);
        $this->assertTrue($response->is(StatusEnum::ERROR));

        $actions = $response->actions();
        $this->assertCount(1, $actions);

        $action = $actions->first();
        $this->assertInstanceOf(Message::class, $action);
        $this->assertEquals($message, $action->toArray()['message']);
        $this->assertEquals(MessageTypeEnum::ERROR, $action->toArray()['type']);
    }

    /**
     * Tests that the static 'cmd' method creates a ResponseAction
     * with a pending Command action and the expected description.
     */
    #[Test]
    public function cmdCreatesResponseActionWithDescription()
    {
        $description = 'Pending task description';

        $response = ResponseAction::cmd($description);

        $this->assertInstanceOf(ResponseAction::class, $response);
        $this->assertTrue($response->is(StatusEnum::NOTHING));

        $actions = $response->actions();
        $this->assertCount(1, $actions);

        $action = $actions->first();
        $this->assertInstanceOf(Command::class, $action);
        $this->assertEquals('cmd', $action->name());
        $this->assertEquals($description, $action->toArray()['description']);
        $this->assertFalse($action->isFailed());
    }

    /**
     * Tests that the static 'cmd' method creates a ResponseAction
     * with a pending Command action when no description is provided.
     */
    #[Test]
    public function cmdCreatesResponseActionWithoutDescription()
    {
        $response = ResponseAction::cmd();

        $this->assertInstanceOf(ResponseAction::class, $response);
        $this->assertTrue($response->is(StatusEnum::NOTHING));

        $actions = $response->actions();
        $this->assertCount(1, $actions);

        $action = $actions->first();
        $this->assertInstanceOf(Command::class, $action);
        $this->assertEquals('cmd', $action->name());
        $this->assertArrayNotHasKey('description', $action->toArray());
        $this->assertFalse($action->isFailed());
    }
}
