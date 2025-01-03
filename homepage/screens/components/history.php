<div class="card bg-white p-3 shadow m-5">
    <h1 class="text-dark text-center">Historical Data</h1>
    <div class="row p-2 w-100 ">
      <div class="card col mx-4 align-items-center bg-white shadow text-dark ">
        <h3 class="text-center mt-4">History</h3>
        <div
          class="table-responsive w-100"
        >
          <table
            class="table table-primary"
            id="history_table"
          >
            <thead>
              <tr id="table_history_column_names">
                <th scope="col">Year</th>
                <th scope="col">Average Water Level</th>
              </tr>
            </thead>
            <tbody id="history_table_data">
          </table>
        </div>
        
      </div>
      <div class="card col-4 mx-4 align-items-center bg-white shadow text-dark p-3 ">
          <div class="mb-3">
            <label for="" class="form-label">Search By:</label>
            <select
              class="form-select form-select-md"
              name=""
              id="search_by"
            >
              <option selected>Select item</option>
              <option value="year">Year</option>
              <option value="month">Month</option>
              <option value="day">Day</option>
            </select>
          
        </div>
        
      </div>
    </div>
    </div>


    
<script src="../script.js"></script>
<script src="../assets/js/DataTables/datatables.js"></script>
<script>
  $(document).ready(()=>{
    $.post("../../ajax.php",{action:"get_yearly_history"},(yearly_history_response)=>{
          let yearly_history_array = JSON.parse(yearly_history_response);
          $("#history_table_data").empty();
          yearly_history_array.forEach(yearly_history => {
            $("#history_table_data").append(
              $("<tr scope='row'></tr>")
              .append("<td>"+yearly_history.year+"</td>")
              .append("<td>"+yearly_history.water_level+" cm</td>")
          );
          });
          $("#history_table").DataTable();
        });
    $("#search_by").on("change",(e)=>{
      if(e.target.value =="year"){
        $("#table_history_column_names").empty();
        $("#table_history_column_names")
        .append("<th scope='col'>Year</th>")
        .append("<th scope='col'>Average Water Level</th>");
        $.post("../../ajax.php",{action:"get_yearly_history"},(yearly_history_response)=>{
          let yearly_history_array = JSON.parse(yearly_history_response);
          $("#history_table_data").empty();
          yearly_history_array.forEach(yearly_history => {
            $("#history_table_data").append(
              $("<tr scope='row'></tr>")
              .append("<td>"+yearly_history.year+"</td>")
              .append("<td>"+yearly_history.water_level+" cm</td>")
          );
          });
          $("#history_table").DataTable();
        });
      }
      else if(e.target.value =="month"){
        $("#table_history_column_names").empty();
        $("#table_history_column_names")
        .append("<th scope='col'>Month</th>")
        .append("<th scope='col'>Average Water Level</th>");
        $.post("../../ajax.php",{action:"get_monthly_history"},(yearly_history_response)=>{
          let yearly_history_array = JSON.parse(yearly_history_response);
          $("#history_table_data").empty();
          yearly_history_array.forEach(yearly_history => {
            $("#history_table_data").append(
              $("<tr scope='row'></tr>")
              .append("<td>"+yearly_history.month+"</td>")
              .append("<td>"+yearly_history.water_level+" cm</td>")
          );
          });
        });
      }
      else if(e.target.value =="day"){
        $("#table_history_column_names").empty();
        $("#table_history_column_names")
        .append("<th scope='col'>Date</th>")
        .append("<th scope='col'>Average Water Level</th>");
        $.post("../../ajax.php",{action:"get_daily_history"},(yearly_history_response)=>{
          let yearly_history_array = JSON.parse(yearly_history_response);
          $("#history_table_data").empty();
          yearly_history_array.forEach(yearly_history => {
            $("#history_table_data").append(
              $("<tr scope='row'></tr>")
              .append("<td>"+yearly_history.day+"</td>")
              .append("<td>"+yearly_history.water_level+" cm</td>")
          );
          });
          $("#history_table").DataTable();
        });
      }
    });

  });
</script>