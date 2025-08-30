function persianDate() {
  $('.persiandate').each(function() {
    let text = $(this).text();
    let date = new Date(text);
    const tehranOffset = 3 * 60 + 30;
    const tehranDate = new Date(date.getTime() + (tehranOffset * 60000));
    date = new Date(tehranDate);
    options = {
      year: `numeric`,
      month: `numeric`,
      day: `numeric`,
      hour12: false,
      timeZone: `Asia/Tehran`
    };
    if($(this).hasClass(`persiantime`))
    {
      options.hour=`numeric`;
      options.minute=`numeric`;
    }
    try{
      $(this).text((new Intl.DateTimeFormat(`fa-IR`, options).format(date)).replaceAll(`,`,``));
    }
    catch(error){
      console.log($(this).text()+error);
    }
  });
}

let spinner = `
  <div class="d-flex align-items-center">
    <div class="spinner-border ms-auto" aria-hidden="true"></div>
  </div>
`;

$(function() {
  persianDate();

  $('.confirm').click(function(e) {
    if (confirm($(this).data('message')))
    {
      return true;
    }
    return false;
  });
});
   
$(".delete-img").click(function(e) {
  if (confirm($(this).data("message")))
  {
    e.preventDefault();
    let imgTag = $(this).prev();
    let btn = $(this);
    let src = imgTag.attr("src");
    let id = imgTag.data("id");
    let table = $(this).data('table');
    let filename = src.substring(src.lastIndexOf("/")+1);
    
    $.ajax({
      url: "ajax.php",
      type: "POST",
      data: {op: "delete-img", filename: filename, id: id, table: table},

      success: function(data, status)
      {
        imgTag.remove();
        btn.remove();
        if (data == "1")
        {
          console.log("تصویر با موفقیت حذف شد.");
          $(".delete-img-alert").append(`
          <span class="badge bg-success-subtle border border-dark-subtle
          text-dark-emphasis fs-7 mb-2">
            با موفقیت حذف شد.
          </span>`);
        }
        else
        {
          console.log("مشکلی در حذف تصویر به وجود آمد!");
          $(".delete-img-alert").append(`
          <span class="badge bg-danger-subtle border border-dark-subtle
          text-dark-emphasis fs-7 mb-2">
            مشکلی به وجود آمد!
          </span>`);
        }
      },
      error: function(xhr, status, error)
      {
        console.log("مشکلی در اتصال به سرور به وجود آمد...");
      }
    });
  }
}); 

// $("#uri").change(function() {
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
//         $("#uri").removeClass("is-valid");
//         $("#uri").addClass("is-invalid");
//         $("#feedback").html(data);
//       }
//       else
//       { 
//         $("#uri").removeClass("is-invalid");
//         $("#uri").addClass("is-valid");
//       }
//     },
//     error: function() {
//       console.log("مشکلی در اتصال به سرور به وجود آمد...");
//     } 
//   });   
// });

$("#email").change(function() {
  $.ajax({
    url: "ajax.php",
    type: "POST",
    data: {
      op: "validate-email",
      email: $(this).val(),
      table: $(this).data("table")
    },
    success: function(data, status) {
      if (data != "")
      {
        $("#email").removeClass("is-valid");
        $("#email").addClass("is-invalid");
        $("#feedback-email").html(data);
      }
      else
      { 
        $("#email").removeClass("is-invalid");
        $("#email").addClass("is-valid");
      }
    },
    error: function() {
      console.log("مشکلی در اتصال به سرور به وجود آمد...");
    } 
  });   
});

function toDark()
{
  $('#btn-toggle-theme').find('i').removeClass('bi-moon').addClass('bi-sun');
  $('html').attr('data-bs-theme', 'dark');
  $('.navbar').removeClass('bg-light').addClass('bg-dark');
  $('.navbar-brand').removeClass('bg-light').addClass('bg-dark');
  $('.navbar-brand').removeClass('text-dark').addClass('text-light');
  $('#btn-berger-menu').removeClass('text-dark').addClass('text-light');
  $('main.form-signin').removeClass('bg-white').addClass('bg-dark');
  $('.dropdown-toggle').removeClass('btn-light').addClass('btn-dark');
}

function toLight()
{
  $('#btn-toggle-theme').find('i').removeClass('bi-sun').addClass('bi-moon');
  $('html').attr('data-bs-theme', 'light');
  $('.navbar').removeClass('bg-dark').addClass('bg-light');
  $('.navbar-brand').removeClass('bg-dark').addClass('bg-light');
  $('.navbar-brand').removeClass('text-light').addClass('text-dark');
  $('#btn-berger-menu').removeClass('text-light').addClass('text-dark');
  $('main.form-signin').removeClass('bg-dark').addClass('bg-white');
  $('.dropdown-toggle').removeClass('btn-dark').addClass('btn-light');
}

function alert(message, type)
{
  return `
    <div class="alert alert-${type}">${message}</div>
  `;  
}

function success(message)
{
  return `
    <div class="alert alert-success alert-dismissible fade show">
      <i class="bi bi-check-circle"></i> ${message}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  `;
}

function error(message)
{
  return `
    <div class="alert alert-danger alert-dismissible fade show">
      <i class="bi bi-exclamation-triangle"></i> ${message}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  `;
}