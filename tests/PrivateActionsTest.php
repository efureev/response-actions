<?php

declare(strict_types=1);

namespace ResponseActions\Tests;

use PHPUnit\Framework\TestCase;
use ResponseActions\Actions\Download;
use ResponseActions\Actions\Event;
use ResponseActions\Actions\Redirect;
use ResponseActions\ResponseAction;

final class PrivateActionsTest extends TestCase
{
    /**
     * @test
     */
    public function makeCollection(): void
    {
        $ra = ResponseAction::successMessage('Operation has done!')
            ->addAction(
                Event::make('log', ['saved!', 'continue watching...']),
                Event::make('uploadModuleData')->private(),
                Event::make('uploadData')->private('menu'),
                Event::make('refreshUser')->private('authUser')->setOrder(1),
                Redirect::make('https://example.com')->setOrder(5),
                Download::make('https://example.com/file.pdf', 'Readme.pdf')->setOrder(2),
            );

        self::assertCount(7, $ra->actions());
        self::assertEquals([
            'status' => 'success',
            'actions' => [
                [
                    'name' => 'message',
                    'message' => 'Operation has done!',
                    'type' => 'success',
                    'order' => 0,
                ],
                [
                    'name' => 'event',
                    'event' => 'log',
                    'params' => ['saved!', 'continue watching...'],
                    'order' => 0,
                ],
                [
                    'name' => 'event',
                    'event' => 'uploadModuleData',
                    'private' => true,
                    'params' => [],
                    'order' => 0,
                ],
                [
                    'name' => 'event',
                    'event' => 'uploadData',
                    'private' => 'menu',
                    'params' => [],
                    'order' => 0,
                ],
                [
                    'name' => 'event',
                    'event' => 'refreshUser',
                    'private' => 'authUser',
                    'params' => [],
                    'order' => 1,
                ],
                [
                    'name' => 'download',
                    'url' => 'https://example.com/file.pdf',
                    'file' => 'Readme.pdf',
                    'order' => 2,
                ],
                [
                    'name' => 'redirect',
                    'url' => 'https://example.com',
                    'target' => '_blank',
                    'order' => 5,
                    'code' => 302,
                    'type' => 'native'
                ],
            ],
        ], $ra->toArray());
    }
}
