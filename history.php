<?php


include('header.php');

?>



<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0">History</h4>
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
        <div class="row">
       
          <!-- ./col -->
          <div class="col-lg-12">
  
</div>

          <!-- ./col -->
         
          <!-- ./col -->
        </div>
        <!-- /.row -->
           <!-- Main row -->
        <div class="row">
          <div class="col-md-12">
        
          
                <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title"></h5>

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
              <div class="table-responsive">
              <select id="sortBy" class="form-control w-25 mb-3">
                <option value="">Sort By</option>
                <option value="day">Day</option>
                <option value="month">Month</option>
                <option value="year">Year</option>
            </select>
          <table id="history" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Date</th>
                <th>Average Water Level</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
     
                    </div>
 
                 </div>
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
           
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        </section>
        </div>   


      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
 
  
</div>
  </div>
  <!-- /.content-wrapper -->
  <?php include ('footer.php');  ?>