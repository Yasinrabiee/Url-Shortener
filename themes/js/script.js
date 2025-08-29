$('#clipboard').click(function() {
	let content = $('#customCreatedLink').html();
	navigator.clipboard.writeText(content);
	alert('در کلیپ برد ذخیره شد.');
});


// Set last active tab in localStorage
let activeTab = localStorage.getItem('activeTab');
if (activeTab)
{
	let triggerEl = $(`.nav-item button[data-bs-target="${activeTab}"]`);
	if (triggerEl.length)
	{
		let tab = new bootstrap.Tab(triggerEl[0]);
		tab.show();
	}
}
		
$('.nav-item button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
	localStorage.setItem('activeTab', $(e.target).attr('data-bs-target'));
});


// Validate uri(username) field: AJAX Request
// $("#uri").change(function() {
// 	$("#waiting").html(spinner);
// 	$("#feedback").empty();

//   $.ajax({
//     url: "ajax.php",
//     type: "POST",
//     data: {
//       op: "validate-field",
//       field: $(this).data('field'),
//       fieldValue: $(this).val(),
//       table: $(this).data('table')
//     },
//     success: function(data, status) {
//       if (data != "")
//       {
//       	$("#uri").removeClass("is-valid")
//         $("#uri").addClass("is-invalid");
//         $("#waiting").empty();
//         $("#feedback").html(data);
//       }
//       else
//       { 
//         $("#uri").removeClass("is-invalid");
//         $("#uri").addClass("is-valid");
//         $("#waiting").empty();
//       }
//     },
//     error: function() {
//       $("#uri").removeClass("is-valid");
//       $("#uri").addClass("is-invalid");
//       $("#waiting").hide();
//       $("#feedback").html('مشکلی در اتصال به سرور به وجود آمد...');
//     } 
//   });   
// });

$('#random').change(function() {
  if ($(this).is(':checked'))
  {
    $('.short-link').prop('disabled', true);
  }
  else
  {
    $('.short-link').prop('disabled', false);
  }
});

$('#secure').change(function() {
  if ($(this).is(':checked'))
  {
    $('#password').prop('disabled', false);
  }
  else
  {
    $('#password').prop('disabled', true);
  }
});

$('.filter').on('input' , function(e) {
  console.log(e.target);
});