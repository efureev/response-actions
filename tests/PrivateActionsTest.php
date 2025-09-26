<?php

declare(strict_types=1);

namespace ResponseActions\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ResponseActions\Actions\Download;
use ResponseActions\Actions\Event;
use ResponseActions\Actions\MessageTypeEnum;
use ResponseActions\Actions\Redirect;
use ResponseActions\ResponseAction;
use ResponseActions\StatusEnum;

final class PrivateActionsTest extends TestCase
{
    #[Test]
    public function makeCollection(): void
    {
        $ra = ResponseAction::successMessage('Operation has done!')
            ->addAction(
                new Event('log', ['saved!', 'continue watching...']),
                new Event('uploadModuleData')->private(),
                new Event('uploadData')->private('menu'),
                new Event('refreshUser')->private('authUser')->withOrder(1),
                new Redirect('https://example.com')->withOrder(5),
                new Download('https://example.com/file.pdf', 'Readme.pdf')->withOrder(2),
            );

        self::assertCount(7, $ra->actions());
        self::assertEquals(
            [
                'status'  => StatusEnum::SUCCESS,
                'actions' => [
                    [
                        'name'   => 'event',
                        'event'  => 'log',
                        'params' => [
                            'saved!',
                            'continue watching...',
                        ],
                        'order'  => 0,
                    ],
                    [
                        'name'    => 'event',
                        'event'   => 'uploadModuleData',
                        'private' => true,
                        'params'  => [],
                        'order'   => 0,
                    ],
                    [
                        'name'    => 'event',
                        'event'   => 'uploadData',
                        'private' => 'menu',
                        'params'  => [],
                        'order'   => 0,
                    ],
                    [
                        'name'    => 'message',
                        'message' => 'Operation has done!',
                        'type'    => MessageTypeEnum::SUCCESS,
                        'order'   => 0,
                    ],
                    [
                        'name'    => 'event',
                        'event'   => 'refreshUser',
                        'private' => 'authUser',
                        'params'  => [],
                        'order'   => 1,
                    ],
                    [
                        'name'  => 'download',
                        'url'   => 'https://example.com/file.pdf',
                        'file'  => 'Readme.pdf',
                        'order' => 2,
                    ],
                    [
                        'name'   => 'redirect',
                        'url'    => 'https://example.com',
                        'target' => '_blank',
                        'order'  => 5,
                        'code'   => 302,
                        'type'   => 'native',
                    ],
                ],
            ],
            $ra->toArray()
        );
    }
}
