<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php"><?php echo lang("ADMIN") ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#App_Nav" aria-controls="App_Nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="App_Nav">
      <ul class="navbar-nav  mt-2 mt-lg-0">
      <li class="nav-item <?php if($active == "categories"){ echo 'active';} ?>">
          <a class="nav-link" href="categories.php"><?php echo lang("SECTIONS") ?></a>
        </li>
        <li class="nav-item <?php if($active == "items"){ echo 'active';} ?>">
          <a class="nav-link" href="items.php"><?php echo lang("ITEMS") ?></a>
        </li>
        <li class="nav-item <?php if($active == "videos"){ echo 'active';} ?>">
          <a class="nav-link" href="videos.php"><?php echo lang("VIDEOS") ?></a>
        </li>
        <li class="nav-item <?php if($active == "members"){ echo 'active';} ?>">
          <a class="nav-link" href="members.php"><?php echo lang("MEMBERS") ?></a>
        </li>
        <li class="nav-item dropdown <?php if($active == "comments"){ echo 'active';} ?>">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo lang("COMMENTS") ?>
          </a>
          <div class="dropdown-menu" aria-labelledby="userDrop">
            <a class="dropdown-item" href="comments.php?comment=posts">at Posts</a>
            <a class="dropdown-item" href="comments.php?comment=courses">at Courses</a>
            <a class="dropdown-item" href="comments.php?comment=videos">at Videos</a>
          </div>
        </li>

        <li class="nav-item <?php if($active == "posts"){ echo 'active';} ?>">
          <a class="nav-link" href="posts.php"><?php echo lang("POSTS") ?></a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto my-2 my-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="userDrop" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php
                  $stmt = $conn->prepare("SELECT * FROM users WHERE UserName = ? AND UserID = ?");
                  $stmt->execute(array($_SESSION["Username"] , $_SESSION["ID"]));
                  $user = $stmt->fetch();
                  echo $user["NickName"]; 
                  echo "<img src='".$user["UserImage"]."' width='40px' height='25px' class='ml-1'>"; 
              ?>
          </a>
          <div class="dropdown-menu" aria-labelledby="userDrop">
            <a class="dropdown-item" href="members.php?action=Edit&userid=<?php echo $_SESSION["ID"]; ?>&Name=<?php echo $_SESSION["Username"] ?>"> <?php echo lang("EDIT") ?></a>
            <a class="dropdown-item" href="../index.php">Visit Site</a>
            <a class="dropdown-item" href="logout.php"><?php echo lang("EXIT") ?></a>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>