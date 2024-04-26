const validation = new JustValidate("#signup");
const patient_validation = new JustValidate("#addpatient");

validation
    .addField("#fName", [
        {
            rule: "required"
        }
    ])
    .addField("#lName", [
        {
            rule: "required"
        }
    ])
    .addField("#email", [
        {
            rule: "required"
        },
        {
            rule: "email"
        },
        {
            validator: (value) => () => {
                return fetch("validate-email.php?email=" + encodeURIComponent(value))
                       .then(function(response) {
                           return response.json();
                       })
                       .then(function(json) {
                           return json.available;
                       });
            },
            errorMessage: "email already taken"
        }
    ])
    .addField("#type_ID", [
        {
            rule: "required"
        }
    ])
    .addField("#password", [
        {
            rule: "required"
        },
        {
            rule: "password"
        }
    ])
    .addField("#password_confirmation", [
        {
            validator: (value, fields) => {
                return value === fields["#password"].elem.value;
            },
            errorMessage: "Passwords should match"
        }
    ])
    .onSuccess((event) => {
        document.getElementById("signup").submit();
    });
    
patient_validation
 
    .addField("#patient_fName", [
        {
            rule: "required"
        }
    ])
    .addField("#patient_lName", [
        {
            rule: "required"
        }
    ])
    .addField("#patient_ContactNO", [
        {
            rule: "required"
        }
    ])
    .addField("#patient_Email", [
        {
            rule: "required"
        },
        {
            rule: "email"
        },
        {
            validator: (value) => () => {
                return fetch("validate-patient-email.php?email=" + encodeURIComponent(value))
                       .then(function(response) {
                           return response.json();
                       })
                       .then(function(json) {
                           return json.available;
                       });
            },
            errorMessage: "email already taken"
        }
    ])
    .addField("#patient_address", [
        {
            rule: "required"
        }
    ])

    .onSuccess((event) => {
        document.getElementById("addpatient").submit();
    });
    