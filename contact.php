<?php require 'includes/app.php';
$error = '';
$sent = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check();
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    if (!empty($_POST['website'])) $error = 'Submission rejected.';
    elseif (strlen($name) < 2 || strlen($name) > 150 || strlen($email) > 254 || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($message) < 10 || strlen($message) > 10000) $error = 'Enter your name, a valid email, and a message between 10 and 10,000 characters.';
    elseif (time() - ($_SESSION['last_message'] ?? 0) < 60) $error = 'Please wait one minute before sending another message.';
    else {
        $q = db()->prepare('INSERT INTO messages(name,email,message) VALUES(?,?,?)');
        $q->execute([$name, $email, $message]);
        $_SESSION['last_message'] = time();
        $_SESSION['sent'] = true;
        header('Location: contact.php');
        exit;
    }
}
$sent = !empty($_SESSION['sent']);
unset($_SESSION['sent']);
$title = 'Contact';
require 'includes/header.php'; ?><section class="section">
    <div class="container">
        <h1>Contact us</h1>
        <p><?= e($s['address']) ?></p><?php if ($s['phone']): ?><p>Phone: <?= e($s['phone']) ?></p><?php endif; ?><?php if ($s['email']): ?><p>Email: <?= e($s['email']) ?></p><?php endif; ?><?php if ($sent): ?><p class="notice" role="status">Your enquiry has been received.</p><?php endif; ?><?php if ($error): ?><p class="notice" role="alert"><?= e($error) ?></p><?php endif; ?><form method="post"><?= token() ?><label for="name">Name</label><input id="name" name="name" maxlength="150" required value="<?= e($_POST['name'] ?? '') ?>"><label for="email">Email</label><input id="email" name="email" type="email" maxlength="254" required value="<?= e($_POST['email'] ?? '') ?>"><label for="message">Message</label><textarea id="message" name="message" minlength="10" maxlength="10000" required><?= e($_POST['message'] ?? '') ?></textarea>
            <div class="honeypot" aria-hidden="true"><label>Website<input name="website" tabindex="-1" autocomplete="off"></label></div>
            <p>Your name, email and message are stored so the company can respond to your enquiry. Do not submit sensitive information.</p><button class="btn-company" type="submit">Send enquiry</button>
        </form>
    </div>
</section><?php require 'includes/footer.php'; ?>