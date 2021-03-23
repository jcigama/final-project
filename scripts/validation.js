document.getElementById("other").onclick = showOtherField;
document.getElementById("male").onclick = showOtherField;
document.getElementById("female").onclick = showOtherField;

function showOtherField() {
    let otherField = document.getElementById("other");
    let male = document.getElementById("male");
    let female = document.getElementById("female");
    let otherInputField = document.getElementById("otherGenderInput");

    if(otherField.checked){
        otherInputField.classList.remove("d-none");
    } else if(male.checked) {
        otherInputField.classList.add("d-none");
    } else if(female.checked) {
        otherInputField.classList.add("d-none");
    }

}