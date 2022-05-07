(function ($) {

    $.fn.threestatebutton = function (params) {

        return this.each(function () {

        console.log(params);
//            params.statecount = params.statecount * 2;
            var casing = $(document.createElement("div"))
                    .addClass("tsb-casing")
                    .css("width", (params.statecount  * 2 ) + "em")
                    .append($(document.createElement("span"))
                            .addClass("tsb-ball")
                            .css("left", (2 * params.state ) + "em")
                            .attr("data-tbsstate", params.state));
            var source = $(this);
            source.append(casing);
            for (var i = 0; i < params.statecount; i++) {
                casing.append($(document.createElement("span"))
                        .addClass("tsb-state")
                        .attr("data-tbsstate", i)
                        .css("left", ( i * 2) + "em"));
            }

            setLable(params.state);
            
            casing.children(".tsb-state").click(function () {
                
                console.log(this);
                var newpos = $(this).css("left");
                var state = $(this).attr("data-tbsstate");
                 setLable(state);
                var oldstate = $(this).siblings(".tsb-ball").attr("data-tbsstate");
                if (state !== oldstate) {
                    $(this).siblings(".tsb-ball").animate({left: newpos}, 200, function () {
                        $(this).attr("data-tbsstate", state);
                        params.stateChanged(state, source);
                          
                    });
                }
            });
        });

    };

}(jQuery));


function setLable(state,ele =  ''){
    
    
    state = parseInt(state);
//    console.log(state)
    if(state === 0){
        
        $(".senstivity-label").html("Normal");
        $('.tsb-casing').css("background-color",'#4CD964');
        
    }else if(state === 1){
        
        
        $(".senstivity-label").html("High");
        $('.tsb-casing').css("background-color",'#36c6d3')
        
    }else if(state === 2){
        
        
        $(".senstivity-label").html("Aggressive");
        $('.tsb-casing').css("background-color",'#ed6b75')
        
    }
}
