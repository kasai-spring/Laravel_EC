function onClickConfirmFormButton(action){
    const form = document.getElementById("confirm_form");
    form.setAttribute("action",action);
    form.submit()
}
