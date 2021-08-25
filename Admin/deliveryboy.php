<?php 
  include('top.php');
  if(isset($_GET['type']) && $_GET['type']!=='' && isset($_GET['id']) && $_GET['id']>0){
    $type=$_GET['type'];
    $id=$_GET['id'];
    if($type=='active' || $type == 'deactive'){
      $status=1;
      if($type=='deactive'){
        $status=0;
      }
      $con->query("update delivery_boy set status='$status' where id='$id'");
    }
    elseif ($type=='edit') {
      # code...
    }
  }
  $sql="select * from delivery_boy order by name";
  $res=$con->query($sql);


 ?>         
          <h1 class="card-title ml10">Delivery Boy</h1>
          <div class="card">
            <div class="card-body">
              <a href="addboy.php"><label class="badge badge-info cursor-hand">Add Boy</label></a>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="10%">S No.</th>
                            <th width="40%">Name</th>
                           <th width="20%">mobile</th>
                           <th width="10%">Added On</th>
                            <th width="40%">Actions</th>
                        </tr>
                      </thead>
                      <tbody>

                  <?php echo $res->num_rows;  if($res->num_rows>0){ 
                    $i=1;
                        while($row=$res->fetch_assoc()){  ?>
                            <tr>
                                <td><?php echo $i?></td>
                                <td><?php echo $row['name']?></td>
                                <td><?php echo $row['mobile']?></td>
                                <td>
                                  <?php 
                                $datestr=strtotime($row['added_on']);

                                  echo date('d-m-Y',$datestr); ?>
                                </td>

                                <td>
                                  <a href="addboy.php?id=<?php echo $row['id']?>&type=edit"><label class="badge badge-info cursor-hand">Edit</label></a>
                                  &nbsp;
                                    <?php 
                                    if($row['status']==1){?>
                                      <a href="?id=<?php echo $row['id']?>&type=deactive"><label class="badge badge-success cursor-hand">Active</label></a>
                                    <?php } 
                                    else{ ?>
                                      <a href="?id=<?php echo $row['id']?>&type=active"><label class="badge badge-success cursor-hand">Deactive</label></a>  
                                    <?php
                                    }
                                    ?>
                                </td>
                                
                            </tr>    
                      <?php
                      $i++;
                       }} ?>  
                    
                      </tbody>
                    </table>
                  </div>
		        		</div>
              </div>
            </div>
          </div>
<?php 
  include('footer.php');
 ?>