<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
	  integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<?php

define('SRC_DIR', __DIR__ . '/../src/');

require_once __DIR__ . '/../vendor/autoload.php';

@mkdir(__DIR__ . '/tmp');
@mkdir(__DIR__ . '/log');

\Tracy\Debugger::enable(\Tracy\Debugger::DEVELOPMENT, __DIR__ . '/log');

$loader = new Nette\Loaders\RobotLoader;
$loader->addDirectory(__DIR__ . '/../src');
$loader->setCacheStorage(new Nette\Caching\Storages\FileStorage(__DIR__ . '/tmp'));
$loader->register();

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

		$container->setUserRole('registered');

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
			->setType('danger')
			->setIcon();

		echo $dropDown->render();

		echo '<br><hr><br>';

		$dropDown = new \Mesour\UI\DropDown('testDropDown0', $container);

		$dropDown->addHeader('Test header');

		$first = $dropDown->addButton();

		$first->setText('First button')
			->setPermission('menu', 'second')
			->setAttribute('href', $dropDown->link('/first/'));

		$dropDown->addDivider();

		$dropDown->addHeader('Test header 2');

		$dropDown->addButton()
			->setText('Second button')
			->setConfirm('Test confirm :-)')
			->setAttribute('href', $dropDown->link('/second/'));

		$dropDown->addButton()
			->setText('Third button')
			->setPermission('menu', 'second')
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
			->setPermission('menu', 'second')
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
			->setPermission('menu', 'second')
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

		echo '<br><hr><br>';

		$dropDown = new \Mesour\UI\DropDown('testDropDown4', $container);

		$dropDown->getControlPrototype()
			->style('float:right;');

		$dropDown->setPullRight();

		$dropDown->addHeader('Test header');

		$first = $dropDown->addButton();

		$first->setText('First button')
			->setAttribute('href', $dropDown->link('/first/'));

		$mainButton = $dropDown->getMainButton();

		$mainButton->setText('Pull right')
			->setType('warning');

		echo $dropDown->render();

		echo '<br style="clear: both;">';

		?>
	</div>
</div>

<hr>

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<!-- Latest compiled and minified JavaScript -->
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
		integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
		crossorigin="anonymous"></script>