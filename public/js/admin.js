function onSidebarButtonChange(){
    const mode_id = Number($("#side_bar input[name=mode]:checked").val());
    if(mode_id === 0){
        $("#user_edit_form").show();
        $("#user_register_form").hide();
        $("#user_register_form input").map(function (index, input) {
            input.disabled = true;
        });
        $("#good_edit_form").hide();
        $("#inquiry_check_form").hide();
    }else if(mode_id === 1){
        $("#user_edit_form").hide();
        $("#user_register_form").show();
        $("#user_register_form input").map(function (index, input) {
            input.disabled = false;
        });
        $("#good_edit_form").hide();
        $("#inquiry_check_form").hide();
    }else if(mode_id === 2){
        $("#user_edit_form").hide();
        $("#user_register_form").hide();
        $("#user_register_form input").map(function (index, input) {
            input.disabled = true;
        });
        $("#good_edit_form").show();
        $("#inquiry_check_form").hide();
    }else if(mode_id === 3){
        $("#user_edit_form").hide();
        $("#user_register_form").hide();
        $("#user_register_form input").map(function (index, input) {
            input.disabled = true;
        });
        $("#good_edit_form").hide();
        $("#inquiry_check_form").show();
    }else{
        location.reload();
    }
}

window.onload = onSidebarButtonChange;
