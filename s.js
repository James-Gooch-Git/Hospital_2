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

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("updateForm").addEventListener("submit", function(event) {
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
