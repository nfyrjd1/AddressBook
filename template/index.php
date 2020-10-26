<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Адресная книга</title>
    <link rel="shortcut icon" href="template/images/favicon.ico" type="image/x-icon">
    <link href="template/css/style.css" rel="stylesheet">
    <script type="text/javascript" src="template/js/jquery.js"></script>
    <script src="template/js/script.js"></script>
</head>

<body>
    <header>
        <h1 class="page-title">
            <a href="index.php?view=list">Адресная книга</a>
        </h1>
    </header>

    <main class="container">
        <?php 
            echo $data;
        ?>
    </main>

    <?php include_once 'src/contact/view/ContactModalView.php'; ?>
</body>

</html>