/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



simApp = {};
simApp["con1"] = true;
simApp["arr"] = [1];

function submitFormApproved(result) {
    if (result === true) {
        console.warn("submitted");
    }
}

function confirmBeforeSubmit(callback) {
    var msg = '<p>msg2</p>';
    if (simApp["con1"])
        msg = '<p>msg2-changed</p>';

    modalUtil('header2', msg, 'Return', 'Submit');
}


function modalUtil(title, body, btnSubmit, btnReturn) {
    
     
//    debugger;
    var confirm = $('#generic-modal');
    confirm.find('#generic-modal-action').html('');
    // confirm.find('.modal-header').css('color', color);
    confirm.find('.modal-title').text(title);
    confirm.find('.modal-body').html(body);
    confirm.modal('show')

    
    confirm.find('#generic-modal-action').append(btnReturn);
    confirm.find('#generic-modal-action').append(btnSubmit);
    
    confirm.find('#btn-return').html(btnReturn).off('click').click(function () {
        confirm.modal('hide');

       // callback(false);
    });
//    confirm.find('#btn-submit').html(btnSubmit).off('click').click(function (event) {
//        event.preventDefault();
//        event.stopPropagation();
//        if (btnSubmit != "Continue") {
//            confirm.modal('hide');
//        }
////        callback(true);
//    });

} // end of modalUtil()

    