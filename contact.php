<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize an empty array to store errors
    $errors = array();

    // Collect form data and sanitize it
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate name
    if (empty($name)) {
        $errors[] = "Please enter your name.";
    }

    // Validate email
    if (empty($email)) {
        $errors[] = "Please enter your email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    // Validate phone
    if (empty($phone)) {
        $errors[] = "Please enter your phone number.";
    }elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $errors[] = "Please enter a valid 10-digit phone number.";
    }

    // Validate message
    if (empty($message)) {
        $errors[] = "Please enter your message.";
    }elseif (strlen($message) < 10) {
        $errors[] = "Your message must be at least 10 characters long.";
    }

    // If no errors, process the form and send the email
    if (empty($errors)) {
        // Email settings
        $to = "brandon14ogola@gmail.com";  // Replace with your email address
        $subject = "New Contact Form Submission from $name";
        $body = "You have received a new message from your website contact form.\n\n";
        $body .= "Here are the details:\n";
        $body .= "Name: $name\n";
        $body .= "Email: $email\n";
        $body .= "Phone: $phone\n";
        $body .= "Message:\n$message\n";

        // Additional headers
        $headers = "From: $email" . "\r\n" .
                   "Reply-To: $email" . "\r\n" .
                   "X-Mailer: PHP/" . phpversion();

        // Send the email
        if (mail($to, $subject, $body, $headers)) {
            echo "<h2>Thank you, $name! Your message has been sent.</h2>";
        } else {
            echo "<h2>Sorry, there was a problem sending your message. Please try again later.</h2>";
        }
    } else {
        // Display errors
        echo "<h2>Oops! There were some issues with your submission:</h2>";
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
} else {
    // Redirect to the contact page if accessed directly
    header("Location: /index.html");
    exit();
}
?>

