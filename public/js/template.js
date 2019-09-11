$(function () {
    header_mypage_menu_width();
    $(".pull_down_menu_check").change(function () {
        const is_checked = $(this).prop("checked");

        if(is_checked){
            $("~.pull_down_menu",this).show();
            $("~.pull_down_menu_label",this).find(".fa-caret-square-down").hide();
            $("~.pull_down_menu_label",this).find(".fa-caret-square-up").show();
        }else{
            $("~.pull_down_menu", this).hide();
            $("~.pull_down_menu_label",this).find(".fa-caret-square-up").hide();
            $("~.pull_down_menu_label",this).find(".fa-caret-square-down").show();
        }
    })

    function header_mypage_menu_width(){
        const label_width = $("#header_mypage_label").width();
        const menu_width = $("#header_mypage_menu").width();
        $("#header_mypage_menu").width(Math.max(label_width,menu_width));
    }
});

function onClickConfirmFormButton(action){
    const form = document.getElementById("confirm_form");
    form.setAttribute("action",action);
    form.submit()
}
