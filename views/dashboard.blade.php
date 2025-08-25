{% include 'header.html.twig' %}

	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container">
			<a class="navbar-brand" href="./">Zaplink</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav me-auto">
					<li class="nav-item">
						<a class="nav-link" href="./">خانه</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="">لینک‌های من</a>
					</li>
				</ul>
        <div class="d-flex">
            <a href="./profile.php" class="btn btn-primary me-2">پروفایل شما</a>
            <a href="./logout.php" class="btn btn-danger">خروج</a>
        </div>
      </div>
    </div>
  </nav>

<div class="container my-5">
	<div class="d-flex justify-content-between align-items-center mb-4">
		<h1>لینک‌های من</h1>
		<a href="./" class="btn btn-primary">
			<i class="bi bi-plus-circle"></i> لینک جدید
		</a>
	</div>

	<div class="card mb-4">
		<div class="card-header row row-cols-md-5 mb-2 align-items-center row-cols-3">
			<div>
				<span id="recordCount" class="badge bg-light-subtle border border-danger-subtle text-dark-emphasis fs-7">
					0 رکورد
				</span>
			</div>

			<!-- <div class="row row-cols-2 align-items-center flex-wrap">
				<div class="text-end pe-1">تعداد:</div>	
				<div class="ps-0">
					<select id="limit" class="form-select form-select-sm">
						<option value="2">2</option>					
						<option value="10">10</option>					
						<option value="20">20</option>					
						<option value="50">50</option>					
						<option value="100">100</option>					
						<option value="200">200</option>					
		 			</select>
			 	</div>
			</div> -->

			<!-- <div>
				<div class="row row-cols-2 align-items-center flex-wrap">
				 	<div class="text-end pe-1">صفحه:</div>
				 		<div class="ps-0">
				 			<select class="form-select form-select-sm" id="page">	 	
				 				<option value="1">1</option>
				 				<option value="2" selected>2</option>
							</select>
						</div>
				</div>
			</div> -->

			<div class="row row-cols-1 align-items-center flex-wrap">
				<div class="ps-0">
 					<select class="form-select form-select-sm" id="searchOp">	 	
 						<option value="id">آیدی</option>
 						<option value="uri">لینک کوتاه</option>
 						<option value="target">لینک اصلی</option>
					</select>
				</div>
			</div>

			<div>
				<input type="text" id="search" class="form-control form-control-sm" placeholder="جستجو...">
			</div>
		</div>
		<div class="card-body">
			<div id="result"></div>
			<div id="result-delete"></div>
			<div class="table-responsive">
				<table class="table table-bordered table-striped text-center">
					<thead>
						<tr>
							<th>آیدی</th>
							<th>لینک کوتاه</th>
							<th>لینک اصلی</th>
							<th>تاریخ ایجاد</th>
							<th>عملیات</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
				<div id="waiting" class="text-center"></div>
			</div>
		</div>
	</div>
</div>
<br><br>

<script>
	function loadLinks()
	{
		$.ajax({
			url: 'ajax.php',
			type: 'POST',
			data: {
				op: 'load-links',
				limit: $('#limit').val(),
				page: $('#page').val()
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
							<td>${records[record].id}</td>
							<td>${records[record].uri}</td>
							<td>${records[record].target}</td>
							<td>${records[record].add_date}</td>
							<td>
                <a href="" class="btn btn-sm btn-outline-primary me-2">
                    <i class="bi bi-bar-chart"></i>
                </a>
                <button data-id="${records[record].id}" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-trash"></i>
                </button>
							</td>
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

	$('#waiting').html(spinner);

	$('#search').on('input', function() {
		$('tbody').html('');
		$('#waiting').html(spinner);

		let query = $(this).val();
		let searchOp = $('#searchOp').val();

		$.ajax({
			url: 'ajax.php',
			type: 'POST',
			data: {op: 'search-link', query: query, searchOp: searchOp},

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
								<td>${records[record].id}</td>
								<td>${records[record].uri}</td>
								<td>${records[record].target}</td>
								<td>${records[record].add_date}</td>
								<td>
	                <a href="" class="btn btn-sm btn-outline-primary me-2">
	                    <i class="bi bi-bar-chart"></i>
	                </a>
	                <button data-id="${records[record].id}" class="btn btn-sm btn-outline-danger">
	                    <i class="bi bi-trash"></i>
	                </button>
								</td>
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
	});

	$(document).on('click', '.btn-outline-danger', function() {
		if (confirm('آیا از عملیات مورد نظر اطمینان دارید؟'))
		{
			let id = $(this).data('id');

			$.ajax({
				url: 'ajax.php',
				type: 'POST',
				data: {op: 'delete-link', id: id},

				success: function(res, status)
				{
					loadLinks();
					if (res)
					{
						$('#result-delete').html(success('رکورد مورد نظر با موفقیت حذف شد.'));
					}
					else
					{
						$('#result-delete').html(error('مشکلی در حذف رکوردی مورد نظر به وجود آمد...'));
					}
				},
				error: function()
				{
			 		$('#waiting').html('');
					$('#result').html(error('مشکلی در اتصال به سرور به وجود آمد...'));
				}
			});
		}
	});
</script>

{% include 'footer.html.twig' %}