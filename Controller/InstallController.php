<?php
App::uses('SetupAppController', 'Setup.Controller');
App::uses('Install', 'Model');

/**
 * Auto-Installer
 */
class InstallController extends SetupAppController {

	public $uses = ['Install'];

	public function beforeFilter() {
		parent::beforeFilter();

		if (isset($this->Auth)) {
			$this->Auth->allow();
		}

		if (!Configure::read('debug')) {
			throw new MethodNotAllowedException('Debug Mode needs to be enabled for this');
		}
	}

	public function index() {
	}

	/**
	 * Sql tables
	 */
	public function step1() {
		if ($this->Common->isPosted()) {
			$this->Install = @ClassRegistry::init('Install');
			if ($this->Install->createDatabaseFile($this->request->data)) {
				$this->Flash->message('database.php created', 'success');
				return $this->Common->postRedirect(['action' => 'step2']);
			}

		} else {
			$this->request->data['Install'] = [
				'datasource' => 'Database/Mysql',
				'host' => 'localhost',
				'login' => 'root',
				'database' => 'cake',
				'prefix' => 'app_',
				'encoding' => 'utf8',
				'enhanced_database_class' => true,
				'name' => 'default',
				'environment' => HTTP_HOST,
				'path' => [],
			];
		}
	}

	/**
	 * ?
	 */
	public function step2() {
	}

}
