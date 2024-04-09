<?php
include_once 'functions.php';
        $Availabilities = getAvailability();
        foreach ($Availabilities as $availability) {
            echo "<div class='availability-box'>";
            echo "<p>Date:" . htmlspecialchars($availability['date']) . "</p>";
            echo "<p>Consultant: " . htmlspecialchars($availability['consultantName']) . "</p>";
            echo "<p>Time: " . htmlspecialchars($availability['timeSlotHourBlock']) . "</p>";
            
            echo "<div class='availability-actions'>";
            echo "<a href='update_Availability.php?id=" . htmlspecialchars($availability['availability_id']) . "' class='btn update-btn'>Update</a>";
            echo "<button onclick='confirmDelete(" . htmlspecialchars($availability['availability_id']) . ")' class='btn delete-btn'>Delete</button>";
            echo "</div>";
            echo "</div>";
        }
        ?>