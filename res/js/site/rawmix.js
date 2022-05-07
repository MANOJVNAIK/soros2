/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

window.onload = function () {

    // $('#product-profile').hide();


    //validate product profile

    $('#selected-source-id').on('change', function () {

//        alert('ghh')
        loadElementCompositionList($(this).val());
    })

    init();
    $('#product-profile').on('submit', function (e) {


        e.preventDefault();
        var name = $('#product_name').val();



        $.ajax({
            url: layout_name_check_url,
            method: "GET",
            data: {name: name},
            success: function (message) {
                var msgObj = JSON.parse(message);
                console.log(msgObj.error);
                if (msgObj.error == 1) {
                    //  console.log('profile name exits')

                    alert('profile name already exits please chose different name');

                } else {

                    createProfile(name);

                    //$('a[href="##portlet-pane-2"]').trigger('click');

                }

            }, error: function (xhr) {


            }
        });

    }); // #product-profile send form end



    //detailed form submission

    $('#product-profile-form').on('submit', function (e) {


        tempValidate('#product-profile-form');
        e.preventDefault();



        if (tempValidate('#product-profile-form')) {



            var data = $('#product-profile-form').serialize();
            var profile_id = $('#ProductProfile_product_id').val();




            $.ajax({
                url: update_product_profile_url,
                type: "POST",
                data: {data: data, profile_id: profile_id},
                success: function (message) {

                    profileNext();
                    getStatusBar($('#ProductProfile_product_id').val());



                }, error: function (xhr) {


                }
            });
        }


    }); // #product-profile send form end








    $('#add-source').button({icons: {
            primary: "ui-icon-circle-plus"
        }});





    getStatusBar($('#ProductProfile_product_id').val());


    $('#set-point-prev').on('click', setPointPrev)
    $('#set-point-next').on('click', setPointNext)

    $('#source-next').on('click', sourceNext);
    $('#source-prev').on('click', sourcePrev)

    $('#elelemt-prev').on('click', elementPrev);


    $('input:checkbox[name="checkbox[]"]').on('click', function () {


        $('input[name="checkbox[]"]').each(function () {

            console.log(this);
        })

    });

} // End of  window.onlod()




function init() {




    $("#setpoint-dialog-form").on('submit', function (e) {
        e.preventDefault();
    });
    // $('#portlet-product_profile');


    $("#product-profile-form").on('submit', function (e) {
        e.preventDefault();
    });

    $('#element_compossition_form').on('submit', function (e) {
        e.preventDefault();

    })

    $('#source-form').on('submit', function (e) {

        e.preventDefault();
    })


}

function createProfile(name) {



    $.ajax({
        url: creat_profile_url,
        method: "GET",
        data: {name: name},
        success: function (message) {

            $('#portlet-product_profile').html(message);

            removePreviousState();
            $('#progress_bar').css('width', '10%');
            getStatusBar($('#ProductProfile_product_id').val());

        }, error: function (xhr) {


        }
    });

}

//Invoked form add Setpoint button

function loadSetpointForm(sp_id = null) {

    var actionBtn
    $.ajax({
        url: setpoint_load_form_url,
        method: "GET",
        data: {sp_id: sp_id},
        beforeSend: setAccessCode,
        success: function (responseText) {

            var actionBtn;
            //if sp_id is set Update 
            if (sp_id)
            {

                actionBtn = createActionButton('Update', updateSetPoint);

            } else // create new
            {
                actionBtn = createActionButton('Save', createSetPoint);

            }
            var closeBtn = createCloseButton();
            modalUtil('Create Set-Points', responseText, actionBtn, closeBtn);
            $('#generic-modal').modal('show');


        },
        error: handleError
    });

}
function createSetPoint() {


    {
        var product_id = $('#productprofile-product_id').val();
        $('#setpoints-product_id').val(product_id);//populating product id
        var data = serializeObject($('#set-points-form'));
        axios.post(setpoint_create_url, data, {
            headers: {
                'Content-Type': 'application/json',
                'X-Access-Token': access_token
            }
        }
        ).then(function (a) {
            refreshSetpointTable();
        }).catch(function (response) {
            alert(response.message)
        });
    }


}
function updateSetPoint() {


    var id = $("#setpoints-sp_id").val();
    var param = "&id=" + id;
    var data = serializeObject($('#set-points-form'));
    axios.put(setpoint_update_url + param, data, {
        headers: {
            'Content-Type': 'application/json',
            'X-Access-Token': access_token
        }
    }
    ).then(function (a, b, c) {
        refreshSetpointTable();
    }).catch(function (response) {
        alert(response.message)
    });

}
function deleteSetPoint(id) {

    var param = '&id=' + id
    $.ajax({
        url: setpoint_delete_url + param,
        method: "DELETE",
        beforeSend: setAccessCode,
        success: function (message) {
            alert(message)
            refreshSetpointTable();

        },
        error: handleError
    });
}
function refreshSetpointTable() {

    closeModal();

    var product_id = $('#productprofile-product_id').val();
    $.ajax({
        url: setpoint_list,
        type: "GET",
        data:{pid:product_id},
        beforeSend: setAccessCode,
        success: function (response) {

            $('#set-point-list').html(response);



        }, 
        error: handleError
    });
}

///////////////////////// Source /////////////////////////

function loadSourceForm(source_id = null) {

    var title
    $.ajax({
        url: source_load_form_url,
        method: "GET",
        data: {source_id: source_id},
        beforeSend: setAccessCode,
        success: function (responseText) {

            var actionBtn;
            //if source_id is set Update
            if (source_id)
            {

                actionBtn = createActionButton('Update', updateSource);
                title = 'Update Source';

            } else // create new
            {
                actionBtn = createActionButton('Save', createSource);
                title = 'Create Source';

            }
            var closeBtn = createCloseButton();
            modalUtil(title, responseText, actionBtn, closeBtn);
            $('#generic-modal').modal('show');


        },
        error: handleError
    });

}
function createSource() {


    {
        var product_id = $('#productprofile-product_id').val();
        $('#source-product_id').val(product_id);//populating product id
        var data = serializeObject($('#source-form'));
        axios.post(source_create_url, data, {
            headers: {
                'Content-Type': 'application/json',
                'X-Access-Token': access_token
            }
        }
        ).then(function (a) {
            refreshSourceTable();
        }).catch(function (response) {
            alert(response.message)
        });
    }


}
function updateSource() {


    var id = $("#source-src_id").val();
    var param = "&id=" + id;
    var data = serializeObject($('#source-form'));
    axios.put(source_update_url + param, data, {
        headers: {
            'Content-Type': 'application/json',
            'X-Access-Token': access_token
        }
    }
    ).then(function (a, b, c) {
        refreshSourceTable();
    }).catch(function (response) {
        alert(response.message)
    });

}
function deleteSource(id) {

    var param = '&id=' + id
    $.ajax({
        url: source_delete_url + param,
        method: "DELETE",
        beforeSend: setAccessCode,
        success: function (message) {
            refreshSourceTable();

        },
        error: handleError
    });
}
function refreshSourceTable() {

    closeModal();

    var product_id = $('#productprofile-product_id').val();
    $.ajax({
        url: source_list,
        type: "GET",
        data:{pid:product_id},
        beforeSend: setAccessCode,
        success: function (response) {

            $('#source-list').html(response);



        },
        error: handleError
    });
}



function loadElementCompositionForm(element_id = null) {

    var title;
    $.ajax({
        url: element_composition_load_form_url,
        method: "GET",
        data: {element_id: element_id},
        beforeSend: setAccessCode,
        success: function (responseText) {

            var actionBtn;
            //if element_id is set Update
            if (element_id)
            {

                actionBtn = createActionButton('Update', updateEleCom);
                title = 'Update Element Composition';

            } else // create new
            {
                actionBtn = createActionButton('Save', createEleCom);
                title = 'Create Element Composition';

            }
            var closeBtn = createCloseButton();
            modalUtil(title, responseText, actionBtn, closeBtn);
            $('#generic-modal').modal('show');


        },
        error: handleError
    });

}
function createEleCom() {



  var source_id = $('#selected-source-id').val();
  
  
  $('#elementcomposition-source_id').val(source_id);

    {
        var product_id = $('#productprofile-product_id').val();
        $('#elementcomposition-source_id').val(source_id);//populating product id
        var data = serializeObject($('#element_composition_form'));
        axios.post(element_composition_creat_url, data, {
            headers: {
                'Content-Type': 'application/json',
                'X-Access-Token': access_token
            }
        }
        ).then(function (a) {
            loadElementCompositionList(source_id);
        }).catch(function (response) {
            alert(response.message)
        });
    }


}
function updateEleCom() {

    var ele_id = $('#elementcomposition-element_id').val();
    var source_id = $('#selected-source-id').val();
  
    var param = "&id=" + ele_id;
    var data = serializeObject($('#element_composition_form'));
    axios.put(element_composition_update_url + param, data, {
        headers: {
            'Content-Type': 'application/json',
            'X-Access-Token': access_token
        }
    }
    ).then(function (a, b, c) {
        loadElementCompositionList(source_id);
    }).catch(function (response) {
        alert(response.message)
    });

}
function deleteEleCom(id) {

    var source_id = $('#selected-source-id').val();
  
    var param = '&id=' + id
    $.ajax({
        url: element_composition_delete_url + param,
        method: "DELETE",
        beforeSend: setAccessCode,
        success: function (message) {
            loadElementCompositionList(source_id);

        },
        error: handleError
    });
}
function refreshEleComTable() {

    closeModal();

    var product_id = $('#productprofile-product_id').val();
    $.ajax({
        url: element_composition_list,
        type: "GET",
        data:{pid:product_id},
        beforeSend: setAccessCode,
        success: function (response) {

            $('#element-composition-list').html(response);



        },
        error: handleError
    });
}




function setpointDeleteConfirm(id, name) {

    $('#confirm-delete-btn').off('click').on('click', function () {

        deleteSetPoint(id);
    });
    confirmDelete();
}

function loadElementCompositionList(source_id) {

   closeModal();
    $.ajax({
        url: element_compostion_list,
        type: "GET",
        data: {sourceid: source_id},
        beforeSend:setAccessCode,
        success: function (message) {

            $('#element-composition-list').html(message);

            getStatusBar($('#ProductProfile_product_id').val());



        }, 
        error: handleError
    });

}


function deleteConfirm(type, id, name) {



    if (type === 'source') {

        $('#confirm-delete-btn').off('click').on('click', function () {

            deleteSource(id);
        });

    } else if (type === 'setpoint') {


        $('#confirm-delete-btn').off('click').on('click', function () {

            deleteSetPoint(id);
        });


    } else if (type === 'element_composition') {



        $('#confirm-delete-btn').off('click').on('click', function () {

            deleteEleCom(id, name)
        });


    }else if (type === 'profile_log'){
        
        
        $('#confirm-delete-btn').off('click').on('click', function () {
            deleteProfileLog(id)
        });
    }

    showDeleteBox();
}


function profileNext() {


    var setPointTab = $('a[data-tab="#portlet-set-point"]');

    $(setPointTab).attr('href', '#portlet-set-point');

    $('#portlet-set-point').removeClass('hide');


    $('a[href="#portlet-set-point"]').trigger('click');
}

function setPointNext() {

    //alert('set point next')

    $('a[href="#portlet-source"]').trigger('click');
    //$('a[href="##portlet-pane-2"]').trigger('click');

}

function setPointPrev() {



    $('a[href="#portlet-product_profile"]').trigger('click');
}

function sourceNext() {


    $('a[href="#portlet-source-element"]').trigger('click');
}

function sourcePrev() {

    $('a[href="#portlet-set-point"]').trigger('click');
}

function elementPrev() {


    $('a[href="#portlet-source"]').trigger('click');
}


function removePreviousState() {

    $('#progress_bar').removeClass('ui-state-error');

    $('#progress_bar').removeClass('ui-state-success');
    $('#progress_bar').removeClass('ui-state-highlight');

}


function getStatusBar(pid) {


    //console.log(get_progress_url)

    $.ajax({
        url: get_progress_url,
        type: "GET",
        data: {productid: pid},
        success: function (message) {


            $('#progress-bar').html(message);

            //getStatusBar($('#ProductProfile_product_id').val());
            //$('#delete-confirm-dialog-form').dialog('close')



        }, error: function (xhr) {


        }
    });


}



function sourceSelectList(pid) {


    //console.log(get_progress_url)

    $.ajax({
        url: update_source_select_url,
        type: "GET",
        data: {productid: pid},
        success: function (message) {


            $('#source-select').html(message);

            //getStatusBar($('#ProductProfile_product_id').val());
            //$('#delete-confirm-dialog-form').dialog('close')



        }, error: function (xhr) {


        }
    });


}

function createActionButton(name, callback,option = false) {



    var actionBtn = document.createElement('button');
    //        actionBtn.type = 'submit';
    actionBtn.onclick = callback;

    actionBtn.id = 'model-action-btn';
    actionBtn.className = 'btn  blue';
    actionBtn.innerHTML = name;

    if(option)
    {
        for(var x in option){
            
            var attr = option[x];
            actionBtn[attr] 

        }
        
        
    }

    return actionBtn;


}

function createCloseButton(name = 'close', callback = null) {



    var closeBtn = document.createElement('button');
    //        actionBtn.type = 'submit';
    closeBtn.onclick = callback;

    closeBtn.className = 'btn btn-default';
    closeBtn.innerHTML = name;
    closeBtn.setAttribute('data-dismiss', 'modal')


    //<button type="button" id="btn-return" class="btn dark btn-outline" data-dismiss="modal"></button>
    //<button type="button" id="btn-submit" class="btn btn-primary" data-dismiss="modal"></button>

    console.warn(closeBtn)

    return closeBtn;


}

function showDeleteBox()
{
    $("#confirm-modal").modal('show');
}


function closeModal() {

    $("#confirm-modal,#generic-modal").modal('hide');


}



/**
 * fillForm function populate form by using json
 * @param {string} id
 * @param {json} jsonObject
 * @param {string} modal
 * @returns {true | false}
 */
function fillForm(id, jsonObject, modal) {
    var frm = $("#" + id);
    var i;
    //  console.dir(response);      // for debug
    for (i in jsonObject) {
        frm.find('[name="' + i + '"]').val(response[i]);
    }
}



function handleError(xHr, a, b) {


    alert('Error occured')
}


function setAccessCode(request) {
    request.setRequestHeader("X-Access-Token", access_token);
}


function serializeObject($form) {
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function (n, i) {
        indexed_array[n['name']] = n['value'];

    });

    return indexed_array;
}


