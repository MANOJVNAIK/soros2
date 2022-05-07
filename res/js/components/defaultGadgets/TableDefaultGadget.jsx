import React, { Component } from 'react';
import { Button , FormGroup , ControlLabel , FormControl , Modal } from 'react-bootstrap';
import  Select  from 'react-select';


class TableGadget extends Component {
    
        constructor(props) {
            super(props);
            
            this.state = {  showModal: false,
                            detectorOption:[],
                            eleOption:[],
                            gadget_type:'System_Messages',
                            gadget_name:'',
                            detectorInfo:detectorInfo,  // detectorInfo is set in create view file
                            lay_id : this.props.layoutID,
                            detector_source : 'analysis_A1_A2_Blend',
                            disabled: false,
                            stayOpen: false,
                            display_style:'',
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
        
        
        
        
        if(this.props.action === 'edit'){
            
            
            this.state =   Object.assign({}, this.state, this.props.data);
            
            this.handleDetectorChange = this.handleDetectorChange.bind(this);
            this.handleEleChange   = this.handleEleChange.bind(this);
           this.handleSizeChange     = this.handleSizeChange.bind(this);
        
            
            
        }
        
        this.baseState = this.state;    // user to revert back to initial state        
        this.close = this.close.bind(this);
        this.open = this.open.bind(this);
        this.handleInputChange = this.handleInputChange.bind(this);
        this.createGadget = this.createGadget.bind(this);
        this.selectElements = this.selectElements.bind(this);
        this.handleDetectorChange = this.handleDetectorChange.bind(this);
        this.handleEleChange   = this.handleEleChange.bind(this);
        this.handleSizeChange     = this.handleSizeChange.bind(this);
        
  
  }
  
    close() {
    this.setState({ showModal: false });
  }

  open() {
     this.setState({ showModal: true });
     //this.props.onClick();  //to close gadget select modal
  }
  handleInputChange(event) {
      
    const target = event.target;
    const value = target.type === 'checkbox' ? target.checked : target.value;
    const name = target.name;
    this.setState({
      [name]: value
    });
  }
  

    handleEleChange (value) {
            console.log('You\'ve selected:', value);
            
            this.setState({ data_source :  value });
    }


    handleSizeChange (value) {
            console.log('You\'ve selected:', value);
            
            this.setState({ gadget_size : value });
    }
    
  createGadget(event) {
    
   
    event.preventDefault();     
   const data = {
    gadget_type     : this.state.gadget_type,
    gadget_name     : this.state.gadget_name,
    detector_source : this.state.detector_source,
    gadget_size     : this.state.gadget_size,
    display_style   : this.state.display_style,
    data_source     : this.state.data_source,
    lay_id          : this.props.layoutID,   
    gadget_data_id  : this.state.gadget_data_id,
    widgetsPos      : this.props.data.widgetsPos
    } 
    
    
    
      let validator = $("#table_gadget_form").validate(this.state.validationOption);
        validator.form();
        let valid = validator.valid();
        
        if(!valid){
            return false;
        }
    
    this.close()
    
    this.props.updateDefaultGadgets(data);
   // this.props.onChange(this.state.lay_id)
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
            elementArry.push({ value : list[x], label : list[x]});
        }
        
        
        this.setState({eleOption:elementArry})
  }
  
  
  componentDidMount(){
         
        var detectorArray = Array();
        
        for(const x in detectorInfo){
            detectorArray.push({value : x , label : x});
        }
        
        this.setState({detectorOption:detectorArray});
        
        this.handleDetectorChange(this.state.detector_source) 
        
        
        
  }
   render() {
       
       var actionBtn;
       if(this.props.action == 'edit'){
           
           
        actionBtn = <a href="javascript:;" className="btn blue btn-sm" onClick={this.open}>
        Edit &nbsp; <i className="fa fa-pencil"></i>   
        </a>
       }else{
           
           
        actionBtn = <div className="col-md-4">
                                            <div className="mt-widget-3">
                                                <div className="mt-head bg-purple-seance">
                                                    <div className="mt-head-icon">
                                                        <i className=" fa fa-table"></i>
                                                    </div>
                                                    <div className="mt-head-desc"> Table</div>
                                                    <div className="mt-head-button">
                                                        <button type="button" className="btn btn-circle btn-outline white btn-sm" onClick={this.open}>Add</button>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>

       }
        
                        

      return (
              
        <span>
         
         { actionBtn }
         
        
         
        <Modal show={this.state.showModal} onHide={this.close}>
          <Modal.Header closeButton>
            <Modal.Title className="text-center">
                <span className="caption-subject bold uppercase font-green ">Table Gadget</span>
            </Modal.Title>
          </Modal.Header>
          <Modal.Body>
              <form id="table_gadget_form" className="form-horizontal" role="form" onSubmit={this.createGadget}>
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
                                    <input type="text" name='gadget_type' className="form-control" placeholder="Gadget Type" onChange={this.handleInputChange}  value={this.state.gadget_type}/> </div>
                            </div>
                            <div className="form-group">
                                <label className="col-md-3 control-label">Table type</label>
                                <div className="col-md-9">
                                
                                <Select
                                    name="display_style"
                                    closeOnSelect={!this.state.stayOpen}
					
					onChange={(value) => { this.setState({display_style:value})}}
					options={ [ {value : 'avg' , label : 'Avg'} , {value : 'standard' , label : 'Standard'}  ] }
					placeholder="Select Table Type "
					simpleValue
					value={this.state.display_style}
                                />
                                
                            </div>
                            </div>
                            <div className="form-group">
                                <label className="col-md-3 control-label">Detector Source</label>
                                <div className="col-md-9">
                                <Select
                                    name="detector_source"
                                    closeOnSelect={true}
                                    disabled ={true}
                                    onChange={this.handleDetectorChange}
                                    options={this.state.detectorOption}
                                    placeholder=" Select  Detector "
                                    simpleValue
                                    value={this.state.detector_source}
                                />
                                </div>
                            </div>
                            <div className="form-group">
                                <label className="col-md-3 control-label"> Elements</label>
                                <div className="col-md-9">
                                <Select
                                    name="data_source"
                                    closeOnSelect={!this.state.stayOpen}
					multi
					onChange={this.handleEleChange}
					options={this.state.eleOption}
					placeholder="Select  element(s)"
					simpleValue
					value={this.state.data_source}
                                />
                                </div>
                            </div>
                            <div className="form-group">
                                <label className="col-md-3 control-label">Size</label>
                                <div className="col-md-9">
                              
                                <Select
                                    name="gadget_size"
                                    closeOnSelect={!this.state.stayOpen}
					
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
                <div className="form-actions right">
                
                      <button type="submit" className="btn blue"   onClick={this.createGadget} >Submit</button>
                    <button type="button" className="btn default" onClick={this.close}>Cancel</button>
                  
                </div>
          </Modal.Footer>
        </Modal>
        </span>
      
      );
   }
}



export default TableGadget;