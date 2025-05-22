<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <script src="script.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Contact Us</h2>

        <?php
        // Display success or error messages
        if (isset($_GET['status'])) {
            if ($_GET['status'] == 'success') {
                echo '<div class="message success">Your message has been sent successfully!</div>';
            } elseif ($_GET['status'] == 'error') {
                echo '<div class="message error">Failed to send your message. Please try again later.</div>';
                if (isset($_GET['msg'])) {
                    // Optional: Display the specific error message from PHPMailer (good for debugging)
                    // echo '<div class="message error">Error: ' . htmlspecialchars($_GET['msg']) . '</div>';
                }
            }
        }
        ?>

        <form action="send_email.php" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject" required>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" required></textarea>
            </div>
            <button type="submit" class="button-submit">Send Message</button>
        </form>
    </div>
</body>
</html>