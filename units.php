<?php 
session_start();
if(!isset($_SESSION['email'])){
    header('location:login.php');
   }
define("TITLE","Unit");
define("PAGE","Unit");
include 'connection.php';
include 'header.php';

?>
<style>
    .mm{
        margin-top:150px;
    }
    .mn{
        margin-top:-40px;
    }
</style>

<div class="body-section">
<div class="container ">
         <div class="card mm">
              <div class="card-header border-0">
                <h3 class="card-title">Units</h3>
                <!-- Button trigger modal -->
                 <button type="button" class="btn btn-primary float-end mn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                  <i class="fas fa-plus"></i>  Add Unit
                    </button>
               
          <div class="container mt-1">
   


    <hr>
              <div class="card-body table-responsive p-0">
                    <table id="table" class="table table-bordered pt-2">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Unit </th>
                                <th>Status</th>
                                <th>Operation</th>
                            </tr>
                        </thead>
                        <tbody class="table-light">
                        <?php
                        $squery="select * from units";
                        $run=mysqli_query($conn,$squery);
                        while($row=mysqli_fetch_assoc($run)){

                        ?>
                      <tr>
                        <td><?php echo $row['id'] ?></td>
                        <td><?php echo $row['name'] ?></td>
                        <td><?php echo $row['unit'] ?></td>
                        <td><?php echo $row['status'] ?></td>
                        <td>

                    <button type="button" class="btn btn-success btn-sm editbtn"><i class="fas fa-edit"></i></button>
                    <input type="hidden" class="delete_id_value" value="<?php echo $row['id']; ?>">
                    <a href="javascript:void(0)" type="button" class="delete_btn_ajax btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                    </td>
                        </tr><?php
                        }
                        ?>
                        </tbody>
                    </table>
              </div>
            </div>
            



            </div>
            <!-- flex-item -->
        </div>
        <!-- /flex-container -->
    </div>
            </div>
            <!-- flex-item -->
        </div>
        <!-- /flex-container -->
    </div>
</div>
        
        </div>
      
    </div>




    </div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Unit Name</label>
                <input type="text" class="form-control" name="name" placeholder="Enter Unit Name">               
            </div>
            <div class="mb-3">
                <label for="short" class="form-label">Short Form</label>
                <input type="text" class="form-control" name="short" placeholder="Enter Unit Short Form">               
            </div>

            <div class="form-group">
            <label class="form-label">Status</label><br>
                <input type="radio" name="status" value="active" checked>Active
                <input type="radio" name="status" value="deactive">Dective

            </div>  
           
            <button type="submit" class="btn btn-primary mt-1 float-end" name="add">Submit</button>
      </form>
      </div>
      
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="myModalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form method="POST">
      <input type="hidden" name="update_id" id="update_id">
            <div class="mb-3">
                <label for="name" class="form-label">Unit Name</label>
                <input type="text" class="form-control" name="name" id="name">              
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Short Form</label>
                <input type="text" class="form-control" name="short" id="short">              
            </div>
            <div class="form-group">
            <label class="form-label">Status</label><br>
            <select name="status" id="status" class="form-control">
                  <option value="active">Active</option>
                  <option value="deactive">Deactive</option>
                </select>
            </div>  
           
            <button type="submit" class="btn btn-success mt-2 float-end" name="edit">Edit</button>
      </form>
      </div>
      
    </div>
  </div>
</div>
<!-- Edit Modal END -->


 <script>
  $(document).ready(function(){
    $('.editbtn').on('click',function(){
      $('#myModalEdit').modal('show');

      $tr=$(this).closest('tr');

      var data=$tr.children('td').map(function(){
        return $(this).text();
      }).get();

      console.log(data);
      $('#update_id').val(data[0]);
      $('#name').val(data[1]);
      $('#short').val(data[2]);
      $('#status').val(data[3]);
    });
  });

</script>
<script>
    $(document).ready(function () {
        $(".delete_btn_ajax").click(function (e) { 
            e.preventDefault();
            var deleteid=$(this).closest('tr').find('.delete_id_value').val();
           // alert(deleteid);
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this Data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                   $.ajax({
                       type: "POST",
                       url: "deleteunit.php",
                       data: {
                           "delete_btn_set":1,
                           "deleteid":deleteid,
                       },                      
                       success: function (response) {
                        swal("Deleted!", "Your Data is Deleted", "success", {
                            button: "Ok!",
                            }).then((result)=>{
                              location.reload();
                            });
                            
                       }
                   });
                } 
                });
            
        });
    });
</script>
<?php 
include 'footer.php';

    if(isset($_POST['add'])){
        $unit=$_POST['name'];
        $short=$_POST['short'];
        $status=$_POST['status'];
        
        $result=mysqli_query($conn,"insert into units (name,unit,status) values('$unit','$short','$status')");
        if($result){
            ?>
          <script>
              window.location = "<?php echo $app_url.'/units.php' ?>";
          </script>
        
          <?php
        }
    }

    if(isset($_POST['edit'])){
        $id=$_POST['update_id'];
        $name=$_POST['name'];
        $short=$_POST['short'];
        $status=$_POST['status'];
        $updatequery="update units set name='$name',unit='$short', status='$status' where id='$id'";
        $uquery=mysqli_query($conn,$updatequery);
        if($uquery){
          ?>
          <script>
              window.location = "<?php echo $app_url.'/units.php' ?>";
          </script>
        
          <?php
        }else{
          ?>
          <script>
              alert('Update Failed');
          </script>
        
          <?php
        }
        
      }
?>