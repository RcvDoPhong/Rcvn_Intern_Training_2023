
const products = {
    editor: null,
    handleSalePercentInput: function () {
        common.updateSalePricePercent('base_price', 'sale_price', 'sale_price_percent')
    },
    handleDisplayValidateImage: function (key, value) {
        const dotString = key.indexOf('.');
        key = key.slice(0, dotString);
        const errorText = $(`span[name="${key}"]`);
        errorText.text('');
        errorText.text(value);
    },
    handleDisplayValidateOptions: function (key, value, isParent) {
        const splitStrings = key.split('.');
        splitStrings.shift();
        const index = splitStrings[0];
        const field = splitStrings[1];

        let mainDiv = '#parent_option_products';
        let subDiv = 'option_parent_product';
        if (!isParent) {
            mainDiv = '#child_option_products';
            subDiv = 'option_child_product';
        }
        const optionsElement = $(`div${mainDiv}`).find(`div[name="${subDiv}"]`);
        console.log($(optionsElement[index]).find('span#option_id'), field);
        $(optionsElement[index]).find(`span#${field}`).text(value);
        $(optionsElement[index]).find(`select[name="${field}"]`).addClass('is-invalid');
        $(optionsElement[index]).find(`input#${field}`).addClass('is-invalid');
    },
    switchPriceState: function (btnElement, targetElement) {
        const btnState = $(btnElement).is(':checked');

        if (!btnState) {
            $(`div${targetElement}`).addClass('d-none');
        } else {
            $(`div${targetElement}`).removeClass('d-none');
        }
    },
    displayOptions: function (targetElement) {
        const select = $(targetElement).val();
        $('span#parent_flag').text('');
        $('select#parent_flag').removeClass('is-invalid');

        if (select !== '') {
            if (parseInt(select) === 1) {
                $('div#child_option_products').addClass('d-none');
                $('div#has_product_options').removeClass('d-none');
                $('input#has_children').prop('checked', 'checked');
                $('div#parent_option_products').removeClass('d-none');
            } else {
                $('div#has_product_options').addClass('d-none');
                $('div#parent_option_products').addClass('d-none');
                $('div#child_option_products').removeClass('d-none');
            }
        } else {
            $('div#has_product_options').addClass('d-none');
            $('div#parent_option_products').addClass('d-none');
            $('div#child_option_products').addClass('d-none');
        }
    },
    getProductInfo: function (targetElement) {
        const select = $(targetElement)
        const productId = select.val();
        const option = select.data('option');
        const optionName = select.parents(`div${option}`).find('input#option_name');
        const optionPrice = select.parents(`div${option}`).find('input#option_price');

        if (productId === '') {
            console.log(optionName, optionPrice)
            $(optionName).val('');
            $(optionPrice).val('');
            let selects = $('div#parent_option_products').find('select');
            selects = selects.filter(function (index, element) {
                return $(element).val() !== '';
            });

            if (selects.length !== 0) {
                products.hideOptions(select, select.data('prev'), 'add');
                select.data('prev', '');
            } else {
                $('div#parent_option_products').find('option').removeClass('d-none');
            }
            return;
        }

        $.ajax({
            type: 'GET',
            url: route('admin.products.show', productId)
        }).done(function (response) {
            $(optionName).val(response.data.product_name);
            $(optionPrice).val(response.data.base_price);

            select.data('prev', productId);
            products.hideOptions(select, productId, 'hide');
        })
    },
    hideOptions: function (parentSelect, productId, action) {
        let selects = $('div#parent_option_products').find('select');

        selects = selects.filter(function (index, element) {
            return parentSelect.attr('id') !== $(element).attr('id');
        });

        $.each(selects, function (index, element) {
            switch (action) {
                case 'hide':
                    $(element).find(`option#${productId}`).addClass('d-none');
                    break;

                case 'add':
                    $(element).find(`option#${productId}`).removeClass('d-none');
                    break;
            }
        })
    },
    addMore: function (targetElement) {
        const btn = $(targetElement);
        const type = btn.data('type');
        const selectElement = btn.data('select');

        // Handle new option button id
        const option = btn.data('option');
        const cloneElement = $(option).clone();
        const optionButton = $(cloneElement).find('div#option_button');

        $(cloneElement).find('option:selected').attr('selected', false);
        $(cloneElement).find('input').val('');
        $(cloneElement).find('span.invalid-feedback').text('');

        // Handle clone and append new option button
        $(type).append(cloneElement);

        // count total button has in parent options
        const btnCount = $(type).children().length;

        // Change id div parent & id select option product
        const cloneElementNewId = `${option}_${btnCount}`;
        const cloneSelectNewId = `${selectElement}_${btnCount}`;

        $(cloneElement).prop('id', cloneElementNewId.replace('#', ''));
        $(cloneElement).find('select').attr('id', cloneSelectNewId.replace('#', ''));
        $(cloneElement).find('select').data('option', cloneElementNewId);

        // Handle add remove option
        $(optionButton).append(`
            <button id="removeButton" type="button" class="btn btn-danger" data-type="${type}"
                data-option="${cloneElementNewId}" onclick="products.removeOption(this)">
                <i class="fas fa-window-close"></i>
            </button>
        `)

        // Hide selected options from other selects
        let selects = $('div#parent_option_products').find('select');

        selects = selects.filter(function (index, element) {
            return $(cloneElement).attr('id') !== $(element).attr('id');
        });

        $.each(selects, function (index, element) {
            const selectedOption = $(element).find('option:selected');
            const value = selectedOption.val();
            if (selectedOption.val()) {
                $(cloneElement).find(`option#${value}`).addClass('d-none');
            }
        })
    },
    removeOption: function (targetElement) {
        const option = $(targetElement).data('option');
        const parent = $(targetElement).parents(`div${option}`);

        const select = parent.find('select');

        if (select.val() !== '') {
            products.hideOptions(select, select.val(), 'add');
        }
        $(parent).remove();
    },
    displaySalePriceInput: function (targetElement) {
        const btnElement = parseInt($(targetElement).val());

        if (btnElement === 1) {
            products.resetInput('#sale_price_percent', '#sale_price', 0)
            return;
        }

        products.resetInput('#sale_price', '#sale_price_percent', 0);
    },
    resetInput: function (displayElementId, hideElementId, value) {
        $(`div${displayElementId}`).removeClass('d-none');
        $(`div${hideElementId}`).addClass('d-none');
        $(`input${displayElementId}`).val(value);
        $(`input${hideElementId}`).val(value);
    },
    getDataForm: function (formTarget) {
        const data = new FormData($(`form${formTarget}`)[0]);
        const imageDropzone = Dropzone.forElement(".dropzone");

        const options = products.getOptionProductIds();
        const parent_flag = $('select#parent_flag').val();
        const is_sale = $('input#is_sale').is(':checked');

        if ($('input[name="_method"]') && $('input[name="product_thumbnail"]').val()) {
            data.append('product_thumbnail', $('input[name="product_thumbnail"]')[0].files[0])
        }

        if ($('div[name="product_description"]')) {
            data.append('product_description', this.editor.getData());
        }

        if (parent_flag !== '') {
            data.append('parent_flag', parseInt(parent_flag) === 1 ? true : false);
        }

        if (parseInt(parent_flag) === 2 || ($('input#has_children').is(':checked') && parseInt(parent_flag) === 1)) {
            products.formatArrayFormData(options, data);
        }
        data.append('is_sale', is_sale ? 1 : 0);
        data.append('has_children', $('input#has_children').is(':checked'));

        if (!is_sale) {
            data.set('sale_price', 0);
            data.set('sale_price_percent', 0);
        }

        data.append('imagesCount', imageDropzone.files.length);

        return data;
    },
    handleCreateAndUpdate: function (event, target) {
        event.preventDefault();
        this.clearErrorInput();
        const data = products.getDataForm('#handleFormInfo');
        const parentFlag = parseInt($('select#parent_flag').val()) === 1 ? true : false;
        const imageDropzone = Dropzone.forElement(".dropzone");
        const url = $('form#handleFormInfo').attr('action');

        $(target).attr('disabled', true);

        $.ajax({
            url: url,
            type: 'post',
            data: data,
            processData: false,
            contentType: false,
            statusCode: {
                422: function (error) {
                    $.each(error.responseJSON.errors, function (key, value) {
                        if (key.includes('options')) {
                            // products.handleDisplayValidateImage(key, value)
                            products.handleDisplayValidateOptions(key, value, parentFlag);
                        } else if (key !== 'product_description') {
                            $(`span[name="${key}"]`).text(value);
                            $(`input[name="${key}"]`).addClass('is-invalid');
                            $(`select[name="${key}"]`).addClass('is-invalid');
                        } else {
                            $('div.ck-editor').addClass('border border-danger');
                        }
                    })
                },
                200: function (response) {
                    if (imageDropzone.files.length > 0) {
                        $('div#imageDropzone').data('id', response.product_id);
                        imageDropzone.processQueue();
                    } else {
                        common.sweetAlertNoButton(response.title, response.message, 'success', response.redirect)
                    }
                }
            }
        }).fail(function (error) {
            if (error.status !== 422) {
                common.sweetAlertNoButton('Something went wrong!', error.responseJSON.message, 'error')
            }
        }).always(function (response) {
            if (imageDropzone.files.length === 0 || response.status !== 200) {
                $(target).attr('disabled', false);
            }
        });
    },
    getOptionProductIds: function () {
        const parentFlag = $('select#parent_flag').val();
        let parent = '';

        if (parentFlag !== '') {
            if (parseInt(parentFlag) === 1) { // if flag is parent
                parent = '#parent_option_products';

            } else {
                parent = '#child_option_products';
            }

            return products.getChildValueFromParent(parent);
        }

        return null;
    },
    getChildValueFromParent: function (parent) {
        const groupChild = $(parent).children();

        let data = [];

        $.each(groupChild, function (index, value) {
            const optionId = $(value).find('select[name="option_id"]').val();
            const inputOptionName = $(value).find('input#option_name').val();
            data.push({
                option_id: optionId,
                option_name: inputOptionName
            })
        });

        return data;
    },
    formatArrayFormData: function (items, formData) {
        for (let i = 0; i < items.length; i++) {
            for (let key of Object.keys(items[i])) {
                formData.append(`options[${i}][${key}]`, items[i][key]);
            }
        }
    },
    clearErrorInput: function () {
        $('form#handleFormInfo').find('input').removeClass('is-invalid');
        $('form#handleFormInfo').find('select').removeClass('is-invalid');
        $('form#handleFormInfo').find('div.ck-editor').removeClass('border border-danger');
        $('form#handleFormInfo').find('span.invalid-feedback').text('');
        $('form#handleFormInfo').find('span.text-danger').text('');
    },
    createNewEditor: function () {
        ClassicEditor
            .create($('#product_description')[0], {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
                heading: {
                    options: [{
                        model: 'paragraph',
                        title: 'Paragraph',
                        class: 'ck-heading_paragraph'
                    },
                    {
                        model: 'heading1',
                        view: 'h1',
                        title: 'Heading 1',
                        class: 'ck-heading_heading1'
                    },
                    {
                        model: 'heading2',
                        view: 'h2',
                        title: 'Heading 2',
                        class: 'ck-heading_heading2'
                    }
                    ]
                }
            })
            .then(newEditor => {
                this.editor = newEditor;
            })
            .catch(error => {
                common.sweetAlertNoButton('Something went wrong!', error.responseJSON.message, 'error')
            });
    }
}

// $(document).ready(function () {
//     $('select#option_id').select2();
// });
products.createNewEditor();
