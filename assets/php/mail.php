<?php
header("Access-Control-Allow-Origin: *");

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $first_name = strip_tags(trim($_POST["first_name"]));
		$first_name = str_replace(array("\r","\n"),array(" "," "),$first_name);
        $last_name = trim($_POST["last_name"]);
        $email = filter_var(trim($_POST["email_address"]), FILTER_SANITIZE_EMAIL);
        $phone = trim($_POST["phone_no"]);
        $birthdate = trim($_POST["birthdate"]);
        $school = trim($_POST["school"]);
        $studies = trim($_POST["studies"]);
        $year = trim($_POST["year"]);
        $partner_first_name = trim($_POST["partner_first_name"]);
        $partner_last_name = trim($_POST["partner_last_name"]);
        $linkedin_link = trim($_POST["linkedin_link"]);
        $message = trim($_POST["con_message"]);

        // Check that data was sent to the mailer.
        if ( empty($first_name) OR ( empty($last_name) OR empty($phone) OR empty($birthdate) OR empty($school) OR empty($studies) OR empty($year) OR empty($partner_first_name) OR empty($partner_last_name)    OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Please complete the form and try again.";
            exit;
        }

        // Set the recipient email address.
        $recipient = "register@hecliegebusinessgame.com";

        // Set the email subject.
        $subject = "Business Game - Mail From $first_name";

        // Build the email content.
        $email_content = "Name: $first_name + $last_name\n";
        $email_content .= "Phone: $phone\n\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Birthdate: $birthdate\n\n";
        $email_content .= "School: $school\n\n";
        $email_content .= "Studies: $studies\n\n";
        $email_content .= "Year: $year\n\n";
        $email_content .= "Partner's first name: $partner_first_name\n\n";
        $email_content .= "Partner's last name: $partner_last_name\n\n";
        $email_content .= "LinkedIn Profile: $linkedin_link\n\n";
        $email_content .= "Comment:\n$message\n";

        // Build the email headers.
        $email_headers = "From: $first_name <$email>";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Thank You! Your registration has been sent successfully.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your registration, please try again";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>
