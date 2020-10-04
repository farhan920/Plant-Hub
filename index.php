<?php
    date_default_timezone_set('America/New_York');
    require_once('db.php');
    require_once('controller.php');
    if (isset($db)) {
        $controller = new Controller($db);
    } else {
        echo 'missing db';
        die();
    }
    $data = $controller->getData()['result'];
    $history = $controller->getHistoricalData(10)['result'];
    $avg = $controller->getAverageData(10)['result'];
 ?>
<html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    </head>
    <body>
        <nav>
            <div class="nav-wrapper">
                <a href="#" class="brand-logo">Plant Hub</a>
            </div>
        </nav>
        <br />
        <div class="container">
            <div class="row">
                <div class="col s12 m6">
                    <div class="card blue-grey darken-1">
                        <div class="card-content white-text">
                            <span class="card-title activator">Parts per Million<i class="material-icons right">more_vert</i></span>
                            <p>Last Reading: <?php echo $data['ppm']; ?></p>
                            <p>Avg. PPM: <?php echo $avg['ppm']; ?></p>
                            <p><i>Average over 10 minutes.</i></p>
                        </div><div class="card-reveal">
                            <span class="card-title grey-text text-darken-4">History<i class="material-icons right">close</i></span>
                            <?php
                                foreach ($history as &$item) {
                                    echo '<p><span class="new badge" data-badge-caption="">' . gmdate('h:m A', $item['timestamp']) . '</span>' . $item['ppm'] . '</p>';
                                }
                            ?>
                        </div>
                    </div>
                </div><div class="col s12 m6">
                    <div class="card blue-grey darken-1">
                        <div class="card-content white-text">
                            <span class="card-title activator">Water pH<i class="material-icons right">more_vert</i></span>
                            <p>Last pH: <?php echo $data['waterph']; ?></p>
                            <p>Avg. pH: <?php echo $avg['waterph']; ?></p>
                            <p><i>Average over 10 minutes.</i></p>
                        </div><div class="card-reveal">
                            <span class="card-title grey-text text-darken-4">History<i class="material-icons right">close</i></span>
                            <?php
                                foreach ($history as &$item) {
                                    echo '<p><span class="new badge" data-badge-caption="">' . gmdate('h:m A', $item['timestamp']) . '</span>' . $item['waterph'] . '</p>';
                                }
                            ?>
                        </div>
                    </div>
                </div><div class="col s12 m6">
                    <div class="card blue-grey darken-1">
                        <div class="card-content white-text">
                            <span class="card-title activator">Water Temperature<i class="material-icons right">more_vert</i></span>
                            <p>Last Temperature: <?php echo $data['watertemp']; ?> &deg;C</p>
                            <p>Avg. Temperature: <?php echo $avg['watertemp']; ?> &deg;C</p>
                            <p><i>Average over 10 minutes.</i></p>
                        </div><div class="card-reveal">
                            <span class="card-title grey-text text-darken-4">History<i class="material-icons right">close</i></span>
                            <?php
                                foreach ($history as &$item) {
                                    echo '<p><span class="new badge" data-badge-caption="">' . gmdate('h:m A', $item['timestamp']) . '</span>' . $item['watertemp'] . '</p>';
                                }
                            ?>
                        </div>
                    </div>
                </div><div class="col s12 m6">
                    <div class="card blue-grey darken-1">
                        <div class="card-content white-text">
                            <span class="card-title activator">Air Temperatures<i class="material-icons right">more_vert</i></span>
                            <p>Last temperature: <?php echo $data['airtemp']; ?> &deg;C</p>
                            <p>Avg. temperature: <?php echo $avg ['airtemp']; ?> &deg;C</p>
                            <p><i>Average over 10 minutes.</i></p>
                        </div><div class="card-reveal">
                            <span class="card-title grey-text text-darken-4">History<i class="material-icons right">close</i></span>
                            <?php
                            foreach ($history as &$item) {
                                echo '<p><span class="new badge" data-badge-caption="">' . gmdate('h:m A', $item['timestamp']) . '</span>' . $item['airtemp'] . '</p>';
                            }
                            ?>
                        </div>
                    </div>
                </div><div class="col s12 m6">
                    <div class="card blue-grey darken-1">
                        <div class="card-content white-text">
                            <span class="card-title">Settings</span>
                        </div>
                        <div class="card-action">
                            <a href="#">Change Settings</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>