<?php
require_once 'db.php';

if (isset($_POST['submit'])) {
    // Basic Validation
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $contact_link = filter_var($_POST['contact_link'], FILTER_SANITIZE_URL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    // Handle Image Upload
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // Secure Image Validation
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        die("File is not an image.");
    }

    $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];
    $file_extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));

    if (!in_array($file_extension, $allowed_exts)) {
        die("Only JPG, JPEG, PNG, and GIF files are allowed.");
    }
    $new_filename = uniqid() . '.' . $file_extension;
    $target_file = $target_dir . $new_filename;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Generate Unique Slug
        $slug = bin2hex(random_bytes(5));

        // Generate Reference for Paystack
        $reference = bin2hex(random_bytes(8));

        // Insert into Database
        $stmt = $pdo->prepare("INSERT INTO landing_pages (email, title, description, image_path, contact_link, slug, reference) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$email, $title, $description, $target_file, $contact_link, $slug, $reference]);

        // Paystack Payment Integration
        $url = "https://api.paystack.co/transaction/initialize";
        $fields = [
            'email' => $email,
            'amount' => "500000", // Amount in kobo (5000 NGN = 500000 kobo)
            'reference' => $reference,
            'callback_url' => BASE_URL . "verify.php"
        ];

        $fields_string = http_build_query($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer " . PAYSTACK_SECRET_KEY,
            "Cache-Control: no-cache",
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        $response = json_decode($result, true);

        if ($response && $response['status']) {
            header("Location: " . $response['data']['authorization_url']);
            exit();
        } else {
            echo "Paystack Initialization Error: " . ($response['message'] ?? 'Unknown error');
        }
    } else {
        echo "Error uploading image.";
    }
}
?>
