$(function () {
    $(".user_delete_button").click(function () {
        const email = $(this).closest("tr").attr("id");
        let delete_confirm = confirm(email+"を削除してもよろしいですか?");
        if(delete_confirm){
            const input_user_email = $("<input>",{
                type:"hidden",
                name:"user_email",
                value:email,
            });
            const form = $("form");
            form.append(input_user_email);
            form.submit();
        }
    });

    $(".good_delete_button").click(function () {
        const good_name = $(this).closest("tr").attr("id");
        let delete_confirm = confirm(good_name+"を削除してもよろしいですか?");
        if(delete_confirm){
            const good_id = $(this).attr("id");
            const input_good_id = $("<input>",{
                type:"hidden",
                name:"good_id",
                value:good_id,
            });
            const form = $("form");
            form.append(input_good_id);
            form.submit();
        }
    })
});

function onSidebarButtonChange(){
    const mode_id = Number($("#side_bar input[name=mode]:checked").val());
    if(mode_id === 0){
        $("#user_edit_form").show();
        $("#user_register_form").hide();
        $("#user_register_form input").map(function (index, input) {
            input.disabled = true;
        });
        $("#edit_good_form").hide();
        $("#inquiry_check_form").hide();
    }else if(mode_id === 1){
        $("#user_edit_form").hide();
        $("#user_register_form").show();
        $("#user_register_form input").map(function (index, input) {
            input.disabled = false;
        });
        $("#edit_good_form").hide();
        $("#inquiry_check_form").hide();
    }else if(mode_id === 2){
        $("#user_edit_form").hide();
        $("#user_register_form").hide();
        $("#user_register_form input").map(function (index, input) {
            input.disabled = true;
        });
        $("#edit_good_form").show();
        $("#inquiry_check_form").hide();
    }else if(mode_id === 3){
        $("#user_edit_form").hide();
        $("#user_register_form").hide();
        $("#user_register_form input").map(function (index, input) {
            input.disabled = true;
        });
        $("#edit_good_form").hide();
        $("#inquiry_check_form").show();
    }else{
        location.reload();
    }
    onUserRoleEditChange();
}

function onUserRoleEditChange(){
    const user_type = Number($("#user_role_edit").val());
    if(user_type === 1 || user_type === 3){
        $("#company_name").prop("disabled", false);
    }else{
        $("#company_name").prop("disabled", true);
    }
}

window.onload = onSidebarButtonChange;
