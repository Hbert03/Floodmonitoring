<?php


include('header.php');

?>



<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0">Dashboard</h4>
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
    <div class="small-box bg-info">
        <div class="inner">
            <div class="row">
                <div class="col-md-6">
                    <p id="location-name"><span><p id="date-time"></p></span></p>
                    <div class="row">
                    <div class="col">
                    <p style="color:black; font-size:25px">Water Speed:</p>
                    <div id="gaugeContainer" style="width: 120px; height: 120px;"></div>
                  
                    </div>  
                    <div class="col">
                    <p style="color:black; font-size:25px">Water Speed:</p>
                   
                    <div id="gaugeContainer1" style="width: 120px; height: 120px;"></div>
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <p id="flood-chance" class="float-right">
                    <span><p style="color:black; font-weight:bold; font-size:25px"  id="station-1">Total Volume: Loading...</p></span>
                    <span><p style="color:black; font-weight:bold; font-size:25px"  id="station-2">Total Volume: Loading...</p></span>
                    <span><p style="color:black; font-weight:bold; font-size:25px"  id="station-3">Total Volume: Loading...</p></span>
                      <span><p style="color:black; font-weight:bold; font-size:25px"  id="total-volume">Total Volume: Loading...</p></span>
                     
                </div>
               
               
            </div>
            <div class="row">
    
            </div>
        </div>
    </div>
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
                <h5 class="card-title">Weather Monitor</h5>

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
                  <div class="current-weather text-center">
            <img id="weather-icon" src="" alt="Weather Icon">
            <p id="temperature">--°C</p>
            <p id="condition">Condition</p>
        </div>
        <div class="additional-info">
            <p id="humidity">Humidity: --%</p>
            <p id="wind-speed">Wind Speed: -- km/h</p>
        </div>

                       <div class="chart" style="width:100%;">
                       <!-- Sales Chart Canvas -->
                         <p id="hourly-forecast" class="hourly-forecast"></p>
                        </div>
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