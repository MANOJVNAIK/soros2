import React, { Component } from 'react';
import Select from 'react-select';
import axios from 'axios';
import { Button , FormGroup , ControlLabel , FormControl , Modal } from 'react-bootstrap';

class SystemAlertsGadget extends Component {
    
        constructor(props) {
                super(props);
                
   
                this.state = {  
                                showModal: false,
                                gadget_data_id : '',
                                lay_id : this.props.layoutID,
                                detector_source : '',
                                gadget_name : this.props.data.gadget_name,
                                detectorOption:false,
                                eleOption:false,
                                gadget_size: this.props.data.gadget_size,
                                gadget_type:'SystemAlert',
                                detectorInfo:detectorInfo,
                                productProfile: '',
                                alert_sources : '',
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
         
        this.close = this.close.bind(this);
        this.open = this.open.bind(this);
        this.save = this.save.bind(this);
        
        this.creatGadget            = this.creatGadget.bind(this);
        this.updateGadget           = this.updateGadget.bind(this);
        this.handleInputChange      = this.handleInputChange.bind(this);
        this.getProductProfile      = this.getProductProfile.bind(this);
        this.edit                   = this.edit.bind(this);
       
  
  }
  
    close() {
    this.setState({ showModal: false });

  }

  open() {
  
     this.setState({ showModal: true });
  }
  
  edit(){
      
        
            this.open();
  }
  handleInputChange(event) {
      
    const target = event.target;
    const value = target.type === 'checkbox' ? target.checked : target.value;
    const name = target.name;
    this.setState({
      [name]: value
    });
  }

 
  handleElementChange(element){

    
    this.setState({element_compostion : element});
 } 
 
 updateGadget(){
     
        let validator = $("#system_alert_default_gadget_form").validate(this.state.validationOption);
        validator.form();
        let valid = validator.valid();
        
        //Add validation later
        if(!valid){
            return false;
        }
    
        
            var data = this.serializeObject($('#system_alert_default_gadget_form'));
            data.sources    =  this.state.sources; 
            data.setpoints  =  this.state.setpoints; 
            data.elements   =  this.state.elements; 
            
           
            axios.put(baseUrl+'/index.php?r=Gadgets/system-alert-gadget/update&id='+this.props.data.gadget_data_id, data, {
            headers: {
            'Content-Type': 'application/json',
                    'X-Access-Token': access_token
            }
            }
            ).then( (response, b, c) => {
             this.close();
            this.props.onSubmit(this.state.lay_id);
            swal('Success','System Alert Gadget Updated Successfully','success')
              
    }).catch(function (response) {
        swal('Error','Some Error Occured','Sucess','warning')
    });
 }
 
 creatGadget(){
     
     
        let validator = $("#system_alert_default_gadget_form").validate();
        validator.form();
        let valid = validator.valid();
        
        if(!valid){
            return false;
        }
        
        this.close();
        const data = this.serializeObject($('#system_alert_default_gadget_form'));
        
          data.sources    =  this.state.sources; 
          data.setpoints  =  this.state.setpoints; 
          data.elements   =  this.state.elements; 
          this.props.updateDefaultGadgets(data);
      
           
    }
 
  save(){
      
     
                this.creatGadget();

  }
      
  serializeObject($form) {
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function (n, i) {
        indexed_array[n['name']] = n['value'];

    });

    return indexed_array;
}


  getProductProfile(){
        
        
        
       
        axios.get(get_complete_profile  ,{
        headers: {
            'Content-Type': 'application/json',
            'X-Access-Token': access_token
        }
        }
        ).then( (response) => {
                
                //  alert(response.data.data)  ;
                let sourceArray         = Array();
                let setPointArray       = Array(); 
                let elementCompArray    = Array();
        
          
                  const productProfile = response.data.data;
                  this.setState( { productProfile : productProfile }) 
                  this.render();
                  


            }).catch( (response)  =>{
                alert(response.message);
                }); 
    }
  
  componentDidMount(){
         
        let detectorArray       = Array();
  
        
        this.getProductProfile()
        //Populating detector array
        for(const x in detectorInfo){
            detectorArray.push(x);
        }
        
        var detectorOption = detectorArray.map( d => {  return { value : d, label :d} })
        
        this.setState({detectorOption : detectorOption});
        

        
  }
   
    
    
    render() {
       
      const sizeOption = [{value: 'small' , label :"Small"},{value: 'medium' , label :" Medium"},{value: 'large' , label :" Large"}];
      
               
       
      return (
              
    
              
                <span>
        
        
        <button href="javascript:;" className="btn blue btn-sm" onClick={() => {this.open()}}>
            Edit &nbsp;<i className="fa fa-pencil"></i>   
         </button> 

        <Modal show={this.state.showModal} onHide={this.close}>
          <Modal.Header closeButton>
            <Modal.Title className="text-center"><span className="caption-subject bold uppercase font-blue">System Alert Gadget</span></Modal.Title>
          </Modal.Header>
          <Modal.Body>
              <form id="system_alert_default_gadget_form" className="form-horizontal has-validation" role="form" onSubmit={(e) => {  e.preventDefault() } }>
              
              
                        <input name="lay_id" type="hidden" value={this.state.lay_id} />
                        <input name="gadget_data_id" type="hidden" value={this.state.gadget_data_id} />
                        <input name="widgetsPos" type="hidden" value={this.props.data.widgetsPos} />
              
              
                        <div className="form-body">
                            <div className="form-group">
                                <label className="col-md-3 control-label">Gadget Name</label>
                                <div className="col-md-9">
                                  <input type="text" className="form-control " required placeholder="Gadget Name" required name='gadget_name' value={this.state.gadget_name}
                                   onChange={this.handleInputChange} /> 
                                    </div>
                            </div>
                            <div className="form-group">
                                <label className="col-md-3 control-label">Gadget Type</label>
                                <div className="col-md-9">
                                    <input type="text" 
                                    name='gadget_type' 
                                    className="form-control" 
                                     
                                    required = {true}
                                    placeholder="Gadget Type" 
                                    onChange={this.handleInputChange}  
                                    value={this.state.gadget_type}/> 
                                </div>
                            </div>
                            
                                   <div className="form-group">
                                <label className="col-md-3 control-label">Size</label>
                                <div className="col-md-9">
                                   
                                    <Select
                                name="gadget_size"
                                closeOnSelect={true}
                                required = {true}
                                onChange={value => {this.setState({gadget_size: value})}}
                                options={sizeOption}
                                placeholder=" Select  Size "
                                simpleValue
                                value={this.state.gadget_size}
                            />
                                </div>
                            </div>
                            
           
                  
                            
                            <div className="form-group">
                                <label className="col-md-3 control-label"> Alert Source</label>
                                <div className="col-md-9">
                                <Select
                                    name="alert_sources"
                                    closeOnSelect={!this.state.stayOpen}
					 multi
                                       
					onChange={this.handleSourceChange}
					options=''
					placeholder="Select  Alert Source(s)"
					simpleValue
					value={this.state.alert_sources}
                                />
                                </div>
                            </div>
                            
                   
                        </div>
                    </form>
                
          </Modal.Body>
          
          <Modal.Footer>
                        <div className="form-actions float-right">
                        
                        <button className="btn   blue" onClick={this.save}> Submit</button>
                                
                        <button className="btn  " onClick={this.close}> Cancel</button>
                        
                        </div>
          </Modal.Footer>
        </Modal>
        </span>
      
      );
   }
}



export default SystemAlertsGadget;