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
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#tab1">Realtime Data</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#tab2">History</a>
              </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
              <div id="tab1" class="tab-pane active"><br>
                <div class="table-responsive">
                <p class="text-center">Realtime Water Level From Station 1 to 3</p>
                  <div class="chart" style="width:100%; height: 500px; margin-bottom:5em">
                    <!-- Sales Chart Canvas -->
                    <canvas id="waterLevelChart"></canvas>
                  </div>
                </div>
              </div>
              
              <div id="tab2" class="tab-pane fade"><br>
                <div class="table-responsive">
                  <div class="row">
                    <div class="col-md-4">
                <select class="form-control" id="timeRange">
              <option value="minute">Last Hour (in Minutes)</option>
              <option value="hour" selected>Last 24 Hours (By Hour)</option>
              <option value="day">Last 7 Days (By Day)</option>
              <option value="month">Last 12 Months (By Month)</option>
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
          
          </div>


          <p class="text-center mt-3">History of Water Level From Station 1 to 3</p>
            <div class="chart" style="width:100%; height: 500px;">
           
          
           
                    <canvas id="waterLevelChart1"></canvas>
                  
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


    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <!-- /.row -->
           <!-- Main row -->
        <div class="row">
          <div class="col-md-12">
            <div class="card">
            
          
 
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
    <h3 class="card-title">Water Level & Turbidity</h3>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-6">
        <p class="text-center">Percentage</p>
        <div class="station_1_waterlevel" style="height:250px"></div>
      </div>
      <div class="col-md-6">
      <p class="text-center">Percentage</p>
        <div class="station_1_turbidity" style="height:250px" ></div>
      </div>
    </div>
    <div class="row">
    <div class="col-md-6">
    <p class="text-center">Percentage</p>
        <div class="station_2_waterlevel" style="height:250px"></div>
      </div>
      <div class="col-md-6">
      <p class="text-center">Percentage</p>
        <div class="station_3_waterlevel" style="height:250px"></div>
      </div>
      <!-- <div class="col-md-6">
        <div class="station_2_raindrop" style="height:250px" ></div>
      </div> -->
    </div>
    <div class="row">
      
      <!-- <div class="col-md-6">
        <div class="station_3_raindrop" style="height:250px" ></div>
      </div> -->
    </div>
  </div>
</div>
        </div>
        <!-- /.row -->
</div>
</section>



   <script>
    
   </script>

  <!-- /.content-wrapper -->
  <?php include ('footer.php');  ?>