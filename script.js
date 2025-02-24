
function confirmLogout() {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will be logged out!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("logoutForm").submit();
        }
    });
}


function checkWaterLevel() {
    fetch('send_sms.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        }
    })
    .then(response => response.json())
    .then(data => {
        // console.log(`[${new Date().toLocaleTimeString()}] ${data.message}`);

        if (data.status === 'sms_sent') {
            // console.log("✅ SMS successfully sent to all recipients.");
        } else if (data.status === 'warning' || data.status === 'critical') {
            // console.log(`⚠️ Alert: ${data.message}`);
        } else {
            // console.log("ℹ️ No SMS sent. Status: " + data.status);
        }
    })
    .catch(error => console.error("❌ Error fetching water level:", error));
}


setInterval(checkWaterLevel, 10000);


$(function () {
    let gauge;

    function initGauge() {
        gauge = $("#gaugeContainer").dxCircularGauge({
            value: 0,  // Initial value
            valueIndicator: {
                color: '#222629'
            },
            geometry: {
                startAngle: 180,
                endAngle: 360
            },
            scale: {
                startValue: 0,
                endValue: 10,
                customTicks: [0, 2, 4, 6, 8, 10], 
                tick: {
                    length: 8
                },
                label: {
                    font: {
                        color: '#222629',
                        size: 9,
                        family: '"Open Sans", sans-serif'
                    }
                }
            },
            title: {
                verticalAlignment: 'bottom',
                text: "Water Speed",
                font: {
                    family: '"Open Sans", sans-serif',
                    color: '#222629',
                    size: 12
                },
                subtitle: {
                    text: "0 m/s",
                    font: {
                        family: '"Open Sans", sans-serif',
                        color: '#222629',
                        weight: 700,
                        size: 20
                    }
                }
            }
        }).dxCircularGauge("instance");
    }

    $(function () {
        let gauge1, gauge2;
    
        function initGauge() {
            gauge1 = $("#gaugeContainer").dxCircularGauge({
                value: 0,  
                valueIndicator: { color: '#222629' },
                geometry: { startAngle: 180, endAngle: 360 },
                scale: {
                    startValue: 0,
                    endValue: 10,
                    customTicks: [0, 2, 4, 6, 8, 10], 
                    tick: { length: 8 },
                    label: {
                        font: { color: '#222629', size: 9, family: '"Open Sans", sans-serif' }
                    }
                },
                title: {
                    verticalAlignment: 'bottom',
                    text: "Water Speed (Station 1 → 2)",
                    font: { family: '"Open Sans", sans-serif', color: '#222629', size: 12 },
                    subtitle: {
                        text: "0 m/s",
                        font: { family: '"Open Sans", sans-serif', color: '#222629', weight: 700, size: 20 }
                    }
                }
            }).dxCircularGauge("instance");
    
            gauge2 = $("#gaugeContainer1").dxCircularGauge({
                value: 0,  
                valueIndicator: { color: '#222629' },
                geometry: { startAngle: 180, endAngle: 360 },
                scale: {
                    startValue: 0,
                    endValue: 10,
                    customTicks: [0, 2, 4, 6, 8, 10], 
                    tick: { length: 8 },
                    label: {
                        font: { color: '#222629', size: 9, family: '"Open Sans", sans-serif' }
                    }
                },
                title: {
                    verticalAlignment: 'bottom',
                    text: "Water Speed (Station 2 → 3)",
                    font: { family: '"Open Sans", sans-serif', color: '#222629', size: 12 },
                    subtitle: {
                        text: "0 m/s",
                        font: { family: '"Open Sans", sans-serif', color: '#222629', weight: 700, size: 20 }
                    }
                }
            }).dxCircularGauge("instance");
        }
    


        async function fetchVolumeData() {
            try {
                const response = await fetch('get_volume.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'action=get_last_data'
                });
    
                if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
    
                const dataResponse = await response.json();
                const { highest_levels, total_volume, velocity } = dataResponse;
    
                $("#station-1").text(`Station 1: ${highest_levels.station_1} cm`);
                $("#station-2").text(`Station 2: ${highest_levels.station_2} cm`);
                $("#station-3").text(`Station 3: ${highest_levels.station_3} cm`);
                $("#total-volume").text(`Total Volume: ${total_volume.toFixed(2)} cm³`);
    
                let waterSpeed1to2 = velocity.station_1_to_2.toFixed(2);
                let waterSpeed2to3 = velocity.station_2_to_3.toFixed(2);
    
 
                gauge1.option("value", parseFloat(waterSpeed1to2));
                gauge1.option("title.subtitle.text", `${waterSpeed1to2} m/s`);
    
               
                gauge2.option("value", parseFloat(waterSpeed2to3));
                gauge2.option("title.subtitle.text", `${waterSpeed2to3} m/s`);
    
            } catch (error) {
                // console.error("Error fetching volume data:", error);
            }
        }
    
        initGauge(); 
        fetchVolumeData();
        setInterval(fetchVolumeData, 5000);
    });
    
    initGauge(); 
    fetchVolumeData();  
    setInterval(fetchVolumeData, 5000); 
});




$(document).ready(function () {
    
            $("button.save").on("click", function(event){
                event.preventDefault();
                var requiredFilled = true;
                $("#addForm input, #addForm select").each(function() {
                  if ($(this).prop("required") && !$(this).val()) {
                        requiredFilled = false;
                        $(this).addClass("is-invalid");
                    } else {
                        $(this).removeClass("is-invalid");
                    }
                });
          
                if (requiredFilled) {
                    $.ajax({
                        url: "function.php",
                        type: "POST",
                        data: $("#addForm").serialize() + "&save=true",
                        success: function(response) {
                            try {
                                response = JSON.parse(response);
                            } catch (e) {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Failed to parse JSON response: " + e,
                                    icon: "error"
                                });
                                return;
                            }
          
                            if (response.success) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Student Successfully Saved!",
                                    showConfirmButton: true
                                })
                            } else {
                                toastr.error("Verify your Entry: " + response.error);
                            }
                        }
                    });
                } else {
                    toastr.error("Please fill out all required fields.");
                }
            });
   })




$(document).ready(function () {
    $('#sortBy').select({
        placeholder: "Select sort option",
        allowClear: true,
    });

    var table = $('#history').DataTable({
        dom: 'lBfrtip',
        buttons: ['copy', 'excel'],
        serverSide: true,
        lengthChange: true,
        responsive: true,
        autoWidth: false,
        ajax: {
            url: "fetch.php",
            type: "POST",
            data: function (d) {
                d.history = true;
                d.sortby = $('#sortBy').val();
            },
            error: function (xhr, error, thrown) {
                // console.log("Ajax Failed: " + thrown);
            }
        },
        columns: [
            {
                "data": "grouped_date",
              
                "render": function (data, type, row) {
                    if (type === "display" || type === "filter") {
                        const options = { year: 'numeric', month: 'long', day: 'numeric' };
                        return new Date(data).toLocaleDateString('en-US', options);
                    }
                    return data;
                }
            },
            { "data": "average_water_level"},
        ],
    });


    $('#sortBy').on('change', function () {
        table.ajax.reload();
    });
});




$(document).ready(function () {
 $('#resident_table').DataTable({
               serverSide: true,
               lengthChange: true,
               responsive: true,
               autoWidth: false,
               ajax: {
                   url: "fetch.php",
                   type: "POST",
                   data: {residents: true},
                   error: function(xhr, error, thrown) {
                    //    console.log("Ajax Failed: " + thrown);
                   }
               },
               columns: [
                   { "data": "fullname" },
                   { "data": "phone_number" },
                   { "data": "residents_type" },
                   {"data": null,
                       "render": function(data, type, row){
                           return "<button class='btn btn-info btn-sm edit' data-residents='"+row.id+"'>Edit<span><i style='margin-left:2px' class='fas fa-pen'></i></span></button>";
                       }
                   },
                   {"data": null,
                       "render": function(data, type, row){
                           return "<button class='btn btn-danger btn-sm delete' data-residents='"+row.id+"'>Delete<span><i style='margin-left:2px' class='fas fa-trash'></i></span></button>";
                       }
                   }
               ],
               drawCallback: function(){
                   edit();
                   deleteid();
               }
           });
  
       
       function deleteid(){
           $('#resident_table').on('click', 'button.delete', function(){
               let id = $(this).data('residents');
                       Swal.fire({
                           title: 'Are you sure?',
                           text: "You want to delete it?",
                           icon: 'warning',
                           showCancelButton: true,
                           confirmButtonColor: '#3085d6',
                           cancelButtonColor: '#d33',
                           confirmButtonText: 'Yes, delete it!'
                       }).then((result) => {
                           if (result.isConfirmed) {
                               $.ajax({
                                   url: 'fetch.php',
                                   type: 'POST',
                                   data: {
                                       delete: true,
                                       id: id
                                   },
                                   success: function(response) {
                                       if (response.trim() === "Your data has been deleted.") {
                                           Swal.fire(
                                               'Deleted!',
                                               'File has been deleted successfully.',
                                               'success'
                                           );
                                           $('#resident_table').DataTable().ajax.reload(null, false);
                                       } else {
                                           Swal.fire(
                                               'Failed!',
                                               'Failed to delete file.',
                                               'error'
                                           );
                                       }
                                   },
                               });
                           }
                       });
                   });
           }
        
       
          function edit() {
           $('#resident_table').on('click', 'button.edit', function() {
               let id = $(this).data('residents');
               $.ajax({
                   url: 'fetch.php',
                   type: 'POST',
                   data: {
                       getdata: true,
                       id: id
                   },
                   success: function(response) {
                       if (response.trim() !== "") {
                           var data = JSON.parse(response);
                           Swal.fire({
                               title: 'Resident Details',
                               html: '<label>Firstname:</label>' +
                                     '<input id="swal-input1" class="form-control mb-2" value="' + data[0].firstname + '">' +
                                     '<label>Middlename:</label>' +
                                     '<input id="swal-input2" class="form-control mb-2" value="' + data[0].middlename + '">' +
                                     '<label>Lastname:</label>' +
                                     '<input id="swal-input3" class="form-control mb-2" value="' + data[0].lastname + '">' +
                                     '<label>Address:</label>' +
                                     '<input id="swal-input4" class="form-control mb-2" value="' + data[0].phone_number + '">' +
                                     '<label>Mobile Number:</label>' +
                                     '<input id="swal-input5" class="form-control mb-2" value="' + data[0].residents_type + '">',
                                     
                               focusConfirm: false,
                               confirmButtonText: 'Update',
                               preConfirm: () => {
                                   const value1 = document.getElementById('swal-input1').value;
                                   const value2 = document.getElementById('swal-input2').value;
                                   const value3 = document.getElementById('swal-input3').value;
                                   const value4 = document.getElementById('swal-input4').value;
                                   const value5 = document.getElementById('swal-input5').value;
        
                                   return [value1, value2, value3, value4, value5];
                               },
                           }).then((result) => {
                               if (result.isConfirmed) {
                                   const [value1, value2, value3, value4, value5]= result.value;
                                   $.ajax({
                                       url: 'fetch.php',
                                       type: 'POST',
                                       data: {
                                           update: true,
                                           id: id,
                                           firstname: value1,
                                           middlename: value2,
                                           lastname: value3,
                                           phone_number: value4,
                                           residents_type: value5,
                                       },
                                       success: function(response) {
                                           if (response.trim() === "Updated Successfully") {
                                               Swal.fire(
                                                   'Updated!',
                                                   'File has been updated successfully.',
                                                   'success'
                                               );
                                               $('#resident_table').DataTable().ajax.reload(null, false);
                                           } else {
                                               Swal.fire(
                                                   'Failed!',
                                                   'Failed to update file.',
                                                   'error'
                                               );
                                           }
                                       },
                                   });
                               }
                           });
                       }
                   },
               });
           });
           };
        })
       

        $(document).ready(function () {
            let table = $('#volumeTable').DataTable({
                ajax: {
                    url: 'get_volume_his.php',
                    dataSrc: 'data'
                },
                columns: [
                    { data: 'station' },
                    { data: 'period' },
                    { data: 'volume' },
                    { data: 'readings' }
                ]
            });
        
        
            $('#filterSelect').on('change', function () {
                let selectedFilter = $(this).val();
                table.ajax.url('get_volume_his.php?filter=' + selectedFilter).load();
            });
        });
        



    

        
document.addEventListener('DOMContentLoaded', function () {
    var currentLocation = location.href;
    var menuItem = document.querySelectorAll('#sidebarNav .nav-link');
    var menuLength = menuItem.length;
    for (var i = 0; i < menuLength; i++) {
      if (menuItem[i].href === currentLocation) {
        menuItem[i].classList.add('active');
        if (menuItem[i].closest('.nav-treeview')) {
          menuItem[i].closest('.nav-treeview').parentNode.querySelector('.nav-link').classList.add('active');
        }
      }
    }
  });


  



function checkSensorStatus() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'check_status.php', true);
    
    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            var response = JSON.parse(xhr.responseText);
            
            if (response.status === "warning" || response.status === "error") {
                response.stations.forEach(station => {
                    // console.warn("Station " + station.station + " issue: " + station.message);
                    toastr.error("⚠ Warning: " + station.message);
                  
                });
            }
        } else {
            // console.error("Failed to fetch sensor status.");
        }
    };

    xhr.onerror = function () {
        // console.error("AJAX request failed.");
    };

    xhr.send();
}


setInterval(checkSensorStatus, 6000);


checkSensorStatus();

document.getElementById("generateReport").addEventListener("click", function () {
    var timeRange = document.getElementById("timeRange").value;
    var station = document.getElementById("station").value;
    var xhr = new XMLHttpRequest();

    // FIXED: Added & between parameters
    xhr.open("GET", "fetch_report.php?time_range=" + encodeURIComponent(timeRange) + "&station=" + encodeURIComponent(station), true);

    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            document.getElementById("modalReportContent").innerHTML = xhr.responseText;

            var reportModal = new bootstrap.Modal(document.getElementById("reportModal"));
            reportModal.show();
        } else {
            alert("Failed to fetch the report.");
        }
    };
    xhr.send();
});


function printTable() {
    var modalContent = document.getElementById("modalReportContent").innerHTML;
    
    var newWindow = window.open("", "_blank");
    newWindow.document.write(`
        <html>
            <head>
                <title>Print Report</title>
                <style>
                    body { font-family: Arial, sans-serif; padding: 20px; }
                    table { width: 100%; border-collapse: collapse; }
                    th, td { border: 1px solid black; padding: 8px; text-align: left; }
                    @media print { body { visibility: visible; } }
                </style>
            </head>
            <body>
                ${modalContent}
            </body>
        </html>
    `);
    
    newWindow.document.close();
    newWindow.print();
    newWindow.close();
}
