@include('header')

<div class="container">
  <div class="login-container">
    <div class="login-header text-center">
      <div class="bi bi-person-circle text-center mb-0"></div>
      <div class="fs-3">ثبت نام</div>
    </div>
    <form action="" method="post">
      <div class="my-2">
        {{ $success ?? '' }}
        {{ $error ?? ''}}
      </div>
      <div class="mb-3">
        <label for="uri" class="form-label">
          نام کاربری<span class="text-danger">*</span>:
        </label>
        <input type="text" autofocus name="username" dir="ltr" class="form-control"
        id="uri"  maxlength="20" data-table="user" data-field="username">
        <div id="waiting"></div>
        <div class="invalid-feedback" id="feedback"></div>
        <small class="text-muted">
          (کاراکترهای مجاز: A-Z a-z 0-9 _ طول مجاز: 1 تا 20 کاراکتر)
        </small>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">
          رمز عبور<span class="text-danger">*</span>:
        </label>
        <input type="password" name="password" dir="ltr" class="form-control"
        id="password">
      </div>
      <div class="mb-3">
        <label for="fname" class="form-label">
          نام<span class="text-danger">*</span>:
        </label>
        <input type="text" name="fname" class="form-control" id="fname">
      </div>
      <div class="mb-3">
        <label for="lname" class="form-label">
          نام خانوادگی<span class="text-danger">*</span>:
        </label>
        <input type="text" name="lname" class="form-control" id="lname">
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">
          ایمیل<span class="text-danger">*</span>:
        </label>
        <input type="text" name="email" dir="ltr" class="form-control" id="email">
      </div>
      <button type="submit" name="signup" class="btn btn-primary btn-login">
        <i class="bi bi-person-plus"></i>
        ثبت نام
      </button>
    </form>
  </div>
</div>
@include('footer')