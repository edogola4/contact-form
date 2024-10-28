<?php

use PHPUnit\Framework\TestCase;

class ContactFormTest extends TestCase
{
    protected function submitForm($name, $email, $phone, $message)
    {
        // Simulate form submission by sending POST request
        $_POST['name'] = $name;
        $_POST['email'] = $email;
        $_POST['phone'] = $phone;
        $_POST['message'] = $message;
        $_SERVER['REQUEST_METHOD'] = 'POST';
        ob_start();
        include 'contact.php';
        $output = ob_get_clean();
        return $output;
    }

    public function testValidSubmission()
    {
        $output = $this->submitForm('John Doe', 'johndoe@example.com', '1234567890', 'This is a test message.');
        $this->assertStringContainsString('Thank you, John Doe! Your message has been sent.', $output);
    }

    public function testMissingName()
    {
        $output = $this->submitForm('', 'johndoe@example.com', '1234567890', 'This is a test message.');
        $this->assertStringContainsString('Please enter your name.', $output);
    }

    public function testInvalidEmail()
    {
        $output = $this->submitForm('John Doe', 'invalid-email', '1234567890', 'This is a test message.');
        $this->assertStringContainsString('Please enter a valid email address.', $output);
    }

    public function testMissingMessage()
    {
        // $output = $->submitForm('John Doe', 'johndoe@example.com', '1234567890', '');

        $this->assertStringContainsString('Please enter your message.', $output);
    }

    public function testMissingEmail()
    {
        $output = $this->submitForm('John Doe', '', '1234567890', 'This is a test message.');
        $this->assertStringContainsString('Please enter your email.', $output);
    }
}
