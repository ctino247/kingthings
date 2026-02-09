<?php
require_once 'db.php';

$reference = $_GET['reference'] ?? '';

if (!$reference) {
    die("No reference supplied");
}

$url = "https://api.paystack.co/transaction/verify/" . rawurlencode($reference);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer " . PAYSTACK_SECRET_KEY,
    "Cache-Control: no-cache",
]);

$result = curl_exec($ch);
$response = json_decode($result, true);

if ($response && $response['status'] && $response['data']['status'] === 'success') {
    // Payment successful
    $stmt = $pdo->prepare("UPDATE landing_pages SET payment_status = 'paid' WHERE reference = ?");
    $stmt->execute([$reference]);

    // Fetch the slug to display the link
    $stmt = $pdo->prepare("SELECT slug, email, title FROM landing_pages WHERE reference = ?");
    $stmt->execute([$reference]);
    $page = $stmt->fetch();

    if ($page) {
        $slug = $page['slug'];
        $landing_page_url = BASE_URL . "page/" . $slug;

        // Automated Email Delivery
        $to = $page['email'];
        $subject = "Your Landing Page is Ready: " . $page['title'];
        $message = "Hello,\n\nYour landing page has been successfully created and activated.\n\n";
        $message .= "You can access it here: $landing_page_url\n\n";
        $message .= "Thank you for using our service!";
        $headers = "From: " . FROM_NAME . " <" . FROM_EMAIL . ">";

        mail($to, $subject, $message, $headers);

        echo "<h1>Payment Successful!</h1>";
        echo "<p>Your landing page is now active. A confirmation email has been sent to " . htmlspecialchars($to) . ".</p>";
        echo "<p>Your Link: <a href='$landing_page_url'>$landing_page_url</a></p>";
    }
} else {
    echo "<h1>Payment Verification Failed</h1>";
    echo "<p>" . ($response['message'] ?? 'Please contact support.') . "</p>";
}
?>
