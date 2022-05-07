/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var GlobalConfing = {
    
    
    dateTimeOption : {
            useCurrent: false, //Important! See issue #1075
            format: "YYYY-MM-DD HH:mm",
            keepInvalid : true,
            keyBinds: {
                up: null,
                down: function (widget) {
                    if (!widget) {
                        this.show();
                        return;
                    }
                },
                left: null,
                right: null,
                t: null,
                'delete': null,
            }
        }

    
    
}

