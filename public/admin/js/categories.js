const categories = {
    parentCategoryElement: $('div#parent_categories_id'),

    handleParentCategories: function(target) {
        const targetElement = parseInt($(target).val());
        if (targetElement) {
            this.parentCategoryElement.removeClass('d-none');
        } else {
            this.parentCategoryElement.addClass('d-none');
        }
    }
}