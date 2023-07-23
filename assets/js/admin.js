jQuery(document).ready(function ($) {
    var saf_length = $('.saf_parent_row').length;
    if(saf_length >= 1){
         $('.save_presets').show();
    }

    $(".saf_add_preset").click(function () {
        $.ajax({
            url: saf.admin_ajax,
            type: "POST",
            data: {
                action: 'saf_filter_perset_group'
            },
            dataType: "json",
            success: function (res) {
                var getTermOptions = '';
                $.each(res, function (i, v) {
                    getTermOptions += '<option value="' + v + '">' + v + '</option>';
                });
                $.confirm({
                    title: 'Please Select Your Term',
                    content: function () {
                        var termHTML = '<div class="col-12 pt-4">'
                                + ' <label for="sel1" class="form-label">Select term:</label>'
                                + '<select class="form-select" id="select_taxonomy" name="select_taxonomy">'
                                + '<option value="empty">select term</option>'
                                + getTermOptions +
                                +'</select>'
                                + '</div>';
                        return termHTML;
                    },
                    onClose: function () {
//                        var getTaxonomy = this.$content.find('#select_taxonomy').val();
//                        if (getTaxonomy !== 'empty') {
//                            var getFilterPerset = genFieldsHTML(getTaxonomy);
//                            $(".saf_filter").append(getFilterPerset);
//                        }

                    },
                    buttons: {
                        button_add: {
                            text: 'Add',
                            action: function (button_add) {
                                var getTaxonomy = this.$content.find('#select_taxonomy').val();
                                if (getTaxonomy !== 'empty') {
                                    console.log(getTaxonomy);
                                    var getFilterPerset = genFieldsHTML(getTaxonomy);
                                    $(".saf_filter").append(getFilterPerset);
                                     $('.save_presets').show();
                                }
                            },
                        },
                        button_close: {
                            text: 'close'
                        },
                    },
                });
                // $('.save_presets').show();
            }

        });
    });
    // Remove presets.
    $(document).on('click', '.saf_remove_preset', function () {
        $(this).parents('.saf_parent_row').remove();
    });
    const genFieldsHTML = (index) => {
        var form_fields = '<div id="taxonomy_' + index + '" class="col-md-6 saf_parent_row">'
                + '<div class="card">'
                + '<div class="card-header">'+ index +'</div>'
                + '<div class="card-body ">'
                + '<div class="row">'
                + '<div class="col-md-4 pt-4">'
                + '<label class="form-label">Filter Title:</label>'
                + '<input type="text" name="saf_persets[' + index + '][title]" class="form-control">'
                + '</div>'
                + '<div class="col-md-4 pt-4">'
                + '<label class="form-label">Default Filter:</label>'
                + '<select class="form-select" id="sel1" name="saf_persets[' + index + '][default_filter]">'
                + '<option value="collapse"   >collapse</option>'
                + '<option value="show_list"  >show list</option>'
                + '</select>'
                + '</div>'
                + '<div class="col-md-4 pt-4">'
                + '<label class="form-label">Select Column:</label>'
                + '<select class="form-select" id="sel1" name="saf_persets[' + index + '][columns]">'
                + '<option value="col1">one column</option>'
                + '<option value="col2">two column</option>'
                + '</select>'
                + '</div>'
                + '<div class="col-md-4 pt-4">'
                + '<label class="form-label">Filter Type:</label>'
                + '<select class="form-select" id="sel1" name="saf_persets[' + index + '][filter_type]">'
                + '<option value="radio" >radio</option>'
                + '<option value="checkbox" >checkbox</option>'
                + '<option value="dropdown" >dropdpwn</option>'
                + '</select>'
                + '</div>'
                + '<div class="col-md-4 pt-4">'
                + '<label class="form-label">Exlude term ids:</label>'
                + '<input type="text" name="saf_persets[' + index + '][exlcude]" class="form-control">'
                + '</div>'
                + '<div class="col-md-4 pt-4">'
                + '<label class="form-label">Sorting:</label>'
                + '<input type="text" name="saf_persets[' + index + '][sorting]" class="form-control">'
                + '</div>'
                + '<div class="col-md-4 pt-4">'
                + '<button class="btn btn-danger btn-sm saf_remove_preset" >Remove</button>'
                + '</div>'
                + '</div>'
                + '</div>'
                + '</div>';
        return form_fields;
    };
});
	