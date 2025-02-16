<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-2xl p-6 bg-white rounded-lg shadow-md">
    <?php if($_SESSION['error']) { ?>
        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
            <span class="font-medium">Error!</span> <?php echo $_SESSION['error']; ?>
        </div>
    <?php } unset($_SESSION['error']) ?>

    <?php if($_SESSION['success']) { ?>
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            <span class="font-medium">Success!</span> <?php echo $_SESSION['success']; ?>
        </div>
    <?php } unset($_SESSION['success'])?>

    <?php if($_SESSION['errors']) { ?>
        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
            <ul>
                <?php foreach ($_SESSION['errors'] as $field => $messages) { ?>
                    <?php foreach ($messages as $message) { ?>
                        <li> <span class="font-medium"><?= ucwords($field) ?>:</span> <?= $message; ?>.</li>
                        <hr>
                    <?php } ?>
                <?php } ?>
            </ul>
        </div>
    <?php } unset($_SESSION['errors']) ?>
