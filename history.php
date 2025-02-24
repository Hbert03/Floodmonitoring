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
    <div class="row">
      <div class="col-12">
        <div class="card ">
          <!-- /.card-header -->
          <div class="card-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tab1">Avergare History</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab2">Average Volume</a>
              </li>
             
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
              <div id="tab1" class="tab-pane active"><br>
                <div class="table-responsive">
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
              <div id="tab2" class="tab-pane fade"><br>
                <div class="table-responsive">
                <select id="filterSelect" class="form-control w-25 mb-3">
                <option value="day">Daily</option>
                <option value="month">Monthly</option>
                <option value="year">Yearly</option>
            </select>

            <table id="volumeTable" class="table table-bordered table-striped w-100">
                <thead>
                    <tr>
                        <th>Period</th>
                        <th>Volume (Station 1 to 2)</th>
                        <th>Volume (Station 2 to 3)</th>
                        <th>Total Volume</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
                </div>
              </div>
           
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
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