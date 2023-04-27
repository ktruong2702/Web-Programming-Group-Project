const validation = new JustValidate("#signup");

validation
    .addField("#name", [
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
        }
    ])

    .addField("#password", [
        {
            rule: "required"
        },
        {
            rule: "password"
        },
        {
            validator: (value) => () => {
                return fetch("validate-email.php?email=" + encodeURIComponent(value))
                        .then(function(response){
                            return response.json();
                        })
                        .then(function(json){
                            return json.available;
                        });

            },
            errorMessage: "The email already taken"
        }
    ])

    .addField("#password_confirmation", [
        {
            validator: (value, field) => {
                return value === fields["#password"].elem.value;  
            },
            errorMessage: "The passwords should match"
        }
    ])

    .onSuccess((event) => {
        document.getElementById("signup").submit();
    });