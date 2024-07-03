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

// เพิ่มข้อมูลพนักงาน
if (isset($_POST['add'])) {
    $employee_name = $_POST['employee_name'];
    $department_id = $_POST['department_id'];
    $sql = "INSERT INTO employees (employee_name, department_id) VALUES ('$employee_name', $department_id)";
    $conn->query($sql);
}

// ลบข้อมูลพนักงาน
if (isset($_POST['delete'])) {
    $employee_id = $_POST['employee_id'];
    $sql = "DELETE FROM employees WHERE employee_id = $employee_id";
    $conn->query($sql);
}

// แก้ไขข้อมูลพนักงาน
if (isset($_POST['edit'])) {
    $employee_id = $_POST['employee_id'];
    $employee_name = $_POST['employee_name'];
    $sql = "UPDATE employees SET employee_name = '$employee_name' WHERE employee_id = $employee_id";
    $conn->query($sql);
}

// ดึงข้อมูลพนักงานทั้งหมด
$result = $conn->query("SELECT employees.*, departments.department_name FROM employees JOIN departments ON employees.department_id = departments.department_id");

// ดึงข้อมูลแผนกทั้งหมด
$departments = $conn->query("SELECT * FROM departments");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Employees</title>
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
    <h2>Manage Employees</h2>
    <form method="post" action="">
        <label>Employee Name:</label>
        <input type="text" name="employee_name" required>
        <label>Department:</label>
        <select name="department_id">
            <?php while ($dept = $departments->fetch_assoc()): ?>
                <option value="<?php echo $dept['department_id']; ?>"><?php echo $dept['department_name']; ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit" name="add">Add</button>
    </form>

    <h3>Employees List</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Department</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['employee_id']; ?></td>
                <td><?php echo $row['employee_name']; ?></td>
                <td><?php echo $row['department_name']; ?></td>
                <td>
                    <form method="post" action="" style="display:inline-block;">
                        <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">
                        <input type="text" name="employee_name" value="<?php echo $row['employee_name']; ?>">
                        <button type="submit" name="edit">Edit</button>
                    </form>
                    <form method="post" action="" style="display:inline-block;">
                        <input type="hidden" name="employee_id" value="<?php echo $row['employee_id']; ?>">
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