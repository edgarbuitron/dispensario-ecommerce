<?php

namespace Tests\Unit;

use App\Services\TotpService;
use PHPUnit\Framework\TestCase;

class TotpServiceTest extends TestCase
{
    /**
     * Vector de prueba oficial de RFC 6238 (Apéndice B), adaptado a 6 dígitos:
     * secreto ASCII "12345678901234567890", en T=59s el HMAC-SHA1 truncado
     * de 8 dígitos es 94287082 → los últimos 6 dígitos son 287082.
     */
    public function test_matches_rfc6238_official_test_vector(): void
    {
        $totp = new TotpService();

        $reflection = new \ReflectionClass($totp);
        $encodeMethod = $reflection->getMethod('base32Encode');
        $secret = $encodeMethod->invoke($totp, '12345678901234567890');

        $code = $totp->generateCode($secret, intdiv(59, 30));

        $this->assertSame('287082', $code);
    }

    public function test_generated_secret_round_trips_through_verify(): void
    {
        $totp = new TotpService();
        $secret = $totp->generateSecret();
        $timestamp = 1700000000;

        $code = $totp->generateCode($secret, intdiv($timestamp, 30));

        $this->assertTrue($totp->verify($secret, $code, $timestamp));
        $this->assertFalse($totp->verify($secret, '000000', $timestamp));
    }

    public function test_tolerates_one_time_step_of_clock_drift(): void
    {
        $totp = new TotpService();
        $secret = $totp->generateSecret();
        $timestamp = 1700000000;

        $code = $totp->generateCode($secret, intdiv($timestamp, 30));

        $this->assertTrue($totp->verify($secret, $code, $timestamp + 30));
        $this->assertFalse($totp->verify($secret, $code, $timestamp + 90));
    }

    public function test_otp_auth_url_contains_expected_parameters(): void
    {
        $totp = new TotpService();
        $url = $totp->getOtpAuthUrl('ABCDEFGH', 'cesar', 'Dispensario Admin');

        $this->assertStringStartsWith('otpauth://totp/', $url);
        $this->assertStringContainsString('secret=ABCDEFGH', $url);
        $this->assertStringContainsString('digits=6', $url);
        $this->assertStringContainsString('period=30', $url);
    }
}
