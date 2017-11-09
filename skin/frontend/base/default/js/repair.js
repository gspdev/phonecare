var repair = function ($, url) {
    makeName = '';
    productName = '';
    modelName = '';
    var valueTemplate = '<span class="selected-value" style="background-image: url(\'#:data.image#\')"></span><span>#:data.name#</span>';
    var template = '<span class="k-state-default" style="background-image: url(\'#:data.image#\')"></span>' +
        '<span class="k-state-default"><h3>#: data.name #</h3></span>';

    var categoryTransport = {
        parameterMap: function (data) {
            if (data.filter && data.filter.filters && data.filter.filters.length > 0) {
                return { id: data.filter.filters[0].value };
            }
            return {};
        },
        read: {
            url: url + "repair-device/ajax/category",
            type: "get",
            dataType: "json"
        }
    };

    function saveRepair() {
        var failed = false;
        var data = {
            imei: $("#imei").val(),
            problem: $("#problem").val(),
            pincode: $("#pincode").val(),
            screencode: $("#screencode").val(),
            extracodes: $("#extracodes").val(),
            product_hash: Math.random().toString(36).substring(2),
            shipping: $('input:radio[name=shipping-method]:checked').val(),
            store: $('input:radio[name=shipping-store]:checked').val(),
            repairs: $.grep($('input.my-repair:checkbox:checked').map(function () { return $(this).val(); }), function (n) { return (n) })
        };

        // $("#imei").removeClass("validation-failed");
        $("#problem").removeClass("validation-failed");
        $(".repair-table").removeClass("validation-failed");
        $(".shipping-methods").removeClass("validation-failed");

        // if (data.imei.trim() === "") {
        //     $("#imei").addClass("validation-failed");
        //     failed = true;
        // }

        if (data.problem.trim() === "") {
            $("#problem").addClass("validation-failed");
            failed = true;
        }

        if (data.repairs.length == 0) {
            $(".repair-table").addClass("validation-failed");
            failed = true;
        }

        if (data.shipping == undefined) {
            $(".shipping-methods").addClass("validation-failed");
            failed = true;
        }
        
        if(failed){
            return;
        }

        $.ajax({
            type: "POST",
            url: url + "repair-device/ajax/save",
            dataType: "json",
            data: data
        }).then(function (data) {
            if (data.result) {
                window.location = '/checkout/cart';
            }
        }, function () {});
    }

    function typeOf (obj) {
        return {}.toString.call(obj).split(' ')[1].slice(0, -1).toLowerCase();
    }

    function addDeviceBlock(data) {
        var deviceText = '';
        if (this.makeName != '') {
            deviceText += this.makeName;
        }
        if (this.productName != '') {
            deviceText += ', ' + this.productName;
        }
        if (this.modelName != '') {
            deviceText += ', ' + this.modelName;
        }

        $("#my-device").text(deviceText);
    }

    $(document).ready(function () {
        kendo.culture("sv-SE");

        $("#brands").kendoDropDownList({
            optionLabel: "Välj märke",
            dataTextField: "name",
            dataValueField: "id",
            valueTemplate: valueTemplate,
            template: template,
            dataSource: {
                filter: { field: "id", operator: "eq", value: "22" },
                serverFiltering: true,
                transport: categoryTransport
            },
            change: function () {
                makeName = $(this.span).text();
                productName = modelName = '';
                $('#product-image').empty();
                $('div#repair-block').hide();
                addDeviceBlock(this);
            }
        });

        $("#products").kendoDropDownList({
            autoBind: false,
            optionLabel: "Välj produkt",
            cascadeFrom: "brands",
            dataTextField: "name",
            dataValueField: "id",
            valueTemplate: valueTemplate,
            template: template,
            dataSource: {
                serverFiltering: true,
                transport: categoryTransport
            },
            change: function () {
                productName = $(this.span).text();
                modelName = '';
                $('#product-image').empty();
                $('div#repair-block').hide();
                addDeviceBlock(this);
            }
        });

        $("#modell").kendoDropDownList({
            autoBind: false,
            cascadeFrom: "products",
            optionLabel: "Välj modell",
            dataTextField: "name",
            dataValueField: "id",
            valueTemplate: valueTemplate,
            template: template,
            dataSource: {
                serverFiltering: true,
                transport: categoryTransport
            },
            change: function () {
                $("#status").css('visibility', 'visible');
                $("#bg_fade").css('visibility', 'visible');
                $("#preloader").css('visibility', 'visible');
                $('table#repairs tbody').empty();
                modelName = $(this.span).text();
                $('#product-image').empty();
                $(this.span).find('.selected-value').clone().prependTo('#product-image');
                addDeviceBlock(this);

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: url + "repair-device/ajax/product",
                    data: 'id=' + this._old,
                    success: function(data) {
                        $("#status").css('visibility', 'hidden');
                        $("#preloader").css('visibility', 'hidden');
                        $("#bg_fade").css('visibility', 'hidden');
                        $.each(data, function(index, element) {
                            $('table#repairs tbody').append(
                                '<tr>' +
                                '<td><img style="width: 25px; height: 25px;" src="' + element.image + '"></td>' +
                                '<td class="name">' + element.name + '<span class="mobile-price">' + element.price + '</span>' + '</td>' +
                                '<td class="price">' + element.price + '</td>' +
                                '<td class="check"><input class="my-repair" type="checkbox" name="repairs" value="' + element.id + '" title="' + element.name + '" id="' + element.id + '" /><label for="' + element.id + '"></label></td>' +
                                '</tr>');
                            $('div#repair-block').show();
                        });
                    }
                });
            }
        });

        $("#order").on("click", function () { saveRepair(); });
        $(document).on('click', '.my-repair', function () {
            var selected = 0;
            $('#reapirs-selected').empty();
            jQuery('input.my-repair:checkbox:checked').each(function () {
                selected++;
                //$(this).parent().parent().addClass('checked');
                $('#reapirs-selected').append('<span>' + selected + '. ' + jQuery(this).attr('title') + '</span>');
                $('.no-select').hide();
            });
            if (selected == 0) {
               // $(this).parent().parent().removeClass('checked');
                $('.no-select').show();
            }
            if ($(this).is(':checked')) {
                $(this).closest('tr').addClass('checked');
            }
            else {
                $(this).closest('tr').removeClass('checked');
            }
        });

        $(document).on('click', '.shipping', function () {
            if ($('.shipping-butik').is(':checked')) {
                $('.butiks').show();
            }
            else {
                $('.butiks').hide();
            }
        });
        $('#repairs tbody').bind('scroll', function()
        {
            if($(this).scrollTop() + $(this).innerHeight()>=$(this)[0].scrollHeight)
            {
                $(this).closest('div').addClass('end');
            }
            else {
                $(this).closest('div').removeClass('end');
            }
        });
    });
};