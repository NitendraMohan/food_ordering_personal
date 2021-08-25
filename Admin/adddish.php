<?php 
include('top.php'); 
include('constant.inc.php');
$category_id="";
$dish="";
$dish_detail="";
$image="";
$image_status="required";
$type="";
$id="";
$image_error="";
if(isset($_GET['id']) && $_GET['id']>0){
  $id=$_GET['id'];
  $row=mysqli_fetch_assoc($con->query("select * from dish where id='$id'"));
  $category_id=$row['category_id'];
  $dish=$row['dish'];
  $dish_detail=$row['dish_detail'];
  $image=$row['image'];
}
if(isset($_POST['cancel'])){
  redirect('dish.php');
}
if(isset($_POST['submit'])){
  $category_id=$_POST['category_id'];
  $dish=$_POST['dish'];
  $dish_detail=$_POST['dish_detail'];
  $image=$_POST['image'];
  $added_on=date('Y-m-d h:m:s');
  if($id!=''){
    $image_status='';
    if($_FILES['image']['name']!=''){
      $type=$_FILES['image']['type'];
    if($type!='image/jpeg' && $type!='image/png'){
      $image_error="Invalid Image Format";
    }
    else{
      $image=$_FILES['image']['name'];
      move_uploaded_file($_FILES['image']['tmp_name'], SERVER_DISH_IMAGE.$_FILES['image']['name']);      
      $image_status=", image='$image'";
    
    $con->query("update dish set category_id='$category_id',dish='$dish',dish_detail='$dish_detail' $image_status where id='$id'");
    redirect('dish.php'); 
    }
    } 
  }
  else{
    if(mysqli_num_rows(mysqli_query($con,"select * from dish where dish='$dish' and category_id='$category_id'"))>0){
    $msg="Dish already added";
  }
  else{
    $type=$_FILES['image']['type'];
    if($type!='image/jpeg' && $type!='image/png'){
      $image_error="Invalid Image Format";
    }
    else{
    $image=$_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], SERVER_DISH_IMAGE.$_FILES['image']['name']);

  $con->query("insert into dish(category_id,dish,dish_detail,image,status,added_on) values('$category_id'
    ,'$dish','$dish_detail','$image',1,'$added_on')");
  redirect('dish.php');
  }  
  }  
  }
}
$res_cat=$con->query("select * from category where status='1'");
?>
<div class="row">
  <h1 class="card-title ml10">Manage Dish</h1>
        <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <form class="forms-sample" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="exampleInputName1">Category</label>
                  <select class="form-control" name="category_id" placeholder="Category">
                      <option value="">Select Category</option>
                      <?php 
                        while ($c_row=$res_cat->fetch_assoc()) {
                          if($c_row['id']==$category_id){
                          echo "<option value='".$c_row['id']."'' selected>".$c_row['category']."</option>";  
                          }
                          echo "<option value='".$c_row['id']."''>".$c_row['category']."</option>";
                        }
                       ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail3">Dish</label>
                  <input type="textbox" class="form-control" name="dish" value="<?php echo $dish; ?>" placeholder="Dish">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail3">Dish Detail</label>
                  <textarea class="form-control" name="dish_detail" value="<?php echo $dish_detail; ?>" placeholder="Dish Detail"></textarea>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail3">Image</label>
                  <input type="file" class="form-control" name="image"  placeholder="Image">
                  <div><?php echo $image_error ?></div>
                </div>
                <button type="submit" class="btn btn-primary mr-2" name="submit">Submit</button>
                <button type="submit" class="btn btn-light mr-2" name="cancel">Cancel</button>
              </form>
            </div>
          </div>
        </div>
            
     </div>

<?php
include('footer.php');
 ?>
        
		