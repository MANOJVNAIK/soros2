import React, { Component } from 'react';
import { Button , FormGroup , ControlLabel , FormControl , Modal } from 'react-bootstrap';
import CustomizeElements from './CustomizeElements.jsx'
import  Select  from 'react-select';


class LightGadget extends Component {
    
        constructor(props) {
                super(props);
                
                this.state = {  showModal: false,
                                detectorOption:[],
                                eleOption:[],
                                gadget_type:'IdiotLights',
                                gadget_name:'',
                                gadget_size : 'large',
                                detectorInfo:detectorInfo,  // detectorInfo is set in create view file
                                lay_id : this.props.layoutID,
                                disabled: false,
                                crazy: false,
                                stayOpen: false,
                                action :this.props.action,
                                elementOption  : [],
                                continue : false,
                                 validationOption : {
                                                    errorElement: "span",
                                                    errorClass: "help-block help-block-error",
                                                    focusInvalid: !1,
                                                    ignore: "",

                                                    errorPlacement: function(e, r) {
                                                        var i = $(r).parent(".input-group");
                                                        i.size() > 0 ? i.after(e) : r.after(e)
                                                    },
                                                    highlight: function(e) {
                                                        $(e).closest(".form-group").addClass("has-error")
                                                    },
                                                    unhighlight: function(e) {
                                                        $(e).closest(".form-group").removeClass("has-error")
                                                    },
                                                    success: function(e) {
                                                        e.closest(".form-group").removeClass("has-error")
                                                    },
                                                    submitHandler: function(e) {
                                                        i.show(), r.hide()
                                                    }
                                                }  


                         };
                         
//                    this.props.onClick();//close select object
                    if(this.props.action === 'edit'){


                        this.state                  =   Object.assign({}, this.state, this.props.data);
                        this.handleDetectorChange   =   this.handleDetectorChange.bind(this);
                        this.handleEleChange        =   this.handleEleChange.bind(this);
                        this.handleSizeChange       =   this.handleSizeChange.bind(this);



                    }         
        
                
                this.close                  = this.close.bind(this);
                this.open                   = this.open.bind(this);
                this.handleInputChange      = this.handleInputChange.bind(this);
                this.handleSubmit           = this.handleSubmit.bind(this);
                this.selectElements         = this.selectElements.bind(this);
                this.handleDetectorChange   = this.handleDetectorChange.bind(this);
                this.handleEleChange        = this.handleEleChange.bind(this);
                this.handleSizeChange       = this.handleSizeChange.bind(this);
                this.next                   = this.next.bind(this);
       
  }
  
    close() {
    this.setState({ showModal: false });
    
    $("#gadget-select").show();
         

  }

  open(){
      
            this.setState({ showModal: true });
            $("#gadget-select").hide();

  }
  handleInputChange(event) {
      
    const target = event.target;
    const value = target.type === 'checkbox' ? target.checked : target.value;
    const name = target.name;
    this.setState({
      [name]: value
    });
  }

  handleSubmit(data) {
      
     
    var  element = data;    
    const formData  = { GadgetsData : {
    gadget_type     : this.state.gadget_type,
    gadget_name     : this.state.gadget_name,
    detector_source : this.state.detector_source,
    gadget_size     : this.state.gadget_size,
    data_source     : '',
    
    lay_id          : this.props.layoutID  ,   
    elements        : element ,
    
    } 
}


        let validator = $("#light_gadget_form").validate(this.state.validationOption);
        validator.form();
        let valid = validator.valid();
        
        if(!valid){
            return false;
        }
    
        var url ;
        if(this.state.action === 'edit'){
             url = baseUrl+'/index.php/gadgets-data/update?&id='+this.state.gadget_data_id;

        }else{
            url = baseUrl+'/index.php/gadgets-data/create';
        }


    $.ajax({
        type:'POST',
        url:url,
        data: formData,
        success:function(msg){
            let jObject = JSON.parse(msg);
            this.close();
            this.props.onSubmit(this.state.lay_id);
//              this.props.onClick();  //to close gadget select
        
        }.bind(this)
        ,
        error: function(request,status,errorThrown) {
//            
//        console.log('request =>',request, 'status => ',status, 'errorThrown' ,errorThrown);
        
        alert('Error  !',request.responseText);
        
            //this.close();
            //this.props.onSubmit(this.state.lay_id);
            //this.props.onClick();  //to close gadget select
        
        // There's been an error, do something with it!
        // Only use status and errorThrown.
        // Chances are request will not have anything in it.
   }.bind(this)
        
    });
  }
  
 handleDetectorChange(value){
     
    this.selectElements(this.state.detectorInfo[value]);
   
    this.setState({
       detector_source : value
    });
    
    
    
 } 
  
  
  selectElements(list){
      
      var elementArry = Array();
        
        for(const x in list){
            elementArry.push({value:list[x] , label : list[x]});
        }
        this.setState({eleOption:elementArry})
        
        
  }
  
  
  handleEleChange (value) {
//            console.log('You\'ve selected:', value);
            
            this.setState({ data_source :  value });
    }


    handleSizeChange (value) {
//            console.log('You\'ve selected:', value);
            
            this.setState({ gadget_size : value },()=>{
                
            });
            
    }
    
  
  
  componentDidMount(){
         
         var detectorArray = Array();
         var systemStatusArray = Array();
         
         
        
        for(const x in detectorInfo){
            detectorArray.push({value : x , label : x});
        }
        
        
        for(const y in system_status){
            systemStatusArray.push({value : y , label : y});
        }
        
        this.setState({detectorOption:detectorArray, elementOption : systemStatusArray});
        
        
        
                 this.setState({ CustomizeElements : 
                                                    <CustomizeElements  
                                                        action={this.props.action} 
                                                        data={this.props.data} 
                                                        gadget_size={this.state.gadget_size} 
                                                        gadget_type={this.state.gadget_type} 
                                                        elementOption={this.state.systemStatusArray} 
                                                        onSubmit={this.handleSubmit}
                                                      
                                                        />})  ;
        
        
        if(this.props.action === 'edit'){
            
            let model = this.props.data;
            this.setState({});
            this.handleDetectorChange(model.detector_source) 
            this.handleEleChange(model.data_source)
            this.handleSizeChange(model.gadget_size)   
        
            
            
        }
       
        
  }
  
  next(){
      
        let validator = $("#light_gadget_form").validate(this.state.validationOption);
        validator.form();
        let valid = validator.valid();
        
        if(!valid){
            return false;
        }
    
      
        
        this.setState({ CustomizeElements : 
                                                    <CustomizeElements  
                                                        action={this.props.action} 
                                                        data={this.props.data} 
                                                        gadget_size={this.state.gadget_size} 
                                                        gadget_type={this.state.gadget_type} 
                                                        elementOption={this.state.systemStatusArray} 
                                                        onSubmit={this.handleSubmit}
                                                        showModal={true}
                                                        />} , this.render)  ;
      
      
  }
   render() {
       
       
       var actionBtn;
       if(this.props.action == 'edit'){
           
           
        actionBtn = <a href="javascript:;" className="btn blue   btn-sm" onClick={this.open}>
        Edit &nbsp;<i className="fa fa-pencil fontwhite"></i>   
                    </a>
       }else{
           
           
        actionBtn = <div className="col-md-4">
                            <div className="mt-widget-3">
                                <div className="mt-head bg-yellow-lemon">
                                    <div className="mt-head-icon">
                                        <i className=" fa fa-lightbulb-o"></i>
                                    </div>
                                    <div className="mt-head-desc"> Light</div>
                                    <div className="mt-head-button">
                                        <button type="button" className="btn btn-circle btn-outline white btn-sm" onClick={this.open}>Add</button>
                                    </div>
                                </div>

                            </div>
                        </div>

       }
       
      return (
              
        <span>
        
        {actionBtn}
         

        <Modal show={this.state.showModal} onHide={this.close}>
          <Modal.Header closeButton>
            <Modal.Title className="text-center" ><span className="caption-subject bold uppercase font-blue">Light Gadget</span></Modal.Title>
          </Modal.Header>
          <Modal.Body>
              <form id="light_gadget_form" className="form-horizontal" role="form" onSubmit={(e) => {  e.preventDefault() } }>
              
              
                        <div className="form-body">
                            <div className="form-group">
                                <label className="col-md-3 control-label">Gadget Name</label>
                                <div className="col-md-9">
                                  <input type="text" className="form-control " placeholder="Gadget Name" required="required" name='gadget_name' value={this.state.gadget_name}
                                   onChange={this.handleInputChange} /> 
                                    </div>
                            </div>
                            <div className="form-group">
                                <label className="col-md-3 control-label">Gadget Type</label>
                                <div className="col-md-9">
                                    <input type="text" name='gadget_type' disabled={true} className="form-control" placeholder="Gadget Type" onChange={this.handleInputChange}  value={this.state.gadget_type}/> </div>
                            </div>
                            
                           <div className="form-group">
                                <label className="col-md-3 control-label">Size</label>
                                <div className="col-md-9">
                              
                                <Select
                                    name="gadget_size"
                                    closeOnSelect={!this.state.stayOpen}
					disabled = {true}
					onChange={this.handleSizeChange}
					options={ [ {value : 'small' , label : 'Small'} , {value : 'medium' , label : 'Medium'} , {value : 'large' , label : 'Large'} ] }
					placeholder="Select size "
					simpleValue
					value={this.state.gadget_size}
                                />
                                </div>
                        </div>
                        </div>
                    </form>
                
          </Modal.Body>
          
          
                    <Modal.Footer>
                    
                        <div className="form-actions float-right">
                       
                                  
                           
                            { this.state.CustomizeElements }
                            
                            
                            
                            
                            
                             <button type="button" className="btn btn-default" onClick={this.close}>Cancel</button>
                                    
                        
                        </div>
                    </Modal.Footer>
        </Modal>
        </span>
      
      );
   }
}



export default LightGadget;