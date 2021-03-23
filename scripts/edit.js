document.getElementById("subscriptionCheck").onclick = showSubscriptionFields;

function showSubscriptionFields() {
    let intervalField = document.getElementById("intervalField");
    let subscriptionField = document.getElementById("subscriptionField");
    let subscriptionCheck = document.getElementById("subscriptionCheck");

    if(!subscriptionCheck.checked){
        intervalField.classList.add("d-none");
        subscriptionField.classList.add("d-none");
    } else {
        intervalField.classList.remove("d-none");
        subscriptionField.classList.remove("d-none");
    }

}