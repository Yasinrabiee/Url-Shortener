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
      	<span class="badge bg-primary py-2 px-3">پروفایل شما</span>
    	</h1>
    	<div class="my-2">
    	  {!! $success ?? '' !!}
    	  {!! $error ?? '' !!}
    	</div>
    	<!-- User information -->
    	<form action="" method="post">
    	  <div class="mb-3">
    	    <label for="uri" class="form-label">
    	      نام کاربری:
    	    </label>
    	    <input type="text" class="form-control" autofocus readonly
    	    value="{{ $userInfo['username'] }}" dir="ltr">

    	    <small>
    	    	<span class="text-danger">توجه:</span>
    	    	<span>
    	    		شما اجازه تغییر نام کاربری خود را ندارید.
    	    	</span>
    	    </small>
    	  </div>

    	  <div class="mb-3">
    	    <label for="fname" class="form-label">
    	      نام<span class="text-danger">*</span>:
    	    </label>
    	    <input type="text" name="fname" class="form-control" id="fname"
    	    value="{{ $_POST['fname'] ?? $userInfo['fname'] }}">
    	  </div>

    	  <div class="mb-3">
    	    <label for="lname" class="form-label">
    	      نام خانوادگی<span class="text-danger">*</span>:
    	    </label>
    	    <input type="text" name="lname" class="form-control" id="lname"
    	    value="{{ $_POST['lname'] ?? $userInfo['lname'] }}">
    	  </div>

    	  <div class="mb-3">
    	    <label for="email" class="form-label">
    	      ایمیل<span class="text-danger">*</span>:
    	    </label>
    	    <input type="text" name="email" dir="ltr" class="form-control"
    	    id="email" value="{{ $_POST['email'] ?? $userInfo['email'] }}">
    	  </div>

    	  <button type="submit" name="edit" class="btn btn-primary btn-login">
    	    <i class="bi bi-floppy"></i>
    	    ثبت تغییرات
    	  </button>
    	</form>
    </div>
  </div>

@include('footer')