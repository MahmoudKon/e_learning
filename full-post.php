<?php
ob_start();
// Start Session
session_start();
$title = "Blog";
$action = "";
$active = "Blog";
include "inhi.php";
$post_id = $_GET["post"];
$stmt = $conn->prepare("SELECT posts.*, users.UserName, categories.Name FROM posts
                        INNER JOIN users ON users.UserID = posts.User_ID
                        INNER JOIN categories ON categories.ID = posts.Cat_ID
                        WHERE posts.Post_Approve = 1 AND PostID = ?");
$stmt->execute(array($post_id));
$post = $stmt->fetch();
?>

<!--
=======================
Start Section Back Link
======================= 
-->
<div class="home">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="breadcrumbs">
						<ul>
							<li><a href="index.php">Home </a></li>
							<li><i class="fa fa-chevron-right fa-fw"></i> <a href="blog.php">Blog </a></li>
							<li><i class="fa fa-chevron-right fa-fw"></i> <?= $post["Post_Title"];?></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
</div>
<!--
=======================
End Section Back Link
======================= 
-->


<!-- 
=====================================================================================================================================
                                                Start Body
=====================================================================================================================================
-->
<section class="blog"> <!-- Start Section Class [ Blog ] -->
<div class="container"> <!-- Start Div Class Bootstrap [ Container ] -->
<div class="row"> <!-- Start Div Grid Class Bootstrap [ ROW ] -->

<!-- 
===========================================================
=================================== Start Left Col - 8 Div
===========================================================
 -->
<div class="col-md-8"> <!-- Start Div Grid Class Bootstrap [ COL - MD - 8 ] -->
<?php if(! empty($sessionUser)): ?>
<div class="create-post"> <!-- Start DIV Class [ Create - Post ] -->
<!-- Trigger the modal with a button -->
<button type="button" class="btn btn-primary btn-post" data-toggle="modal" data-target="#myModal">create-post</button>
<!-- Modal -->
  <div id="myModal" class="modal fade" role="dialog"> <!-- Start DIV Class Bootstrap [ Model ] -->
    <div class="modal-dialog"> <!-- Start DIV Class Bootstrap [ Model - Dialog ] -->

      <!-- Modal content-->
      <div class="modal-content"> <!-- Start DIV Class Bootstrap [ Model - Content ] -->

        <div class="modal-header"> <!-- Start DIV Class Bootstrap [ Model - Header ] -->
          <button type="button" class="close ml-0" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Create Post</h4>
        </div> <!-- End DIV Class Bootstrap [ Model - Header ] -->

        <div class="modal-body"> <!-- Start DIV Class Bootstrap [ Model - Body ] -->
          <form class="blog-create-post pl-4 pr-4 mt-3" action=""  method="POST" enctype="multipart/form-data"> <!-- Start DIV [ Form ] -->

            <!-- Start Hidden Field -->
              <div class="form-group row text-center">
                <input id="userid" name="userid" value="<?= $sessionUserID; ?>" hidden>
              </div>
            <!-- End Hidden Field -->

            <!-- Start Tags Field -->
                <div class="form-group row text-center">
                    <label class="pt-1 col-sm-3 text-md-right control-label">Title</label>
                    <div class="col-sm-9">
                        <input type="text" name="post-header" id="post-header" class="form-control" placeholder="Title">
                    </div>
                </div>
            <!-- End Tags Field -->

            <!-- Start Categories Field -->
                <div class="form-group row text-center">
                  <label class="pt-1 col-sm-3 text-md-right control-label">Category</label>
                  <div class="col-sm-9">
                      <select id="post-cat" name="post-cat" class="form-control">
                          <?php
                              $stmt = $conn->prepare("SELECT * FROM categories");
                              $stmt->execute();
                              $cats = $stmt->fetchAll();
                              foreach ($cats as $cat) {
                                  echo "<option value=" . $cat["ID"] . ">" . $cat["Name"] . "</option>";
                              }
                          ?>
                      </select>
                  </div>
                </div>
            <!-- End Categories Field -->

            <!-- Start Tags Field -->
                <div class="form-group row text-center">
                    <label class="pt-1 col-sm-3 text-md-right control-label">Tags</label>
                    <div class="col-sm-9">
                        <input type="text" name="post-tags" id="input-tags" class="form-control">
                    </div>
                </div>
            <!-- End Tags Field -->

            <!-- Start Description Field -->
                <div class="form-group row text-center">
                  <label class="pt-1 col-sm-3 text-md-center control-label">Description</label>
                  <div class="col-sm-9">
                    <textarea id="post-desc" name="post-desc" class="form-control" placeholder="Description"></textarea>
                  </div>
                </div>
            <!-- End Description Field -->

            <input type="submit" value="Post" class="btn btn-primary float-right">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

          </form> <!-- Start DIV [ Form ] -->
        </div> <!-- End DIV Class Bootstrap [ Model - Body ] -->
      </div> <!-- End DIV Class Bootstrap [ Model - Content ] -->
    </div> <!-- End DIV Class Bootstrap [ Model - Dialog ] -->
  </div> <!-- End DIV Class Bootstrap [ Model ] -->
</div> <!-- End DIV Class [ Create - Post ] -->
<?php endif;?>
<!-- End Create Post -->

<div class="blog-share-posts" id="view-post-search"> <!-- Start Div Class Bootstrap [ blog Share Posts ] -->

<!-- Start Single Post -->
  <div class="card my-4 blog-share-posts"> <!-- Start Div Class Bootstrap [ Card ] -->
    <div class="card-header">
        <div class="row">
          <div class="col-2">
            <img width="100%" src="images/about_1.jpg">
          </div>
          <div class="col-10">
            <p>
                <a class="name" href="#"> <?= $post["UserName"]; ?> </a>
                <span class="float-right">on <?= date('l j F Y', strtotime($post["Post_Date"])); ?></span> 
            </p>
            <p>
              <span>category / <a class="cat cat-post" data-id="<?= $post['Cat_ID']; ?>" href="#"><?= $post["Name"]; ?></a> </span>
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
    <div class="card-body pb-2"> <!-- Start Div Class Bootstrap [ card-body ] -->
          <div class="card-body-title">
            <p><?= $post["Post_Title"]; ?></p>
          </div>
          <p><?= $post["Post_Description"]; ?></p>
          <div class="post-btns">
            <div class="row">
              <div class="col-4">
                  <p data-like="<?= $post["PostID"]; ?>" class="post-like"> <i class="far fa-thumbs-up fa-fw"></i> Like </p>
                  <span id="like"><?= $post["Post_Like"]; ?></span>
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


<!-- Start Form To Ctreat Comments -->

    <h1>Comments</h1>
<!-- Start Create Comments -->
   <div class="add_comment_container pb-4"> <!-- Start DIV Class [ Add - Comment - Container ] -->
      <?php if(!isset($_SESSION["user"])){ ?>
		   <div class="add_comment_text pl-5">You must be <a href="login.php">logged</a> in to post a comment.</div>
      <?php }else{ ?>
         <form class="comment-form pl-4 pr-4 mt-3" action="" method="POST">
               <textarea name="desc" id="desc" class="input-group p-3" placeholder="Leave Your Comment" required></textarea>
               <input type="text" name="userid" id="userid" value="<?= $sessionUserID;?>" hidden>
               <input type="text" name="postid" id="postid" value="<?= $post["PostID"];?>" hidden>
               <input type="submit" value="Comment" class="btn btn-info mt-3">
         </form>
      <?php }?>
   </div> <!-- End DIV Class [ Add - Comment - Container ] -->
<!-- End Create Comments -->

<!-- End Form To Ctreat Comments -->


<div class="post-comments" id="post-comments">  <!-- Start DIV Class [ Post - Comments ] -->
<?php
$stmt = $conn->prepare("SELECT post_comments.*, users.UserName, users.UserImage FROM post_comments
                        INNER JOIN users ON users.UserID = post_comments.User_ID
                        WHERE Post_ID = ?
                        ORDER BY Post_Comment_Date DESC");
$stmt->execute(array($post["PostID"]));
$comments = $stmt->fetchAll();
foreach($comments as $comment):
?>
<!-- Start Signle Comment -->
<div class="single-comment">   <!-- Start DIV Class [ Single - Comment ] -->

   <div class="comment-header">   <!-- Start DIV Class [ Header - Comment ] -->
      <div class="row">   <!-- Start [ ROW ] -->
         <div class="col-2 pr-0 text-center">
            <img src="<?= $comment["UserImage"];?>">
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
<?php endforeach; ?>

   </div>  <!-- End DIV Class [ Post - Comments ] -->
</div> <!-- End Div Class Bootstrap [ Card ] -->
<!-- End Single Post -->




</div> <!-- End Div Class Bootstrap [ blog Share Posts ] -->

</div> <!-- End Div Grid Class Bootstrap [ COL - MD - 8 ] -->
<!-- 
===========================================================
=================================== Start Right Col - 4 Div
===========================================================
 -->
<div class="col-md-4"> <!-- Start Div Grid Class Bootstrap [ COL - MD - 4 ] -->

<!-- Start First Div To Display [ Search ] -->
    <div class="card my-4 blog-search"> <!-- Start Div Class Bootstrap [ Card ] -->
      <h5 class="card-header">Search</h5>
      <div class="card-body"> <!-- Start Div Class Bootstrap [ card-body ] -->
        <div class="input-group">
          <input type="text" class="search-posts form-control" placeholder="Search for...">
        </div>
      </div> <!-- End Div Class Bootstrap [ card-body ] -->
    </div> <!-- End Div Class Bootstrap [ Card ] -->
<!-- End First Div To Display [ Search ] -->

<!-- Start Second Div To Display [ Categories ] -->
    <div class="card my-4 blog-categories"> <!-- Start Div Class Bootstrap [ card ] -->
      <h5 class="card-header">Categories</h5>
      <div class="card-body p-0"> <!-- Start Div Class Bootstrap [ card-body ] -->
        <ul class="list-unstyled mb-0">
            <?php
              $cats = getCats();
                echo "<li>";
                      echo "<span class='active cat-pos' data-id='0'>All</span>";
                echo "</li>";
              foreach ($cats as $cat) :
                echo "<li>";
                      echo "<span class='cat-post' data-id='".$cat['ID']."'> " . $cat['Name'] . " </span>";
                echo "</li>";
              endforeach;
            ?>
        </ul>
      </div> <!-- End Div Class Bootstrap [ card-body ] -->
    </div> <!-- End Div Class Bootstrap [ card ] -->
<!-- End Second Div To Display [ Categories ] -->

<!-- Start Second Div To Display [ Popular Blogs ] -->
    <div class="card my-4 blog-popular"> <!-- End Div Class Bootstrap [ card ] -->
      <h5 class="card-header">Popular Blogs</h5>
      <div class="card-body"> <!-- Start Div Class Bootstrap [ card-body ] -->
      <?php 
         $stmt = $conn->prepare("SELECT * FROM `posts` WHERE  `Post_Approve` = 1 LIMIT 5");
         $stmt->execute();
         $posts = $stmt->fetchAll();
         foreach($posts as $post):
      ?>
         <div class="blog-popular-post"> <!-- Start Div Class Bootstrap [ Blog - Popular - Post ] -->
            <div class="row">
              <div class="col-4 py-0">
                <img width="100%" src="<?= $post['Post_File'];?>">
              </div>
              <div class="col-8 pl-0">
                <a href="full-post.php?post=<?= $post['PostID'];?>"><?= Substr($post['Post_Description'] , 0 , 95);?></a>
              </div>
            </div>
         </div> <!-- End Div Class Bootstrap [ Blog - Popular - Post ] -->
      <?php endforeach; ?>

      </div> <!-- End Div Class Bootstrap [ card-body ] -->
    </div> <!-- End Div Class Bootstrap [ card ] -->
<!-- End Second Div To Display [ Popular Blogs ] -->

</div> <!-- End Div Grid Class Bootstrap [ COL - MD - 4 ] -->
<!-- 
===========================================================
=================================== End Right Col - 4 Div
===========================================================
 -->

</div> <!-- End Div Grid Class Bootstrap [ ROW ] -->
</div> <!-- End Div Class Bootstrap [ Container ] -->
</section> <!-- End Section Class [ Blog ] -->
<!-- 
=====================================================================================================================================
                                                End Body
=====================================================================================================================================
-->
<?php
include "template/footer.php";
ob_end_flush();
?>