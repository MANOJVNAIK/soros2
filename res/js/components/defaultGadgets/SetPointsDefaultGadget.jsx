import React, { Component } from 'react';

import { fromJS  , Map  } from 'immutable' 

import { Button , FormGroup , ControlLabel , FormControl , Modal } from 'react-bootstrap';
import Select from 'react-select';

import axios from 'axios';




class SetPointsWidget extends Component {
    
        constructor(props) {
                super(props);
                
   
                console.log('Set Points',this.props);
                this.state = {  
                                showModal: false,
                                gadget_data_id : '',
                                lay_id : this.props.layoutID,
                                detector_source : '',
                                gadget_name : this.props.data.gadget_name,
                                detectorOption:false,
                                eleOption:false,
                                gadget_type:'SetPoints',
                                detectorInfo:detectorInfo,
                                productProfile: this.props.productProfile,
                                setpointOption : [],
                                sourceOption : [],
                                elementOption : [],
                                sources:'',
                                setpoints:'',
                                element_compostion : '',
                                interval : '',
                                gadget_size : this.props.data.gadget_size,
                                widgetsPos : this.props.data.widgetsPos
                               
                                
                                // detectorInfo is set in create view file
                            };
         
        this.baseState = this.state;            
        this.close = this.close.bind(this);
        this.open = this.open.bind(this);
        this.save = this.save.bind(this);
        
        this.creatGadget            = this.creatGadget.bind(this);
        this.handleInputChange      = this.handleInputChange.bind(this);
        this.handleSetPointChange   = this.handleSetPointChange.bind(this);
        this.handleSourceChange     = this.handleSourceChange.bind(this);
        this.handleElementChange    = this.handleElementChange.bind(this);
        this.handleDetectorChange   = this.handleDetectorChange.bind(this);
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
 
 
  handleElementChange(element){

    
    this.setState({element_compostion : element});
 } 
 
 
 creatGadget(){
     
     
        let validator = $("#setpoint_gadget_form").validate();
        validator.form();
        let valid = validator.valid();
        
        if(!valid){
            return false;
        }
        
        
        this.close();
        const data = this.serializeObject($('#setpoint_gadget_form'));
        
        data.sources    =  this.state.sources; 
        data.setpoints  =  this.state.setpoints; 
        data.elements   =  this.state.elements; 
            
        this.props.updateDefaultGadgets(data);
    
    }
 
  
 
  
  save(){
      
     
      this.creatGadget()
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




                  this.setState({setpointOption:setPointArray , sourceOption:sourceArray , elementOption:elementCompArray})


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
      
           let actionBtn;
       if(this.props.action === 'edit'){
           
           
        actionBtn = <a href="javascript:;" className="btn blue btn-sm" onClick={this.edit}>
        Edit &nbsp;  <i className="fa fa-pencil"></i>   
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
              
              
                        <input name="lay_id" type="hidden" value={this.props.data.lay_id} />
                        
                        <input name="gadget_data_id" type="hidden"  value={this.state.gadget_data_id} />
                        <input name="widgetsPos"    type="hidden"   value={this.props.data.widgetsPos} />
                        
              
                        <div className="form-body">
                            <div className="form-group">
                                <label className="col-md-3 control-label">Gadget Name</label>
                                <div className="col-md-9">
                                  <input type="text" className="form-control " 
                                  required placeholder="Gadget Name" 
                                   name='gadget_name' 
                                   value={this.state.gadget_name}
                                   onChange={this.handleInputChange}
                                   /> 
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
                                <label className="col-md-3 control-label">Detector Source</label>
                            <div className="col-md-9">
                            <Select
                                name="detector_source"
                                closeOnSelect={true}
                                required={true}
                                onChange={this.handleDetectorChange}
                                options={this.state.detectorOption}
                                placeholder=" Select  Detector "
                                simpleValue
                                value={this.state.detector_source}
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
                                <label className="col-md-3 control-label"> Source</label>
                                <div className="col-md-9">
                                <Select
                                    name="sources"
                                    closeOnSelect={!this.state.stayOpen}
					 multi
                                        required={true}
					onChange={this.handleSourceChange}
					options={this.state.sourceOption}
					placeholder="Select  Source(s)"
					simpleValue
					value={this.state.sources}
                                />
                                </div>
                            </div>
                            
                            <div className="form-group">
                                <label className="col-md-3 control-label"> Elements</label>
                                <div className="col-md-9">
                                <Select
                                    name="element_compostion"
                                    closeOnSelect={!this.state.stayOpen}
					multi
					onChange={this.handleElementChange}
					options={this.state.elementOtion}
					placeholder="Select  element(s)"
					simpleValue
					value={this.state.element_compostion}
                                />
                                </div>
                            </div>
                            
                            
                            <div className="form-group">
                                <label className="col-md-3 control-label"> Interval</label>
                                <div className="col-md-9">
                                <Select.Creatable
                                    name="interval"
                                    closeOnSelect={!this.state.stayOpen}
					multi
					onChange={(value) => { this.setState({interval :value })}}
					options={[{value: 10, label:'10min' } , {value : 20 , label : "20min"}, {value : 30 , label : "30min"}]}
					placeholder="Select  interval(s)"
					simpleValue
					value={this.state.interval}
                                />
                                </div>
                            </div>
                            
  
                        </div>
                    </form>
                
          </Modal.Body>
          
          <Modal.Footer>
                        <div className="form-actions float-right">
                        
                        
                         <button className="btn   blue" onClick={this.save}> Submit</button>
                        <button className="btn btn-default  " onClick={this.close}> Cancel</button>
                        
                        
                        </div>
          </Modal.Footer>
        </Modal>
        </span>
      
      );
   }
}



export default SetPointsWidget;