<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ExampleTest extends TestCase
{
    #[Test]
    public function password_must_be_at_least_8_characters()
    {
        $password = 'Pa@1';
        $this->assertLessThan(8, strlen($password), "Password should be at least 8 characters");
    }

    #[Test]
    public function password_must_contain_a_number()
    {
        $password = 'Password!';
        $this->assertEquals(0, preg_match('/\d/', $password), "Password should contain at least one number");
    }

    #[Test]
    public function password_must_contain_a_special_character()
    {
        $password = 'Password1';
        $this->assertEquals(0, preg_match('/[^a-zA-Z0-9]/', $password), "Password should contain at least one special character");
    }

    #[Test]
    public function confirm_password_must_match_password()
    {
        $password = 'Pass@123';
        $confirmPassword = 'Pass@123';
        $this->assertEquals($password, $confirmPassword, "Confirm password should match password");
    }

    #[Test]
    public function email_must_be_valid()
    {
        $email = 'user@example.com';
        $this->assertTrue(filter_var($email, FILTER_VALIDATE_EMAIL) !== false, "Email format is invalid");
    }
}
