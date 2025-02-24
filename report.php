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
    <div class="row">
      <div class="col-12">
        <div class="card">
          <!-- /.card-header -->
          <div class="card-body">
            <!-- Nav tabs -->

                  <div class="row">
                    <div class="col-md-4">
                <select class="form-control" id="timeRange">
              <option value="minute">Last Hour (in Minutes)</option>
              <option value="hour" selected>Last 24 Hours (in Hour)</option>
              <option value="day">Last 7 Days (in Day)</option>
              <option value="month">Last 12 Months (in Month)</option>
          </select>
          </div>
          <div class="col-md-4">
                <select class="form-control" id="station">
              <option value=" ">Sort by Station</option>
              <option value="1">Station 1</option>
              <option value="2" selected>Station 2</option>
              <option value="3">Station 3</option>

          </select>
          </div>
          <!-- Generate Report Button -->
           <div class="col-md-4">
          <button id="generateReport" class="btn btn-primary btn-sm">Generate Report</button>
          </div>
          </div>
        <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportModalLabel">Water Level Report</h5>
                <div class="float-right">
                <button type="button" class="btn btn-secondary " data-dismiss="modal">Close</button>
                <button onclick="printTable()" class="btn btn-success">Print Report</button>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
              </div>
            <div class="modal-body">
               
                <div id="printSection">
                    <div id="modalReportContent">
                        <!-- Report data will be inserted here -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
             
            </div>
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
</div>





  <!-- /.content-wrapper -->
  <?php include ('footer.php');  ?>