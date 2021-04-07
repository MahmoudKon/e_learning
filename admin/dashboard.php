<?php
  ob_start();
  session_start();
  if(isset($_SESSION["Username"])){
    $pageTitle = "DASHBOARD"; // To Change The Page Title
    $active = ""; // To Change The Active In navbar Links
    include "init.php";  //  Include To init Routes File
?>
<!-- 
================================================= Start Dashboard Page ============================================================= 
-->
<h1 class="text-center">Dashboard</h1> <!-- Header -->

<!-- 
=====================================================================================================================================
============================================== Start Calculate Section ============================================================= 
=====================================================================================================================================-->
<div class="container text-center home-stats"> <!-- Start Container Div -->
    <div class="row"> <!-- Start Row Graid System Div -->

<!-- Start Calculate The Number of Users -->
      <div class="col-sm-6 col-lg-3"> <!-- Start Div Col-graid -->
          <div class="stat st-members mb-3"> <!-- Start Div Parent [ Members ] -->
            <a href="members.php"> 
                <i class="fa fa-users"></i>
                <div class="info"> <!-- Start Div Class Info -->
                    Total Members
                    <span>
                      <?php echo countItems("UserID","users") ?>
                    </span>
              </div> <!-- Start Div Class Info -->
            </a>
          </div> <!-- End Div Parent [ Members ] -->
        </div> <!-- End Div Col-graid -->
<!-- End Calculate The Number of Users -->

<!-- Start Calculate The Number of Users Pending -->
        <div class="col-sm-6 col-lg-3"> <!-- Start Div Col-graid -->
          <div class="stat st-pending mb-3"> <!-- Start Div Parent [ Pending ] -->
            <a href="members.php?action=Manage&page=Pending">
              <i class="fa fa-user-plus"></i>
              <div class="info"> <!-- Start Div Class Info -->
                Pending Members
                <span>
                    <?php echo checkItem("RegStatus","users",0) ?>
                </span>
              </div> <!-- End Div Class Info -->
            </a>
          </div> <!-- End Div Parent [ Pending ] -->
        </div> <!-- End Div Col-graid -->

<!-- End Calculate The Number of Items -->
        <div class="col-sm-6 col-lg-3"> <!-- Start Div Col-graid -->
          <div class="stat st-items mb-3"> <!-- Start Div Parent [ Items ] -->
            <a href="items.php?action=Manage&page=Pending">
              <i class="fa fa-tag"></i>
              <div class="info"> <!-- Start Div Class Info -->
                Total Courses
                  <span>
                    <?php echo countItems("Course_ID", "courses") ?>
                </span>
              </div> <!-- End Div Class Info -->
            </a>
          </div> <!-- End Div Parent [ Items ] -->
        </div> <!-- End Div Col-graid -->
<!-- End Calculate The Number of Items -->

<!-- Start Calculate The Number of Comments -->
        <div class="col-sm-6 col-lg-3"> <!-- Start Div Col-graid -->
          <div class="stat st-comments mb-3"> <!-- Start Div Parent [ Comments ] -->
            <a href="comments.php?action=Manage">
              <i class="fa fa-comments"></i>
              <div class="info"> <!-- Start Div Info -->
                Total Comments
                <span>
                  <?php echo countItems("Comment_ID", "comments") ?>
                </span>
              </div> <!-- Start Div Class Info -->
            </a>
          </div> <!-- End Div Parent [ Comments ] -->
        </div> <!-- End Div Col-graid -->
<!-- Start Calculate The Number of Comments -->

    </div> <!-- End Row Graid System Div -->
</div> <!-- End Container Div -->

<!-- 
=====================================================================================================================================
================================================= End Calculate Section ============================================================ 
=====================================================================================================================================-->


<!-- 
=====================================================================================================================================
============================================== Start Latest Section ================================================================ 
=====================================================================================================================================-->

<div class="container latest"> <!-- Start Container Div For Latests -->
<div class="row">  <!-- Start Row Graid System Div For Latests -->

<!--
==================================================
              Start Left Divs
==================================================
-->
<div class="col-md-6"> <!-- Start Col Graid System Div num [ 1 ] in The Row [ Latest Users ] -->
<!-- Start Latest Users [ Left ] -->
<div class="card mb-4"> <!-- Start Card Bootstrap Class [ Parent ] -->
        <?php $numUsers = 5; ?>

        <div class="card-header bg-dark text-white bg-dark text-white"> <!-- Start card-header bg-dark text-white Bootstrap Class [ Header ] -->
            <i class="fa fa-users mr-2"></i>Latest <?php echo "[ ".$numUsers." ]" ?> Registerd Users
            <span class="toggle-info pull-right selected"> <i class="fa fa-minus fa-lg"></i> </span>
        </div> <!-- End card-header bg-dark text-white Bootstrap Class [ Header ] -->

        <div class="card-body scrolling p-0"> <!-- Start Card-Body Bootstrap Class [ Body ] -->
            <div class="latest-list">
                <?php
                $where = "WHERE Admin != " . 1;
                $rows = getLatest("*", "users", $where, "UserID", $numUsers); // Function Used To Select Data From Database
                if(!empty($rows)){
                  foreach($rows as $row) :  // Start Foreach Loop
                  ?>
                    <div class="single">
                      <div class="row">
                        <div class="col-4">
                          <img style="width: 100%" src='<?= $row["UserImage"] ;?>'>
                        </div>
                        <div class="col-8 pl-0 pt-2 pb-2">
                          <p class="name"> <?= $row["UserName"] ;?> </p>
                          <p> <?= $row["Country"] ;?> </p>
                          <span> <?= date('l j F Y', strtotime($row["Date"])) ;?> </span>
                        </div>
                      </div>
                      <div class="btns">
                        <?php
                          echo "<a href='#' data-action='members' data-id='".$row["UserID"]."' data-type='delete' class='btn btn-danger btn-sm del-dash'> <i class='fa fa-close'></i> Delete</a>";

                          echo "<a href='members.php?action=Edit&userid=".$row["UserID"]."&name=".$row["UserName"]."' class='btn btn-success btn-sm mt-1 mb-1'> <i class='fa fa-edit'></i> Edit</a>";

                          if($row["Regstatus"] == 0){
                            echo "<a href='#' data-action='members' data-id='".$row["UserID"]."' data-type='approve' class='btn btn-info btn-sm del-dash'> <i class='fa fa-check'></i> Approve</a>";
                          }  // End IF Statment [ Regstatus ]
                        ?>
                      </div>
                    </div>
                  <?php
                  endforeach;  // Start Foreach Loop
                  }else{ echo "<div class='alert alert-info'>No Users To Display Them ..</div>"; }
                  ?>
            </div>
        </div> <!-- End Card-Body Bootstrap Class [ Body ] -->

</div> <!-- End Card Bootstrap Class [ Parent ] -->
<!-- End Latest Users [ Left ] -->

<!-- Start Latest Comments [ Left ] -->
<div class="card mb-4"> <!-- Start Card Bootstrap Class [ Parent ] -->
        <div class="card-header bg-dark text-white"> <!-- Start card-header bg-dark text-white Bootstrap Class [ Header ] -->
              <?php $numComments = 5; ?>
              <i class="fa fa-comments-o mr-2"></i>Latest [ <?php echo $numComments; ?> ] Comments at Courses
              <span class="toggle-info pull-right selected"> <i class="fa fa-minus fa-lg"></i> </span>
        </div>  <!-- End card-header bg-dark text-white Bootstrap Class [ Header ] -->

        <div class="card-body scrolling p-0">  <!-- Start Card-Body Bootstrap Class [ Body ] -->
              <?php 
                $stmt = $conn->prepare("SELECT course_comment.*, users.UserName, users.Admin, users.UserImage, courses.Name
                                        FROM `course_comment`
                                        INNER JOIN users ON users.UserID = course_comment.User_ID 
                                        INNER JOIN courses ON courses.Course_ID = course_comment.Course_ID
                                        WHERE Admin != 1
                                        ORDER BY CommentID DESC LIMIT $numComments");
                $stmt->execute();
                $rows = $stmt->fetchAll();
                if(!empty($rows)){
              ?>
                  <div class="latest-list" id="latest-list">
                    <?php  foreach($rows as $row) :  // Start Foreach Loop ?>
                    <div class="single">
                      <div class="row">
                        <div class="col-4">
                          <img style="width: 100%" src='<?= $row["UserImage"] ;?>'>
                        </div>
                        <div class="col-8 pl-0 pt-2 pb-2">
                          <p class="title">
                  <?php if(strlen($row['Name'])>20){echo substr($row["Name"],0,20).". . . ";
                                  }else{ echo $row["Name"];}?> 
                          </p>
                          <p class="name"> <?= $row["UserName"] ;?> </p>
                          <span> <?= date('l j F Y', strtotime($row["Date"])) ;?> </span>
                          
                          <p class="desc">
                          <?php if(strlen($row['Comment']) > 60){ echo substr($row["Comment"],0,60) . ". . . ";
                                  }else{ echo $row["Comment"];}?> 
                          </p>
                        </div>
                      </div>
                      <div class="btns">
                        <?php
                          echo "<a href='#' data-action='comment' data-id='".$row["CommentID"]."' data-type='course' class='btn btn-danger btn-sm del-dash'> <i class='fa fa-close'></i> Delete</a>";
                        ?>
                      </div>
                    </div>
                  <?php endforeach; ?>
                  </div>
                  <?php }else{ echo "<div class='alert alert-info'>No Comments To Display IT ..</div>"; }?>
        </div><!-- End Card-Body Bootstrap Class [ Body ] -->

</div> <!-- End Card Bootstrap Class [ Parent ] -->
<!-- End Latest Comments [ Left ] -->


<!-- Start Latest Comments [ Left ] -->
<div class="card mb-4"> <!-- Start Card Bootstrap Class [ Parent ] -->
    <div class="card-header bg-dark text-white"> <!-- Start card-header bg-dark text-white Bootstrap Class [ Header ] -->
          <?php $numComments = 5; ?>
          <i class="fa fa-comments-o mr-2"></i>Latest [ <?php echo $numComments; ?> ] Comments at Videos
          <span class="toggle-info pull-right selected"> <i class="fa fa-minus fa-lg"></i> </span>
    </div>  <!-- End card-header bg-dark text-white Bootstrap Class [ Header ] -->

    <div class="card-body scrolling p-0">  <!-- Start Card-Body Bootstrap Class [ Body ] -->
          <?php 
            $stmt = $conn->prepare("SELECT comments.*, users.UserName, users.Admin, courses.Name, users.UserImage, video_list.Video_Name 
                                    FROM `comments`
                                    INNER JOIN users ON users.UserID = comments.User_ID 
                                    INNER JOIN video_list ON video_list.Video_ID = comments.Video_List_ID 
                                    INNER JOIN courses ON courses.Course_ID = comments.Course_ID
                                    WHERE Admin != 1
                                    ORDER BY Comment_ID DESC LIMIT $numComments");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            if(!empty($rows)){
          ?>
              <div class="latest-list" id="latest-list">
                <?php  foreach($rows as $row) :  // Start Foreach Loop ?>
                  <div class="single">
                    <div class="row">
                      <div class="col-4">
                        <img style="width: 100%" src='<?= $row["UserImage"] ;?>'>
                      </div>
                      <div class="col-8 pl-0 pt-2 pb-2">
                        <p class="title">
                <?php if(strlen($row['Video_Name'])>20){echo substr($row["Video_Name"],0,20).". . . | <span>".$row["Name"]."</span>";
                                }else{ echo $row["Video_Name"]." | <span>".$row["Name"]."</span>";}?> 
                        </p>
                        <p class="name"> <?= $row["UserName"] ;?> </p>
                        <span> <?= date('l j F Y', strtotime($row["Comment_Date"])) ;?> </span>
                        
                        <p class="desc">
                        <?php if(strlen($row['Comment']) > 60){ echo substr($row["Comment"],0,60) . ". . . ";
                                }else{ echo $row["Comment"];}?> 
                        </p>
                      </div>
                    </div>
                    <div class="btns">
                      <?php
                        echo "<a href='#' data-action='comment' data-id='".$row["Comment_ID"]."' data-type='videos' class='btn btn-danger btn-sm del-dash'> <i class='fa fa-close'></i> Delete</a>";
                      ?>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
              <?php }else{ echo "<div class='alert alert-info'>No Comments To Display IT ..</div>"; }?>
    </div><!-- End Card-Body Bootstrap Class [ Body ] -->

</div> <!-- End Card Bootstrap Class [ Parent ] -->
<!-- End Latest Comments [ Left ] -->


<!-- Start Latest Comments [ Left ] -->
<div class="card mb-4"> <!-- Start Card Bootstrap Class [ Parent ] -->
    <div class="card-header bg-dark text-white"> <!-- Start card-header bg-dark text-white Bootstrap Class [ Header ] -->
          <?php $numComments = 5; ?>
          <i class="fa fa-comments-o mr-2"></i>Latest [ <?php echo $numComments; ?> ] Comments at Posts
          <span class="toggle-info pull-right selected"> <i class="fa fa-minus fa-lg"></i> </span>
    </div>  <!-- End card-header bg-dark text-white Bootstrap Class [ Header ] -->

    <div class="card-body scrolling p-0">  <!-- Start Card-Body Bootstrap Class [ Body ] -->
          <?php 
            $stmt = $conn->prepare("SELECT post_comments.*, users.UserName , users.Admin, posts.Post_Title, users.UserImage FROM `post_comments`
                                    INNER JOIN users ON users.UserID = post_comments.User_ID 
                                    INNER JOIN posts ON posts.PostID = post_comments.Post_ID
                                    WHERE Admin != 1
                                    ORDER BY Post_ComentsID DESC LIMIT $numComments");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            if(!empty($rows)){
          ?>
              <div class="latest-list" id="latest-list">
                <?php  foreach($rows as $row) :  // Start Foreach Loop ?>
                  <div class="single">
                    <div class="row">
                      <div class="col-4">
                        <img style="width: 100%" src='<?= $row["UserImage"] ;?>'>
                      </div>
                      <div class="col-8 pl-0 pt-2 pb-2">
                        <p class="title">
                        <?php if(strlen($row['Post_Title']) > 30){ echo substr($row["Post_Title"],0,30) . ". . . ";
                                }else{ echo $row["Post_Title"];}?> 
                        </p>
                        <p class="name"> <?= $row["UserName"] ;?> </p>
                        <span> <?= date('l j F Y', strtotime($row["Post_Comment_Date"])) ;?> </span>
                        
                        <p class="desc">
                        <?php if(strlen($row['Post_Comment_Desc']) > 30){ echo substr($row["Post_Comment_Desc"],0,30) . ". . . ";
                                }else{ echo $row["Post_Comment_Desc"];}?> 
                        </p>
                      </div>
                    </div>
                    <div class="btns">
                      <?php
                        echo "<a href='#' data-action='comment' data-id='".$row["Post_ComentsID"]."' data-type='posts' class='btn btn-danger btn-sm del-dash'> <i class='fa fa-close'></i> Delete</a>";
                      ?>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
              <?php }else{ echo "<div class='alert alert-info'>No Comments To Display IT ..</div>"; }?>
    </div><!-- End Card-Body Bootstrap Class [ Body ] -->

</div> <!-- End Card Bootstrap Class [ Parent ] -->
<!-- End Latest Comments [ Left ] -->



<!-- Here Write Next Latest In [ Left ] -->

</div> <!-- End Col Graid System Div num [ 1 ] in The Row [ Latest Users ] -->

<!--
==================================================
              End Left Divs
==================================================
-->

<!-- 
  ====================================================================================
                    Top Is Left Div Graid and Bottom IS Right Div Graid
  ====================================================================================
 -->

<!--
==================================================
              Start Right Divs
==================================================
-->

<div class="col-md-6"> <!-- Start Col Graid System Div num [ 2 ] in The Row [ Latest Items ] -->

<!-- Start Latest Items [ Right ] -->
<div class="card mb-4"> <!-- Start Card Bootstrap Class [ Parent ] -->
    <?php $numCats = 5; ?>
    <div class="card-header bg-dark text-white"> <!-- Start card-header bg-dark text-white Bootstrap Class [ Header ] -->
          <i class="fa fa-tag mr-2"></i>Latest <?php echo "[ ".$numCats." ]" ?> Categories
          <span class="toggle-info pull-right selected"> <i class="fa fa-minus fa-lg"></i> </span>
    </div>  <!-- End card-header bg-dark text-white Bootstrap Class [ Header ] -->

    <div class="card-body scrolling p-0">  <!-- Start Card-Body Bootstrap Class [ Body ] -->
          <?php 
            $stmt = $conn->prepare("SELECT * FROM `categories` ORDER BY ID DESC LIMIT $numCats");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            if(!empty($rows)){
          ?>
              <div class="latest-list" id="latest-list">
                <?php  foreach($rows as $row) :  // Start Foreach Loop ?>
                  <div class="single">
                    <div class="pl-0 pt-2 pb-2">
                      <p class="title pl-5 mb-3"> <?= $row["Name"] ;?> </p>
                      <span class="pl-5"> <?= $row["Description"] ;?> </span>
                    </div>
                    <div class="btns">
                      <?php
                        echo "<a href='#' class='btn btn-danger del-comments' data-id='".$row['ID']."' data-action='cats' data-type='delete' ><i class='fa fa-close'></i> Delete</a>";

                        echo "<a href='categories.php?action=Edit&ID=".$row["ID"]."&name=".$row["Name"]."' class='btn btn-success btn-sm mt-1 mb-1'> <i class='fa fa-edit'></i> Edit</a>";
                      ?>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
            <?php }else{ echo "<div class='alert alert-info'>No Categories To Display IT ..</div>"; }?>
</div><!-- End Card-Body Bootstrap Class [ Body ] -->


<!-- Start Latest Items [ Right ] -->
<div class="card mb-4"> <!-- Start Card Bootstrap Class [ Parent ] -->
    <?php $numItems = 5; ?>
    <div class="card-header bg-dark text-white"> <!-- Start card-header bg-dark text-white Bootstrap Class [ Header ] -->
          <i class="fa fa-tag mr-2"></i>Latest <?php echo "[ ".$numItems." ]" ?> Courses
          <span class="toggle-info pull-right selected"> <i class="fa fa-minus fa-lg"></i> </span>
    </div>  <!-- End card-header bg-dark text-white Bootstrap Class [ Header ] -->

    <div class="card-body scrolling p-0">  <!-- Start Card-Body Bootstrap Class [ Body ] -->
          <?php 
            $stmt = $conn->prepare("SELECT courses.*, categories.Name AS Category_Name, users.UserName, users.Admin FROM `courses`
                                    INNER JOIN categories ON categories.ID = courses.Categories_ID 
                                    INNER JOIN users ON users.UserID = courses.User_ID
                                    WHERE Admin != 1
                                    ORDER BY Course_ID DESC");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            if(!empty($rows)){
          ?>
              <div class="latest-list" id="latest-list">
                <?php  foreach($rows as $row) :  // Start Foreach Loop ?>
                  <div class="single">
                    <div class="row">
                      <div class="col-4">
                        <img style="width: 100%" src='<?= $row["Img"] ;?>'>
                      </div>
                      <div class="col-8 pl-0 pt-2 pb-2">
                        <?php if(strlen($row['Name']) > 30){ echo substr($row["Name"],0,30) . ". . . ";
                                }else{ echo $row["Name"];}?> 
                        </p>
                        <p class="name"> <?= $row["UserName"] ;?> </p>
                        <span> <?= $row["Category_Name"]." | ".date('l j F Y', strtotime($row["Add-Date"])) ;?> </span>
                      </div>
                    </div>
                    <div class="btns">
                      <?php
                        echo "<a href='#' data-action='item' data-id='".$row["Course_ID"]."' data-type='delete' class='btn btn-danger btn-sm del-dash'> <i class='fa fa-close'></i> Delete</a>";

                        echo "<a href='items.php?action=Edit&courseid=".$row["Course_ID"]."&name=".$row["Name"]."' class='btn btn-success btn-sm mt-1 mb-1'> <i class='fa fa-edit'></i> Edit</a>";

                        if($row["Approve"] == 0){
                          echo "<a href='#' data-action='item' data-id='".$row["Course_ID"]."' data-type='approve' class='btn btn-info btn-sm del-dash'> <i class='fa fa-check'></i> Activate</a>";
                        }  // End IF Statment [ Regstatus ]
                      ?>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
            <?php }else{ echo "<div class='alert alert-info'>No Courses To Display IT ..</div>"; }?>
</div><!-- End Card-Body Bootstrap Class [ Body ] -->



<!-- Start Latest Items [ Right ] -->
<div class="card mb-4"> <!-- Start Card Bootstrap Class [ Parent ] -->
    <?php $numItems = 5; ?>
    <div class="card-header bg-dark text-white"> <!-- Start card-header bg-dark text-white Bootstrap Class [ Header ] -->
          <i class="fa fa-tag mr-2"></i>Latest <?php echo "[ ".$numItems." ]" ?> Videos
          <span class="toggle-info pull-right selected"> <i class="fa fa-minus fa-lg"></i> </span>
    </div>  <!-- End card-header bg-dark text-white Bootstrap Class [ Header ] -->

    <div class="card-body scrolling p-0">  <!-- Start Card-Body Bootstrap Class [ Body ] -->
          <?php 
            $stmt = $conn->prepare("SELECT video_list.*, categories.Name AS Category_Name, users.UserName, users.Admin, courses.Name
                                    FROM `video_list`
                                    INNER JOIN categories ON categories.ID = video_list.Cat_ID 
                                    INNER JOIN courses ON courses.Course_ID = video_list.Course_ID 
                                    INNER JOIN users ON users.UserID = video_list.User_ID
                                    WHERE Admin != 1
                                    ORDER BY Video_ID DESC LIMIT 5");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            if(!empty($rows)){
          ?>
              <div class="latest-list" id="latest-list">
                <?php  foreach($rows as $row) :  // Start Foreach Loop ?>
                  <div class="single">
                    <div class="row">
                      <div class="col-4">
                        <video width="100%">
                        <source src="../<?php echo $row["Video_Src"]; ?>" type="video/mp4">
                          Your browser does not support the video tag.
                        </video>

                        </video>
                      </div>
                      <div class="col-8 pl-0 pt-2 pb-2">
                        <p class="title">
            <?php if(strlen($row['Video_Name'])>20){echo substr($row["Video_Name"],0,20).". . . | <span>".$row["Name"]."</span>";
                                }else{ echo $row["Video_Name"] . " | <span>" . $row["Name"] . "</span>" ;}?> 
                        </p>
                        <p class="desc"><?= $row["UserName"]." | "."<span>".date('l j F Y',strtotime($row["Video_Date"]));?></span></p>
                        <p class="desc">
                        <?php if(strlen($row['Video_Desc']) > 30){ echo substr($row["Video_Desc"],0,30) . ". . . ";
                                }else{ echo $row["Video_Desc"];}?> 
                        </p>
                      </div>
                    </div>
                    <div class="btns">
                      <?php
                        echo "<a href='#' data-action='video' data-id='".$row["Video_ID"]."' data-type='delete' class='btn btn-danger btn-sm del-dash'> <i class='fa fa-close'></i> Delete</a>";
                      ?>
                    </div>
                  </div>
            <?php endforeach; ?>
              </div>
    </div>
          <?php }else{ echo "<div class='alert alert-info mb-0'>No Videos To Display IT ..</div>"; } ?>
</div><!-- End Card-Body Bootstrap Class [ Body ] -->

</div>

<!-- Start Latest Items [ Right ] -->
<div class="card mb-4"> <!-- Start Card Bootstrap Class [ Parent ] -->
    <?php $numItems = 5; ?>
    <div class="card-header bg-dark text-white"> <!-- Start card-header bg-dark text-white Bootstrap Class [ Header ] -->
          <i class="fa fa-tag mr-2"></i>Latest <?php echo "[ ".$numItems." ]" ?> Posts
          <span class="toggle-info pull-right selected"> <i class="fa fa-minus fa-lg"></i> </span>
    </div>  <!-- End card-header bg-dark text-white Bootstrap Class [ Header ] -->

    <div class="card-body scrolling p-0">  <!-- Start Card-Body Bootstrap Class [ Body ] -->
          <?php 
            $stmt = $conn->prepare("SELECT posts.*, categories.Name, users.UserName, users.Admin FROM `posts`
                                    INNER JOIN categories ON categories.ID = posts.Cat_ID 
                                    INNER JOIN users ON users.UserID = posts.User_ID
                                    WHERE Admin != 1
                                    ORDER BY PostID DESC LIMIT $numItems");
            $stmt->execute();
            $rows = $stmt->fetchAll();
            if(!empty($rows)){
          ?>
            <div class="latest-list" id="latest-posts">
              <?php  foreach($rows as $row) :  // Start Foreach Loop ?>
                <div class="single">
                  <div class="row">
                    <div class="col-4">
                      <img style="width: 100%" src='<?= $row["Post_File"] ;?>'>
                    </div>
                    <div class="col-8 pl-0 pt-2 pb-2">
                      <p class="title">
                      <?php if(strlen($row['Post_Title']) > 37){ echo substr($row["Post_Title"],0,37) . ". . . ";
                                }else{ echo $row["Post_Title"];}?> 
                      </p>
                      <p class="name"> <?= $row["UserName"] ;?> </p>
                      <span> <?= $row["Name"] . " | " . date('l j F Y', strtotime($row["Post_Date"])) ;?> </span>
                    </div>
                  </div>
                  <div class="btns">
                    <?php
                      echo "<a href='#' data-action='post' data-id='".$row["PostID"]."' data-type='delete' class='btn btn-danger btn-sm del-dash'> <i class='fa fa-close'></i> Delete</a>";

                      if($row["Post_Approve"] == 0){
                        echo "<a href='#' data-action='post' data-id='".$row["PostID"]."' data-type='approve' class='btn btn-info btn-sm del-dash'> <i class='fa fa-check'></i> Activate</a>";
                      }  // End IF Statment [ Regstatus ]
                    ?>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
    </div>
        <?php }else{ echo "<div class='alert alert-info mb-0'>No Posts To Display IT ..</div>"; }?>
</div><!-- End Card-Body Bootstrap Class [ Body ] -->

    
<!-- End Latest Items [ Right ] -->
                    </div>

</div> <!-- End Card Bootstrap Class [ COL - 6 ] -->

    
<!-- End Latest Items [ Right ] -->

</div> <!-- End Col Graid System Div num [ 2 ] in The Row [ Latest Items ] -->
<!--
==================================================
              End Right Divs
==================================================
-->
</div> <!-- End Row Graid System Div -->
<!-- 
=====================================================================================================================================
============================================== End Latest Section ================================================================ 
=====================================================================================================================================-->


<!-- 
================================================ End Dashboard Page ================================================================ 
-->

<style>
  .scrolling{
    max-height: 300px;
    overflow-y: scroll;
    overflow-x: hidden;
  }
</style>
    
  <?php
    include $tpl."footer.php";  //  Include To init Routes File
  }else{
    header("Location: index.php"); // Back To Login Page
    exit();
  }
  include $tpl."footer.php";  //  Include To Header File
  ob_end_flush();
  ?>