
    $(document).ready(function () {
        $('.opacityImage-collection-item-display-full').click(function () {
            var itemId = $(this).data("id");
            window.location.href = "/CollectionItem/?Id=" + itemId;
        })
    })
