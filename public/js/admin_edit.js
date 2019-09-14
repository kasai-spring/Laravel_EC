function onChangePublisherCheck(){
    if($("#publisher_change").prop("checked")){
        $("#company_name").prop("disabled",false);
    }else{
        $("#company_name").prop("disabled",true);
    }
    console.log();
}

window.onload = onChangePublisherCheck;
