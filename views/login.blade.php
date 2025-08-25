@include('header')
<div class="container">
	<div class="login-container">
		<div class="alert alert-info text-center">
		  کاربر محترم لطفا جهت استفاده از سرویس کوتاه کننده لینک و دسترسی به اطلاعات
		  دقیق لینک‌های خود ابتدا وارد سیستم شوید.
		</div>
		<div class="login-header text-center">
		  <div class="bi bi-person-circle text-center mb-0"></div>
		  <div class="fs-3">ورود به سیستم</div>
		</div>
		<form action="" method="post">
		  <div class="mb-3">
		    <label for="username" class="form-label">نام کاربری</label>
		    <input type="text" autofocus name="username" dir="ltr" class="form-control" id="username" >
		  </div>
		  <div class="mb-3">
		    <label for="password" class="form-label">رمز عبور</label>
		    <input type="password" name="password" dir="ltr" class="form-control" id="password">
		  </div>
		  <div class="d-flex flex-column gap-1">
		  	<button type="submit" name="login" class="btn btn-primary btn-login">
		  	  <i class="bi bi-box-arrow-in-left"></i> ورود
		  	</button>
		  	<div class="d-grid">
		  		<a href="{{ ACC::asset('signup') }}" class="btn btn-outline-primary btn-login">
		  			<i class="bi bi-person-plus"></i>
		  			ثبت نام
		  		</a>
		  	</div>
		  </div>
		  <div class="my-2">
		    {!! $success ?? '' !!}
		    {!! $error ?? '' !!}
		  </div>
		  <div class="forgot-password text-center">
		    <a href=""><i class="bi bi-question-circle"></i> رمز عبور خود را فراموش کرده اید؟</a>
		  </div>
		</form>
	</div>
</div>
@include('footer')