var Page          = $('.transport-page'),
    navFilter     = true,
    $rollingStock = $('#rollingStock'),
    filterType    = null,
    listDrivers   = [],
    delay         = (function () {
        var timer = 0;
        return function (callback, ms) {
            clearTimeout(timer);
            timer = setTimeout(callback, ms);
        };
    })();

Transport.prototype = {
    create: function () {
        $.post('transport')
    },

    remove: function ($this) {
        var id = this.id;
        swal({
                 title              : '',
                 text               : transport_text_delete,
                 type               : 'warning',
                 showCancelButton   : true,
                 cancelButtonText: btn_cancel,
                 showLoaderOnConfirm: true,
                 preConfirm         : function () {
                     return new Promise(function (resolve) {
                         $.ajax({
                                    url     : '/transport/' + id,
                                    type    : 'DELETE',
                                    data    : {_token: CSRF_TOKEN},
                                    dataType: 'JSON'
                                })
                          .done(function (data) {
                              if (data.status === 'success') {
                                  resolve(data);
                                  location.reload();

                              }else if (data.status === 'active'){
                                  appAlert('', 'Transport in flight cannot be deleted :(', 'warning');
                              }  else {
                                  appAlert('', 'Transport not found :(', 'warning');
                              }
                          })
                          .fail(function (data) {
                              appAlert('', 'Something went wrong... :(', 'warning');
                          });
                     })
                 },
                 allowOutsideClick  : false
             }).then(function (data) {

            // $this.parents('.panel-group').detach()

            // $('#transport' + id).detach();
            swal({
                     type: 'success',
                     text: 'ТС удалено из вашего списка.'
                 })
        }).catch(swal.noop);

    },

    update: function (data, $this) {
        var $form   = $('#transport' + data.id);
        var $loader = $form.find('.as-loader');
        var refresh = data.field === 'monitoring' || data.field === 'login' || data.field === 'password';

        $loader.removeClass('hidden');

        $('.text-danger').hide();

        $.ajax({
            url        : '/transport-update-ajax',
            type       : "POST",
            data       : data,
            dataType: 'json'
        })
            .done(function (res) {
                 if (res.status === 'success' && !refresh) {
                     updateTransport($('#formFilters').serialize(), $form);
                 }

                 if(res.status === 'limit'){
                     $form.find('.transport-active').prop('checked', false);
                     appAlert('', 'Достигнут лимит транспорта в Вашем тарифном плане', 'warning');
                 }
            })
            .fail(function (response) {
                // console.log(response);
                var errors = response.responseJSON;
                console.log($form);
                console.log(data.field);


                if (response.status === 422) {

                    $.each( errors, function( key, value ) {
                        $form.find('.error_'+data.field).text(value);
                        $form.find('.error_'+data.field).show();
                        // $form.find('input[name=password]').val('');
                    });
                } else {
                    appAlert('', 'Something went wrong... :(', 'warning');
                }

            })
            .always(function(){
                $loader.addClass('hidden');
            });
    }
};

Handbook.prototype = {
    generate: function () {
        var groups   = this.data.groups,
            select   = this.select,
            idSelect = select.attr('id');

        // select.append('<option value="">' + select.data('cancel') + '1</option>');

        $.each(groups, function (key, item) {
            select.append('<optgroup label="' + item.name_lang + '" id="group' + idSelect + item.id + '"></optgroup>');
        });

        $.each(this.data.category, function (key, item) {
            if (groups.length && item.parent_id > 0) {
                $('#group' + idSelect + item.parent_id).append('<option value="' + item.id + '" data-name="' + item.name + '">' + item.name_lang + '</option>');
            } else {
                var html = '<option value="' + item.id + '" data-name="' + item.name + '">' + item.name_lang + '</option>';
                if (item.id > 0)
                    select.append(html);
                else
                    select.prepend(html)
            }
        });

        // this.toggle();
        this.refresh();
    },

    toggle: function () {
        var parent = this.select.parents('.form-group');

        if (this.data.category.length > 0)
            parent.slideDown('fast');
        else
            parent.slideUp('fast');
    },

    clear: function () {
        this.select.html('');
    },

    refresh: function () {
        this.select.prop('disabled', false);
        this.select.selectpicker('refresh');
    },

    hideOrShowFields: function (name) {
        var fields = this.fields[name];

        $.each(fields, function (key, items) {
            $.each(items, function (k, val) {
                if (key === 'hide')
                    $('[' + val + ']').slideUp('fast');
                else
                    $('[' + val + ']').slideDown('fast');
            });
        });
    },

    add: function (obj) {
        this.data.category.unshift(obj);
    },

    fields: {
        tractor          : {
            hide: ['data-dimensions', 'data-trailer'],
            show: ['data-driver', 'data-tractor', 'data-account', 'data-status']
        },
        trailer          : {
            hide: ['data-driver', 'data-tractor', 'data-account', 'data-status'],
            show: ['data-dimensions', 'data-trailer']
        },
        semitrailer      : {
            hide: ['data-driver', 'data-tractor', 'data-account', 'data-status'],
            show: ['data-dimensions', 'data-trailer']
        },
        truck            : {
            hide: ['data-trailer'],
            show: ['data-driver', 'data-dimensions', 'data-tractor', 'data-account', 'data-status']
        },
        special_machinery: {
            hide: ['data-trailer', 'data-tractor'],
            show: ['data-driver', 'data-dimensions', 'data-account', 'data-status']
        }

    }
};

Filters.prototype = Object.create(Handbook.prototype);

Filters.prototype.toggle = function () {
    if (this.data.category.length > 0)
        this.select.removeAttr('disabled');
    else
        this.select.attr('disabled', 'disabled');
};

/*--- FUNCTIONS ---*/
function Handbook($select, data, filter) {
    this.select = $select;
    this.data   = data;
    this.groups = data.groups;
    this.filter = filter || null;
}

function Filters($select, data, filter) {
    Handbook.apply(this, arguments)
}

function Transport(id) {
    this.id = id;
}

// function randomPassword(length) {
//     var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
//     var pass  = "";
//
//     for (var x = 0; x < length; x++) {
//         var i = Math.floor(Math.random() * chars.length);
//         pass += chars.charAt(i);
//     }
//
//     return pass;
// }

function randomPassword(length) {
    var pass  = "";

    var pwd = [], cc = String.fromCharCode, R = Math.random, rnd, i;
    pwd.push(cc(48+(0|R()*10))); // push a number
    pwd.push(cc(65+(0|R()*26))); // push an upper case letter

    for(i=2; i<length; i++){
        rnd = 0|R()*62; // generate upper OR lower OR number
        pwd.push(cc(48+rnd+(rnd>9?7:0)+(rnd>35?6:0)));
    }

    pass = pwd.sort(function(){ return R() - .5; }).join('');

    return pass;
}

function generate($input, length) {
    $input.val(randomPassword(length));
}

function createHandbook(id, name, filter) {
    var type = name.split('-');
    $.ajax({
               url  : '/transport/category',
               type : 'POST',
               data : {categoryId: id, type: type[0]},
               async: false
           })
     .done(function (data) {
         if (data.status === 'success') {
             var $select = $('#' + name),
                 handbook;

             if (filter !== undefined)
                 handbook = new Filters($select, data);
             else
                 handbook = new Handbook($select, data);

             // handbook.refresh();
             handbook.clear();
             handbook.toggle();
             handbook.generate();

             if (name === 'type') {
                 handbook.select.on('hidden.bs.select', function (e) {
                     handbook.hideOrShowFields($(e.target).find('option:selected').attr('data-name'));
                 });
             }

             return;
         }
         appAlert('', 'Category not found :(', 'warning');
     })

     .fail(function (data) {
         appAlert('', 'Something went wrong... :(', 'warning');
     });
}

function newFileInput(id) {
    var $this = $('[for="' + id + '"]'),
        attr  = $this.attr('for'),
        el    = $this.prev().clone(),
        num   = attr.split('-');

    ++num[1];
    var newId = num.join('-');

    $this.attr('for', newId);
    $(el)
        .addClass('hidden')
        .find('#' + attr)
        .attr('id', newId).val('')
        .removeAttr('required')
        .end()
        .insertBefore($this);
}

function applyFilters(filters) {
    if (window.completedAjax) {

        if(typeof window.progressBar === "function") {
            window.progressBar(60);
        }

        $.ajax({
                   url     : '/transport',
                   type    : 'GET',
                   data    : filters,
                   dataType: 'JSON'
               })
         .done(function (data) {
             if (data.status === 'success') {
                 $('#transportsBox').html(data.html);
                 $('.drivers, .transport-select').selectpicker('refresh');
             } else {
                 appAlert('', 'Something went wrong... :(', 'warning');
             }
         })
         .fail(function (data) {
             appAlert('', 'Something went wrong... :(', 'warning');
         })
         .always(function () {
             navFilter = true;
             if(typeof window.progressBar === "function") {
                 window.progressBar( 100 );
             }
         });
    }
}

function updateTransport(filters, $panel) {
    $panel.addClass('updating');
    let page = $('.content-box__paginav .active').text();
    $.get('/transport?page='+page, filters)
     .done(function (data) {
         if (data.status === 'success') {
             $('#transportsBox').html(data.html);
             $('.drivers, .transport-select').selectpicker('refresh');
         }
     })
     .fail((data) => appAlert('', 'Something went wrong... :(', 'warning'))
     .always(() => $panel.removeClass('updating'));
}

function hasError($input, hide) {
    if (hide === 'hide') {
        $input.parent().removeClass('has-error');
        $input.parents('.auth-transport').find('.error-text').addClass('hidden');
    } else {
        $input.parent().addClass('has-error');
        $input.parents('.auth-transport').find('.error-text').removeClass('hidden');
    }
}

function refreshPass($this) {
    $this.next().val(randomPassword(8));
    $this.next().change();
}

/* EVENTS */
// Upload files
$('body').on('change', ".photo-upload", function (e) {
    var $this      = $(this);
    var id         = $this.attr('id');
    var countFiles = $this[0].files.length;
    var imgPath    = $this[0].value;
    var extn       = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();

    if (extn === "gif" || extn === "png" || extn === "jpg" || extn === "jpeg") {
        if (typeof (FileReader) !== "undefined") {
            //loop for each file selected for uploaded.
            for (var i = 0; i < countFiles; i++) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $this.parent()
                         .css({
                                  backgroundImage: 'url(' + e.target.result + ')',
                                  backgroundSize : 'contain',
                              })
                         .append('<span class="delete-img"></span>')
                         .removeClass('hidden');
                };
                newFileInput(id);
                reader.readAsDataURL($(this)[0].files[i]);
            }
        } else {
            appAlert("", "This browser does not support FileReader.", "error");
        }
    } else {
        appAlert("", "Pls select only images", "error");
    }
});
//Delete uploaded file
$('.image-block').on('click', '.delete-img', function () {
    let $this      = $(this),
        $parent    = $this.parent(),
        _countFile = $parent.siblings('.photo:not(.hidden)').length;

    if ($this.hasClass('delete-save')) {

        let type = '';

        if ($this.hasClass('img')) {
            type = 'img'
        } else if ($this.hasClass('doc')) {
            type = 'doc'
        }
            $.ajax({
                url: '/transport/delete-image/' + $this.attr('id'),
                type: 'GET',
                data: { type }
            })
                .done(function (data) {
                    console.log(data)
                })
                .fail(function (data) {
                    console.log(data)
                })

    }

    if (_countFile > 0) {
        $parent.fadeOut(300, function () {
            $(this).detach();
        });
    }
    if (_countFile === 0 && $this.siblings('input[type="file"]').val() !== '') {
        $parent
            .siblings('.photo.hidden').removeClass('hidden').end()
            .detach();
    }
});
// Delete transport
Page.on('click', '[data-transport-remove]', function () {
    var transport = new Transport($(this).attr('data-transport-remove'));

    transport.remove($(this));
});
// Create file
Page.on('click', '[show-photo]', function () {
    var lightbox = $(this).find('.photo a').simpleLightbox();

    lightbox.open();
});
// Apply filter
// Page.on('click', '[app-filter]', function () {
//     select(this);
// });

$('.ajaxTab').on('click', function(){
    select(this);
});
// Update data
Page.on('change', '[listen-change]', function (e) {
    var option = $(this).find('option:selected');
    if(option.hasClass('AddNewItem')){

        window.location.href = option.data('url-add');
        return true;
    }

    var $this     = $(this),
        transport = new Transport($this.attr('listen-change')),
        data      = {};

    data.id    = transport.id;
    data.field = $this.attr('name').replace(/\d+/, '');
    data.val   = $this.val();

    if (data.field === 'active') {
        data.checked   = $this.prop('checked');

    }

    if ($this.hasClass('trailer-coupling')) {
        data.coupling = 1;
    }

    if (data.val === '') {
        hasError($this);
    } else {
        hasError($this, 'hide');
        transport.update(data, $this)
    }
});
// Update a status
Page.on('click', '.dropdown-menu .label-status', function () {
    [id, status] = $(this).attr('data-trans-status').split('-');

    if (id && status) {
        let trans = new Transport(id);
        trans.update({id: id, field: 'status_id', val: status});
    }
});
// Search
Page.on('input', '.filter-search', function () {
    delay(function () {
        applyFilters($('#formFilters').serialize());
    }, 1000);
});
// Get list transport
Page.on('show.bs.select', '.transport-select:not(.bootstrap-select)', function (e) {
    var $this = $(this),
        id    = $this.attr('listen-change'),
        type  = $this.attr('name'),
        data  = {id: id, type: type};

    appSelectpiker.loader($this);

    $.post('/transport-list', data)
     .done(function (data) {
         if (data.status === 'success') {
             $this.html(data.html);
             $this.selectpicker('refresh');
         }
     })
     .fail(data => appAlert('', 'Something went wrong... :(', 'warning'))
     .always(() => appSelectpiker.loader('hide'));
});
// Get list driver
Page.on('show.bs.select', '.drivers:not(.bootstrap-select)', function (e) {
    var $this = $(e.currentTarget);

    appSelectpiker.loader($this);

    $.get('/drivers-free-ajax/' + $this.attr('listen-change'))
     .done(function (data) {
         if (data.status === 'success') {
             listDrivers = data.drivers;

             $this.html(data.html)
             $this.selectpicker('refresh');


         }
     })
     .fail(function (data) {
         console.error(data);
         appAlert('', 'Something went wrong... :(', 'warning');
     })
     .always(function () {
         appSelectpiker.loader('hide');
     });
});
// Change driver
// Page.on('changed.bs.select', function (e) {
//     let $sct = $(e.target),
//         $box = $sct.parents('.driver-info'),
//         drv  = [];
//
//     drv = listDrivers.filter(driver => driver.id == $sct.val());
//
//     if (drv.length > 0) {
//         $box
//             .find('.phone .label-name').text(drv[0].phone).end()
//             .find('.license .label-name').text(drv[0].license).end()
//             .find('.phone.hidden, .license.hidden').removeClass('hidden')
//     } else {
//         $box.find('.phone, .license').addClass('hidden');
//     }
// });
// Change rolling stock type
$('#rollingStockFilter').on('show.bs.select', function (e) {
    var $this = $(e.currentTarget);
    var id    = $('#filterType').val();

    if (filterType === id) return;

    $this.prop('disabled', true);
    $this.selectpicker('refresh');

    $.post('/transport/category', {type: 'rollingStock', categoryId: id})
     .done(function (res) {
         if (res.status === 'success') {
             var handbook = new Handbook($this, res);
             filterType   = id;

             var locale = {};
             var str = '';
             locale['ru'] = 'Все';
             locale['en'] = 'All';

             if(typeof locale[res.locale] === 'undefined') {
                 str = locale['ru'];
             }
             else {
                 str = locale[res.locale];
             }

             handbook.clear();
             if ($this.hasClass('filter'))
                 handbook.add({id: '', parent_id: 0, name: 'All', name_lang: str});
             handbook.generate();
         }
     })
     .fail(function () {
         appAlert('', 'Something went wrong... :(', 'warning');
     });
});
// Change select
$('#rollingStockFilter').on('changed.bs.select', function (e) {
    applyFilters($('#formFilters').serialize());
});

$('#category').on('changed.bs.select', function (e) {
    applyFilters($('#formFilters').serialize());
});

$('#ownerFilter').on('changed.bs.select', function (e) {
    applyFilters($('#formFilters').serialize());
});
// Collapse
Page.on('hide.bs.collapse', '.panel-collapse', function collapseHidden () {
    $(this).parents('.panel-transport').find('.editing-tools').addClass('hidden');

    $( this ).find( '.photos-slider' ).addClass( 'hidden' ).slick( 'unslick' );
});
Page.on('show.bs.collapse', '.panel-collapse', function collapseShow () {
    $(this).parents('.panel-transport').find('.editing-tools').removeClass('hidden');

    $( this ).find( '.photos-slider' ).removeClass( 'hidden' ).slick( {
        infinite: false,
        speed: 300,
        slidesToShow: 6,
        slidesToScroll: 5,
        responsive: [
            {
                breakpoint: 1480,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 3
                }
            },
            {
                breakpoint: 1180,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 900,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 650,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            }
        ]
    } );
});
// Event enter
$('#formFilters').on('keyup keypress', function (e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) {
        e.preventDefault();
        return false;
    }
});

$(document).on('click', '.sendDriverSMS', function () {
    var id = $(this).data('id');
    var text = $(this).attr('data-text-success');

    $.ajax({
            url     : '/transport/' + id + '/sendSMS',
            type    : 'GET',
            dataType: 'JSON'
        })
        .done(function (data) {
            if (data.status === 'success') {
                // resolve(data);
                // appAlert('', '', 'success');
                $.notify({message: text}, {type: 'success'});
            } else {

            }
        })
        .fail(function (data) {
            appAlert('', 'Something went wrong... :(', 'warning');
        });
});

$(document).find('.tooltipItem').each(function (index) {
    let $this     = $(this);
    $(this).popover({
        container: $(this),
        html     : true,
        placement: 'auto right',
        title    : $(this).data('title'),
        content  : $(this).data('body'),
        trigger  : 'hover'
    });
});

function select(el){
    var $this = $(el);
    // $this.parents('.nav-filter').find('.active').removeClass('active');
    $this.parents('.content-box__body-tabs').find('.active').removeClass('active');
    $this.parent().addClass('active');
    $('#rollingStockFilter').val('');
    $('#rollingStockFilter').selectpicker('refresh');
    $('[name="filters[text]"]').val('');
    $('#filterType').val($this.attr('app-filter'));

    if (navFilter) {
        navFilter = false;
        applyFilters($('#formFilters').serialize());
    }
}

/*
$('#rowTab a').click(function(e) {
    e.preventDefault();
    $(this).tab('show');
});
*/

$("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
    var id = $(e.target).attr("href").substr(1);
    window.location.hash = id;
});

var hash = window.location.hash;
$block = $('#rowTab a[href="' + hash + '"]');

if($block.hasClass('ajaxTab')){
    window.completedAjax = true;
    select($block);
} else {
    $block.tab('show');
}