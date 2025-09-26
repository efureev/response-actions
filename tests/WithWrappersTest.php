<?php

namespace ResponseActions\Tests;

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
    public function testEventCreatesResponseAction()
    {
        $eventName = 'user.logged_in';
        $eventParams = ['user_id' => 123, 'timestamp' => '2025-09-26T10:30:00Z'];

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
    public function testEventCreatesResponseActionWithoutParams()
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
    public function testDownloadCreatesResponseAction()
    {
        $url = 'https://example.com/file.zip';
        $name = 'file.zip';
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
    public function testDownloadCreatesResponseActionWithoutParams()
    {
        $url = 'https://example.com/file.zip';
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
        $this->assertEmpty($action->toArray()['params']);
    }

    /**
     * Tests that the static 'redirect' method creates a ResponseAction
     * with the expected URL, target, and HTTP code.
     */
    public function testRedirectCreatesResponseAction()
    {
        $url = 'https://example.com';
        $target = Redirect::TARGET_TOP;
        $code = 301;

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
    public function testRedirectCreatesResponseActionWithDefaultTargetAndCode()
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
    public function testCmdDoneCreatesResponseActionWithDescription()
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
    public function testCmdDoneCreatesResponseActionWithoutDescription()
    {
        $response = ResponseAction::cmdDone();

        $this->assertInstanceOf(ResponseAction::class, $response);
        $this->assertTrue($response->is(StatusEnum::SUCCESS));

        $actions = $response->actions();
        $this->assertCount(1, $actions);

        $action = $actions->first();
        $this->assertInstanceOf(Command::class, $action);
        $this->assertEquals('cmd', $action->name());
        $this->assertNull($action->toArray()['description']);
        $this->assertEquals(CommandStatus::Done, $action->toArray()['status']);
    }

    /**
     * Tests that the static 'cmdFailed' method creates a ResponseAction
     * with the expected status and a Command action marked as 'failed'.
     */
    public function testCmdFailedCreatesResponseActionWithDescription()
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
    public function testCmdFailedCreatesResponseActionWithoutDescription()
    {
        $response = ResponseAction::cmdFailed();

        $this->assertInstanceOf(ResponseAction::class, $response);
        $this->assertTrue($response->is(StatusEnum::ERROR));

        $actions = $response->actions();
        $this->assertCount(1, $actions);

        $action = $actions->first();
        $this->assertInstanceOf(Command::class, $action);
        $this->assertEquals('cmd', $action->name());
        $this->assertNull($action->toArray()['description']);
        $this->assertEquals(CommandStatus::Failed, $action->toArray()['status']);
    }

    /**
     * Tests that the static 'infoMessage' method creates a ResponseAction
     * with the 'INFO' status and a Message action of correct type.
     */
    public function testInfoMessageCreatesResponseAction()
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
    public function testWarningMessageCreatesResponseAction()
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
    public function testErrorMessageCreatesResponseAction()
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
    public function testCmdCreatesResponseActionWithDescription()
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
    public function testCmdCreatesResponseActionWithoutDescription()
    {
        $response = ResponseAction::cmd();

        $this->assertInstanceOf(ResponseAction::class, $response);
        $this->assertTrue($response->is(StatusEnum::NOTHING));

        $actions = $response->actions();
        $this->assertCount(1, $actions);

        $action = $actions->first();
        $this->assertInstanceOf(Command::class, $action);
        $this->assertEquals('cmd', $action->name());
        $this->assertNull($action->toArray()['description']);
        $this->assertFalse($action->isFailed());
    }
}
