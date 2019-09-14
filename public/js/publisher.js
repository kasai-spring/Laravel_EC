$(function () {
   $(".good_delete_button").click(function () {
       let delete_confirm = confirm($(this).closest("tr").attr("id")+"を削除してもよろしいですか?");
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
   });
});

function onSidebarButtonChange(){
    const mode_id = Number($("#side_bar input[name=mode]:checked").val());
    if(mode_id === 0){
        $("#sales_history").show();
        $("#good_edit").hide();
        $("#good_edit input").map(function (index, input) {
            input.disabled = true;
        });
        $("#good_display").hide();
        $("#good_display input").map(function (index, input) {
            input.disabled = true;
        });

    }else if(mode_id === 1){
        $("#sales_history").hide();
        $("#good_edit").show();
        $("#good_edit input").map(function (index, input) {
            input.disabled = false;
        });
        $("#good_display").hide();
        $("#good_display input").map(function (index, input) {
            input.disabled = true;
        });

    }else if(mode_id === 2){
        $("#sales_history").hide();
        $("#good_edit").hide();
        $("#good_edit input").map(function (index, input) {
            input.disabled = true;
        });
        $("#good_display").show();
        $("#good_display input").map(function (index, input) {
            input.disabled = false;
        });
    }else{
        location.reload();
    }
}

window.onload = onSidebarButtonChange;
