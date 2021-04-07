<?php
include "connection.php";
$action = isset($_POST["action"]) ? $_POST["action"] : "";

if($action == "add"){

   $post_id = $_POST["id"];
   $stmt = $conn->prepare("SELECT Post_Like From posts WHERE `PostID` = ?");
   $stmt->execute(array($post_id));
   $result = $stmt->fetch();
   $count = $result["Post_Like"];

   $stmt = $conn->prepare("UPDATE `posts` SET `Post_Like` = ? WHERE `PostID` = ?");
   $stmt->execute(array($count+1,$post_id));
   echo $count+1;


}elseif($action == "del"){


   $post_id = $_POST["id"];
   $stmt = $conn->prepare("SELECT Post_Like From posts WHERE `PostID` = ?");
   $stmt->execute(array($post_id));
   $result = $stmt->fetch();
   $count = $result["Post_Like"];

   $stmt = $conn->prepare("UPDATE `posts` SET `Post_Like` = ? WHERE `PostID` = ?");
   $stmt->execute(array($count-1,$post_id));
   echo $count-1;

}elseif($action == "comment"){
   $desc = $_POST["desc"];
   $user = $_POST["userid"];
   $post = $_POST["postid"];
   $stmt = $conn->prepare("INSERT INTO `post_comments`(`Post_Comment_Desc`, `Post_Comment_Date`, `User_ID`, `Post_ID`) 
                           VALUES (? , now() , ? , ?)");
   $stmt->execute(array($desc,$user,$post));
   
   $stmt = $conn->prepare("SELECT post_comments.*, users.UserName, users.UserImage FROM post_comments
                           INNER JOIN users ON users.UserID = post_comments.User_ID
                           WHERE Post_ID = ?
                           ORDER BY Post_Comment_Date DESC");
   $stmt->execute(array($post));
   $comments = $stmt->fetchAll();
   foreach($comments as $comment):
   ?>
<!-- Start Signle Comment -->
<div class="single-comment">   <!-- Start DIV Class [ Single - Comment ] -->

   <div class="comment-header">   <!-- Start DIV Class [ Header - Comment ] -->
      <div class="row">   <!-- Start [ ROW ] -->
         <div class="col-2 pr-0 text-center">
            <img src="<?= $comment['UserImage'];?>">
         </div>
         <div class="col-9 pl-0 pt-2">
            <p><?= $comment["UserName"];?></p>
            <p class="date">on <?= date('l j F Y', strtotime($comment["Post_Comment_Date"])); ?></p>
         </div>
      </div>   <!-- End [ ROW ] -->
   </div>   <!-- End DIV Class [ Header - Comment ] -->

   <div class="comment-body pb-3">   <!-- Start DIV Class [ Body - Comment ] -->
      <p><?= $comment["Post_Comment_Desc"] ?></p>
   </div>   <!-- End DIV Class [ Body - Comment ] -->

</div>   <!-- End DIV Class [ Single - Comment ] -->
<!-- End Signle Comment -->
   <?php
   endforeach;

}elseif($action == "post"){
   $userid = $_POST["userid"];
   $stmt = $conn->prepare("SELECT * FROM users WHERE UserID = ?");
   $stmt->execute(array($userid));
   $result = $stmt->fetch();

   $approve = $result['Admin'] == 1 ? 1 : 0;
   $header          = filter_var($_POST["post-header"] , FILTER_SANITIZE_STRING);
   $cat             = filter_var($_POST["post-cat"] , FILTER_SANITIZE_STRING);
   $tags            = filter_var($_POST["post-tags"] , FILTER_SANITIZE_STRING);
   $desc            = filter_var($_POST["post-desc"] , FILTER_SANITIZE_STRING);

   $stmt = $conn->prepare("INSERT INTO `posts`
                  (`Post_Title`, `Post_Description`, `Post_Tags`, `Post_Date`, `User_ID`, `Cat_ID`, `Post_Approve`) VALUES (? , ? , ? , now() , ? , ? , ?)");
   $stmt->execute(array($header, $desc, $tags,$userid,$cat,$approve));
   $count = $stmt->rowCount();

   $stmt = $conn->prepare("SELECT posts.*, users.UserName, users.UserImage, categories.Name FROM posts
                        INNER JOIN users ON users.UserID = posts.User_ID
                        INNER JOIN categories ON categories.ID = posts.Cat_ID
                        WHERE posts.Post_Approve = 1
                        ORDER BY `PostID` DESC");
   $stmt->execute();
   $posts = $stmt->fetchAll();
   if($approve == 0){
     echo "<div class='msg_aprove'>Waiting Admin To Approve The Post ...</div>";
   }
foreach($posts as $post):
      ?>
      <!-- Start Single Post -->
        <div class="card my-4 blog-share-posts"> <!-- Start Div Class Bootstrap [ Card ] -->
          <div class="card-header">
              <div class="row">
                <div class="col-2">
                  <img width="100%" height="60px" src="<?= $post["UserImage"];?>">
                </div>
                <div class="col-10">
                  <p>
                      <a class="name" href="#"> <?= $post["UserName"]; ?> </a>
                      <span class="float-right">on <?= date('l j F Y', strtotime($post["Post_Date"])); ?></span> 
                  </p>
                  <p>
                    <span>category / <a class="cat-post cat" data-id="<?= $post["Cat_ID"];?>" href="#"><?= $post["Name"]; ?></a> </span>
                    <?php
                        $tags = explode(',',$post['Post_Tags']);
                        if(!empty($post['Post_Tags'])){
                          echo "<span class='float-right'>Tags / ";
                          foreach ($tags as $tag) :
                            echo '<a class="cat" href="#">'.$tag.'</a>';
                          endforeach;
                          echo "</span>";
                        }
                      ?>
                  </p>
                </div>
              </div>
          </div>
          <div class="card-body"> <!-- Start Div Class Bootstrap [ card-body ] -->
                <div class="card-body-title">
                  <p><?= $post["Post_Title"]; ?></p>
                </div>
                <p>
                    <?php if(strlen($post["Post_Description"]) > 180){
                      echo Substr($post['Post_Description'] , 0 , 170);
                      echo "<a class='read-more' href='full-post.php?post=".$post["PostID"]."'> ... Read More</a>";
                    }else{
                      echo $post['Post_Description'];
                    }
                    ?> 
                </p>
                <div class="post-btns">
                  <div class="row">
                    <div class="col-4">
                        <?php if(isset($_SESSION["user"])){ ?>
                            <p data-like="<?= $post["PostID"]; ?>" class="post-like"> <i class="far fa-thumbs-up fa-fw"></i> Like </p>
                            <span id="count"><?= $post["Post_Like"]; ?></span>
                        <?php }else{?>
                            <p> <a href="login.php"> <i class="far fa-thumbs-up fa-fw"></i> Like </a></p>
                            <span><?= $post["Post_Like"]; ?></span>
                        <?php }?>
                    </div>
                    <div class="col-4">
                        <p class="post-comment"> <a href="full-post.php?post=<?= $post['PostID']; ?>"> <i class="fa fa-comment fa-fw"></i> Comment </a> </p>
                        <span>
                          <?php
                            $stmt = $conn->prepare("SELECT * FROM post_comments WHERE `Post_ID` = ?");
                            $stmt->execute(array($post["PostID"]));
                            $count = $stmt->rowCount();
                            echo $count;
                          ?>
                        </span>
                    </div>
                    <div class="col-4">
                        <p class="post-share"> <i class="fa fa-share fa-fw"></i> Share </p>
                        <span>4</span>
                    </div>
                  </div>
              </div>
          </div> <!-- End Div Class Bootstrap [ card-body ] -->
        </div> <!-- End Div Class Bootstrap [ Card ] -->
      <!-- End Single Post -->
<?php endforeach;?>


<?php
// For Search In Blog Page
}elseif($action == "SearchPosts"){
  $key = FILTER_VAR($_POST["key"] , FILTER_SANITIZE_STRING);
  $query = ! empty($key) ? "AND Post_Title LIKE '%" . $key . "%'" : "";
  $stmt = $conn->prepare("SELECT posts.*, users.UserName, users.UserImage, categories.Name FROM posts
                          INNER JOIN users ON users.UserID = posts.User_ID
                          INNER JOIN categories ON categories.ID = posts.Cat_ID
                          WHERE posts.Post_Approve = 1 AND Post_Title LIKE '%$key%'
                          ORDER BY `PostID` DESC");
  $stmt->execute();
  $posts = $stmt->fetchAll();
  if(! empty($posts)){
  foreach($posts as $post):
?>
<!-- Start Single Post -->
<div class="card my-4 blog-share-posts"> <!-- Start Div Class Bootstrap [ Card ] -->
    <div class="card-header">
        <div class="row">
          <div class="col-2">
            <img width="100%" height="60px" src="<?= $post["UserImage"];?>">
          </div>
          <div class="col-10">
            <p>
                <a class="name" href="#"> <?= $post["UserName"]; ?> </a>
                <span class="float-right">on <?= date('l j F Y', strtotime($post["Post_Date"])); ?></span> 
            </p>
            <p>
              <span>category / <a class="cat cat-post" data-id="<?= $post["Cat_ID"];?>" href="#"><?= $post["Name"]; ?></a> </span>
              <?php
                  $tags = explode(',',$post['Post_Tags']);
                  if(!empty($post['Post_Tags'])){
                    echo "<span class='float-right'>Tags / ";
                    foreach ($tags as $tag) :
                      echo '<a class="cat" href="#">'.$tag.'</a>';
                    endforeach;
                    echo "</span>";
                  }
                ?>
            </p>
          </div>
        </div>
    </div>
    <div class="card-body"> <!-- Start Div Class Bootstrap [ card-body ] -->
          <div class="card-body-title">
            <p><?= $post["Post_Title"]; ?></p>
          </div>
          <p>
              <?php if(strlen($post["Post_Description"]) > 180){
                echo Substr($post['Post_Description'] , 0 , 170);
                echo "<a class='read-more' href='full-post.php?post=".$post["PostID"]."'> ... Read More</a>";
              }else{
                echo $post['Post_Description'];
              }
              ?> 
          </p>
          <div class="post-btns">
            <div class="row">
              <div class="col-4">
                  <?php if(isset($_SESSION["user"])){ ?>
                      <p data-like="<?= $post["PostID"]; ?>" class="post-like"> <i class="far fa-thumbs-up fa-fw"></i> Like </p>
                      <span id="count"><?= $post["Post_Like"]; ?></span>
                  <?php }else{?>
                      <p> <a href="login.php"> <i class="far fa-thumbs-up fa-fw"></i> Like </a></p>
                      <span><?= $post["Post_Like"]; ?></span>
                  <?php }?>
              </div>
              <div class="col-4">
                  <p class="post-comment"> <a href="full-post.php?post=<?= $post['PostID']; ?>"> <i class="fa fa-comment fa-fw"></i> Comment </a> </p>
                  <span>
                    <?php
                      $stmt = $conn->prepare("SELECT * FROM post_comments WHERE `Post_ID` = ?");
                      $stmt->execute(array($post["PostID"]));
                      $count = $stmt->rowCount();
                      echo $count;
                    ?>
                  </span>
              </div>
              <div class="col-4">
                  <p class="post-share"> <i class="fa fa-share fa-fw"></i> Share </p>
                  <span>4</span>
              </div>
            </div>
        </div>
    </div> <!-- End Div Class Bootstrap [ card-body ] -->
  </div> <!-- End Div Class Bootstrap [ Card ] -->
<!-- End Single Post -->
<?php 
  endforeach; 
  }else{
    echo "<h3 class='post-request-msg'>No Posts By This Text</h3>";
  }
// For Search In Blog Page By Catigories
}elseif($action == "CatsPosts"){
  $id = $_POST["id"];
  $query = $id == 0 ? "" : "AND Cat_ID = ?";
  $stmt = $conn->prepare("SELECT posts.*, users.UserName, users.UserImage, categories.Name FROM posts
                          INNER JOIN users ON users.UserID = posts.User_ID
                          INNER JOIN categories ON categories.ID = posts.Cat_ID
                          WHERE posts.Post_Approve = 1 $query
                          ORDER BY `PostID` DESC");
  $stmt->execute(array($id));
  $posts = $stmt->fetchAll();
  if(! empty($posts)){
  foreach($posts as $post):
?>
<!-- Start Single Post -->
<div class="card my-4 blog-share-posts"> <!-- Start Div Class Bootstrap [ Card ] -->
    <div class="card-header">
        <div class="row">
          <div class="col-2">
            <img width="100%" height="60px" src="<?= $post["UserImage"];?>">
          </div>
          <div class="col-10">
            <p>
                <a class="name" href="#"> <?= $post["UserName"]; ?> </a>
                <span class="float-right">on <?= date('l j F Y', strtotime($post["Post_Date"])); ?></span> 
            </p>
            <p>
              <span>category / <a class="cat cat-post" data-id="<?= $post['Cat_ID'];?>" href=""><?= $post["Name"]; ?></a> </span>
              <?php
                  $tags = explode(',',$post['Post_Tags']);
                  if(!empty($post['Post_Tags'])){
                    echo "<span class='float-right'>Tags / ";
                    foreach ($tags as $tag) :
                      echo '<a class="cat" href="#">'.$tag.'</a>';
                    endforeach;
                    echo "</span>";
                  }
                ?>
            </p>
          </div>
        </div>
    </div>
    <div class="card-body"> <!-- Start Div Class Bootstrap [ card-body ] -->
          <div class="card-body-title">
            <p><?= $post["Post_Title"]; ?></p>
          </div>
          <p>
              <?php if(strlen($post["Post_Description"]) > 180){
                echo Substr($post['Post_Description'] , 0 , 170);
                echo "<a class='read-more' href='full-post.php?post=".$post["PostID"]."'> ... Read More</a>";
              }else{
                echo $post['Post_Description'];
              }
              ?> 
          </p>
          <div class="post-btns">
            <div class="row">
              <div class="col-4">
                  <?php if(isset($_SESSION["user"])){ ?>
                      <p data-like="<?= $post["PostID"]; ?>" class="post-like"> <i class="far fa-thumbs-up fa-fw"></i> Like </p>
                      <span id="count"><?= $post["Post_Like"]; ?></span>
                  <?php }else{?>
                      <p> <a href="login.php"> <i class="far fa-thumbs-up fa-fw"></i> Like </a></p>
                      <span><?= $post["Post_Like"]; ?></span>
                  <?php }?>
              </div>
              <div class="col-4">
                  <p class="post-comment"> <a href="full-post.php?post=<?= $post['PostID']; ?>"> <i class="fa fa-comment fa-fw"></i> Comment </a> </p>
                  <span>
                    <?php
                      $stmt = $conn->prepare("SELECT * FROM post_comments WHERE `Post_ID` = ?");
                      $stmt->execute(array($post["PostID"]));
                      $count = $stmt->rowCount();
                      echo $count;
                    ?>
                  </span>
              </div>
              <div class="col-4">
                  <p class="post-share"> <i class="fa fa-share fa-fw"></i> Share </p>
                  <span>4</span>
              </div>
            </div>
        </div>
    </div> <!-- End Div Class Bootstrap [ card-body ] -->
  </div> <!-- End Div Class Bootstrap [ Card ] -->
<!-- End Single Post -->
<?php 
  endforeach; 
  }else{
    echo "<h3 class='post-request-msg'>No Posts In This Catigory</h3>";
  }


// For Register In Form Contact
}elseif($action == "Register"){
  $name    = FILTER_var( $_POST["name"] , FILTER_SANITIZE_STRING );
  $email   = filter_var( $_POST["email"] , FILTER_SANITIZE_EMAIL );
  $phone   = FILTER_var( $_POST["phone"] , FILTER_SANITIZE_NUMBER_INT );
  $msg     = FILTER_var( $_POST["msg"] , FILTER_SANITIZE_STRING );
  $subject = $_POST["subject"];

  if(strlen($name) < 4){
    $errors[] = "The User Name Must Be More Than 4 Letters..";
  }
  if(strlen($name) > 20){
    $errors[] = "The User Name Must Be Less Than 20 Letters..";
  }
  if(empty($email)){
    $errors[] = "Please Write Your Email..";
  }
  if(strlen($phone) != 11){
    $errors[] = "Your Phone Number Must Be Equal 11 Numbers..";
  }
  if(strlen($msg) < 4){
    $errors[] = "Your Message Must Be More Than 10 Letters..";
  }
  if($subject == 0){
    $errors[] = "Please Select The Subject Are You Want..";
  }
  if(strlen($msg) > 200){
    $errors[] = "Your Message Must Be Less Than 200 Letters..";
  }
  $headers = "Form: " . $email . "\r\n";
  $sub     = "Contact Form";
  if(empty($errors)){
    echo "<span class='msg-success'>Success,Please Open Your Mail and Check The Message..</span>";
    // mail("mahmoud.mohammed050684@gmail.com", $sub, $msg, $headers);
  }else{
    foreach ($errors as $error) {
      echo "<span class='msg-errors'>" . $error . "</span>";
    }
  }
//===================================== Vewi More Courses In Page Profile
}elseif($action == "moreCourses"){
  $userid = $_POST["userid"];
?>
  <div class="row"> <!-- Start Div Class [ Row ] -->
  <?php
    $stmt = $conn->prepare("SELECT courses.*, users.UserName, comments.Course_ID AS CourseID FROM `courses`
                            INNER JOIN users ON users.UserID = courses.User_ID
                            INNER JOIN comments ON comments.Course_ID = courses.Course_ID
                            WHERE courses.User_ID = ?");
    $stmt->execute(array($userid));
    $courses = $stmt->fetchAll();
      if(empty($courses)){
        echo "<h3 class='text-center'> Sorry No Courses To Display IT !! </h3>";
      }else{
        foreach ($courses as $course): 
            $tags = explode(',',$course['Tags']);
            $stmt = $conn->prepare("SELECT count(Comment) FROM comments WHERE Course_ID = ?");
            $stmt->execute(array($course["Course_ID"]));
            $rows = $stmt->fetchColumn();
          ?>
          <div class="col-12 col-lg-4 mb-4">  <!--  Start Grid DIV  -->
            <div class="card"> <!--  Start card DIV  -->
              <div class="card-price-img">
                  <span class="approve <?php if($course['Approve'] != 0){ echo "d-none"; } ?>">Waiting For Approval</span>
                  <img class="card-img-top" src="<?php echo $course['Img']; ?>" alt="Card image cap">
                  <div class="price">
                        <span> <?php $price = ($course['Price'] == 0) ? "FREE" : "$".$course['Price']; echo $price ?></span>
                  </div>
              </div>

              <div class="card-block"> <!--  Start card-block DIV  -->
                  <h4 class="card-title">
                    <a href='course.php?courseid=<?= $course["Course_ID"];?>'><?= $course['Name'];?></a>
                    <span class="date"> <i class="far fa-clock"></i> <?php echo $course['Add-Date']; ?></span>
                  </h4>
                  <div class="card-text">
                      <h5 class="desc"> <i class="fa fa-pen-nib"></i> Description:</h5>
                      <p> <?php echo $course['Course_Describe']; ?> </p>
                  </div>
                  <div class="card-footer">
                      <div class="row">
                      <div class="student col-6 pr-0">
                            <span> <i class="fa fa-graduation-cap"></i> <?php echo $course['Registered']; ?>  Student</span>
                        </div>
                        <div class="student col-3 p-0">
                            <span> <i class="fa fa-comments"></i> <?php echo $rows; ?> </span>
                        </div>
                        <div class="rating col-3 pl-0 text-right">
                            <span><?php for($i = 1;$i<=$course['Rating'];$i++){ echo "<i class='fa fa-star'></i>" ;} if($course['Rating'] == 0){echo "0 Rating";} ?> </span>
                        </div>
                      </div>
                  </div>
                  <div class="tags col-12"> <!--  Start Tags DIV  -->
                      <span> <i class="fa fa-tags"></i>
                          <?php
                                if(!empty($course['Tags'])){
                                  foreach ($tags as $tag) {
                                    echo '<a href="all-course.php?filter=Tag&name='. $tag .'"> '. strtoupper($tag) .' </a>';
                                  }
                                }else{
                                    echo "<span>NO Tags</span>";
                                }
                          ?>
                      </span>
                  </div> <!--  End Tags DIV  -->
              </div> <!--  End card-block DIV  -->

              <a href="course-details.php?courseid=<?php echo $course['Course_ID']; ?>" class="info">More Information</a>
            </div> <!--  End card DIV  -->
          </div>  <!--  End Grid DIV  -->
          <?php
              endforeach;
              }
          ?>
      </div> <!-- End Div Class [ Row ] -->





<?php
//===================================== Vewi More Courses In Page Profile
}elseif($action == "morePosts"){
  $userid = $_POST["userid"];
?>
<div class="row"> <!-- Start Div Class [ Row ] -->
          <?php
              $stmt = $conn->prepare("SELECT posts.*, users.UserName, users.UserImage, categories.Name FROM posts
                                      INNER JOIN users ON users.UserID = posts.User_ID
                                      INNER JOIN categories ON categories.ID = posts.Cat_ID
                                      WHERE User_ID = ?
                                      ORDER BY `PostID` DESC");
              $stmt->execute(array($userid));
              $posts = $stmt->fetchAll();
              $count = $stmt->rowCount();
              foreach($posts as $post) :
          ?>
          <div class="col-4">
            <div class="post">
              <div class="card">
                <div class="card-header pt-0 pb-0 pr-0 pl-0"> <img width="100%" src="<?= $post['Post_File'];?>"> </div>
                <div class="card-body pt-0">
                  <span>on <?= date('l j F Y', strtotime($post["Post_Date"])); ?></span>
                  <h5> <a href="full-post.php?post=<?= $post["PostID"];?>"> <?= $post["Post_Title"];?> </a> </h5>
                  <span class="post-approve <?php if($post['Approve'] != 0){ echo "d-none"; } ?>">Waiting For Approve</span>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div> <!-- End Div Class [ Row ] -->
<?php
}elseif($action == "AllPosts"){
  $userid = $_POST["userid"];
  $stmt = $conn->prepare("SELECT posts.*, users.UserName, users.UserImage, categories.Name FROM posts
                          INNER JOIN users ON users.UserID = posts.User_ID
                          INNER JOIN categories ON categories.ID = posts.Cat_ID
                          WHERE User_ID = ? AND Post_Approve = 1
                          ORDER BY `PostID` DESC");
  $stmt->execute(array($userid));
  $posts = $stmt->fetchAll();
  $count = $stmt->rowCount();
?>
<div class="card post mb-4"> <!-- Start Card Bootstrap Class [ Card ] -->
  <div class="card-header"> <!-- Start Card-header Bootstrap Class [ Header ] -->
      <i class='fa fa-book-reader fa-fw'></i> All Posts
  </div> <!-- End Card-header Bootstrap Class [ Header ] -->

  <div class="card-body" id="profile-posts"> <!-- Start Card-Body Bootstrap Class [ Body ] -->
    <div class="row"> <!-- Start Div Class [ Row ] -->
      <?php foreach($posts as $post) : ?>
      <div class="col-4">
        <div class="post mb-4">
          <div class="card">
            <div class="card-header pt-0 pb-0 pr-0 pl-0"> <img width="100%" src="<?= $post['Post_File'];?>"> </div>
            <div class="card-body pt-0">
              <span>on <?= date('l j F Y', strtotime($post["Post_Date"])); ?></span>
              <h5> <a href="full-post.php?post=<?= $post["PostID"];?>"> <?= $post["Post_Title"];?> </a> </h5>
              <span class="post-approve <?php if($post['Post_Approve'] == 1){ echo "d-none"; } ?>">Waiting For Approve</span>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div> <!-- End Div Class [ Row ] -->
  </div> <!-- End Card-Body Bootstrap Class [ Body ] -->
</div> <!--  End card DIV  -->
<?php
/*
=====================================================================================================================================
                                                Start Courses Page
=====================================================================================================================================*/

}elseif($action == "ViewVideos"){
  $id = $_POST["id"];
  $query = $id == 0 ? "" : "AND Cat_ID = ?";
  $stmt = $conn->prepare("SELECT video_list.*, users.UserName, courses.Tags, courses.Approve FROM video_list
                          INNER JOIN courses ON courses.Course_ID = video_list.Course_ID
                          INNER JOIN users ON users.UserID = video_list.User_ID
                          WHERE courses.Approve = 1 $query");
  $stmt->execute(array($id));
  $list = $stmt->fetchAll();
  if(! empty($list)){
    echo "<div class='row'>";
    foreach($list as $item):
      $tags = explode(',',$item['Tags']);
?>
      <div class="col-md-3"> <!-- Start Div Class Bootstrap [ COL - 3 ] -->
          <div class="single-video mb-3"> <!-- Start Div Class [ Single - Video ] -->

            <div class="preview"> <!-- Start Div Class [ Preview ] -->
                <a href="video-play.php?<?php echo "courseid=".$item["Course_ID"]."&videoid=".$item["Video_ID"];?>">
                    <video width="100%">
                      <source src="<?php echo $item["Video_Src"]; ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </a>
            </div> <!-- End Div Class [ Preview ] -->

            <div class="data"> <!-- Start Div Class [ Date ] -->
                <div class="date">
                    <a class="float-left name" href="userprofile.php?userid=<?php echo $item['User_ID']; ?>"><?php echo $item["UserName"]; ?></a>
                    <span><?php echo $item["Video_Date"]; ?></span> 
                </div>
                <h3>
                    <a href="video-play.php?<?php echo "courseid=".$item["Course_ID"]."&videoid=".$item["Video_ID"];?>"><?php echo $item["Video_Desc"]; ?> </a> 
                </h3>
                <div class="tags"> <!--  Start Tags DIV  -->
                  <p> <i class="fa fa-tags"></i>
                      <?php
                          if(!empty($item['Tags'])){
                          foreach ($tags as $tag) {
                            echo '<span class="single-tag"> '. strtoupper($tag) .' </span>';
                          }
                          }else{
                            echo "<i>NO Tags</i>";
                          }
                      ?>
                  </p>
                </div> <!--  End Tags DIV  -->
            </div> <!-- End Div Class [ Date ] -->
          </div> <!-- End Div Class [ Single - Video ] -->
      </div> <!-- End Div Class Bootstrap [ COL - 3 ] -->

<?php
    endforeach;
    echo "</div>";
  }else{
    echo "<h3 class='videos-msg'>No Videos In This Catigory</h3>";
  }
}elseif($action == "ViewVideosKey"){
  $key = $_POST["key"];
  $query = ! empty($key) ? "AND Video_Desc LIKE '%" . $key . "%'" : "";
  $stmt = $conn->prepare("SELECT video_list.*, users.UserName, courses.Tags, courses.Approve FROM video_list
                          INNER JOIN courses ON courses.Course_ID = video_list.Course_ID
                          INNER JOIN users ON users.UserID = video_list.User_ID
                          WHERE courses.Approve = 1 $query
                          ORDER BY `Video_ID` DESC");
  $stmt->execute(array($key));
  $list = $stmt->fetchAll();
  if(! empty($list)){
    echo "<div class='row'>";
    foreach($list as $item):
      $tags = explode(',',$item['Tags']);
?>
      <div class="col-md-3"> <!-- Start Div Class Bootstrap [ COL - 3 ] -->
          <div class="single-video mb-3"> <!-- Start Div Class [ Single - Video ] -->

            <div class="preview"> <!-- Start Div Class [ Preview ] -->
                <a href="video-play.php?<?php echo "courseid=".$item["Course_ID"]."&videoid=".$item["Video_ID"];?>">
                    <video width="100%">
                      <source src="<?php echo $item["Video_Src"]; ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </a>
            </div> <!-- End Div Class [ Preview ] -->

            <div class="data"> <!-- Start Div Class [ Date ] -->
                <div class="date">
                    <a class="float-left name" href="userprofile.php?userid=<?php echo $item['User_ID']; ?>"><?php echo $item["UserName"]; ?></a>
                    <span><?php echo $item["Video_Date"]; ?></span> 
                </div>
                <h3>
                    <a href="video-play.php?<?php echo "courseid=".$courseid."&videoid=".$item["Video_ID"];?>"><?php echo $item["Video_Desc"]; ?> </a> 
                </h3>
                <div class="tags"> <!--  Start Tags DIV  -->
                  <p> <i class="fa fa-tags"></i>
                      <?php
                          if(!empty($item['Tags'])){
                          foreach ($tags as $tag) {
                            echo '<span class="single-tag"> '. strtoupper($tag) .' </span>';
                          }
                          }else{
                            echo "<i>NO Tags</i>";
                          }
                      ?>
                  </p>
                </div> <!--  End Tags DIV  -->
            </div> <!-- End Div Class [ Date ] -->
          </div> <!-- End Div Class [ Single - Video ] -->
      </div> <!-- End Div Class Bootstrap [ COL - 3 ] -->
<?php
    endforeach;
  echo "</div>";
  }else{
    echo "<h3 class='videos-msg'>No Videos In This Catigory</h3>";
  }
//  Search To Videos By Tags In Courses Page
}elseif($action == "ViewVideosKey"){
  $tag   = FILTER_var( $_POST["tag"] , FILTER_SANITIZE_STRING );
  $stmt  = $conn->prepare("SELECT video_list.*, users.UserName, courses.Tags, courses.Approve FROM video_list
                          INNER JOIN courses ON courses.Course_ID = video_list.Course_ID
                          INNER JOIN users ON users.UserID = video_list.User_ID
                          WHERE courses.Approve = 1 AND Tags LIKE '%$tag%'
                          ORDER BY `Video_ID` DESC");
  $stmt->execute();
  $list = $stmt->fetchAll();
  if(! empty($list)){
    echo "<div class='row'>";
    foreach($list as $item):
      $tags = explode(',',$item['Tags']);
?>
      <div class="col-md-3"> <!-- Start Div Class Bootstrap [ COL - 3 ] -->
          <div class="single-video mb-3"> <!-- Start Div Class [ Single - Video ] -->

            <div class="preview"> <!-- Start Div Class [ Preview ] -->
                <a href="video-play.php?<?php echo "courseid=".$courseid."&videoid=".$item["Video_ID"];?>">
                    <video width="100%">
                      <source src="<?php echo $item["Video_Src"]; ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </a>
            </div> <!-- End Div Class [ Preview ] -->

            <div class="data"> <!-- Start Div Class [ Date ] -->
                <div class="date">
                    <a class="float-left name" href="userprofile.php?userid=<?php echo $item['User_ID']; ?>"><?php echo $item["UserName"]; ?></a>
                    <span><?php echo $item["Video_Date"]; ?></span> 
                </div>
                <h3>
                    <a href="video-play.php?<?php echo "courseid=".$item["Course_ID"]."&videoid=".$item["Video_ID"];?>"><?php echo $item["Video_Desc"]; ?> </a> 
                </h3>
                <div class="tags"> <!--  Start Tags DIV  -->
                  <p> <i class="fa fa-tags"></i>
                      <?php
                          if(!empty($item['Tags'])){
                          foreach ($tags as $tag) {
                            echo '<span class="single-tag"> '. strtoupper($tag) .' </span>';
                          }
                          }else{
                            echo "<i>NO Tags</i>";
                          }
                      ?>
                  </p>
                </div> <!--  End Tags DIV  -->
            </div> <!-- End Div Class [ Date ] -->
          </div> <!-- End Div Class [ Single - Video ] -->
      </div> <!-- End Div Class Bootstrap [ COL - 3 ] -->
<?php
    endforeach;
  echo "</div>";
  }else{
    echo "<h3 class='videos-msg'>No Videos By Tags</h3>";
  }
// View Videos By Tags
}elseif($action == "ViewVideosTag"){

$tag = $_POST["tag"];
echo $tag;


/*
=====================================================================================================================================
                                                End Courses Page
=====================================================================================================================================*/
}elseif($action == "commentVideo"){
  $user    = $_POST["userid"];
  $video   = $_POST["videoid"];
  $course  = $_POST["courseid"];
  $comment = FILTER_var( $_POST["comment"] , FILTER_SANITIZE_STRING );

  $stmt = $conn->prepare("INSERT INTO `comments`
                                  ( `Comment`, `Comment_Date`, `Course_ID`, `User_ID`, `Video_List_ID`)
                                  VALUES (?, now(), ?, ?, ?)");
  $stmt->execute(array($comment, $course, $user, $video));

  if($stmt){  ?>

    <h3><i class="fa fa-comments"></i> Comments</h3>
    <?php
    $stmt = $conn->prepare("SELECT comments.* , users.UserName, users.UserImage FROM comments
                            INNER JOIN users ON users.UserID = comments.User_ID
                            WHERE Video_List_ID = ?
                            ORDER BY comments.Comment_Date DESC");
    $stmt->execute(array($video));
    $comments = $stmt->fetchAll();
    if(!empty($comments)){
      foreach ($comments as $comment) :
    ?>
      <div class="comment-list">
          <div class="row">
              <div class="col-3 pr-2">
                  <img src="<?php echo $comment['UserImage']; ?>">
              </div>
              <div class="col-9 pl-2">
                  <div class="title">
                    <a class="name" href="userprofile.php?userid=<?php echo $comment['User_ID']; ?>"> <?php echo $comment['UserName']; ?></a>
                    <span class="date"> on <?php echo $comment['Comment_Date']; ?></span>
                  </div>
                  <div class="body-comment">
                    <p> <?php echo $comment['Comment']; ?> </p>
                  </div>
              </div>
          </div>
      </div>
<?php endforeach; ?>

										<!-- End Comments -->

            <div class="add_comment_container">
                <form id="comment-video" class="pl-4 pr-4 mt-3" action="<?php echo $_SERVER['PHP_SELF']."?courseid=".$courseid."&videoid=".$videoid ;?>" method="POST">
                    <textarea name="usercomment" class="input-group p-3" placeholder="Leave Your Comment" required></textarea>
                    <input type="text" hidden value="<?= $sessionUserID;?>" class="userid">
                    <input type="submit" hidden value="<?= $videoid;?>" class="videoid">
                    <input type="submit" hidden value="<?= $courseid;?>" class="courseid">
                    <input type="submit" value="Comment" class="btn btn-info mt-3">
                </form>
            </div>

 <?php       
      }
  }else{
      echo "SomeThing IS Wrong";
  }

/*
=====================================================================================================================================
                                                Start Course Details Page
=====================================================================================================================================*/
}elseif($action == "sell"){
  $user    = $_POST["userid"];
  $course  = $_POST["courseid"];

  $stmt = $conn->prepare("INSERT INTO `cart`(`User_ID`, `CourseID`, `Date`) VALUES (? , ? , now())");
  $stmt->execute(array($user , $course));
  if($stmt){
    $stmt = $conn->prepare("SELECT cart.*, courses.Name FROM cart
                            INNER JOIN courses ON courses.Course_ID = cart.CourseID
                            WHERE User_ID = ?");
    $stmt->execute(array($user));
    $rows = $stmt->fetchAll();
  }


}elseif($action == "comm-list"){
  $comment = filter_var($_POST["comment"], FILTER_SANITIZE_STRING);
  $user    = $_POST["userid"];
  $course  = $_POST["courseid"];

  $stmt_comment = $conn->prepare("INSERT INTO `course_comment`(`Comment`, `Date`, `Course_ID`, `User_ID`) VALUES (?, now(), ?, ?)");
  $stmt_comment->execute(array($comment, $course, $user));

  $stmt = $conn->prepare("SELECT course_comment.*, users.UserName, users.UserImage, courses.Name
								FROM `course_comment`
								INNER JOIN users ON users.UserID = course_comment.User_ID 
								INNER JOIN courses ON courses.Course_ID = course_comment.Course_ID 
								WHERE course_comment.Course_ID = ?");
$stmt->execute(array($course));
$comments = $stmt->fetchAll();
if(!empty($comments)){
	foreach ($comments as $comment) {
?>
											<li>
												<div class="comment_item d-flex flex-row align-items-start jutify-content-start">
													<div class="comment_image"><div><img src="<?php echo $comment['UserImage'] ;?>" alt=""></div></div>
													<div class="comment_content">
														<div class="comment_title_container d-flex flex-row align-items-center justify-content-start">
															<div class="comment_author"><a href="#"><?php echo $comment['UserName'] ;?></a></div>
															<div class="comment_rating"><div class="rating_r rating_r_4"><i></i><i></i><i></i><i></i><i></i></div></div>
															<div class="comment_time ml-auto"><?php echo date('l j F Y', strtotime($comment['Date'])) ;?></div>
														</div>
														<div class="comment_text">
															<p><?php echo $comment['Comment'] ;?>.</p>
														</div>
														<div class="comment_extras d-flex flex-row align-items-center justify-content-start">
															<div class="comment_extra comment_likes"><a href="#"><i class="far fa-heart" aria-hidden="true"></i><span>15</span></a></div>
														</div>
													</div>
                        </div>
                      </li>
<?php } }

}
/*
=====================================================================================================================================
                                                End Course Details Page
=====================================================================================================================================*/

?>