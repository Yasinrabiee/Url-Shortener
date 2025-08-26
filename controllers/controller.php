<?php
	require_once __DIR__.'/../models/UserModel.php';

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
			echo $this->blade->run('main');
		}

		public function loginIndex()
		{
			echo $this->blade->run('login');
		}

		public function loginHandle()
		{
			if (isset($_POST['signup']))
			{
				$username = ACC::post('username');
				$password = ACC::post('password');
				$fname = ACC::post('fname');
				$lname = ACC::post('lname');
				$email = ACC::post('email');

			 	# Validation form: required feild - validate username, password, email
		    # check unique key	
				if (empty($username) || empty($password) || empty($fname) || empty($lname)
				|| empty($email))
				{
				  $errorSignUp = ACC::error('لطفا فیلدهای الزامی را پر نمایید.');
				}
				else
				{
				  if (ACC::validateUri($username) != 1)
				  {
				    $errorSignUp = ACC::error(ACC::validateUri($username));
				  }
				  else
				  {
				    if (strlen($password) <= 6)
				    {
				      $errorSignUp = ACC::error('طول گذرواژه باید بیش از 6 کاراکتر باشد.');
				    }
				    else
				    {
				      # password: allowed character => A-Z, a-z, 0-9, password.length > 6
				      if (preg_match('/^[a-zA-Z0-9]{6,}$/', $password) == 0)
				      {
				        $errorSignUp = ACC::error('گذرواژه باید بیش از 6 کاراکتر و شامل
				        حروف انگلیسی باشد.');
				      }
				      else
				      {
				        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
				        {
				          $errorSignUp = ACC::error('ایمیل نامعتبر است!');
				        }
				        else
				        {
				          if (ACC::select('user', 'username', $username, true) > 0)
				          {
				            $errorSignUp = ACC::error('نام کاربری تکراری است!');
				          }
				          else
				          {
				            # Now insert record
				            if (User::insert($_POST))
				            {
				              $successSignUp = ACC::success('ثبت نام شما با موفقیت انجام شد.');
				            }
				            else
				            {
				              $errorSignUp = ACC::errorCodeInfo('مشکلی در ثبت نام به وجود آمد...');
				            }
				          }
				        }
				      }
				    }
				  }
				}
			}
			else
			{
				if (isset($_POST['signin']))
				{
					$username = ACC::post('username');
					$password = md5(ACC::post('password'));

					if (User::auth($username, $password))
					{
						# Set cookie
						$auth = $username . ':' . $password;

						setcookie(_AUTH_NAME, $auth, time()+_COOKIE_LIFESPAN*24*3600, '/', null, null, true);

						header('location:' . ACC::asset(''));
					}
					else
					{
						# Error
						$errorSignIn = ACC::error('نام کاربری یا گذرواژه اشتباه است!');
					}
				}
			}

			echo $this->blade->run('login',
			[
				'successSignUp' => $successSignUp ?? '',
				'errorSignUp' => $errorSignUp ?? '',
				'successSignIn' => $successSignIn ?? '',
				'errorSignIn' => $errorSignIn ?? ''
			]);
		}

		public function logout()
		{
			setcookie(_AUTH_NAME, null, time()-_COOKIE_LIFESPAN*24*3600, '/');
			header('location:' . ACC::asset('login'));
		}

		public function createLink()
		{
			echo ACC::dump($_POST);

			echo $this->blade->run('main',
			[
				'success' => $success ?? '',
				'error' => $error ?? ''
			]);
		}
	}
?>