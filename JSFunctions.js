
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

function enableEdit(userId) {
    document.getElementById('editFields_' + userId).style.display = 'block';
    document.getElementById('actionButtons_' + userId).style.display = 'none';
    document.getElementById('confirmButtons_' + userId).style.display = 'block';
    
    // Hide the static text display
    var staticInfo = document.querySelectorAll('#employeeBox_' + userId + ' p');
    staticInfo.forEach(function(item) {
        item.style.display = 'none';
    });
}
function confirmEdit(userId) {
    // Assuming the form's ID is set to 'employeeForm_' followed by the userID
    var form = document.querySelector('#employeeForm_' + userId);
    if (form) {
        form.submit();
    } else {
        console.error("Form not found for userID:", userId);
    }
}


function cancelEdit(userId) {
    document.getElementById('editFields_' + userId).style.display = 'none';
    document.getElementById('actionButtons_' + userId).style.display = 'block';
    document.getElementById('confirmButtons_' + userId).style.display = 'none';
    
    // Show the static text display again
    var staticInfo = document.querySelectorAll('#employeeBox_' + userId + ' p');
    staticInfo.forEach(function(item) {
        item.style.display = 'block';
    });
}

function confirmDelete(userId) {
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


function cancelEdit(patientId) {
    document.getElementById('editFields_' + patientId).style.display = 'none';
    document.getElementById('actionButtons_' + patientId).style.display = 'block';
    document.getElementById('confirmButtons_' + patientId).style.display = 'none';
    
    // Show the static text display again
    var staticInfo = document.querySelectorAll('#patientBox_' + patientId + ' p');
    staticInfo.forEach(function(item) {
        item.style.display = 'block';
    });
}

function confirmDelete(patientId) {
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