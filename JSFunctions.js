
function searchPatients() {
    var input = document.getElementById("searchPInput").value;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("patientList").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "search_patients.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("query=" + input);
}


function searchStaff() {
    var input = document.getElementById("searchEInput").value;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("staffList").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "search_staff.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("query=" + input);
}

function enableEditE(userId) {
    document.getElementById('editFields_' + userId).style.display = 'block';
    document.getElementById('actionButtons_' + userId).style.display = 'none';
    document.getElementById('confirmButtons_' + userId).style.display = 'block';
    
    // Hide the static text display
    var staticInfo = document.querySelectorAll('#employeeBox_' + userId + ' p');
    staticInfo.forEach(function(item) {
        item.style.display = 'none';
    });
}

function confirmEditE(userId) {
    // Assuming the form's ID is set to 'patientForm_' followed by the userID
    var form = document.querySelector('#employeeForm_' + userId);
    if (form) {
        form.submit();
    } else {
        console.error("Form not found for userID:", usertId);
    }
}


function hideFormAfterUpdate() {
    // Logic to hide the form, e.g. by hiding the 'editFields' div
    var editFields = document.querySelectorAll('div[id^="editFields_"]');
    editFields.forEach(function(editField) {
        editField.style.display = 'none';
    });
    // Logic to show the 'employee-actions' div again
    var actionButtons = document.querySelectorAll('div[id^="actionButtons_"]');
    actionButtons.forEach(function(actionButton) {
        actionButton.style.display = 'block';
    });
}


function cancelEditE(userId) {
    document.getElementById('editFields_' + userId).style.display = 'none';
    document.getElementById('actionButtons_' + userId).style.display = 'block';
    document.getElementById('confirmButtons_' + userId).style.display = 'none';
    
    // Show the static text display again
    var staticInfo = document.querySelectorAll('#employeeBox_' + userId + ' p');
    staticInfo.forEach(function(item) {
        item.style.display = 'block';
    });
}

function confirmDeleteE(userId) {
    if (confirm("Are you sure you want to delete this employee?")) {
        // If confirmed, proceed with deletion
        // Here you can either submit a form or make an AJAX call to delete the employee

        // Example of making a form submission
        var form = document.createElement('form');
        document.body.appendChild(form);
        form.method = 'post';
        form.action = 'delete_employee.php';

        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'user_ID';
        input.value = userId;
        form.appendChild(input);

        form.submit();
    }
}

function confirmDeleteB(availabilityId) {
    if (confirm("Are you sure you want to delete this booking?")) {
        // If confirmed, proceed with deletion
        // Here you can either submit a form or make an AJAX call to delete the employee

        // Example of making a form submission
        var form = document.createElement('form');
        document.body.appendChild(form);
        form.method = 'post';
        form.action = 'delete_booking.php';

        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'availability_id';
        input.value = availabilityId;
        form.appendChild(input);

        form.submit();
    }
}

document.addEventListener("DOMContentLoaded", function() {
    // Select all forms with the class 'update-form'
    var forms = document.querySelectorAll('.update-form');

    forms.forEach(function(form) {
        form.addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent the default form submission
            var formData = new FormData(this);

            fetch('update_patient.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.text())
            .then(data => {
                console.log("Success:", data);
                // Optionally, you can log 'data' to the console if your PHP script echoes something back
            })
            .catch(error => {
                console.error("Error:", error);
            });
        });
    });
});




function enableEdit(patientId) {
    document.getElementById('editFields_' + patientId).style.display = 'block';
    document.getElementById('actionButtons_' + patientId).style.display = 'none';
    document.getElementById('confirmButtons_' + patientId).style.display = 'block';
    
    // Hide the static text display
    var staticInfo = document.querySelectorAll('#patientBox_' + patientId + ' p');
    staticInfo.forEach(function(item) {
        item.style.display = 'none';
    });
}
function confirmEdit(patientId) {
    // Assuming the form's ID is set to 'patientForm_' followed by the userID
    var form = document.querySelector('#patientForm_' + patientId);
    if (form) {
        form.submit();
    } else {
        console.error("Form not found for userID:", patientId);
    }
}


function cancelEditP(patientId) {
    document.getElementById('editFields_' + patientId).style.display = 'none';
    document.getElementById('actionButtons_' + patientId).style.display = 'block';
    document.getElementById('confirmButtons_' + patientId).style.display = 'none';
    
    // Show the static text display again
    var staticInfo = document.querySelectorAll('#patientBox_' + patientId + ' p');
    staticInfo.forEach(function(item) {
        item.style.display = 'block';
    });
}

function confirmDeleteP(patientId) {
    if (confirm("Are you sure you want to delete this patient?")) {
        // If confirmed, proceed with deletion
        // Here you can either submit a form or make an AJAX call to delete the employee

        // Example of making a form submission
        var form = document.createElement('form');
        document.body.appendChild(form);
        form.method = 'post';
        form.action = 'delete_patient.php';

        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'patient_ID';
        input.value = patientId;
        form.appendChild(input);

        form.submit();
    }
}

document.addEventListener("DOMContentLoaded", function() {
    // Select all forms with the class 'update-form'
    var forms = document.querySelectorAll('.update-form');

    forms.forEach(function(form) {
        form.addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent the default form submission
            var formData = new FormData(this);

            fetch('update_patient.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.text())
            .then(data => {
                console.log("Success:", data);
                // Optionally, you can log 'data' to the console if your PHP script echoes something back
            })
            .catch(error => {
                console.error("Error:", error);
            });
        });
    });
});

// document.addEventListener("DOMContentLoaded", function() {
//     document.getElementById("updateForm").addEventListener("submit", function(event) {
//         event.preventDefault(); // Prevent the default form submission
//         var formData = new FormData(this);

//         fetch('update_patient.php', {
//             method: 'POST',
//             body: formData,
//         })
//         .then(response => response.text()) 
//         .then(data => {
//             console.log("Success:", data);
//             // Optionally, you can log 'data' to the console if your PHP script echoes something back
//         })
//         .catch(error => {
//             console.error("Error:", error);
//         });
//     });
// });

function setMinDate() {
    var today = new Date().toISOString().split('T')[0]; 
    document.getElementById("date").setAttribute("min", today); // Sets the min attribute to today's date
}
document.addEventListener('DOMContentLoaded', setMinDate);

let originalData = {};

function toggleEditU() {
    let inputs = document.querySelectorAll('#editForm input');
    inputs.forEach(input => {
        if (input.style.display === 'none') {
            input.style.display = 'inline';
            input.previousElementSibling.style.display = 'none';
        } else {
            input.style.display = 'none';
            input.previousElementSibling.style.display = 'inline';
        }
    });
}



function saveEditU() {
    let formData = new FormData(document.getElementById('editForm'));
    fetch('update_profile.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())  // Assuming response as text for simplicity
    .then(data => {
        if (data.includes("Success")) {
            window.location.href = 'View_Profile.php'; // Redirect on success
        } else {
            throw new Error(data); // Handle errors
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to update profile: ' + error.message);
    });
}




function cancelEditU() {
    // Reset input values to original data
    document.querySelectorAll('input').forEach(input => {
        input.value = originalData[input.id];
        input.style.display = 'none';
        input.previousElementSibling.style.display = 'inline';
    });
}
