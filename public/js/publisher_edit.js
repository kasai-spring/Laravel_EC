function onEditButtonClicked(){
    const edit_confirm = confirm("この内容で更新してもよろしいですか?");
    if(edit_confirm){
        $("form").submit();
    }
}
