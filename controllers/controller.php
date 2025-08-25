<?php

	use eftec\bladeone\BladeOne;

	class controller
	{
		private $blade;

		public function __construct()
		{
			$this->blade = new BladeOne(__DIR__.'/../views', __DIR__.'/../cache', BladeOne::MODE_AUTO);
		}

		public function index()
		{
			$title = 'Main Page';

			echo $this->blade->run('main', compact('title'));
		}

		public function loginIndex()
		{
			echo $this->blade->run('login');
		}

		public function loginHandle()
		{
			echo $this->blade->run('login');
		}

		public function signupIndex()
		{
			echo $this->blade->run('signup');
		}
		public function signupHandle()
		{
			echo $this->blade->run('signup');
		}
	}
?>