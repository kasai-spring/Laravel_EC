function address_select_checker() {
    let address_form = document.getElementsByClassName("address_form");
    if (document.getElementById("do_input").checked) {
        for (let i = 0; i < address_form.length; i++) {
            address_form[i].disabled = false;
        }
    } else {
        for (let i = 0; i < address_form.length; i++) {
            address_form[i].disabled = true;
        }
    }
}

window.onload = address_select_checker;
