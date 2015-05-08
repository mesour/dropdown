<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="../docs/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="../docs/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="../docs/js/jquery.min.js"></script>
<script src="../docs/js/bootstrap.min.js"></script>
<script src="../docs/js/main.js"></script>

<?php

define('SRC_DIR', __DIR__ . '/../src/');

require_once __DIR__ . '/../vendor/autoload.php';

\Tracy\Debugger::enable(\Tracy\Debugger::DEVELOPMENT, __DIR__ . '/log');

require_once SRC_DIR . 'DropDown.php';
require_once SRC_DIR . 'DropDown/MainButton.php';
require_once SRC_DIR . 'DropDown/Item.php';

\Mesour\UI\Control::$default_link = new \Mesour\Components\Link\Link();

?>

<hr>

<div class="container">
    <h2>Basic functionality</h2>

    <div class="jumbotron">
        <?php

        $dropDown = new \Mesour\UI\DropDown;

        $dropDown->addHeader('Test header');

        $first = $dropDown->addButton();

        $first->setText('First button')
            ->setAttribute('href', $dropDown->link('/first/'));

        $dropDown->addDivider();

        $dropDown->addHeader('Test header 2');

        $dropDown->addButton()
            ->setText('Second button')
            ->setConfirm('Test confirm :-)')
            ->setAttribute('href', $dropDown->link('/second/'));

        $dropDown->addButton()
            ->setText('Third button')
            ->setAttribute('href', $dropDown->link('/third/'));

        $mainButton = $dropDown->getMainButton();

        $mainButton->setText('Actions')
            ->setType('danger');

        $dropDown->render();

        ?>
    </div>
</div>

<hr>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>