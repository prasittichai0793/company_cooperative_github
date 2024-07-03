<?php
$servername = "localhost";
$username = "root";
$password = "far123456";
$dbname = "db_company_cooperative";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ดึงข้อมูลรายงาน
$sql = "SELECT departments.department_id, departments.department_name, customers.customer_name 
        FROM customers 
        JOIN employees ON customers.employee_id = employees.employee_id 
        JOIN departments ON employees.department_id = departments.department_id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Department Customer Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 20px;
        }

        h2 {
            color: #333;
        }

        form {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }
    </style>
</head>
<body>
    <h2>Department Customer Report</h2>
    <table border="1">
        <tr>
            <th>Department ID</th>
            <th>Department Name</th>
            <th>Customer Name</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['department_id']; ?></td>
            <td><?php echo $row['department_name']; ?></td>
            <td><?php echo $row['customer_name']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
