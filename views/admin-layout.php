<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevWebCamp - <?php echo $titulo ?? ''; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/e4ca601ead.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/build/css/app.css">

</head>

<body class="dashboard">
    <?php
    include_once __DIR__ . '/templates/admin-header.php';
    ?>
    <div class="dashboard__grid">
        <?php
        include_once __DIR__ . '/templates/admin-sidebar.php';
        ?>

        <main class="dashboard__contenido">
            <?php
            echo $contenido ?? '';
            ?>
        </main>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.5.0/chart.min.js" integrity="sha512-n/G+dROKbKL3GVngGWmWfwK0yPctjZQM752diVYnXZtD/48agpUKLIn0xDQL9ydZ91x6BiOmTIFwWjjFi2kEFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="/build/js/main.min.js" defer></script>
</body>

</html>