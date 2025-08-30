<?php
	class ACC
	{
		public static function alert($message, $type = 'light')
		{
			return '
			<div class="alert alert-'.$type.' alert-dismissible fade show">
				'.$message.'
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
			';
		}

		public static function success($message)
		{
			// return ACC::alert('<i class="bi bi-check-circle"></i> ' . $message, 'success');
			return ACC::alert($message, 'success');
		}

		public static function error($message)
		{
			// return ACC::alert('<i class="bi bi-exclamation-triangle"></i> ' . $message, 'danger');
			return ACC::alert($message, 'danger');
		}

		public static function pre($value = '')
		{
			return 
			'<pre dir="ltr" class="text-primary">'.(is_array($value) ? 
			print_r($value, true) : $value).'</pre>';
		}

		public static function auth($auth = '')
		{
			$auth = explode(':', $auth);
			if ($auth[0] == 'admin' && $auth[1] == md5('123'))
			{
				return true;		
			}
			return false;
		}

		public static function post($key)
		{
			if (!empty($_POST[$key]))
			{
				// ...
				$post = htmlentities($_POST[$key]);
				$post = trim($post);
				return $post;
			}
			return false;
		}

		public static function get($key)
		{
			if (!empty($_GET[$key]))
			{
				// ...
				return $_GET[$key];
			}
			return false;
		}

		public static function errorCodeInfo($message)
		{
			return "
				<div class='alert alert-danger'>
					$message
					<details>
			    			<summary>جزئیات</summary>
			    			<pre dir=ltr>". $_SESSION['errorCode'] ."</pre>
				    </details>
				</div>
			";
		}

		public static function select($table, $column, $value = '')
		{
			// Example: 
			// ACC::select('book', $id);
			// or
			// ACC::select('book', 'uri', $value);

			if ($value === '')
			{
				$value = $column;
				$column = 'id';
			}

			$params = [
			    'table' => $table,
			    'columns' => '*',
			    'where' => "$column = :$column",
			    'whereArray' => [$column => $value]
			];
			
			if (isset(DB::select($params)[0]))
			{
				return DB::select($params)[0];
			}
		}

		public static function selectCount($table, $column, $value)
		{
			// 'whereArray' => ['username' => $username, 'password' => $password],

			$params = [
				'table' => $table,
				'columns' => '*',
				'where' => "$column = :$column",
				'whereArray' => [$column => $value],
				'count' => true
			];

			return DB::select($params);
		}

		public static function consoleLog($data, $type = 'log')
		{
			$varname = 'data_'.time().rand(1,1000);
			return '
				<script>
					let '.$varname.' = '.(json_encode($data)).'
					console.'.$type.'('.$varname.');
				</script>
			';
		}

		public static function validateUri($uri)
		{
			if (strlen($uri) > 40)
			{
				return 'طول شناسه بیش از حد مجاز است!';
			}
			else
			{
				if (!preg_match('/^[a-z0-9\-]+$/i', $uri))
				{
					return 'شناسه حاوی کاراکترهای غیرمجاز است!';
				}
				else
				{
					return true;
				}
			}
		}

		public static function checkMime($imageInfo)
		{
			if ($imageInfo['mime'] != 'image/gif' && $imageInfo['mime'] != 'image/png' && $imageInfo['mime'] != 'image/jpeg' && $imageInfo['mime'] != 'image/jpg' && $imageInfo['mime'] != 'image/webp' && $imageInfo['mime'] != 'image/svg')
			{
				return false;
			}
			return true;
		}

		public static function asset($path)
		{
			# asset('themes/css/style.css');
	    $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") 
	        . "://" . $_SERVER['HTTP_HOST'];

	    $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');

	    $path = ltrim($path, '/\\');

	    $fullUrl = $baseUrl . $basePath . '/' . $path;

	    return $fullUrl;
		}

		public static function dump(...$vars)
		{
			$backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1);
			$caller = $backtrace[0] ?? null;

			echo '<div class="dump-container" dir=ltr>';
			if ($caller)
			{
				$file = $caller['file'] ?? 'unknown file';
				$line = $caller['line'] ?? 'unknown line';
				echo "<div class='dump-header'>Called in <b>$file</b> on line <b>$line</b></div>";
			}

			foreach ($vars as $var)
			{
				ACC::dumpVar($var);
				echo '</div>';
			}
		}

		public static function dumpVar($var, $indent = 0)
		{
			$indentStr = str_repeat('  ', $indent);

			if (is_array($var))
			{
				$count = count($var);
				echo "Array($count)<br>[\n";

				foreach ($var as $key => $value)
				{
					echo $indentStr . "  <span class='dump-key'>" . htmlspecialchars($key) . "</span> => ";
					ACC::dumpVar($value, $indent + 1);
				}

				echo $indentStr . "];\n";
			}

			elseif (is_object($var))
			{
				$className = get_class($var);
				$props = get_object_vars($var);
				$count = count($props);
				echo "Object($className) ($count)<br>{\n";
				foreach ($props as $prop => $value)
				{
					echo $indentStr . "  <span class='dump-key'>$" . htmlspecialchars($prop) . "</span> => ";
					ACC::dumpVar($value, $indent + 1);
				}
				echo $indentStr . "};\n";
			}

			elseif (is_string($var))
			{
				$len = strlen($var);
				echo "<span class='dump-string'>string($len) \"".htmlspecialchars($var)."\"</span>\n";
			}

			elseif (is_int($var))
			{
				echo "<span class='dump-int'>int($var)</span>\n";
			}

			elseif (is_float($var))
			{
				echo "<span class='dump-float'>float($var)</span>\n";
			}

			elseif (is_bool($var))
			{
				$val = $var ? 'true' : 'false';
				echo "<span class='dump-bool'>bool($val)</span>\n";
			}

			elseif (is_null($var))
			{
				echo "<span class='dump-null'>NULL</span>\n";
			}

			else
			{
				echo htmlspecialchars(var_export($var, true)) . "\n";
			}
		}

		public static function str_replace_last($search, $replace, $str)
		{
			if (($pos = strrpos($str, $search)) !== false)
			{
				$search_length = strlen($search);
				$str = substr_replace($str, $replace, $pos, $search_length);

				return $str;
			}
		}
	} 
?>