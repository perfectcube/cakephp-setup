<?php
/**
 * Controller bake template file
 *
 * Allows templating of Controllers generated from bake.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         CakePHP(tm) v 1.3
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

echo "<?php\n";
echo "App::uses('{$plugin}AppController', '{$pluginPath}Controller');\n\n";
?>
/**
 * <?php echo $controllerName; ?> Controller
 *
<?php
if (false && !$isScaffold) {
	$defaultModel = Inflector::singularize($controllerName);
	echo " * @property {$defaultModel} \${$defaultModel}\n";
	if (!empty($components)) {
		foreach ($components as $component) {
			echo " * @property {$component}Component \${$component}\n";
		}
	}
}
?>
 */
class <?php echo $controllerName; ?>Controller extends <?php echo $plugin; ?>AppController {

<?php if ($isScaffold): ?>
	/**
	 * Scaffold
	 *
	 * @var mixed
	 */
	public $scaffold;
<?php else: ?>
<?php
if (count($helpers)):
	echo "\tpublic \$helpers = array(";
	for ($i = 0, $len = count($helpers); $i < $len; $i++):
		if ($i != $len - 1):
			echo "'" . Inflector::camelize($helpers[$i]) . "', ";
		else:
			echo "'" . Inflector::camelize($helpers[$i]) . "'";
		endif;
	endfor;
	echo ");\n";
endif;

// Remove paginator again for now.
if (in_array('Paginator', $components)) {
	$key = array_keys($components);
	$key = array_shift($key);
	unset($components[$key]);
	$comps = $components;
	$components = [];
	foreach ($comps as $comp) {
		$components[] = $comp;
	}
}

if (count($components) && $components !== ['Session']):
	echo "\tpublic \$components = array(";
	for ($i = 0, $len = count($components); $i < $len; $i++):
		if ($i != $len - 1):
			echo "'" . Inflector::camelize($components[$i]) . "', ";
		else:
			echo "'" . Inflector::camelize($components[$i]) . "'";
		endif;
	endfor;
	echo ");\n\n";
endif;

if (isset($orderBy) && count($orderBy) > 0) {
	echo "\tpublic \$paginate = array('order' => array(";
	echo "\n\t";

	foreach ($orderBy as $order => $mode) {
		echo "\t";
		var_export($order);
		echo ' => ';
		var_export($mode);
		echo ",\n\t";
	}
	echo "));\n\n";

} else {
	echo "\tpublic \$paginate = array();\n\n";
}

echo "\tpublic function beforeFilter() {\n";
echo "\t\tparent::beforeFilter();\n";
echo "\t}\n\n\t";


echo trim($actions) . "\n";

endif; ?>

}
