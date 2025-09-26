<?php

declare(strict_types=1);

namespace ResponseActions\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ResponseActions\Actions\Download;
use ResponseActions\Actions\Event;
use ResponseActions\Actions\Redirect;
use ResponseActions\ResponseAction;
use ResponseActions\StatusEnum;
use ResponseActions\Utils\B64;

final class ResponseActionEncodedTest extends TestCase
{
    #[Test]
    public function responseActionToString(): void
    {
        $ra = new ResponseAction(StatusEnum::SUCCESS);
        self::assertFalse($ra->isNothing());
        self::assertFalse($ra->isError());
        self::assertTrue($ra->is(StatusEnum::SUCCESS));
        self::assertCount(0, $ra->actions());
        self::assertEquals(
            [
                'actions' => [
                    'status' => StatusEnum::SUCCESS,
                ],
            ],
            $ra->wrap('actions')
        );

        self::assertEquals('{"_responseAction":{"status":"success"}}', $ra->toString());
    }

    #[Test]
    public function responseActionsToString(): void
    {
        $ra = ResponseAction::successMessage('Operation has done!')
            ->addAction(
                new Event('log', ['saved!', 'continue watching...']),
                new Event('refreshUser')->private('authUser')->withOrder(1),
                new Redirect('https://example.com')->withOrder(5),
                new Download('https://example.com/file.pdf', 'Readme.pdf')->withOrder(2),
            );


        self::assertEquals(
            '{"_responseAction":{"status":"success","actions":[{"name":"event","order":0,"event":"log","params":["saved!","continue watching..."]},{"name":"message","order":0,"message":"Operation has done!","type":"success"},{"name":"event","order":1,"private":"authUser","event":"refreshUser","params":[]},{"name":"download","order":2,"url":"https://example.com/file.pdf","file":"Readme.pdf"},{"name":"redirect","order":5,"url":"https://example.com","target":"_blank","type":"native","code":302}]}}',
            $ra->toString()
        );
    }

    #[Test]
    public function responseActionToEncodedStringB64(): void
    {
        $ra   = new ResponseAction(StatusEnum::SUCCESS);
        $hash = 'eyJfcmVzcG9uc2VBY3Rpb24iOnsic3RhdHVzIjoic3VjY2VzcyJ9fQ==';
        self::assertEquals($hash, $ra->toEncodedString(algo: 'b64'));

        self::assertEquals($ra->toString(), B64::decodeUrlSafe($hash));
    }

    #[Test]
    public function responseActionToEncodedStringB64Safe(): void
    {
        $ra   = new ResponseAction(StatusEnum::SUCCESS);
        $hash = 'eyJfcmVzcG9uc2VBY3Rpb24iOnsic3RhdHVzIjoic3VjY2VzcyJ9fQ~~';
        self::assertEquals($hash, $ra->toEncodedString());

        self::assertEquals($ra->toString(), B64::decodeUrlSafe($hash));
    }

    #[Test]
    public function responseActionToEncodedStringWithKey(): void
    {
        $ra   = new ResponseAction(StatusEnum::SUCCESS);
        $hash = 'eyJtZXRhIjp7InN0YXR1cyI6InN1Y2Nlc3MifX0~';
        self::assertEquals($hash, $ra->toEncodedString('meta'));

        self::assertEquals($ra->toString('meta'), B64::decodeUrlSafe($hash));
    }
}
