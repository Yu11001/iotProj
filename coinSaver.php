<?php
// Include your database connection
require "connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle 'Clear' button
    if (isset($_POST['clear'])) {
        // Update the latest entry and set the total to 0
        $sql = "UPDATE project SET total = 0 ORDER BY id DESC LIMIT 1";
        if (mysqli_query($conn, $sql)) {
            echo "Total amount cleared!";
        } else {
            echo "Error clearing total: " . mysqli_error($conn);
        }
    }

    // Handle 'Withdraw' button
    if (isset($_POST['withdraw']) && isset($_POST['withdrawAmount'])) {
        $withdrawAmount = intval($_POST['withdrawAmount']);
        // Update the latest entry by reducing the total
        $sql = "UPDATE project SET total = total - $withdrawAmount WHERE total >= $withdrawAmount ORDER BY id DESC LIMIT 1";
        if (mysqli_query($conn, $sql)) {
            echo "Successfully withdrew $withdrawAmount!";
        } else {
            echo "Error withdrawing amount: " . mysqli_error($conn);
        }
    }
}

// Fetch the latest total amount
$sql = "SELECT total FROM project ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$totalAmount = $row['total'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coin Saver Project</title>
    
    <!-- 引入 Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=savings" />
    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            margin-top: 50px;
            width: 300px;
        }
        h1 {
            margin-bottom: 30px;
            text-align: center;
        }
        .total-amount {
            font-size: 20px;
            color: #76b8ff;
            text-align: center;
            margin-bottom: 30px;
        }
        .form-group button {
            width: 100%;
        }
        .form-group input {
            margin-bottom: 10px;
        }
        .coin_saver{
            color: #fc9483;
        }
        .btnn{
            background-color:#00dc80;
        }
        .btnb{
            background-color:#dc4900;
        }
    </style>
</head>
<body>

<div class="container center">
    <h1>
        <span class="material-symbols-outlined">
            savings
        </span>
        <span class="coin_saver"> Coin Saver </span>
        <span class="material-symbols-outlined">
            savings
        </span>
    </h1>
    <div class="total-amount">
        Total Amount Saved: <?php echo $totalAmount; ?> Baht
    </div>
    
    <!-- Withdraw amount form -->
    <form method="post" class="form-group">
        <input type="number" name="withdrawAmount" class="form-control" placeholder="Enter amount to withdraw" required>
        <button type="submit" name="withdraw" class="btn btn-success btn-lg btnn">Withdraw</button>
    </form>

    <br>
    <!-- Clear total amount button -->
    <form method="post" class="form-group">
        <button type="submit" name="clear" class="btn btn-danger btn-lg btnb">Clear Total</button>
    </form>
</div>

<!-- 引入 Bootstrap JS 和依赖库 -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>