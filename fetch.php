<?php
include('db.php');

if (isset($_POST['history'])) {
    function getDataTable($draw, $start, $length, $search) {
        global $conn;

        $sortBy = isset($_POST['sortby']) ? $_POST['sortby'] : '';
        $groupBy = '';
        $selectDate = 'date_acquired AS grouped_date';

        // Handling sorting and grouping by day, month, or year
        if ($sortBy == 'day') {
            $groupBy = "DATE(date_acquired)";
            $selectDate = "DATE(date_acquired) AS grouped_date";
        } elseif ($sortBy == 'month') {
            $groupBy = "YEAR(date_acquired), MONTH(date_acquired)";
            $selectDate = "CONCAT(YEAR(date_acquired), '-', LPAD(MONTH(date_acquired), 2, '0')) AS grouped_date";
        } elseif ($sortBy == 'year') {
            $groupBy = "YEAR(date_acquired)";
            $selectDate = "YEAR(date_acquired) AS grouped_date";
        }

        // Base query
        $query1 = "SELECT $selectDate, AVG(water_level) AS average_water_level 
                   FROM water_level_log WHERE 1=1";

        if (!empty($search)) {
            $escapedSearch = $conn->real_escape_string($search);

            $monthNames = [
                'January' => '01',
                'February' => '02',
                'March' => '03',
                'April' => '04',
                'May' => '05',
                'June' => '06',
                'July' => '07',
                'August' => '08',
                'September' => '09',
                'October' => '10',
                'November' => '11',
                'December' => '12'
            ];

            // Check if the search term is a valid month name
            if (isset($monthNames[$search])) {
                $month = $monthNames[$search];
                // Filter by the month
                $query1 .= " AND MONTH(date_acquired) = '$month'";
                $selectDate = "CONCAT(YEAR(date_acquired), '-', LPAD(MONTH(date_acquired), 2, '0')) AS grouped_date"; 
            } else {
                // If the search term is not a month name, search across other fields (date_acquired or water_level)
                $query1 .= " AND (date_acquired LIKE '%$escapedSearch%' OR water_level LIKE '%$escapedSearch%')";
            }
        }

        // Apply GROUP BY clause based on sorting
        if (!empty($groupBy)) {
            $query1 .= " GROUP BY $groupBy";
        }

        // Apply LIMIT for pagination
        $query1 .= " LIMIT " . intval($start) . ", " . intval($length);

        // Execute the query
        $result1 = $conn->query($query1);
        if (!$result1) {
            die("Query failed: " . $conn->error);
        }

        // Fetch the results
        $data = array();
        while ($row = $result1->fetch_assoc()) {
            $data[] = $row;
        }

        // Return the output in DataTables format
        $output = array(
            "draw" => intval($draw),
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            "data" => $data
        );

        return json_encode($output);
    }

    // Get the parameters from the POST request
    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];

    // Call the function and echo the result
    echo getDataTable($draw, $start, $length, $search);
    exit();
}



if (isset($_POST['residents'])) {

    function getDataTable1($draw, $start, $length, $search) {
        global $conn;

        $sortableColumns = array('firstname', 'middlename', 'lastnanme'); 
        
        $orderBy = $sortableColumns[0];
        $orderDir = 'ASC';

        if (isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
            $columnIdx = intval($_POST['order'][0]['column']);
            $orderDir = $_POST['order'][0]['dir'];

            if (isset($sortableColumns[$columnIdx])) {
                $orderBy = $sortableColumns[$columnIdx];
            }
        }

        $query1 = "SELECT *,  CONCAT(firstname, ' ', COALESCE(SUBSTRING(middlename, 1, 1), ''), '. ', lastname) AS fullname FROM recipients  WHERE 1=1";

        if (!empty($search)) {
            $escapedSearch = $conn->real_escape_string($search);
            $query1 .= " AND (firstname LIKE '%$escapedSearch%' OR middlename LIKE '%$escapedSearch%' OR lastname LIKE '%$escapedSearch%')";
        }

        $query1 .= " ORDER BY " . $orderBy . " " . $orderDir . " LIMIT " . intval($start) . ", " . intval($length);

        $result1 = $conn->query($query1);

        if (!$result1) {
            die("Query failed: " . $conn->error); 
        }

        $totalQuery1 = "SELECT COUNT(*) AS total_count FROM recipients WHERE 1=1";

        if (!empty($search)) {
            $escapedSearch = $conn->real_escape_string($search);
            $totalQuery1 .= " AND (firstname LIKE '%$escapedSearch%' OR middlename LIKE '%$escapedSearch%' OR lastname LIKE '%$escapedSearch%')";
        }

        $totalResult1 = $conn->query($totalQuery1);
        if (!$totalResult1) {
            die("Total count query failed: " . $conn->error);
        }

        $totalRow1 = $totalResult1->fetch_assoc();
        $totalRecords1 = $totalRow1['total_count'];

        $data = array();
        while ($row = $result1->fetch_assoc()) {
            $data[] = $row;
        }

        $output = array(
            "draw" => intval($draw),
            "recordsTotal" => intval($totalRecords1),
            "recordsFiltered" => intval($totalRecords1), 
            "data" => $data
        );

        return json_encode($output);
    }

    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];

    echo getDataTable1($draw, $start, $length, $search);
    exit();
}

if (isset($_POST['getdata'])) {
    $id = $_POST['id'];
    $query = "SELECT * FROM recipients WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id); 
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    } else {
        echo "Error executing query: " . $conn->error;
    }
    exit();
}


if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $value1 = $_POST['firstname'];
    $value2 = $_POST['middlename'];
    $value3 = $_POST['lastname'];
    $value4 = $_POST['phone_number'];
    $value5 = $_POST['residents_type'];

   

    $query = "UPDATE recipients
              SET firstname = '$value1', middlename = '$value2', lastname = '$value3', phone_number = '$value4',
               residents_type = '$value5'
              WHERE id = '$id'";
    if (mysqli_query($conn, $query)) {
        echo "Updated Successfully";
    } else {
        echo "Failed to update file in the database.";
    }
}

if (isset($_POST['delete'])) { 
    $id = $_POST['id'];
    $query = "DELETE FROM recipients WHERE id = '$id'";
    if (mysqli_query($conn, $query)) {
        echo "Your data has been deleted."; 
    } else {
        echo "Failed to delete data."; 
    }
    exit();
}
?>