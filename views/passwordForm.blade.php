@include('header')
<div class="container">
  <div class="login-container">
    <div class="alert alert-info text-center">
      <span class="fs-4">رمز مشاهده نیاز است.</span>
      <br>
      <span>
        <span class="text-danger">توجه:</span>
        محتوای این لینک خصوصی است. لطفا جهت مشاهده رمز مشاهده را وارد
        نمایید.
      </span>
    </div>
    <form action="" method="post">
      <div>
        {!! $error ?? '' !!}
      </div>
      <div class="mb-3">
        <label for="password">رمز مشاهده<span class="text-danger">*</span>:</label>
        <input autofocus type="text" name="password" id="password" class="form-control" dir="ltr">
      </div>
      <div>
        <input type="hidden" name="uri" value="{{ $uri }}">
      </div>
      <div class="d-grid">
        <button class="btn btn-primary" name="submit">مشاهده لینک</button>
      </div>
    </form>
  </div>  
</div>