<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Relatório</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <link rel="stylesheet" href="css/style.css"/>

</head>

<body>
    <div class="menu">
        <?php require_once("menu.php"); ?>
    </div>

    <div class="container mt-5">
        <h1>Relatório</h1>
        <p>Este é um espaço para inserir o relatório.</p>

        <div class="form-group">
            <p id="report-text">Aqui será exibido o relatório gerado pelo sistema.</p>
        </div>

        <h2>Calendário</h2>
        <div id="calendar" class="mb-4"></div> <!-- Margem inferior para espaçamento -->

        <h2>Lista de Tarefas</h2>
        <ul class="list-group">
            <li class="list-group-item">Tarefa 1</li>
            <li class="list-group-item">Tarefa 2</li>
            <li class="list-group-item">Tarefa 3</li>
        </ul>
    </div>

    <a href="venda.php" id="fixed-button" class="btn btn-primary">V</a>

    <?php require_once("footer.php"); ?> <!-- Incluindo o footer -->

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#calendar').fullCalendar({
                defaultDate: moment().format('YYYY-MM-DD'), // Data atual
                editable: true,
                eventLimit: true // allow "more" link when too many events
            });
        });
    </script>
</body>

</html>
