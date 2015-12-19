<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="resources/css/bootstrap.min.css">


<!-- Latest compiled and minified JavaScript -->
<script src="resources/js/jquery.min.js"></script>
<script src="resources/js/bootstrap.min.js"></script>

<?php

define('SRC_DIR', __DIR__ . '/../src/');

require_once __DIR__ . '/../vendor/autoload.php';

@mkdir(__DIR__ . '/log');

\Tracy\Debugger::enable(\Tracy\Debugger::DEVELOPMENT, __DIR__ . '/log');

require_once SRC_DIR . 'Mesour/UI/DropDown.php';
require_once SRC_DIR . 'Mesour/DropDown/MainButton.php';
require_once SRC_DIR . 'Mesour/DropDown/Item.php';

?>

<hr>

<div class="container">
    <h2>Demo</h2>

    <div class="jumbotron">
        <?php

        $container = new \Mesour\UI\Control;

        $auth = $container->getAuthorizator();

        $auth->addRole('guest');
        $auth->addRole('registered', 'guest');

        $auth->addResource('menu');

        $auth->allow('guest', 'menu', ['first', 'second']);
        $auth->allow('registered', 'menu');
        $auth->deny('registered', 'menu', 'second');

        $userRole = 'registered';

        $dropDown = new \Mesour\UI\DropDown('testDropDown', $container);

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

        $dropDown->addDivider();

        $dropDown->addHeader('Test header 3');

        $dropDown->addButton()
            ->setText('Fourth button')
            ->setAttribute('href', $dropDown->link('/third/'));

        $dropDown->addButton()
            ->setText('Fifth button')
            ->setConfirm('Test confirm :-)')
            ->setAttribute('href', $dropDown->link('/second/'));

        $dropDown->addButton()
            ->setText('Sixth button')
            ->setAttribute('href', $dropDown->link('/third/'));

        $mainButton = $dropDown->getMainButton();

        $mainButton->setText('Actions (enabled all)')
            ->setType('danger');

        echo $dropDown->render();

        echo '<br><hr><br>';

        $dropDown = new \Mesour\UI\DropDown('testDropDown0', $container);

        $dropDown->addHeader('Test header');

        $first = $dropDown->addButton();

        $first->setText('First button')
            ->setPermission($userRole, 'menu', 'second')
            ->setAttribute('href', $dropDown->link('/first/'));

        $dropDown->addDivider();

        $dropDown->addHeader('Test header 2');

        $dropDown->addButton()
            ->setText('Second button')
            ->setConfirm('Test confirm :-)')
            ->setAttribute('href', $dropDown->link('/second/'));

        $dropDown->addButton()
            ->setText('Third button')
            ->setPermission($userRole, 'menu', 'second')
            ->setAttribute('href', $dropDown->link('/third/'));

        $dropDown->addDivider();

        $dropDown->addHeader('Test header 3');

        $dropDown->addButton()
            ->setText('Fourth button')
            ->setAttribute('href', $dropDown->link('/third/'));

        $dropDown->addButton()
            ->setText('Fifth button')
            ->setConfirm('Test confirm :-)')
            ->setAttribute('href', $dropDown->link('/second/'));

        $dropDown->addButton()
            ->setText('Sixth button')
            ->setPermission($userRole, 'menu', 'second')
            ->setAttribute('href', $dropDown->link('/third/'));

        $mainButton = $dropDown->getMainButton();

        $mainButton->setText('Actions (enabled some)')
            ->setType('danger');

        echo $dropDown->render();

        echo '<br><hr><br>';

        $dropDown = new \Mesour\UI\DropDown('testDropDown2', $container);

        $dropDown->addHeader('Test header');

        $first = $dropDown->addButton();

        $first->setText('First button')
            ->setPermission($userRole, 'menu', 'second')
            ->setAttribute('href', $dropDown->link('/first/'));

        $mainButton = $dropDown->getMainButton();

        $mainButton->setText('Disabled (no link to use because haven\'t permissions)')
            ->setType('primary');

        echo $dropDown->render();

        echo '<br><hr><br>';

        $dropDown = new \Mesour\UI\DropDown('testDropDown3', $container);

        $dropDown->setDisabled();

        $dropDown->addHeader('Test header');

        $first = $dropDown->addButton();

        $first->setText('First button')
            ->setAttribute('href', $dropDown->link('/first/'));

        $mainButton = $dropDown->getMainButton();

        $mainButton->setText('Disabled by default')
            ->setType('warning');

        echo $dropDown->render();

        ?>
    </div>
</div>

<hr>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>