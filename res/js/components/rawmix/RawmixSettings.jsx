import React, { Component } from 'react';
import update from 'react/lib/update';
import Source from './Source.jsx';
import Profile from './Profile.jsx';
import Setpoints from './SetPoints.jsx'
import ElementComposition from './ElementComposition.jsx'
import axios from 'axios';
import swal from 'sweetalert';
import CircularProgressbar from 'react-circular-progressbar';
//import precircle form 


//const access_token = access_token ;


    var SettingsWizard = function () {


    return {
        //main function to initiate the module
        init: function () {
            if (!jQuery().bootstrapWizard) {
                return;
            }

            function format(state) {
                if (!state.id) return state.text; // optgroup
                return "<img class='flag' src='../../assets/global/img/flags/" + state.id.toLowerCase() + ".png'/>&nbsp;&nbsp;" + state.text;
            }


            var form = $('#product-profile-form');
            var error = $('.alert-danger', form);
            var success = $('.alert-success', form);

            form.validate({
                doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input

                messages: { // custom messages for radio buttons and checkboxes
                    'payment[]': {
                        required: "Please select at least one option",
                        minlength: jQuery.validator.format("Please select at least one option")
                    }
                },

                errorPlacement: function (error, element) { // render error placement for each input type
                   
                },

                invalidHandler: function (event, validator) { //display error alert on form submit   
                    success.hide();
                    error.show();
                    App.scrollTo(error, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    if (label.attr("for") == "gender" || label.attr("for") == "payment[]") { // for checkboxes and radio buttons, no need to show OK icon
                        label
                            .closest('.form-group').removeClass('has-error').addClass('has-success');
                        label.remove(); // remove error label here
                    } else { // display success icon for other inputs
                        label
                            .addClass('valid') // mark the current input as valid and display OK icon
                        .closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    }
                },

                submitHandler: function (form) {
                    success.show();
                    error.hide();
                    form[0].submit();
                    //add here some ajax code to submit your form or just call form.submit() if you want to submit the form without ajax
                }

            });

            var displayConfirm = () =>{
                $('#tab4 .form-control-static', form).each(function(){
                    var input = $('[name="'+$(this).attr("data-display")+'"]', form);
                    if (input.is(":radio")) {
                        input = $('[name="'+$(this).attr("data-display")+'"]:checked', form);
                    }
                    if (input.is(":text") || input.is("textarea")) {
                        $(this).html(input.val());
                    } else if (input.is("select")) {
                        $(this).html(input.find('option:selected').text());
                    } else if (input.is(":radio") && input.is(":checked")) {
                        $(this).html(input.attr("data-title"));
                    } else if ($(this).attr("data-display") == 'payment[]') {
                        var payment = [];
                        $('[name="payment[]"]:checked', form).each(function(){ 
                            payment.push($(this).attr('data-title'));
                        });
                        $(this).html(payment.join("<br>"));
                    }
                });
            }

            var handleTitle = (tab, navigation, index) =>{
                
             
                var total = navigation.find('li').length;
                var current = index + 1;
                // set wizard title
                $('.step-title', $('#form-wizard')).text('Step ' + (index + 1) + ' of ' + total);
                // set done steps
                jQuery('li', $('#form-wizard')).removeClass("done");
                var li_list = navigation.find('li');
                for (var i = 0; i < index; i++) {
                    jQuery(li_list[i]).addClass("done");
                }

                if (current == 1) {
                    $('#form-wizard').find('.button-previous').hide();
                } else {
                    $('#form-wizard').find('.button-previous').show();
                }

                if (current >= total) {
                    $('#form-wizard').find('.button-next').hide();
                    $('#form-wizard').find('.button-submit').show();
                    displayConfirm();
                } else {
                    $('#form-wizard').find('.button-next').show();
                    $('#form-wizard').find('.button-submit').hide();
                }
            }

            // default form wizard
            $('#form-wizard').bootstrapWizard({
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
                onTabClick:  (tab, navigation, index, clickedIndex)  =>{
                    return false;
                    
                    success.hide();
                    error.hide();
                    if (form.valid() == false) {
                        return false;
                    }
                    
                    handleTitle(tab, navigation, clickedIndex);
                },
                onNext: function (tab, navigation, index) {
                    
                    
                    if(1 === index){
                        
                       let  isValid = $('#product-profile-form').valid()
                       
                       if(!isValid){
                           
                                swal("Alert", 'Product name can\'t be empty', 'warning');
                                return false;
                           
                       }
                        
                    }
                    success.hide();
                    error.hide();


                    handleTitle(tab, navigation, index);
                },
                onPrevious:  (tab, navigation, index)=> {
                    success.hide();
                    error.hide();

                    handleTitle(tab, navigation, index);
                },
                onTabShow:  (tab, navigation, index) =>{
                    var total = navigation.find('li').length;
                    var current = index + 1;
                    var $percent = (current / total) * 100;
//                    $('#form-wizard').find('.progress-bar').css({
//                        width: $percent + '%'
//                    });
                }
            });

            $('#form-wizard').find('.button-previous').hide();
            $('#form-wizard .button-submit').click(function () {
                swal('Success', ' Rawmix  Settings Completed' , 'success');
            }).hide();

        }

    };

}();


export default class RawmixSettings extends Component {
  constructor(props) {
    super(props);
   
        this.state = {
                        product_id      :  document.getElementById("rawmix_product_id").value,
                        profile_name    : null,
                        productProfile  : null, 
                        sourceList      : null ,
                        setpointList    : null ,
                        elementCompList : null,
                        selected_source_id : null,
                        progress : 0
                        
                        
                    }
                    
           this.refresh         = this.refresh.bind(this);
           this.getSetPoints    = this.getSetPoints.bind(this);   
           this.getSources      = this.getSources.bind(this);
           this.renderProfile   = this.renderProfile.bind(this);  
           this.renderSetpoints = this.renderSetpoints.bind(this);  
           this.renderSource    = this.renderSource.bind(this);  
           this.renderElements  = this.renderElements.bind(this);  
           this.getElementComp  = this.getElementComp.bind(this);
           this.getProfile      = this.getProfile.bind(this);
                
         
            

  }
  
    
    componentDidMount(){
        
            
            let profileId = document.getElementById("rawmix_product_id").value
            
//      
            if(profileId.length == 0){
                return false;
            }
            this.getProfile(profileId);
            SettingsWizard.init();
       
          //  this.getSources();
          //  this.getSetPoints();
           // this.getElementComp();
          
          
                
    }
    
    
    renderProfile(){
                return      <Profile     productProfile={this.state.productProfile}/>
    }
    renderSetpoints(){
                return       <Setpoints  product_id={this.state.product_id}  setpointList={this.state.setpointList}  onChange={this.getSetPoints} />
    }
     renderSource(){
                return       <Source     product_id={this.state.product_id}  sourceList={this.state.sourceList} onChange={this.getSources} />
    }
    
    renderElements(){
                return       <ElementComposition  
                                                    selected_source_id={this.state.selected_source_id} 
                                                    product_id={this.state.product_id} 
                                                    sourceList={this.state.sourceList} 
                                                    elementCompList={this.state.elementCompList} 
                                                    onChange={this.getElementComp} />
    }
    
    onChange(){
       this.getSetPoints();
       this.getSources();
       this.getElementComp();
       
    }
    
    getProfile(profileId){
        
        let param = "?&id="+ profileId; 
        
          //Clear previous State
        this.setState( { productProfile : null}) ;
        this.render();
        
        
        axios.get(baseUrl+'/product-profile/detail' + param ,{
        headers: {
            'Content-Type': 'application/json',
            'X-Access-Token': access_token
        }
        }
        ).then( (response) => {
                
                  let profileDetail     =   response.data.data
                  this.setState( {  productProfile   : profileDetail.product_profile ,
                                    setpointList     : profileDetail.setpoints ,  
                                    sourceList       : profileDetail.source ,
                                    elementCompList  : profileDetail.element_compostion}); 
                 

                    $('#form-wizard').find('.progress-bar').css({
                        width: profileDetail.validation.progress + '%'
                    });


                  this.render();

            }).catch( (response)  =>{
                alert(response.message);
                }); 
    }
    
    validate(){
       
                axios.get(rawmix_validate_profile ,{
        headers: {
            'Content-Type': 'application/json',
            'X-Access-Token': access_token
        }
        }
        ).then( (response) => {
                
                  this.setState( { setpointList : response.data.data}) 
                
                  this.render();

            }).catch( (response)  =>{
                alert(response.message);
                });
       
    }
    getSetPoints(source_id = false){
        
        this.setState( { setpointList : null}) ;

        this.render();
        axios.get(setpoints_url ,{
        headers: {
            'Content-Type': 'application/json',
            'X-Access-Token': access_token
        }
        }
        ).then( (response) => {
                
                  this.setState( { setpointList : response.data.data}) 
                
                  this.render();

            }).catch( (response)  =>{
                alert(response.message);
                });
       
    } 
    
    
    getSources(){
        
        //Clear previous State
        this.setState( { sourceList : null}) ;
        this.render();
        axios.get(source_list_url,{
        headers: {
            'Content-Type': 'application/json',
            'X-Access-Token': access_token
        }
        }
        ).then( (response)  =>{
                this.setState( { sourceList : response.data.data}) ;
                this.render();
                
            }).catch( (response) => {
                alert(response.message);
                });
       
    }
    
    getElementComp(source_id = false){
       
       
        let search = "?&source_id="+source_id;
        
        //Clear previous State
        this.setState( { elementCompList : null , selected_source_id : source_id}) ;

        this.render();
        
        axios.get(element_composition + search ,{
        headers: {
            'Content-Type': 'application/json',
            'X-Access-Token': access_token
        }
        }
        ).then( (response)  =>{
            
            
                        this.setState( { elementCompList : response.data.data}) ;
                        this.render();
                
            }).catch( (response) => {
                alert(response.message);
                });
       
    }
    refresh(){
        
        this.render();
        
    }
   

  render() {

    return (
          <div className="portlet light form-wizard" id="form-wizard" >
    <div className="portlet-title tabbable-line">

        
         <ul className="nav nav-pills nav-justified steps">
            <li>
                <a href="#product-profile" data-toggle="tab" className="step active">
                    <span className="number"> 1 </span>
                    <span className="desc">
                        <i className="fa fa-check"></i> Profile Name </span>
                </a>
            </li>
            <li>
                <a href="#portlet_set_point" data-toggle="tab" className="step">
                    <span className="number"> 2 </span>
                    <span className="desc">
                        <i className="fa fa-check"></i> Set Points </span>
                </a>
            </li>
            <li>
                <a href="#portlet_source" data-toggle="tab" className="step">
                    <span className="number"> 3 </span>
                    <span className="desc">
                        <i className="fa fa-check"></i> Source </span>
                </a>
            </li>
            <li>
                <a href="#portlet_source_element" data-toggle="tab" className="step">
                    <span className="number"> 4 </span>
                    <span className="desc">
                        <i className="fa fa-check"></i> Elements </span>
                </a>
            </li>
        </ul>
        <div id="bar" className="progress progress-striped" role="progressbar">
            <div className="progress-bar progress-bar-success"> </div>
        </div>

        
    </div>
    <div className="portlet-body ">
         
            <div className="tab-content">
            
                
                <div className="tab-pane active" id="product-profile">

                        { this.state && this.state.productProfile && this.renderProfile()   }
                </div>
            
                <div className="tab-pane " id="portlet_set_point">
            
                        { this.state && this.state.setpointList && this.renderSetpoints()   }
                </div>
             
                <div className="tab-pane" id="portlet_source">

                    { this.state && this.state.sourceList   && this.renderSource() }   
               </div>
               
                <div className="tab-pane" id="portlet_source_element">
            
                    { this.state &&  this.state.elementCompList  && this.renderElements() }  
                </div>
            </div>
            
             <div className="form-actions margin-top-20">
                <div className="row">
                    <div className="col-md-12" style={{textAlign:'center'}}>
                        <a href="javascript:;" className="btn default button-previous " >
                            <i className="fa fa-angle-left"></i> Back </a>
                        <a href="javascript:;" className="btn  blue button-next"> Next
                        &nbsp;
                            <i className="fa fa-angle-right"></i>
                        </a>
                        <a href={rawmixConfigLog} className="btn blue button-submit "> Finish
                            <i className="fa fa-check"></i>
                        </a>
                    </div>
                </div>
            </div>
               
    </div>
    </div>

    )}
  
}
