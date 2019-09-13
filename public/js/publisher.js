function onSidebarButtonChange(){
    const mode_id = Number($("#side_bar input[name=mode]:checked").val());
    if(mode_id === 0){
        $("#sales_history").show();
        $("#good_edit").hide();
        $("#good_edit input").map(function (index, input) {
            input.disabled = true;
            console.log(input);
        });
        $("#good_display").hide();
        $("#good_display input").map(function (index, input) {
            input.disabled = true;
            console.log(input);
        });

    }else if(mode_id === 1){
        $("#sales_history").hide();
        $("#good_edit").show();
        $("#good_edit input").map(function (index, input) {
            input.disabled = false;
            console.log(input);
        });
        $("#good_display").hide();
        $("#good_display input").map(function (index, input) {
            input.disabled = true;
            console.log(input);
        });

    }else if(mode_id === 2){
        $("#sales_history").hide();
        $("#good_edit").hide();
        $("#good_edit input").map(function (index, input) {
            input.disabled = true;
            console.log(input);
        });
        $("#good_display").show();
        $("#good_display input").map(function (index, input) {
            input.disabled = false;
            console.log(input);
        });
    }else{
        location.reload();
    }
}

window.onload = onSidebarButtonChange;
