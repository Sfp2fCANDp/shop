jQuery(document).ready(function () {

    console.log("START");

    var searchRequest = null;
    $("#headerSearch").keyup(function () {
        var minlength = 3;
        var that = this;
        var value = $(this).val();

        console.log(value);
        console.log("AFTER VALUE");

        var entitySelector = $("#entitiesNav").html('');

        console.log(entitySelector);
        console.log("AFTER ESEL");

        if (value.length >= minlength) {
            if (searchRequest != null)
                searchRequest.abort();
            searchRequest = $.ajax({
                type: "GET",
                url: "search",
                data: {
                    'q': value
                },
                dataType: "text",
                success: function (msg) {
                    //we need to check if the value is the same
                    if (value.name == $(that).val()) {
                        var result = JSON.parse(msg);
                        $.each(result, function (key, arr) {
                            $.each(arr, function (id, value) {
                                if (key == 'products') {
                                    if (id != 'error') {
                                        for (var i = 0; i < value.length; i++) {
                                            entitySelector.append('<div class="single-product-wrapper"> <div class="product-img"> ' +
                                                '<img src="' + asset('img/product-img/product-7.jpg') + '" alt=""> <img class="hover-img" src="' + asset('img/product-img/product-8.jpg') +
                                                '" alt=""> + <div class="product-badge new-badge"> <span>New' + value.id + '</span> </div> <div class="product-favourite">' +
                                                '<a href="#" class="favme fa fa-heart"></a> </div> </div> <div class="product-description"> <span>topshop</span> <a href="' +
                                                path(product_show) + '"><h6>' + value.name + '</h6> </a> <p class="product-price">$' + value.price + '.00</p> <div class="hover-content">' +
                                                '<div class="add-to-cart-btn"> <a href="#" class="btn essence-btn">Add to Cart</a> </div> </div> </div> </div>');
                                        }
                                    } else {
                                        entitySelector.append('<li class="errorLi">' + value + '</li>');
                                    }
                                }
                            });
                        });
                    }
                }
            });
        }
    });
});