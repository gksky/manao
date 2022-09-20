<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle; ?></title>
  <link rel="stylesheet" href="/src/css/styles.css">
</head>
<body>
  <noscript>
    <h2>Javascript is disabled in your web browser. Some features will not work.</h2>
  </noscript>
  <header>
    <ul class="header nav">
      <li class="nav item"><a href="/">Home</a></li>
      <li class="nav item"><a href="/register.php">Registration</a></li>
      <li class="nav item"><a href="/login.php">Login</a></li>
      <?php if ($user): ?><li class="nav item"><a href="/logout.php">Logout</a></li><?php endif; ?>
    </ul>
  </header>
  <?php if ($user): ?>
    <h2>
      <?php echo "Hello, {$user->getName()}!"; ?>
    </h2>
  <?php endif; ?>