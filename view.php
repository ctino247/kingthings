<?php
require_once 'db.php';

$slug = $_GET['slug'] ?? '';

if (!$slug) {
    die("Page not found.");
}

$stmt = $pdo->prepare("SELECT * FROM landing_pages WHERE slug = ? AND payment_status = 'paid'");
$stmt->execute([$slug]);
$page = $stmt->fetch();

if (!$page) {
    die("Page not found or not yet activated.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page['title']); ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
    <style>
        .landing-container {
            text-align: center;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .hero-img {
            max-width: 100%;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .cta-btn {
            display: inline-block;
            background: #25D366;
            color: white;
            padding: 15px 30px;
            font-size: 1.2rem;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="landing-container">
        <h1><?php echo htmlspecialchars($page['title']); ?></h1>
        <img src="<?php echo BASE_URL . htmlspecialchars($page['image_path']); ?>" alt="Product Image" class="hero-img">
        <div class="description">
            <p><?php echo nl2br(htmlspecialchars($page['description'])); ?></p>
        </div>
        <a href="<?php echo htmlspecialchars($page['contact_link']); ?>" class="cta-btn">Get Started / Contact Us</a>
    </div>
</body>
</html>
