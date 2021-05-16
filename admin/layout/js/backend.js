$(function (){


$(document).scroll(function(){
  var scroll = $(this).scrollTop();
  if(scroll > 70){
    $("nav").css({
                  "position": "fixed",
                  "top"     : "0",
                  "width"   : "100%",
                  "z-index" : "100"
    });
    $("body").css("padding-top" , "60px");
  }else{
    $("nav").css("position", "relative");
    $("body").css("padding-top" , "0px");
  }
});



// AJAX
function createRequest(){
  var myRequest;
  if(window.XMLHttpRequest){
    myRequest = new XMLHttpRequest();
  }else{
    myRequest = new ActiveXObject("Microsoft.XMLHttpRequest");
      if(! myRequest)
        myRequest = new ActiveXObject("Msxml12.XMLHttp.3.0"); // Microsoft V3
      if(! myRequest)
        myRequest = new ActiveXObject("Msxml12.XMLHttp.6.0"); // Microsoft V6
  }
  return myRequest;
}
// End



// Dashboard Toggle
$(".toggle-info").click(function(){
  
  
  if($(this).children('i').hasClass("fa-minus")){
    $(this).find('i').removeClass("fa-minus").addClass("fa fa-plus");
    $(this).parent().parent().find(".card-body").slideToggle(500).stopPropagation();
  }else{
    $(this).find('i').removeClass("fa-plus").addClass("fa fa-minus");
    $(this).parent().parent().find(".card-body").slideToggle(500).stopPropagation();
  }

});



// Add Course
// Page Create New Course
$(".live").keyup(function() { 
  "use strict";
  $($(this).data("class")).text($(this).val());
});

$(document).keyup(function() { 
  "use strict";
  var str = $("#input-tags_tagsinput").text();
  $(".live-tags").text(str.slice(0, -3));
});
$(".img-upload").on("change",function() { 
  "use strict";
      var input = $(this)[0];
      var file = input.files[0];
      var reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = function(e){
         $('.live-img').attr('src', e.target.result);
         $(".upload").text("Uploaded");
       }
});
$(".video-upload").on("change",function() { 
  "use strict";
      var input = $(this)[0];
      var file = input.files[0];
      var reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = function(e){
         $('.live-video').attr('src', e.target.result);
         $(".upload").text("Uploaded");
       }
});
// End Add Course

  // Hide Placeholder on Focus And Show When Blur
  $("[placeholder]").focus(function(){
    $(this).attr('data-text',$(this).attr("placeholder"));
    $(this).attr("placeholder","");
  }).blur(function(){
    $(this).attr("placeholder",$(this).attr("data-text"));
  });
  // Add ' * ' To Each Input Filed
  $("input").each(function (){
    if($(this).attr("required") === "required"){
      $(this).after("<span class='req'>*</span>");
      $(this).css("position","relative");
      var inputHight = $(this).outerHeight();
      var inputWidth = $(this).width();
      $(".req").css({
        "position": "absolute",
        "top": (inputHight - $(this).height() ) / 2,
        "right": 30,
        "color":"red",
        "font-size":"19px",
      });
      $("i.show-pass").css({
        "position": "absolute",
        "top": (inputHight - $(this).height() + 10) / 2,
        "right": 50,
        "color":"#888",
        "font-size":"15px",
        "cursor": "pointer",
      });
    }
  });


// Show The Password And Hide It
$("i.show-pass").click(function(){
  if($(this).parent('span').parent('div').siblings("input").attr("type") == "password"){
    $(this).removeClass('fa-eye').addClass('fa-lock');
    $(this).parent('span').parent('div').siblings("input").attr("type","text");
  }else{
    $(this).removeClass('fa-lock').addClass('fa-eye');
    $(this).parent('span').parent('div').siblings("input").attr("type","password");
  }
});

// Confirm Buttom
$(".confirm").click(function(){
  return confirm("Are You Sure?!!");
});

$('#input-tags').tagsInput();


$("form .avatar input").change(function(){
  var src = $(this).val().slice(12);
  $("form .avatar img").attr('src',"images/" + src);
});


$(".del-comments").click(function(){
  if(confirm("Are You Sure?!!")){
    var action = $(this).data("action");
    var id = $(this).data("id");
    var type = $(this).data("type");
    
    $(this).parent().parent().hide(300);
    if(type == "approve"){
      $(this).parent().parent().show(300);
      $(this).hide(300);
    }

    var myRequest = "";
    myRequest = createRequest();
    myRequest.onreadystatechange = function(){
      var showContent = document.getElementById("show-content");
      if(this.readyState == 4 && this.status == 200){
        showContent.innerHTML = myRequest.responseText;
      }
    }
    myRequest.open('POST' , 'delete.php', 'true');
    myRequest.setRequestHeader("content-type","application/x-www-form-urlencoded");
    myRequest.send("action="+action+"&id="+id+"&type="+type);
  }
  return false;
});

//  Dashboard Delete
$(".del-dash").click(function(){

    var action = $(this).data("action");
    var id = $(this).data("id");
    var type = $(this).data("type");
    
    $(this).parent().parent().hide(300);
    if(type == "approve"){
      $(this).parent().parent().show(300);
      $(this).hide(300);
    } 

    var myRequest = "";
    myRequest = createRequest();
    myRequest.onreadystatechange = function(){
      var showContent = $(this).parent().parent().parent("#latest-list");
      if(this.readyState == 4 && this.status == 200){
        showContent.innerHTML = myRequest.responseText;
      }
    }
    myRequest.open('POST' , 'delete.php', 'true');
    myRequest.setRequestHeader("content-type","application/x-www-form-urlencoded");
    myRequest.send("action="+action+"&id="+id+"&type="+type);
  return false;
});


$(".del-cats").click(function () {
  var action = $(this).data("action");
  var id = $(this).data("id");
  var type = $(this).data("type");
  
  if(type == "delete"){
    $(this).parent().parent().parent().hide(300);
  }

  var myRequest = "";
  myRequest = createRequest();
  myRequest.open('POST' , 'delete.php', 'true');
  myRequest.setRequestHeader("content-type","application/x-www-form-urlencoded");
  myRequest.send("action="+action+"&id="+id+"&type="+type);
  return false;
});


$(".categories-items").click(function(){

  var action = $(this).data("action");
  var id = $(this).data("id");
  var type = $(this).data("type");
// Visibile
  if($(this).hasClass("visibility-disabled")){
      $(this).removeClass("visibility-disabled").addClass("visibility-undisabled");
      $(this).find("i").removeClass("fa-eye-slash").addClass("fa-eye");

  }else if($(this).hasClass("visibility-undisabled")){
      $(this).removeClass("visibility-undisabled").addClass("visibility-disabled");
      $(this).find("i").removeClass("fa-eye").addClass("fa-eye-slash");
// Comment
  }else if($(this).hasClass("comment-disabled")){
      $(this).removeClass("comment-disabled").addClass("comment-undisabled");
      $(this).find("i").removeClass("fa-bell-slash").addClass("fa-bell");

  }else if($(this).hasClass("comment-undisabled")){
      $(this).removeClass("comment-undisabled").addClass("comment-disabled");
      $(this).find("i").removeClass("fa-bell").addClass("fa-bell-slash");
// ADS
  }else if($(this).hasClass("ads-disabled")){
      $(this).removeClass("ads-disabled").addClass("ads-undisabled");
      $(this).find("i").removeClass("fa-bell-slash").addClass("fa-bell");

  }else if($(this).hasClass("ads-undisabled")){
      $(this).removeClass("ads-undisabled").addClass("ads-disabled");
      $(this).find("i").removeClass("fa-bell").addClass("fa-bell-slash");
// ADS
  }

  var myRequest = "";
  myRequest = createRequest();

  myRequest.open('POST' , 'delete.php', 'true');
  myRequest.setRequestHeader("content-type","application/x-www-form-urlencoded");
  myRequest.send("action="+action+"&id="+id+"&type="+type);
  return false;
});




// Change Page Table in Page Member 
$(".change-page li:first-child").addClass("active");

$(".change-page li a").click(function(){
  $(this).parent().addClass("active").siblings("li").removeClass("active");
  var page = $(this).data("page"),
      pageCount = $(this).data("rowinpage"),
      action = "change";

  var myRequest = "";
  myRequest = createRequest();
  myRequest.onreadystatechange = function(){
    var ele = $("div.table-responsive table tbody");
    if(this.readyState == 4 && this.status == 200){
      ele.html(myRequest.responseText);
    }
  }
  myRequest.open('POST' , 'delete.php', 'true');
  myRequest.setRequestHeader("content-type","application/x-www-form-urlencoded");
  myRequest.send("action="+action+"&page="+page+"&pageCount="+pageCount);

  return false;
});


// Change Page Table in Page Member 
var searched_by = $("select#searchBy").val();
$("select#searchBy").change(function(){
  searched_by = $(this).val();
});

$("input#searchByName").keyup(function(){
  var name = $(this).val(),
      active = $(this).data('action');
  var myRequest = "";
  myRequest = createRequest();
  myRequest.onreadystatechange = function(){
    var ele = $("div.table-responsive table tbody");
    if(this.readyState == 4 && this.status == 200){
      ele.html(myRequest.responseText);
      $(".change-page li:first-child").addClass("active").siblings('li').removeClass("active");
    }
  }
  myRequest.open('POST' , 'delete.php', 'true');
  myRequest.setRequestHeader("content-type","application/x-www-form-urlencoded");
  myRequest.send("action="+active+"&name="+name+"&type="+searched_by);

  return false;
});



});