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
                <h5 class="card-title">Station 2 Water Level</h5>

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
              
                  <div class="col-md-12">
                     <p class="text-center">
                      <strong></strong>
                         </p>

                       <div class="chart" style="width:100%;">
                       <!-- Sales Chart Canvas -->
                         <canvas id="station2" height="90"></canvas>
                        </div>
                      </div>
     
                    </div>
 
                 </div>
          
                <!-- /.row -->

              <!-- ./card-body -->
           
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="card">
  <div class="card-header">
    <h3 class="card-title">Water Level & Rain Drop</h3>
  </div>
  <div class="card-body">
    <!-- <div class="row">
      <div class="col-md-6">
        <div class="station_2_waterlevel" style="height:250px"></div>
      </div>
      <div class="col-md-6">
        <div class="station_2_raindrop" style="height:250px" ></div>
      </div>
    </div> -->
  </div>
</div>
        </div>
        <!-- /.row -->
</div>
</section>



   

  <!-- /.content-wrapper -->
  <?php include ('footer.php');  ?>