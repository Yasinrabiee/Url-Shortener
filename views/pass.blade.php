{% include 'header.html.twig' %}

<div class="container">
  <div class="login-container">
    <div class="alert alert-light text-center">
      <span class="fs-4">رمز مشاهده نیاز است.</span>
      <br>
      <span>
      	<span class="text-danger">توجه:</span> محتوای این لینک خصوصی است. لطفا جهت مشاهده رمز مشاهده را وارد نمایید.
      </span>
    </div>
    <form action="" method="post">
    	<div class="my-2">
    		{% if error is defined %}
    		  {{ error | raw}}
    		{% endif %}
    	</div>
    	<div class="mb-3">
    		<label for="password">
    			رمز مشاهده<span class="text-danger">*</span>:
    		</label>
    		<input type="password" name="password" id="password" class="form-control"
    		dir="ltr">
    	</div>
    	<div class="d-grid">
    		<button class="btn btn-primary" name="submit">مشاهده لینک</button>
    	</div>
    </form>
  </div>
</div>

</body>
</html>