function validateForm() {
    document.getElementById('title-error').innerHTML = "";
    document.getElementById('first-name-error').innerHTML = "";
    document.getElementById('middle-name-error').innerHTML = "";
    document.getElementById('last-name-error').innerHTML = "";
    document.getElementById('contact-no-error').innerHTML = "";
    document.getElementById('district-error').innerHTML = "";

    let title = document.forms["add_customer"]["title"].value;
    let firstName = document.forms["add_customer"]["first_name"].value;
    let middleName = document.forms["add_customer"]["middle_name"].value; // Keep it optional
    let lastName = document.forms["add_customer"]["last_name"].value;
    let contactNo = document.forms["add_customer"]["contact_no"].value;
    let district = document.forms["add_customer"]["district"].value;
    let isValid = true;

    if (title === "") {
        document.getElementById('title-error').innerHTML = "Title is required.";
        isValid = false;
    }
    if (firstName === "") {
        document.getElementById('first-name-error').innerHTML = "First name is required.";
        isValid = false;
    }
    if (lastName === "") {
        document.getElementById('last-name-error').innerHTML = "Last name is required.";
        isValid = false;
    }
    if (contactNo === "") {
        document.getElementById('contact-no-error').innerHTML = "Contact number is required.";
        isValid = false;
    } else if (contactNo.length !== 10 || isNaN(contactNo)) {
        document.getElementById('contact-no-error').innerHTML = "Contact number must be 10 digits.";
        isValid = false;
    }
    if (district === "") {
        document.getElementById('district-error').innerHTML = "District is required.";
        isValid = false;
    }

    return isValid; 
}
