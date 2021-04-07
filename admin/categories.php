<?php
/*
    == Manage Members Page
    == You Can Make [ Add | Edit | Delete ] Members From Here
*/
  session_start();
  if(isset($_SESSION["Username"])){
    $pageTitle = "SECTIONS";
    $active = "categories";
    include "init.php";  //  Include To init Routes File
    $action = isset($_GET["action"]) ? $_GET["action"] : "Manage";

    echo "<div class='container'>"; // Start Container

    if($action == "Manage"){
      /***********************************************
        ******* START Manage Members Page **********
      ***********************************************/
      $sort = "ASC";
      $sory_array = array("ASC" , "DESC");
      if(isset($_GET['sort']) && in_array($_GET['sort'] , $sory_array)){
        $sort = $_GET['sort'];
      }
      $stmt = $conn->prepare("SELECT * FROM `categories` ORDER BY `Ordering` $sort");
      $stmt->execute();
      $cats = $stmt->fetchAll();
      ?>
      <h1 class="text-center">Manage Categories</h1>
      <a class="btn btn-primary mb-2" href="?action=Add"> <i class="fa fa-plus"></i> Add New Category</a>
      <div class="card">
        <div class="card-header">
          Manage Categories
          <div class="ordering pull-right">
          <i class='fa fa-sort'></i> Order By:
            <a class="<?php if($sort == 'ASC'){ echo 'active'; }?>" href="?sort=ASC">ASC</a> |
            <a class="<?php if($sort == 'DESC'){ echo 'active'; }?>" href="?sort=DESC">DESC</a>
          </div>
        </div>
        <div class="card-body">

            <div id="accordion-cats">
<?php foreach($cats as $cat){ ?>
              <div class="card cat mb-3">
                <div class="card-header">
                  <div class="btn-hidden">
                    <a href="?action=Edit&ID=<?php echo $cat['ID']?>&name=<?php echo $cat['Name']?>" class="btn btn-primary"> <i class="fa fa-edit"></i> Edit</a>
                    <a href="#" class="btn btn-danger del-cats" data-id="<?= $cat['ID'];?>" data-action='cats' data-type='delete'> <i class="fa fa-close"></i> delete</a>
                  </div>
                  <a class="card-link" data-toggle="collapse" href="#<?php echo str_replace('&','_',str_replace(' ','',$cat['Name'])); ?>">
                    <?php  echo "<h4>".$cat["Name"]."</h4>"; ?>
                  </a>
                </div>
                <div id="<?php echo str_replace('&','_',str_replace(' ','',$cat['Name'])); ?>" class="collapse show" data-parent="#accordion-cats">
                  <div class="card-body">
                          <?php 
                            if($cat["Description"] == ""){
                              echo "<p class='no-description'>This Category has no Description..</p>";
                            }else{
                              echo "<p class='description'>" . $cat["Description"] . "</p>";
                            }

                            if($cat["Visibility"] == 1){
                              echo "<span class='visibility-disabled categories-items'data-id='".$cat['ID']."' data-action='option' data-type='visibil'><i class='fa fa-eye-slash'></i> visibil</span>";
                            }else{
                              echo "<span class='visibility-undisabled categories-items'data-id='".$cat['ID']."' data-action='option' data-type='visibil'><i class='fa fa-eye'></i> visibil</span>";
                            }

                            if($cat["Comments"] == 1){
                              echo "<span class='comment-disabled categories-items'data-id='".$cat['ID']."' data-action='option' data-type='comment'><i class='fa fa-bell-slash'></i> Comment</span>";
                            }else{
                              echo "<span class='comment-undisabled categories-items'data-id='".$cat['ID']."' data-action='option' data-type='comment'><i class='fa fa-bell'></i> Comment</span>";
                            }

                            if($cat["Ads"] == 1){
                              echo "<span class='ads-disabled categories-items'data-id='".$cat['ID']."' data-action='option' data-type='ads'><i class='fa fa-bell-slash'></i> Ads</span>";
                            }else{
                              echo "<span class='ads-undisabled categories-items'data-id='".$cat['ID']."' data-action='option' data-type='ads'><i class='fa fa-bell'></i> Ads</span>";
                            }
                          
                          ?>
                  </div>
                </div>
              </div>
<?php } 
if(empty($cats)){ echo "<p class='alert alert-danger text-center'>No Catigories To Display It !!</p>" ; }
?>


        </div>
        
      </div>
      <?php
      /***********************************************
        ********* END Manage Members Page **********
      ***********************************************/
    }elseif($action == "Add"){
      /***********************************************
        ***************** Add Page *****************
      ***********************************************/
      ?>
      <h1 class="text-center">Add New Categories</h1>
      <form class="form-horizontal text-center" action="?action=Insert" method="POST">

        <!-- Start Name Filed -->
        <div class="form-group row text-center">
          <label class="pt-2 col-sm-12 offset-md-2 col-md-3 offset-lg-1 text-md-right control-label">Name</label>
          <div class="col-sm-12 col-md-6 col-lg-5">
              <input type="text" name="name" class="form-control" required="required" placeholder="Name Of Caregories">
          </div>
        </div>
        <!-- End Name Filed -->

        <!-- Start Description Filed -->
        <div class="form-group row">
          <label class="pt-2 col-sm-12 offset-md-2 col-md-3 offset-lg-1 text-md-right control-label">Description</label>
          <div class="col-sm-12 col-md-6 col-lg-5">
            <input type="text" name="description" class="form-control" placeholder="Leave Your Description">
          </div>
        </div>
        <!-- End Description Filed -->

        <!-- Start Ordering Filed -->
        <div class="form-group row text-center">
          <label class="pt-2 col-sm-12 offset-md-2 col-md-3 offset-lg-1 text-md-right control-label">Ordering</label>
          <div class="col-sm-12 col-md-6 col-lg-5">
              <input type="text" name="ordering" class="form-control" placeholder="Number To Arrange The Categories">
          </div>
        </div>
        <!-- End Ordering Filed -->

        <!-- Start Visibility Filed -->
        <div class="form-group row text-center">
          <label class="pt-2 col-sm-12 offset-md-2 col-md-3 offset-lg-1 text-md-right control-label">Visible</label>
          <div class="col-sm-12 col-md-6 col-lg-5">
            <div class="text-left">
              <input id="vis-yes" type="radio" name="visibility" value="0" checked>
              <label for="vis-yes">Yes</label>
            </div>
            <div class="text-left">
              <input id="vis-no" type="radio" name="visibility" value="1">
              <label for="vis-no">No</label>
            </div>
          </div>
        </div>
        <!-- End Visibility Filed -->

        <!-- Start Commenting Filed -->
        <div class="form-group row text-center">
          <label class="pt-2 col-sm-12 offset-md-2 col-md-3 offset-lg-1 text-md-right control-label">Allow Commenting</label>
          <div class="col-sm-12 col-md-6 col-lg-5">
            <div class="text-left">
              <input id="comm-yes" type="radio" name="commenting" value="0" checked>
              <label for="comm-yes">Yes</label>
            </div>
            <div class="text-left">
              <input id="comm-no" type="radio" name="commenting" value="1">
              <label for="comm-no">No</label>
            </div>
          </div>
        </div>
        <!-- End Commenting Filed -->

        <!-- Start Ads Filed -->
        <div class="form-group row text-center">
          <label class="pt-2 col-sm-12 offset-md-2 col-md-3 offset-lg-1 text-md-right control-label">Allow Ads</label>
          <div class="col-sm-12 col-md-6 col-lg-5">
            <div class="text-left">
              <input id="ads-yes" type="radio" name="ads" value="0" checked>
              <label for="ads-yes">Yes</label>
            </div>
            <div class="text-left">
              <input id="ads-no" type="radio" name="ads" value="1">
              <label for="ads-no">No</label>
            </div>
          </div>
        </div>
        <!-- End Commenting Filed -->

        <!-- Start Submit Filed -->
        <div class="form-group row">
          <div class="m-auto">
            <input type="submit" value="Add Category" class="btn btn-lg btn-primary">
          </div>
          </div>
        <!-- End Submit Filed -->
      </form>
      <!-- End Add Page -->
    <?php
      /***********************************************
        *************** END Add Page ***************
      ***********************************************/

    }elseif($action == "Insert"){
      /***********************************************
        ************* START Insert Page **************
      ***********************************************/
      if($_SERVER["REQUEST_METHOD"] == "POST"){
        echo "<h1 class='text-center'>Insert Categories [ " . $_POST["name"]. " ]</h1>";
        $name       = $_POST["name"];
        $desc       = $_POST["description"];
        $order      = $_POST["ordering"];
        $visible    = $_POST["visibility"];
        $comment    = $_POST["commenting"];
        $ads        = $_POST["ads"];

        if(!empty($name)){
          // Check Item

          if(checkItem("Name","categories",$name) == 1 || checkItem("Ordering","categories",$order) == 1){
            $msg = "This Name Or Ordering IS Exist";
            reHome($msg,"danger","back",2);
          }else{
            //Insert Categories INFO Into Database
            // $stmt  = $conn->prepare("INSERT INTO `categories`(`Name`, `Description `, `Ordering`, `Visibility`, 'Allow_Comment', `Allow_Ads`) VALUES (:nam , :des , :order , :vis, :comment, :ads)");
            // This [Top] or This [Bottom]
$stmt = $conn->prepare("INSERT INTO categories(Name, Description, Ordering, Visibility, Comments, Ads) VALUES(?, ?, ?, ?, ?, ?)");
            $stmt->execute(array($name, $desc, $order, $visible, $comment, $ads));
            reHome("Insert Completed","success","back" , 1);
          }
        }else{
          $smg = "The Name Filed Can't Be Empty";
          reHome($smg,"danger","back" , 1);
        }

      }else{ // If The User Come To Page By External Link or Not By Method Post
        $smg = "Sorry You Can't Come In This Link Directry";
        reHome($smg,"danger","back",2);
      }
      /***********************************************
        ************* END Insert Page **************
      ***********************************************/

    }elseif($action == "Edit"){
      /***********************************************
        ************* START Edit Page **************
      ***********************************************/

      $catid = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET["ID"]) : 0;
      $stmt = $conn->prepare("SELECT * FROM categories WHERE ID = ?");
      $stmt->execute(array($catid));
      $cat = $stmt->fetch();
      $count = $stmt->rowCount();
      if($count > 0){  
      ?>
       <h1 class="text-center">Edit Categories <?= "[ " .$cat["Name"] . " ]" ?></h1>
      <form class="form-horizontal text-center" action="?action=Update" method="POST">

      <input type="hidden" name="id" value="<?php echo $cat["ID"] ?>">

        <!-- Start Name Filed -->
        <div class="form-group row text-center">
          <label class="pt-2 col-sm-12 offset-md-2 col-md-3 offset-lg-1 text-md-right control-label">Name</label>
          <div class="col-sm-12 col-md-6 col-lg-5">
              <input type="text" name="name" class="form-control" required="required" placeholder="Name Of Caregories" value = "<?php echo $cat['Name'] ?>">
          </div>
        </div>
        <!-- End Name Filed -->

        <!-- Start Description Filed -->
        <div class="form-group row">
          <label class="pt-2 col-sm-12 offset-md-2 col-md-3 offset-lg-1 text-md-right control-label">Description</label>
          <div class="col-sm-12 col-md-6 col-lg-5">
            <input type="text" name="description" class="form-control" placeholder="Leave Your Description" value = "<?php echo $cat['Description'] ?>">
          </div>
        </div>
        <!-- End Description Filed -->

        <!-- Start Ordering Filed -->
        <div class="form-group row text-center">
          <label class="pt-2 col-sm-12 offset-md-2 col-md-3 offset-lg-1 text-md-right control-label">Ordering</label>
          <div class="col-sm-12 col-md-6 col-lg-5">
              <input type="text" name="ordering" class="form-control" placeholder="Number To Arrange The Categories" value = "<?php echo $cat['Ordering'] ?>">
          </div>
        </div>
        <!-- End Ordering Filed -->

        <!-- Start Submit Filed -->
        <div class="form-group row">
          <div class="m-auto">
            <input type="submit" value="Save" class="btn btn-lg btn-primary">
          </div>
          </div>
        <!-- End Submit Filed -->
      </form>
      <!-- End Add Page -->
    <?php
      }else{
        reHome("Error ID","danger");
      }
      /***********************************************
        *************** END Edit Page *************
      ***********************************************/
    }elseif($action == "Update"){
      /***********************************************
        ************ START Update Page *************
      ***********************************************/
      

      if($_SERVER["REQUEST_METHOD"] == "POST"){
        echo "<h1 class='text-center'>Update Category [ " . $_POST["name"]. " ]</h1>";
        $catid    = $_POST["id"];
        $name    = $_POST["name"];
        $description  = $_POST["description"];
        $ordering = $_POST["ordering"];
        if(!empty($name)){
        //Update The Database With This INFO
          $stmt  = $conn->prepare("UPDATE `categories` SET `Name` = ? , `Description` = ? , `Ordering` = ? WHERE `ID` = ?");
          $stmt->execute(array($name, $description, $ordering, $catid));
          $count = $stmt->rowCount();
          // echo Success Message
          $msg = $count . " Statments Updated";
          reHome($msg,"success","back",2);
        }else{
          $msg = "The Filed Name Is Empty";
          reHome($msg,"danger","back",2);
        }
      }else{
        $msg = "Sorry You Can't Come In This Link Directry";
        reHome($msg,"danger","back",2);
      }

      
      /***********************************************
        ************ END Update Page ***************
      ***********************************************/

    }elseif($action == "Delete"){
      /***********************************************
        ************ Start Delete Page ***************
      ***********************************************/
      
      echo "<h1 class='text-center'>Dleat Category</h1>";
        $catID = isset($_GET["catID"]) && is_numeric($_GET["catID"]) ? intval($_GET["catID"]) : 0;
        $check = checkItem("ID","categories",$catID);
        if($check > 0){  
          $stmt = $conn->prepare("DELETE FROM `categories` WHERE `ID` = :catID");
          $stmt->bindParam(':catID', $catID);
          $stmt->execute();
          $count = $stmt->rowCount();
          if($count > 0){
            $msg = $count . " Statments Deleted</div>";
            reHome($msg,"success","back",2);
          }else{
            $msg = "Sorry You Can't Delete This Category";
            reHome($msg,"danger","back",2);
          }
        }else{
          $msg = "This Category IS Not Exist";
          reHome($msg,"danger","back",2);
        }


      /***********************************************
        ************ END Delete Page ***************
      ***********************************************/
    }else{
      $msg = "Sorry This Page Not Found";
      reHome($msg,"danger","back",2);
    }
    echo "</div>";
    include $tpl."footer.php";  //  Include To Header File
}else{
    header("Location: index.php"); // Back To Login Page
    exit();
}