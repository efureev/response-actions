<?php

namespace ResponseActions\Tests\Actions;

use PHPUnit\Framework\TestCase;
use ResponseActions\Actions\Redirect;

class RedirectTest extends TestCase
{
    /**
     * Test that toActionArray returns correct values for native redirect
     */
    public function testToActionArrayWithNativeRedirect(): void
    {
        $url = 'https://example.com';
        $target = Redirect::TARGET_SELF;
        $code = 301;
        $type = Redirect::TYPE_NATIVE;

        $redirect = new Redirect($url, $target, $code, $type);
        $expectedArray = [
            'url'    => $url,
            'target' => $target,
            'type'   => $type,
            'code'   => $code,
        ];

        $this->assertSame($expectedArray, $this->invokeToActionArray($redirect));

        $this->assertEquals('redirect', (string)$redirect);
    }

    /**
     * Test the constructor with all arguments provided
     */
    public function testConstructorWithAllArguments(): void
    {
        $url = 'https://example.org';
        $target = Redirect::TARGET_PARENT;
        $code = 307;
        $type = Redirect::TYPE_ROUTER;

        $redirect = new Redirect($url, $target, $code, $type);

        $this->assertSame($url, $redirect->toArray()['url']);
        $this->assertSame($target, $redirect->toArray()['target']);
        $this->assertSame($code, $redirect->toArray()['code']);
        $this->assertSame($type, $redirect->toArray()['type']);
    }

    /**
     * Test the constructor with default values
     */
    public function testConstructorWithDefaultValues(): void
    {
        $url = 'https://default.org';

        $redirect = new Redirect($url);

        $this->assertSame($url, $redirect->toArray()['url']);
        $this->assertSame(Redirect::TARGET_BLANK, $redirect->toArray()['target']);
        $this->assertSame(302, $redirect->toArray()['code']);
        $this->assertSame(Redirect::TYPE_NATIVE, $redirect->toArray()['type']);
    }

    /**
     * Test the constructor when only the target is set
     */
    public function testConstructorWithCustomTarget(): void
    {
        $url = 'https://example.com';
        $target = Redirect::TARGET_SELF;

        $redirect = new Redirect($url, $target);

        $this->assertSame($url, $redirect->toArray()['url']);
        $this->assertSame($target, $redirect->toArray()['target']);
        $this->assertSame(302, $redirect->toArray()['code']);
        $this->assertSame(Redirect::TYPE_NATIVE, $redirect->toArray()['type']);
    }

    /**
     * Test the constructor when custom code is set
     */
    public function testConstructorWithCustomCode(): void
    {
        $url = 'https://example.com';
        $code = 307;

        $redirect = new Redirect($url, Redirect::TARGET_BLANK, $code);

        $this->assertSame($url, $redirect->toArray()['url']);
        $this->assertSame(Redirect::TARGET_BLANK, $redirect->toArray()['target']);
        $this->assertSame($code, $redirect->toArray()['code']);
        $this->assertSame(Redirect::TYPE_NATIVE, $redirect->toArray()['type']);
    }


    /**
     * Test the constructor with all arguments
     */
    public function testConstructorWithCustomArguments(): void
    {
        $url = 'https://example.net';
        $target = Redirect::TARGET_PARENT;
        $code = 301;
        $type = Redirect::TYPE_ROUTER;

        $redirect = new Redirect($url, $target, $code, $type);

        $this->assertSame($url, $redirect->toArray()['url']);
        $this->assertSame($target, $redirect->toArray()['target']);
        $this->assertSame($code, $redirect->toArray()['code']);
        $this->assertSame($type, $redirect->toArray()['type']);
    }

    /**
     * Test that toActionArray returns default values when only URL is provided
     */
    public function testToActionArrayWithDefaultValues(): void
    {
        $url = 'https://default.com';

        $redirect = new Redirect($url);
        $expectedArray = [
            'url'    => $url,
            'target' => Redirect::TARGET_BLANK,
            'type'   => Redirect::TYPE_NATIVE,
            'code'   => 302,
        ];

        $this->assertSame($expectedArray, $this->invokeToActionArray($redirect));
    }

    /**
     * Test that native method creates a redirect with default values
     */
    public function testNativeMethodCreatesRedirectWithDefaultValues(): void
    {
        $url = 'https://example.com';

        $redirect = Redirect::native($url);
        $expectedArray = [
            'name' => 'redirect',
            'order' => 0,
            'url' => $url,
            'target' => Redirect::TARGET_BLANK,
            'type' => Redirect::TYPE_NATIVE,
            'code' => 302,
        ];

        $this->assertSame($expectedArray, $redirect->toArray());
    }

    /**
     * Test that native method creates a redirect with custom target and HTTP code
     */
    public function testNativeMethodCreatesRedirectWithCustomTargetAndCode(): void
    {
        $url = 'https://custom.com';
        $target = Redirect::TARGET_PARENT;
        $code = 307;

        $redirect = Redirect::native($url, $target, $code);
        $expectedArray = [
            'name' => 'redirect',
            'order' => 0,
            'url' => $url,
            'target' => $target,
            'type' => Redirect::TYPE_NATIVE,
            'code' => $code,
        ];

        $this->assertSame($expectedArray, $redirect->toArray());
    }

    /**
     * Test that toActionArray correctly handles router-type redirects
     */
    public function testToActionArrayWithRouterType(): void
    {
        $url = '/router-path';

        $redirect = Redirect::router($url);
        $expectedArray = [
            'url'    => $url,
            'target' => Redirect::TARGET_BLANK,
            'type'   => Redirect::TYPE_ROUTER,
            'code'   => 302,
        ];

        $this->assertSame($expectedArray, $this->invokeToActionArray($redirect));
    }

    /**
     * Helper method to invoke protected toActionArray method
     */
    private function invokeToActionArray(Redirect $redirect): array
    {
        $reflection = new \ReflectionClass($redirect);
        $method = $reflection->getMethod('toActionArray');
        $method->setAccessible(true);

        return $method->invoke($redirect);
    }

    /**
     * Test that withType correctly updates the type of the redirect
     */
    public function testWithTypeMethodChangesType(): void
    {
        $url = 'https://example.com';
        $redirect = new Redirect($url);

        $redirect->withType(Redirect::TYPE_ROUTER);

        $this->assertSame(Redirect::TYPE_ROUTER, $redirect->toArray()['type']);
    }

    /**
     * Test that withType does not change other properties of the redirect
     */
    public function testWithTypePreservesOtherValues(): void
    {
        $url = 'https://example.com';
        $target = Redirect::TARGET_PARENT;
        $code = 307;

        $redirect = new Redirect($url, $target, $code);
        $redirect->withType(Redirect::TYPE_ROUTER);

        $this->assertSame($url, $redirect->toArray()['url']);
        $this->assertSame($target, $redirect->toArray()['target']);
        $this->assertSame($code, $redirect->toArray()['code']);
    }
}