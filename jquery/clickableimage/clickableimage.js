(function($) {
    var images = $('img[id*="id_image"]');
    images.each(function() {
        var id = '#' + this.id.replace("image", "item");
        $(this).click(function() {
            $(id).click();
        });
    });
})(jQuery);
