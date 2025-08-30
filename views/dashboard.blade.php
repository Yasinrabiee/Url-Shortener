@include('header')

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="./">Zaplink</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="{{ ACC::asset('') }}">خانه</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="{{ ACC::asset('links') }}">لینک‌های من</a>
        </li>
      </ul>
      <div class="d-flex">
        <a href="{{ ACC::asset('profile') }}" class="btn btn-primary me-2">پروفایل شما</a>
        <a href="{{ ACC::asset('logout') }}" class="btn btn-danger">خروج</a>
      </div>
    </div>
  </div>
</nav>

<div class="container my-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>لینک‌های من</h1>
    <a href="{{ ACC::asset('') }}" class="btn btn-primary">
      <i class="bi bi-plus-circle"></i> لینک جدید
    </a>
  </div>

  <div class="card mb-4">
    <div class="mt-1">
      @if(isset($_GET['delete']))
        @if($_GET['delete'] == 'error')
          {!! ACC::error('مشکلی در حذف رکورد به وجود آمد...') !!}
        @endif
        @if($_GET['delete'] == 'ok')
          {!! ACC::success('رکورد مورد نظر با موفقیت حذف شد.') !!}
        @endif
      @endif
    </div>

    <div class="card-body">
      <div id="result"></div>
      <div id="result-delete"></div>
      <div class="reference-list" data-references="post">
    <div class="toolbar mb-3">
      <span class="small " id="recordCount">
        
      </span>
      <input type="hidden" class="n2m" value="false">
      <div class="page-number-container d-flex align-items-center">
        <!-- <small class="text-end">صفحه: </small>
        <select class="form-select form-select-sm page-number" dir="ltr">
          
        </select> -->

        <!-- <small class="text-end text-nowrap">در هر صفحه: </small>
        <select class="form-select form-select-sm page-limit" dir="ltr">
          <option value="5">5</option>
          <option value="15">15</option>
          <option value="50">50</option>
          <option value="100">100</option>
          <option value="200">200</option>
          <option value="10000000" dir="rtl">همه</option>
        </select> -->
      </div>
    </div>
    <div class="table-responsive">
      <input type="hidden" class="orderby" value="id">
      <input type="hidden" class="sortby" value="desc">
      <table class="table table-bordered table-striped table-sm">
        <thead>
          <tr>
            <th class="tools-column text-center" style="z-index: 100;">
              امکانات
            </th>
            <th style="min-width: 100px">
              <input type="search" data-name="id" placeholder="آیدی" 
              class="form-control form-control-sm filter" value="">
              <center>
                <i class="bi bi-caret-down btn btn-xsm active-order" data-sort="desc"></i>
                <i class="bi bi-caret-up btn btn-xsm" data-sort="asc"></i>
              </center>
            </th>

            <th style="min-width: 100px">
              <input type="search" data-name="uri" placeholder="لینک کوتاه" 
              class="form-control form-control-sm filter">
              <center>
                <i class="bi bi-caret-down btn btn-xsm" data-sort="desc"></i>
                <i class="bi bi-caret-up btn btn-xsm" data-sort="asc"></i>
              </center>
            </th>

            <th style="min-width: 100px">
              <input type="search" data-name="target" placeholder="لینک اصلی" 
              class="form-control form-control-sm filter">
              <center>
                <i class="bi bi-caret-down btn btn-xsm" data-sort="desc"></i>
                <i class="bi bi-caret-up btn btn-xsm" data-sort="asc"></i>
              </center>
            </th>

            <th style="min-width: 100px">
              <input type="search" data-name="add_date" placeholder="تاریخ افزودن"
              class="form-control form-control-sm filter">
              <center>
                <i class="bi bi-caret-down btn btn-xsm" data-sort="desc"></i>
                <i class="bi bi-caret-up btn btn-xsm" data-sort="asc"></i>
              </center>
            </th>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>
      <div id="waiting"></div>
    </div>
  </div>
    </div>
  </div>
</div>

<br><br><br><br><br>
<br><br><br><br><br>

<script>
  const fields = $('.filter');

  function loadLinks()
  {
    $('tbody').empty();
    $('#waiting').html(spinner);

    const sortField = $('.active-order').parent().siblings('input').data('name');
    const orderBy = $('.active-order').data('sort');

    const where = {};
    where['id'] = fields[0].value; 
    where['uri'] = fields[1].value; 
    where['target'] = fields[2].value; 
    where['add_date'] = fields[3].value;
    console.log($('.page-number').val());
    $.ajax(
    {
      url: '{{ ACC::asset("ajax.php") }}',
      type: 'POST',
      data:
      {
        op: 'list-of-links',
        where: where,
        sortField: sortField,
        orderBy: orderBy
      },

      success: function(records, status)
      {
        $('#waiting').html('');
        if (records == '')
        {
          $('#result').html(alert('رکوردی یافت نشد...', 'light'));
          $('#recordCount').html(`${records.length} رکورد`);
        }
        else
        {
          $('#result').html('');
          let content = '';
          for (record in records)
          {
            content += `
            <tr>
              <td class="text-center">
                <div class="dropdown-checkbox d-flex align-items-center
                justify-content-center">
                  <div class="btn-group">
                    <button type="button" class="btn btn-sm dropdown-toggle
                    btn-dark" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="bi bi-sliders"></i>
                    </button>
                    <ul class="dropdown-menu">
                      <li>
                        <a class="dropdown-item"
                        href="{{ ACC::asset('edit/id/') }}${records[record].id}">
                          <i class="bi bi-pen text-primary"></i> ویرایش
                        </a>
                      </li>
                      <li>
                        <hr class="dropdown-divider">
                      </li>
                      <li>
                        <a class="dropdown-item confirm"
                        href="{{ ACC::asset('delete/id/') }}${records[record].id}"
                          data-message="آیا از عملیات مورد نظر اطمینان دارید؟">
                          <i class="bi bi-trash3 text-danger"></i> حذف
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </td>
              <td class="text-center">${records[record].id}</td>
              <td class="text-center">${records[record].uri}</td>
              <td class="text-center">${records[record].target}</td>
              <td class="text-center">${records[record].add_date}</td>
            </tr>
              `;
            }
            $('tbody').html(content);
            $('#recordCount').html(`${records.length} رکورد`);
          }
        },
        error: function()
        {
          $('#waiting').html('');
          $('#result').html(error('مشکلی در اتصال به سرور به وجود آمد...'));
        }
      });
  }

  loadLinks();

  $('.filter').on('input', function()
  {
    loadLinks();
  });

  $('.btn-xsm').click(function()
  {
    $('.btn-xsm').removeClass('active-order');
    $(this).addClass('active-order');
    loadLinks();
  });
</script>

@include('footer')