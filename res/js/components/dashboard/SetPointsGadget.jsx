import React, { Component } from 'react';

import { fromJS  , Map  } from 'immutable' 

import { Button , FormGroup , ControlLabel , FormControl , Modal } from 'react-bootstrap';
import Select from 'react-select';

import axios from 'axios';




class SetPointsWidget extends Component {
    
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
                                gadget_type:'SetPoints',
                                gadget_size : 'small',
                                detectorInfo:detectorInfo,
                                productProfile: this.props.productProfile,
                                setpointOption : [],
                                sourceOption : [],
                                sources:'',
                                setpoints:'',
                                elements : 'Al2O3,CaO,Fe2O3,SiO2',
                                intervals : '',
                                composition:'',
                                elementOption :
                                        [
                                            {value: 'Al2O3' , label :"Al2O3"} ,
                                            {value: 'CaO' , label :" Cao" },
                                            {value: 'Fe2O3' , label :"Fe2O3"},
                                            {value: 'SiO2' , label :"SiO2"},
                                        ],
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

                  
                                        
                               
                                
                                
                                // detectorInfo is set in create view file
                            };
         
        this.baseState = this.state;            
        this.close = this.close.bind(this);
        this.open = this.open.bind(this);
        this.save = this.save.bind(this);
        
        this.creatGadget            = this.creatGadget.bind(this);
        this.updateGadget           = this.updateGadget.bind(this);
        this.handleInputChange      = this.handleInputChange.bind(this);
        this.handleSetPointChange   = this.handleSetPointChange.bind(this);
        this.handleSourceChange     = this.handleSourceChange.bind(this);
        this.handleDetectorChange   = this.handleDetectorChange.bind(this);
        this.getProductProfile      = this.getProductProfile.bind(this);
        this.handleIntervalChange   = this.handleIntervalChange.bind(this);
        this.edit                   = this.edit.bind(this);
        this.handleComposition      = this.handleComposition.bind(this);


       
  
  }
  
    close() {
    this.setState({ showModal: false });
    $("#gadget-select").show();

  }

  open() {
  
     this.setState({ showModal: true });
     
     $("#gadget-select").hide();
  }
  
  
  edit(){
      
        
            
            axios.get(baseUrl+'/index.php/set-point-gadget/view?&id=' + this.props.data.gadget_data_id, {
            headers: {
            'Content-Type': 'application/json',
                    'X-Access-Token': access_token
            }
            }
            ).then( (response, b, c) => {
              //  self.loadTable()
             let setpointGadget    = response.data.data.gadget;
             let setPointGadgetEle = response.data.data.setpoints ? response.data.data.setpoints : [];
              
          
             // Settings gadlay_data_form
               for(let x in setpointGadget){
          
        
                    this.setState({
                        [x]: setpointGadget[x]
                       });
                }
             
             //Seting setpoint gadget form
              for(let x in setPointGadgetEle){
          
        
                    this.setState({
                        [x]: setPointGadgetEle[x]
                       });
                }
             
             this.setState({composition : setPointGadgetEle['elements']});
             this.open();
              
            }).catch( (response ) => {
            swal('Error','Something Went wrong ','error');
            console.log(response);
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

handleComposition(value){
    
    
    this.setState({composition : value})
}

  

 handleDetectorChange(value){
     
      //  alert(value)
      
      this.setState({detector_source : value});
        
 } 
 
 
 
  handleSetPointChange(value){
     
     
    
        this.setState({ setpoints: value});
    
 } 
 
 
 
  handleSourceChange(sources){
     
              // console.log('Selected source item =>',source) 
              this.setState({sources : sources});
    
 } 
 
 
  handleIntervalChange(value){
      
      
        this.setState({intervals : value});
      
  }
 
 
 updateGadget(){
     
        let validator = $("#setpoint_gadget_form").validate(this.state.validationOption);
        validator.form();
        let valid = validator.valid();
        
        //Add validation later
        if(!valid){
            return false;
        }
    
        
            var data = this.serializeObject($('#setpoint_gadget_form'));
            data.sources    =  this.state.sources; 
            data.setpoints  =  this.state.setpoints; 
            data.elements   =  this.state.elements; 
            data.intervals  =  this.state.intervals;
            
           
            axios.put(baseUrl+'/index.php/set-point-gadget/update&id='+this.props.data.gadget_data_id, data, {
            headers: {
            'Content-Type': 'application/json',
                    'X-Access-Token': access_token
            }
            }
            ).then( (response, b, c) => {
             this.close();
            this.props.onSubmit(this.state.lay_id);
            swal('Success','Setpoint Gadget Updated Successfully','success')
              
    }).catch(function (response) {
        swal('Error','Some Error Occured','Sucess','warning')
    });
 }
 
 creatGadget(){
     
     
        let validator = $("#setpoint_gadget_form").validate(this.state.validationOption);
        validator.form();
        let valid = validator.valid();
        
        if(!valid){
            return false;
        }
        const data = this.serializeObject($('#setpoint_gadget_form'));
        
          data.sources      =  this.state.sources; 
          data.setpoints    =  this.state.setpoints; 
          data.elements     =  this.state.composition; 
          data.gadget_size   =  this.state.gadget_size; 
        
           
        axios.post(setpoint_gadget_create_url, data, {
            headers: {
                'Content-Type': 'application/json',
                'X-Access-Token': access_token
            }
        }
        ).then((response) => {
            
            swal("Sucess",'Setpoint created Successfully','success');
            
            this.close();
            this.props.onSubmit(this.state.lay_id);
            this.props.onClick();  //to close gadget select
            
        }).catch( (response) => {
            
       
            this.close();
           swal("Error",'Some problem occured , couldn\'t create Setpoint','warning')
           
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
                
                //  alert(response.data.data)  ;
                let sourceArray         = Array();
                let setPointArray       = Array(); 
                let elementCompArray    = Array();
        
          
                  const productProfile = response.data.data;
                  this.setState( { productProfile : productProfile }) 
                  //this.setState({progress : productProfile.validation.progress });
                  this.render();
                  
                const sources =productProfile.source || [];
                  for(const x in sources){

                      sourceArray.push({ value : sources[x].src_name, label : sources[x].src_name});
                      // elementArry.push({ value : sources[x], label : list[x]});
                  }


                  //Polupating set point array
                   const setpoints = productProfile.setpoints || [];
                  for(const x in setpoints){
                      setPointArray.push({ value : setpoints[x].sp_name, label : setpoints[x].sp_name});
                  }



                    //Polupating element array
                   const element_composition = productProfile.element_composition;
                  for(const x in element_composition){
                      elementCompArray.push({ value : element_composition[x].element_name, label : element_composition[x].element_name});
                  }




                  this.setState({setpointOption:setPointArray , sourceOption:sourceArray })


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
      const intervalOption = [{value: 'small' , label :"Small"},{value: 'medium' , label :" Medium"},{value: 'large' , label :" Large"}];
      const elementOption = [{value: 'small' , label :"Small"},{value: 'medium' , label :" Medium"},{value: 'large' , label :" Large"}];
      
      
      
           let actionBtn;
       if(this.props.action === 'edit'){
           
           
        actionBtn = <a href="javascript:;" className="btn  blue btn-sm" onClick={this.edit}>
        Edit &nbsp;<i className="fa fa-pencil"></i>   
        </a>
       }else{
           
           actionBtn =  <div className="col-md-4">
                                            <div className="mt-widget-3">
                                                <div className="mt-head bg-blue-hoki">
                                                    <div className="mt-head-icon">
                                                        <i className=" fa fa-warning"></i>
                                                    </div>
                                                    <div className="mt-head-desc"> Setpoints</div>
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
            <Modal.Title className="text-center"><span className="caption-subject bold uppercase font-blue">SetPoints Gadget</span></Modal.Title>
          </Modal.Header>
          <Modal.Body>
              <form id="setpoint_gadget_form" className="form-horizontal has-validation" role="form" onSubmit={(e) => {  e.preventDefault() } }>
              
              
                        <input name="lay_id" type="hidden" value={this.state.lay_id} />
                        <input name="gadget_data_id" type="hidden" value={this.state.gadget_data_id} />
              
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
                                     
                                    required 
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
                                        disabled={true}
                                        onChange={value => {this.setState({gadget_size: value})}}
                                        options={sizeOption}
                                        placeholder=" Select  Size "
                                        simpleValue
                                        value={this.state.gadget_size}
                                    />
                                </div>
                            </div>
                            
                            <div className="form-group">
                                <label className="col-md-3 control-label"> SetPoints</label>
                                <div className="col-md-9">
                                <Select
                                    name="setpoints"
                                    closeOnSelect={!this.state.stayOpen}
					multi
                                         required={true}
					onChange={this.handleSetPointChange}
					options={this.state.setpointOption}
					placeholder="Select  Setpoints(s)"
					simpleValue
					value={this.state.setpoints}
                                />
                                </div>
                            </div>
                            
                            
                            <div className="form-group">
                                <label className="col-md-3 control-label"> Element</label>
                                <div className="col-md-9">
                                <Select
                                    name="composition"
                                    closeOnSelect={!this.state.stayOpen}
					multi
                                         required={true}
					onChange={this.handleComposition}
					options={this.state.elementOption}
					placeholder="Select  Setpoints(s)"
					simpleValue
					value={this.state.composition}
                                />
                                </div>
                            </div>
                            
                            
                            
                            <div className="form-group">
                                <label className="col-md-3 control-label"> Interval</label>
                                <div className="col-md-9">
                                <Select.Creatable
                                    name="intervals"
                                    closeOnSelect={!this.state.stayOpen}
					multi
					onChange={this.handleIntervalChange}
                                        
					options={[{value : "5" , label : '5min'},{value : "10" , label : '10min'},{value : "15" , label : '15Min'},{value : "20" , label : '20Min'}]}
					placeholder="Select  interval(s)"
					simpleValue
					value={this.state.intervals}
                                />
                                </div>
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



export default SetPointsWidget;