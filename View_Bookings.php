
<?php include 'functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patients</title>
    <link rel="stylesheet" href="style.css"> <!-- Make sure your CSS file is linked here -->
</head>
<body>

<div class="container">
    <?php include 'sidebar.php'; ?>
   
    <main class="content">
        <?php include 'list_bookings.php'; ?>
    </main>

    <?php include 'make_Booking.php'; ?>
    
   
</div>


</body>
</html>
