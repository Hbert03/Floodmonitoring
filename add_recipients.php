<?php


include('header.php');
?>






      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row ">
          <div class="col-sm-6">
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <!-- /.row -->
           <!-- Main row -->
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h2 style="font-size:20px" class="card-title"><b>Add Recipients</b></h2>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>

                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form id="addForm">
                        <div class="row">
                            <div class="col">
                                <input class="form-control mb-2" name="firstname" id="firstname" placeholder="Firstname" required>
                            </div>

                            <div class="col">
                                <input class="form-control mb-2" name="middlename" id="middlename" placeholder="Middlename" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input class="form-control mb-2" name="lastname" id="lastname" placeholder="Lastname" required>
                            </div>

                            <div class="col">
                                <input class="form-control mb-2" name="phone" id="phone" placeholder="Phone Number" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label>Residents Type</label>
                                <select class="form-control mb-2" name="residents" id="residents" required >
                                <option value="" disabled selected>Please Select</option>
                                <option value="Citizens">Citizens</option>
                                <option value="MDRRMO">MDRRMO Official</option>
                                    <option value="Barangay Official">Barangay Official</option>
                                </select>
                            </div>

                            <div class="col">
                                <label>Station</label>
                                <select class="form-control mb-2" name="station" id="station" required >
                                <option value="" disabled selected>Please Select</option>
                                    <option value="1">Station 1</option>
                                    <option value="2">Station 2</option>
                                    <option value="3">Station 3</option>
                                </select>
                            </div>
                        </div>
     
                    </div>
                    <div class="card-footer text-center"> 
                        <button type="submit" class="btn btn-primary save">Save</button></div>
                    </form>
                 </div>
               
                <!-- /.row -->

              <!-- ./card-body -->
           
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
       
</div>
        </div>
        <!-- /.row -->
</div>
</section>



   

  <!-- /.content-wrapper -->
  <?php include ('footer.php');  ?>