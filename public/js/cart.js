$(function () {
    check_goods();

    $(".cart_delete_button").on("click", function () {
        const good_div = $(this).closest("div");
        let good_id = good_div.attr("id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "http://127.0.0.1:8001/cart/change",
            type: 'POST',
            data: {"mode": "delete", "good_id": good_id}
        })
            .done(function (data) {
                good_div.remove();
                check_goods();
            })
            .fail(function (data) {
                location.reload();
            });
    });

    $(".cart_quantity").change(function () {
        const select = $(this);
        const quantity = select.val();
        const good_div = select.closest("div");
        const good_id = good_div.attr("id");


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "http://127.0.0.1:8001/cart/change",
            type: 'POST',
            data: {"mode": "change", "good_id": good_id, "quantity":quantity}
        })
            .done(function (data) {
                const before_stock = Number(select.children().last().val());
                const now_quantity = Number(data.quantity);
                const now_stock = Number(data.stock);
                if(now_quantity === 0){
                    good_div.remove();
                    check_goods();
                    $("#cart_message").html("<h3>在庫切れのためカートから削除しました</h3>")
                }else if(before_stock < now_stock){
                    for(let i = before_stock + 1; i<=now_stock; i++){
                        select.append($("<option>").html(i).val(i));
                    }
                }else if(before_stock > now_stock){
                    select.val(now_quantity);
                    while(Number(select.children().last().val()) > now_stock){
                        select.children().last().remove();
                    }
                }
            })
            // Ajaxリクエストが失敗した場合
            .fail(function (data) {
                location.reload();
            });
    });
});

function check_goods() {
    if ($("div").hasClass("good")) {
        $("#settlement").show();
    } else {
        $("#settlement").hide();
        $("#no_cart_message").show();
    }
}
