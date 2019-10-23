$(function () {
    check_goods();

    $(".cart_delete_button").on("click", function () {
        const good_div = $(this).closest("tr");
        let good_id = good_div.attr("id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: location.origin + "/cart/change",
            type: 'POST',
            data: {"mode": "delete", "good_id": good_id}
        })
            .done(function (data) {
                good_div.remove();
                total_price_calc();
                check_goods();
            })
            .fail(function (data) {
                // location.reload();
            });
    });

    $(".cart_quantity").change(function () {
        const select = $(this);
        const quantity = select.val();
        const good_div = select.closest("tr");
        const good_id = good_div.attr("id");


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: location.origin + "/cart/change",
            type: 'POST',
            data: {"mode": "change", "good_id": good_id, "quantity": quantity}
        })
            .done(function (data) {
                const before_stock = Number(select.children().last().val());
                const now_quantity = Number(data.quantity);
                const now_stock = Number(data.stock);
                if (now_quantity === 0) {
                    good_div.remove();
                    check_goods();
                } else if (before_stock < now_stock) {
                    for (let i = before_stock + 1; i <= now_stock; i++) {
                        select.append($("<option>").html(i).val(i));
                    }
                } else if (before_stock > now_stock) {
                    select.val(now_quantity);
                    while (Number(select.children().last().val()) > now_stock) {
                        select.children().last().remove();
                    }
                }
                total_price_calc();
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
        $(".good_table").hide();
        $("#table_top_obj").hide();
        $(".no_cart").show();
    }
}

function total_price_calc() {
    let total_price = 0;
    $(".good").each(function () {
        const good_price = Number($(this).find("#good_price").text().replace("円", ""));
        const quantity = Number($(this).find("#quantity").val());
        total_price += good_price * quantity;
    });
    $("#total_price").text(total_price);
}

window.onload = total_price_calc;
