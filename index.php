<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your Landing Page</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Create Your Landing Page</h1>
        <p>Instantly generate a high-converting landing page for your ads.</p>
        <form action="create.php" method="POST" enctype="multipart/form-data">
            <div>
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="title">Landing Page Title:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div>
                <label for="description">Product/Service Description:</label>
                <textarea id="description" name="description" rows="5" required></textarea>
            </div>
            <div>
                <label for="image">Featured Image:</label>
                <input type="file" id="image" name="image" accept="image/*" required>
            </div>
            <div>
                <label for="contact_link">WhatsApp or Telegram Link:</label>
                <input type="text" id="contact_link" name="contact_link" placeholder="https://wa.me/yournumber" required>
            </div>
            <button type="submit" name="submit">Create & Pay</button>
        </form>
    </div>
</body>
</html>
