<?php

namespace App\Tests\Unit;

use App\Validator\NniValidator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class NniValidatorTest extends TestCase
{
    private NniValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new NniValidator();
    }

    public function testValidNniIsAccepted(): void
    {
        self::assertTrue($this->validator->validate('1234567890'));
    }

    public function testWhitespaceIsStrippedBeforeValidation(): void
    {
        self::assertTrue($this->validator->validate('1234 567 890'));
    }

    #[DataProvider('invalidNniProvider')]
    public function testInvalidNniIsRejected(string $candidate): void
    {
        self::assertFalse($this->validator->validate($candidate));
    }

    public function testNormaliseRemovesWhitespace(): void
    {
        self::assertSame('1234567890', $this->validator->normalise('12 34 56 78 90'));
    }

    public static function invalidNniProvider(): iterable
    {
        yield [''];
        yield ['123456789'];
        yield ['12345678901'];
        yield ['ABCDEFGHIJ'];
        yield ['12345A7890'];
    }
}

