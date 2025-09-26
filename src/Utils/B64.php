<?php

declare(strict_types=1);

namespace ResponseActions\Utils;

final class B64
{
    /**
     * Tail characters of the standard Base64 alphabet.
     */
    private const string STANDARD_ALPHABET_SUFFIX = '+/=';

    /**
     * Tail characters of the URL-safe Base64 alphabet.
     * Note: padding is replaced with '~' to avoid '=' in URLs.
     */
    private const string URL_SAFE_ALPHABET_SUFFIX = '-_~';

    /**
     * Encodes the supplied data to Base64 (standard alphabet).
     */
    public static function encode(string $data): string
    {
        return \base64_encode($data);
    }

    /**
     * Decodes the supplied data from Base64 (standard alphabet).
     *
     * @return string|null Returns null if decoding fails (including strict mode failures).
     */
    public static function decode(string $data, bool $strict = false): ?string
    {
        return ($str = \base64_decode($data, $strict)) !== false ? $str : null;
    }

    /**
     * Encodes the supplied data to a URL-safe variant of Base64.
     */
    public static function encodeUrlSafe(string $data): string
    {
        $encoded = self::encode($data);
        return self::mapStandardToUrlSafe($encoded);
    }

    /**
     * Decodes the supplied data from a URL-safe variant of Base64.
     *
     * @return string|null Returns null if decoding fails.
     */
    public static function decodeUrlSafe(string $data): ?string
    {
        $standard = self::mapUrlSafeToStandard($data);
        return self::decode($standard);
    }

    /**
     * Backward-compatible aliases (kept for existing usage/tests).
     * @deprecated
     */
    public static function encodeSafe(string $data): string
    {
        return self::encodeUrlSafe($data);
    }

    /**
     * Backward-compatible aliases (kept for existing usage/tests).
     * @deprecated
     */
    public static function decodeSafe(string $data): ?string
    {
        return self::decodeUrlSafe($data);
    }

    /**
     * Maps standard Base64 alphabet to URL-safe variant.
     */
    private static function mapStandardToUrlSafe(string $data): string
    {
        return \strtr(
            $data,
            self::STANDARD_ALPHABET_SUFFIX,
            self::URL_SAFE_ALPHABET_SUFFIX
        );
    }

    /**
     * Maps URL-safe Base64 alphabet back to standard.
     */
    private static function mapUrlSafeToStandard(string $data): string
    {
        return \strtr(
            $data,
            self::URL_SAFE_ALPHABET_SUFFIX,
            self::STANDARD_ALPHABET_SUFFIX
        );
    }
}
