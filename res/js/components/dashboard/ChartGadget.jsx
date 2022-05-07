import React, { Component } from 'react';
import { Button , FormGroup , ControlLabel , FormControl , Modal } from 'react-bootstrap';
import  Select  from 'react-select';

class ChartGadget extends Component {
    
        constructor(props) {
            super(props);
            
            this.state = {  showModal: false,
                            detectorOption:[],
                            eleOption:[],
                            gadget_type:'Charts',
                            group_style : '',
                            display_style : '',
                            gadget_name:'',
                            detectorInfo:detectorInfo,  // detectorInfo is set in create view file
                            lay_id : this.props.layoutID,
                            disabled: false,
                            crazy: false,
                            stayOpen: false,
                            detector_source : 'analysis_A1_A2_Blend',
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
        this.handleSubmit = this.handleSubmit.bind(this);
        this.selectElements = this.selectElements.bind(this);
        this.handleDetectorChange = this.handleDetectorChange.bind(this);
        this.handleEleChange   = this.handleEleChange.bind(this);
        this.handleSizeChange     = this.handleSizeChange.bind(this);
        
  
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
  

    handleEleChange (value) {
            console.log('You\'ve selected:', value);
            
            this.setState({ data_source :  value });
    }


    handleSizeChange (value) {
            console.log('You\'ve selected:', value);
            
            this.setState({ gadget_size : value });
    }
    
  handleSubmit(event) {
    
   
    event.preventDefault();     
   const data = { GadgetsData : {
    gadget_type     : this.state.gadget_type,
    gadget_name     : this.state.gadget_name,
    detector_source : this.state.detector_source,
    gadget_size     : this.state.gadget_size,
    display_style   : this.state.display_style,
    group_style     : this.state.group_style,
    data_source     : this.state.data_source,
    lay_id          : this.state.lay_id,   
    gadget_data_id       : this.state.gadget_data_idgadget_size,
   
    
    } 
    }
    
      let validator = $("#chart_gadget_form").validate(this.state.validationOption);
        validator.form();
        let valid = validator.valid();
        
        if(!valid){
            return false;
        }
    
    var url ;
    
    let successMessage = '';
    if(this.props.action === 'edit'){
         url = baseUrl+'/index.php/gadgets-data/update?&id='+this.state.gadget_data_id;
         successMessage = 'Chart Gadget Updated Successfully';
           
    }else{
        url = baseUrl+'/index.php/gadgets-data/create';
        successMessage = 'Chart Gadget created Successfully';
    }
    
    

    $.ajax({
        type:'POST',
        url:url ,
        data: data,
        success:(msg) => {
            
            swal('Sucess ',successMessage,'success')
            this.close();
            this.props.onSubmit(this.state.lay_id)
            this.props.onClick();  //to close gadget select
            
        },
          error: (request,status,errorThrown) => {
            
            
             swal('Error ','Opps Something went wrong','error')
            
            this.props.onSubmit(this.state.lay_id);
            this.close();
            this.props.onClick();  //to close gadget select
        // There's been an error, do something with it!
        // Only use status and errorThrown.
        // Chances are request will not have anything in it.
   }
        
    });//End of ajax
  }
  
 handleDetectorChange(value){
     
     //    console.log('Event' , value);
     let eleString = String( this.state.detectorInfo[value]['elements']);
     
 
    this.selectElements(eleString.split(','));
   
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
        
         detectorArray.push({value : 'analysis_A1_A2_Blend' , label : 'analysis_A1_A2_Blend'});
               
        this.setState({detectorOption:detectorArray});
        
        
      var elementArry = Array();
        
        let list = detectorInfo['analysis_A1_A2_Blend'];
        for(const x in list){
            elementArry.push({ value : list[x], label : list[x]});
        }
        
        
        this.setState({eleOption:elementArry});
        
        
        if(this.props.action === 'edit'){
            
            let model = this.props.data;
            this.setState({});
            this.handleDetectorChange(model.detector_source) 
            this.handleEleChange(model.data_source)
            this.handleSizeChange(model.gadget_size)   
        
            
            
        }else{
         this.handleDetectorChange('analysis_A1_A2_Blend');  //default datashourece    
        }
        
        
        
  }
   render() {
       
       var actionBtn;
       if(this.props.action == 'edit'){
           
           
        actionBtn = <a href="javascript:;" className="btn   blue btn-sm" onClick={this.open}>
        Edit&nbsp;<i className="fa fa-pencil"></i>   
                    </a>
       }else{
           
           
        actionBtn = <div className="col-md-4">
                        <div className="mt-widget-3">
                            <div className="mt-head bg-red">
                                <div className="mt-head-icon">
                                    <i className=" fa fa-area-chart"></i>
                                </div>
                                <div className="mt-head-desc"> Chart</div>
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
            <Modal.Title className="text-center"><span className="caption-subject bold uppercase font-blue">Chart Gadget</span></Modal.Title>
          </Modal.Header>
          <Modal.Body>
              <form id="chart_gadget_form" className="form-horizontal" role="form" onSubmit={this.handleSubmit}>
                        <div className="form-body">
                            <div className="form-group">
                                <label className="col-md-3 control-label">Gadget Name</label>
                                <div className="col-md-9">
                                  <input type="text" required className="form-control "  placeholder="Gadget Name"  name='gadget_name' value={this.state.gadget_name}
                                   onChange={this.handleInputChange} /> 
                                    </div>
                            </div>
                            <div className="form-group">
                                <label className="col-md-3 control-label">Gadget Type</label>
                                <div className="col-md-9">
                                    <input type="text" name='gadget_type' className="form-control" disabled={true}   value={this.state.gadget_type}/> </div>
                            </div>
                            
                            
                            <div className="form-group">
                                <label className="col-md-3 control-label">Chart Style</label>
                                <div className="col-md-9">
                                
                                    <select name='display_style' 
                                    className="form-control " 
                                    onChange={this.handleInputChange} 
                                    value={this.state.display_style} >
                                        <option>Select Chart Style</option>
                                        <option value="individual"> Individual</option>
                                        <option value="grouped">Grouped</option>
                                        <option value="horezontal_set"> Horizontal set</option>
                                    </select>

                               
                            </div>
                            </div>
                            
                            <div className="form-group">
                                <label className="col-md-3 control-label"> Grouping Style</label>
                                <div className="col-md-9">
                                    <select 
                                    name='group_style' 
                                    className="form-control " onChange={this.handleInputChange} value={this.state.group_style} >
                                        <option>Select Group Style</option>
                                        <option value="simple_style"> Simple Style</option>
                                        <option value="areal_spline">Areal Spline</option>
                                        <option value="selectable_area_spline"> Selectable Area Spline</option>
                                    </select>

                                </div>
                            </div>
                            <div className="form-group">
                                <label className="col-md-3 control-label">Detector Source</label>
                                <div className="col-md-9">
                                <Select
                                    name="detector_source"
                                    closeOnSelect={true}
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
                                    required={true}
                                    closeOnSelect={!this.state.stayOpen}
					
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
					required={true}
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
                        
                            
                            <button type="submit" className="btn blue"   onClick={this.handleSubmit} >Submit</button>
                            <button type="button" className="btn btn-default" onClick={this.close}>Cancel</button>
                        </div>
          </Modal.Footer>
        </Modal>
        </span>
      
      );
   }
}



export default ChartGadget;