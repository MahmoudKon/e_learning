$(document).ready(function(){

  $("#option i").click(function(){
    var ele = $(this).parent();
    if(ele.css("left") == "-200px"){
      ele.css("left","0px");
    }else{
      ele.css("left","-200px");
    }
  });



//  Count Number For Form In Index.PHP
$('.register-like').animationCounter({start: 0,end: 1500,step: 1,delay: 2,txt: ""});
$('.register-comm').animationCounter({start: 0,end: 1750,step: 1,delay: 2,txt: ""});
$('.register-cats').animationCounter({start: 0,end: 2000,step: 1,delay: 2,txt: ""});
$('.register-curs').animationCounter({start: 0,end: 3120,step: 1,delay: 2,txt: ""});

  $('.selectpicker').selectpicker();

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


// When The Window Scroll Make Navbar Position Fixed

$(window).on('scroll', function () {
  $scroll = $(this).scrollTop();
  if($scroll >40){
    $(".navbar").css({ "position":"fixed", "top":"0" });
    $("body").css({ "padding-top":"45px" });
  }else{
    $(".navbar").css( "position","relative");
    $("body").css({ "padding-top":"0px" });
  }

});



 // Add ' * ' To Each Input Filed
 $("input[required='required']").each(function (){
  if($(this).attr("required") === "required"){
    $(this).css("position","relative").after("<span class='req'>*</span>");
    $(this).css({ "border-bottom-right-radius": 4, "border-top-right-radius": 4});
    var owidth = $(this).outerWidth();
    var width = $(this).width();
    $(".req").css({
      "position": "absolute",
      "top": 7,
      "right":  owidth - width + 20,
      "color":"red",
      "font-size":"19px",
    });
  }
});


// To Display Form And Hide Siblings[ LonIn | SignUp ]
$("section.forms .header h1 span").click(function() {
   $(this).addClass("active").siblings().removeClass("active");
   $("section.forms form").slideUp(700).delay(700);
   $("#" + $(this).data("class")).slideDown(700);
});

//  To Show And Hide The Password In Sign UP And Login Forms
$(".input-group .input-group-text i.toggle-pass").click(function() {
  
    if($(this).parent("span").parent("div").siblings("input").attr("type") == "password"){
      $(this).removeClass('fa-eye').addClass('fa-lock').parent().parent("div").siblings("input").attr("type","text");
    }else{
      $(this).removeClass('fa-lock').addClass('fa-eye').parent().parent("div").siblings("input").attr("type","password");
    }
});

$("section.forms .layout .body form .avatar input").change(function(){
  var src = $(this).val().slice(12);
  console.log(src);
  $("section.forms .layout .body form .avatar img").attr('src',"images/" + src);
  console.log($("section.forms .layout .body form .avatar img").attr('src'));
});
// Display and Hide The Search Input
  $("i.fa-search").click(function(){
    $("nav div.search").slideToggle(400);
  });

/*
================
Start Page Login
================
*/

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
      $(this).parent("div").siblings("span").css("position","relative").after("<span class='req'>*</span>");
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
    if($(this).siblings("input").attr("type") == "password"){
      $(this).siblings("input").attr("type","text");
    }else{
      $(this).siblings("input").attr("type","password");
    }
  });

/*
================
End Page Login
================
*/

$('#input-tags').tagsInput();


$(".fa-heart").click(function(){
    if($(this).hasClass("far")){
      $(this).removeClass("far").addClass("fas");
      $(this).next("span").text(love);
    }else{
      $(this).removeClass("fas").addClass("far");
    }
});

//===================================================================================================================================
//======================================================== Start Blog Page
//===================================================================================================================================
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

//  Start Button Like 
$(".blog .blog-share-posts .card-body .post-btns p.post-like").click(function(){
  if($(this).hasClass("like-active")){
    $(this).removeClass("like-active");
    var id = $(this).data("like");
    var count = parseInt($(this).next("span").text());
    $(this).next("span").text(count-1);
        myRequest = createRequest();
        // myRequest.onreadystatechange = function(){}
        myRequest.open('POST' , 'like.php', 'true');
        myRequest.setRequestHeader("content-type","application/x-www-form-urlencoded");
        myRequest.send("action=del&id="+id);
  }else{
    $(this).addClass("like-active");
    id = $(this).data("like");
    count = parseInt($(this).next("span").text());
    $(this).next("span").text(count+1);

        myRequest = createRequest();
        // myRequest.onreadystatechange = function(){}
        myRequest.open('POST' , 'like.php', 'true');
        myRequest.setRequestHeader("content-type","application/x-www-form-urlencoded");
        myRequest.send("action=add&id="+id);

  }
});
//  End Button Like 
//  Start Form To Ctreat Comments 
$(".blog .comment-form").submit(function () {
  var myRequest = "";
  var desc   = document.getElementById("desc").value;
  var userid = document.getElementById("userid").value;
  var postid = document.getElementById("postid").value;

        myRequest = createRequest();
        myRequest.onreadystatechange = function(){
          var viewComments = document.getElementById("post-comments");
          if(this.readyState == 4 && this.status == 200){
            document.getElementById("desc").value = " ";
            viewComments.innerHTML = myRequest.responseText;
          }
        }
        myRequest.open('POST' , 'like.php', 'true');
        myRequest.setRequestHeader("content-type","application/x-www-form-urlencoded");
        myRequest.send("action=comment&desc="+desc+"&userid="+userid+"&postid="+postid);
  return false;
});

//  Start Form To Ctreat Comments 
$("#fomt-comm-list").submit(function () {
  var myRequest = "";

  var comment  = document.getElementById("usercomment").value;
  var userid   = document.getElementById("comm-user").value;
  var courseid = document.getElementById("comm-course").value;

        myRequest = createRequest();
        myRequest.onreadystatechange = function(){
          var viewComments = document.getElementById("comm-list");
          if(this.readyState == 4 && this.status == 200){
            viewComments.innerHTML = myRequest.responseText;
          }
        }
        myRequest.open('POST' , 'like.php', 'true');
        myRequest.setRequestHeader("content-type","application/x-www-form-urlencoded");
        myRequest.send("action=comm-list&comment="+comment+"&userid="+userid+"&courseid="+courseid);
  return false;
});

//  End Form To Ctreat Comments 

//  Start Form To Ctreat Post 
$(".blog .blog-create-post").submit(function () {
  var myRequest = "";
  var userid    = document.getElementById("userid").value;
  var title     = document.getElementById("post-header").value;
  var cat       = document.getElementById("post-cat").value;
  var tags      = document.getElementById("input-tags").value;
  var desc      = document.getElementById("post-desc").value;

  
      myRequest = createRequest();
      myRequest.onreadystatechange = function(){
        var viewPosts = document.getElementById("view-post-search");
  
        if(this.readyState == 4 && this.status == 200){
          document.getElementById("userid").value = "";
          document.getElementById("post-header").value = "";
          document.getElementById("input-tags").value = "";
          document.getElementById("post-desc").value = "";
          viewPosts.innerHTML = myRequest.responseText;
          $(".msg_aprove").slideDown(500).delay(3000).slideUp(500);
        }
      }
      myRequest.open('POST' , 'like.php', 'true');
      myRequest.setRequestHeader("content-type","application/x-www-form-urlencoded");
      // myRequest.setRequestHeader("enctype","multipart/form-data");
      myRequest.send("action=post"+
                      "&userid="+userid+
                      "&post-header="+title+
                      "&post-cat="+cat+
                      "&post-tags="+tags+
                      "&post-desc="+desc);

return false;
});
//  End Form To Ctreat Post 

//===================================================================================================================================
//======================================================== End Blog Page
//===================================================================================================================================

//  Start Form To Ctreat Register Form 
$(".register-form #register-course-now").submit(function () {
  var myRequest  = "";
  var name       = document.getElementById("register-name").value;
  var email      = document.getElementById("register-email").value;
  var phone      = document.getElementById("register-phone").value;
  var subject    = document.getElementById("register-subject").value;
  var msg        = document.getElementById("register-msg").value;
  
      myRequest = createRequest();
      myRequest.onreadystatechange = function(){
        var viewError = document.getElementById("register-form-erorr");
  
        if(this.readyState == 4 && this.status == 200){
          document.getElementById("register-name").value = name;
          document.getElementById("register-email").value = email;
          document.getElementById("register-phone").value = phone;
          document.getElementById("register-subject").value = subject;
          document.getElementById("register-msg").value = msg;
          viewError.innerHTML = myRequest.responseText;
        }
      }
      myRequest.open('POST' , 'like.php', 'true');
      myRequest.setRequestHeader("content-type","application/x-www-form-urlencoded");
      myRequest.send("action=Register"+
                      "&name="+name+
                      "&email="+email+
                      "&phone="+phone+
                      "&subject="+subject+
                      "&msg="+msg);
    return false;
});
//  End Form To Ctreat Register Form

// Start To Search On Posts By Keys
$(".search-posts").keyup(function(){
  "use strict";
  var search_post = $(this).val();
  var myRequest = createRequest();
  myRequest.onreadystatechange = function(){
    var viewPosts = document.getElementById("view-post-search");

    if(this.readyState == 4 && this.status == 200){
      viewPosts.innerHTML = myRequest.responseText;
    }
  }
  myRequest.open('POST' , 'like.php', 'true');
  myRequest.setRequestHeader("content-type","application/x-www-form-urlencoded");
  myRequest.send("action=SearchPosts"+
                 "&key="+search_post);
});
// End To Search On Posts By Keys

// Start To Search On Posts By Cats
$(".cat-post").click(function(event){
  "use strict";
  event.preventDefault();
  if($(this).data("tag") != "a" ){
    $(this).addClass("active").parent().siblings("li").find("span").removeClass("active");
  }
  var id   = $(this).data("id");

  var myRequest = createRequest();
  myRequest.onreadystatechange = function(){
    var viewPosts = document.getElementById("view-post-search");

    if(this.readyState == 4 && this.status == 200){
      viewPosts.innerHTML = myRequest.responseText;
    }
  }
  myRequest.open('POST' , 'like.php', 'true');
  myRequest.setRequestHeader("content-type","application/x-www-form-urlencoded");
  myRequest.send("action=CatsPosts"+
                 "&id="+id);
              
});
// End To Search On Posts By Cats
/*
=====================================================================================================================================
                                                Start Profile Page
=====================================================================================================================================*/
// Buttom To View More Posts In Profile Page
$("#view-Courses").click(function () {
  var myRequest  = "";
  var userid     = document.getElementById("course-userid").value;
  
    myRequest = createRequest();
    myRequest.onreadystatechange = function(){
      var viewCourses = document.getElementById("ViewCourses");

      if(this.readyState == 4 && this.status == 200){
        viewCourses.innerHTML = myRequest.responseText;
      }
    }
    myRequest.open('POST' , 'like.php', 'true');
    myRequest.setRequestHeader("content-type","application/x-www-form-urlencoded");
    myRequest.send("action=moreCourses"+
                    "&userid="+userid);
    return false;
});
// Buttom To View More Posts In Profile Page

// Buttom To View More Posts In Profile Page
$("#view-posts").click(function () {
  var myRequest  = "";
  var userid     = document.getElementById("post-userid").value;
  
    myRequest = createRequest();
    myRequest.onreadystatechange = function(){
      var viewPosts = document.getElementById("profile-posts");

      if(this.readyState == 4 && this.status == 200){
        viewPosts.innerHTML = myRequest.responseText;
      }
    }
    myRequest.open('POST' , 'like.php', 'true');
    myRequest.setRequestHeader("content-type","application/x-www-form-urlencoded");
    myRequest.send("action=morePosts"+
                    "&userid="+userid);
    return false;
});
// Buttom To View More Posts In Profile Page

// Buttom To View More Posts In User Profile Page
$("#view-profile-posts").click(function () {
  var myRequest  = "";
  var userid     = document.getElementById("poster-userid").value;
  
    myRequest = createRequest();
    myRequest.onreadystatechange = function(){
      var viewPosts = document.getElementById("ProfilePosts");

      if(this.readyState == 4 && this.status == 200){
        viewPosts.innerHTML = myRequest.responseText;
      }
    }
    myRequest.open('POST' , 'like.php', 'true');
    myRequest.setRequestHeader("content-type","application/x-www-form-urlencoded");
    myRequest.send("action=AllPosts"+
                    "&userid="+userid);
    return false;
});
// Buttom To View More Posts In User Profile Page
/*
=====================================================================================================================================
                                                End Profile Page
=====================================================================================================================================*/

/*
=====================================================================================================================================
                                                Start Courses Page
=====================================================================================================================================*/
$(".cats ul li span").click(function(){
  $(this).addClass("active").parent().siblings("li").find("span").removeClass("active");
  var id = $(this).data("id");
  var myRequest  = "";  
  myRequest = createRequest();
  myRequest.onreadystatechange = function(){
    var ViewVideos = document.getElementById("ViewVideos");

    if(this.readyState == 4 && this.status == 200){
      ViewVideos.innerHTML = myRequest.responseText;
    }
  }
  myRequest.open('POST' , 'like.php', 'true');
  myRequest.setRequestHeader("content-type","application/x-www-form-urlencoded");
  myRequest.send("action=ViewVideos"+
                  "&id="+id);
});

$(".cats form .search-videos").keyup(function(){
  "use strict";
  var search_videos = $(this).val();
  var myRequest = createRequest();
  myRequest.onreadystatechange = function(){
    var ViewVideos = document.getElementById("ViewVideos");

    if(this.readyState == 4 && this.status == 200){
      ViewVideos.innerHTML = myRequest.responseText;
    }
  }
  myRequest.open('POST' , 'like.php', 'true');
  myRequest.setRequestHeader("content-type","application/x-www-form-urlencoded");
  myRequest.send("action=ViewVideosKey"+
                 "&key="+search_videos);

});

$(".single-tag").click(function(){
  "use strict";
  var tag = $(this).text();
  console.log(tag);
  var myRequest = createRequest();
  myRequest.onreadystatechange = function(){
    var ViewVideos = document.getElementById("ViewVideos");

    if(this.readyState == 4 && this.status == 200){
      ViewVideos.innerHTML = myRequest.responseText;
    }
  }
  myRequest.open('POST' , 'like.php', 'true');
  myRequest.setRequestHeader("content-type","application/x-www-form-urlencoded");
  myRequest.send("action=ViewVideosTag"+
                 "&tag="+tag);
});
/*
=====================================================================================================================================
                                                End Courses Page
=====================================================================================================================================*/

/*
=====================================================================================================================================
                                                Start Video Play Page
=====================================================================================================================================*/
$("#comment-video").submit(function(){
  var user      = $("#comment-video .userid").val();
  var video     = $("#comment-video .videoid").val();
  var course    = $("#comment-video .courseid").val();
  var comment   = $("#comment-video textarea").val();

  var myRequest = createRequest();
  myRequest.onreadystatechange = function(){
    var ViewComment = document.getElementById("video-comment");

    if(this.readyState == 4 && this.status == 200){
      ViewComment.innerHTML = myRequest.responseText;
    }
  }
  myRequest.open('POST' , 'like.php', 'true');
  myRequest.setRequestHeader("content-type","application/x-www-form-urlencoded");
  myRequest.send("action=commentVideo"+
                 "&userid="+user+
                 "&videoid="+video+
                 "&courseid="+course+
                 "&comment="+comment);
  return false;
});
/*
=====================================================================================================================================
                                                End Video Play Page
=====================================================================================================================================*/


$("#option input").change(function(){
  var name = $(this).data("name");
  var color = $(this).val();
  if($(this).data("place") == "bg"){
    $(name).css({
      "background-color": color,});
  }
});

$("#option input").change(function(){
  var name = $(this).data("name");
  var color = $(this).val();
  if($(this).data("place") == "color"){
    $(name).css({
                "color": color,});
  }
});

});