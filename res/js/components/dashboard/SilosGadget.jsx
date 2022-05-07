import React, { Component } from 'react';
import Select from 'react-select';
import axios from 'axios';
import { Button , FormGroup , ControlLabel , FormControl , Modal } from 'react-bootstrap';

class SilosGadget extends Component {
    
        constructor(props) {
                super(props);
                
   
                this.state = {  
                                showModal: false,
                                gadget_data_id : '',
                                lay_id : this.props.layoutID,
                                detector_source : '',
                                gadget_name : '',
                                detectorOption:false,
                                eleOption:false,
                                gadget_type:'Silos',
                                detectorInfo:detectorInfo,
                                productProfile: '',
                                alert_sources : '',
                                number_of_silos : '',
                                interval : '',
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
                this.handleIntervalChange   = this.handleIntervalChange.bind(this);
       
  
  }
  
    close() {
            this.setState({ showModal: false });
            $("#gadget-select").show();

  }

  open() {
  
     this.setState({ showModal: true });
     $("#gadget-select").hide();
  }
  
  handleIntervalChange(val){
      
      
  }
  edit(){
      
        
            
            axios.get(baseUrl+'/index.php/Gadgets/silos-gadget/view?&id=' + this.props.data.gadget_data_id, {
            headers: {
            'Content-Type': 'application/json',
                    'X-Access-Token': access_token
            }
            }
            ).then( (response, b, c) => {
              //  self.loadTable()
              
              let siloGadget = response.data.data;
              
          
             // Settings gadlay_data_form
               for(let x in siloGadget){
          
        
                    this.setState({
                        [x]: siloGadget[x]
                       });
                }
             
             
             this.open();
              
            }).catch( (response ) => {
            swal('Something ','clearn','super')
            });
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
     
        let validator = $("#silos_gadget_form").validate(this.state.validationOption);
        validator.form();
        let valid = validator.valid();
        
        //Add validation later
        if(!valid){
            return false;
        }
    
        
            var data = this.serializeObject($('#silos_gadget_form'));
            data.sources    =  this.state.sources; 
            data.setpoints  =  this.state.setpoints; 
            data.elements   =  this.state.elements; 
            
           
            axios.put(baseUrl+'/index.php/Gadgets/silos-gadget/update?&id='+this.props.data.gadget_data_id, data, {
            headers: {
            'Content-Type': 'application/json',
                    'X-Access-Token': access_token
            }
            }
            ).then( (response, b, c) => {
             this.close();
            this.props.onSubmit(this.state.lay_id);
            swal('Success','Setpoint Gadget Updated Successfully','success')
              
             }).catch( (response) =>{
                        swal('Error','Some Error Occured','Sucess','warning')
            });
 }
 
 creatGadget(){
     
     
        let validator = $("#silos_gadget_form").validate(this.state.validationOption);
        validator.form();
        let valid = validator.valid();
        
        if(!valid){
            return false;
        }
        const data = this.serializeObject($('#silos_gadget_form'));
        
          data.sources    =  this.state.sources; 
          data.setpoints  =  this.state.setpoints; 
          data.elements   =  this.state.elements; 
            
           
        axios.post(baseUrl+'/index.php/Gadgets/silos-gadget/create?&id='+this.props.layoutID, data, {
            headers: {
                'Content-Type': 'application/json',
                'X-Access-Token': access_token
            }
        }
        ).then((response) => {
            
            swal("Sucess",'Silo Gadget created Successfully','success');
            
            this.close();
            this.props.onSubmit(this.state.lay_id);
            this.props.onClick();  //to close gadget select
            
        }).catch( (response) => {
            
       
            this.close();
           swal("Error",'Some problem occured , couldn\'t create Silo Gadget','warning')
           
        });
    }
 
  
 
  
  save(){
      
     
      if(this.props.action === 'edit'){
          
      // alert('got inside me!')
          this.updateGadget();
          
      }else{
          this.creatGadget();
      }
      
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
       
      const sizeOption = [{value: 'medium' , label :" Medium"}];
      
           let actionBtn;
       if(this.props.action === 'edit'){
           
        //Universal button to create and update gadget   
        actionBtn = <button href="javascript:;" className="btn   blue btn-sm" onClick={this.edit}>
        Edit  &nbsp; <i className="fa fa-pencil font-white"></i> 
                    </button>
       }else{
           
           
        actionBtn =  <div className="col-md-4">
                        <div className="mt-widget-3">
                            <div className="mt-head bg-blue">
                                <div className="mt-head-icon">
                                    <i className=" fa fa-database"></i>
                                </div>
                                <div className="mt-head-desc"> Silos</div>
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
            <Modal.Title className="text-center"><span className="caption-subject bold uppercase font-blue">Silos Gadget</span></Modal.Title>
          </Modal.Header>
          <Modal.Body>
              <form id="silos_gadget_form" className="form-horizontal has-validation" role="form" onSubmit={(e) => {  e.preventDefault() } }>
              
              
                        <input name="lay_id" type="hidden" value={this.state.lay_id} />
                        <input name="gadget_data_id" type="hidden" value={this.state.gadget_data_id} />
              
                        <div className="form-body">
                            <div className="form-group">
                                <label className="col-md-3 control-label">Gadget Name</label>
                                <div className="col-md-9">
                                  <input type="text" className="form-control " required placeholder="Gadget Name"  name='gadget_name' value={this.state.gadget_name}
                                   onChange={this.handleInputChange} /> 
                                    </div>
                            </div>
                         <div className="form-group">
                                <label className="col-md-3 control-label">Gadget Type</label>
                                <div className="col-md-9">
                                    <input type="text" name='gadget_type' className="form-control"   value={this.state.gadget_type}/> </div>
                            </div>
                            
              
                        </div>
                    </form>
                
          </Modal.Body>
          
          <Modal.Footer>
                        <div className="form-actions float-right">
                        
                       
                        <button className="btn   blue" onClick={this.save}> Submit</button>
                        <button className="btn btn-default" onClick={this.close}> Cancel</button>
                        
                        
                        </div>
          </Modal.Footer>
        </Modal>
        </span>
      
      );
   }
}



export default SilosGadget;