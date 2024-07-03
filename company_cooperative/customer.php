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

// เพิ่มข้อมูลลูกค้า
if (isset($_POST['add'])) {
    $customer_name = $_POST['customer_name'];
    $employee_id = $_POST['employee_id'];
    $sql = "INSERT INTO customers (customer_name, employee_id) VALUES ('$customer_name', $employee_id)";
    $conn->query($sql);
}

// ลบข้อมูลลูกค้า
if (isset($_POST['delete'])) {
    $customer_id = $_POST['customer_id'];
    $sql = "DELETE FROM customers WHERE customer_id = $customer_id";
    $conn->query($sql);
}

// แก้ไขข้อมูลลูกค้า
if (isset($_POST['edit'])) {
    $customer_id = $_POST['customer_id'];
    $customer_name = $_POST['customer_name'];
    $sql = "UPDATE customers SET customer_name = '$customer_name' WHERE customer_id = $customer_id";
    $conn->query($sql);
}

// ดึงข้อมูลลูกค้าทั้งหมด
$result = $conn->query("SELECT customers.*, employees.employee_name FROM customers JOIN employees ON customers.employee_id = employees.employee_id");

// ดึงข้อมูลพนักงานทั้งหมด
$employees = $conn->query("SELECT * FROM employees");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Customers</title>
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

        button {
            background-color: #4CAF50;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 3px;
        }

        button:hover {
            background-color: #45a049;
        }

        input[type="text"] {
            padding: 5px;
            width: 200px;
        }
    </style>
</head>
<body>
    <h2>Manage Customers</h2>
    <form method="post" action="">
        <label>Customer Name:</label>
        <input type="text" name="customer_name" required>
        <label>Employee:</label>
        <select name="employee_id">
            <?php while ($emp = $employees->fetch_assoc()): ?>
                <option value="<?php echo $emp['employee_id']; ?>"><?php echo $emp['employee_name']; ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit" name="add">Add</button>
    </form>

    <h3>Customers List</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Employee</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['customer_id']; ?></td>
            <td><?php echo $row['customer_name']; ?></td>
            <td><?php echo $row['employee_name']; ?></td>
            <td>
                <form method="post" action="" style="display:inline-block;">
                    <input type="hidden" name="customer_id" value="<?php echo $row['customer_id']; ?>">
                    <input type="text" name="customer_name" value="<?php echo $row['customer_name']; ?>">
                    <button type="submit" name="edit">Edit</button>
                </form>
                <form method="post" action="" style="display:inline-block;">
                    <input type="hidden" name="customer_id" value="<?php echo $row['customer_id']; ?>">
                    <button type="submit" name="delete">Delete</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
