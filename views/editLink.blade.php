@include('header')
	<!-- Header -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container">
			<a class="navbar-brand" href="{{ ACC::asset('') }}">Zaplink</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav me-auto">
					<li class="nav-item">
						<a class="nav-link" href="{{ ACC::asset('') }}">خانه</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ ACC::asset('links') }}">لینک‌های من</a>
					</li>
				</ul>
        <div class="d-flex">
            <!-- <a href="./profile.php" class="btn btn-primary me-2">پروفایل شما</a> -->
            <a href="{{ ACC::asset('logout') }}" class="btn btn-outline-light">خروج</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Body -->

  <div class="container">
    <div class="login-container">
      <h1 class="h2 mb-3 text-center">
      	<span class="badge bg-primary py-2 px-3">ویرایش لینک</span>
    	</h1>
    	<div class="my-2">
    	  {!! $success ?? '' !!}
    	  {!! $error ?? '' !!}
    	</div>
    	<!-- User information -->
    	<form action="" method="post">
    	  <div class="mb-3">
    	    <label for="uri" class="form-label">
    	      لینک کوتاه<span class="text-danger">*</span>:
    	    </label>
    	    <input type="text" class="form-control" autofocus name="uri" 
    	    value="{{ $_POST['uri'] ?? $recordInfo['uri'] }}" dir="ltr">
    	  </div>

    	  <div class="mb-3">
    	    <label for="target" class="form-label">
    	      لینک اصلی<span class="text-danger">*</span>:
    	    </label>
    	    <input type="text" name="target" class="form-control" id="target"
    	    value="{{ $_POST['target'] ?? $recordInfo['target'] }}" dir="ltr">
    	  </div>

    	  <div class="mb-3">
    	    <label for="password" class="form-label">
    	      رمز مشاهده
    	    </label>
    	    <input type="password" name="password" class="form-control" id="password"
    	    dir="ltr" value="{{ ACC::post('password') }}">
    	  </div>

    	  <button type="submit" name="edit" class="btn btn-primary btn-login">
    	    <i class="bi bi-floppy"></i>
    	    ویرایش لینک
    	  </button>
    	</form>
    </div>
  </div>
<br><br><br><br>
<br><br><br><br>
@include('footer')