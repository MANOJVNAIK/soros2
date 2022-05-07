import  React, { Component } from 'react';
import  { Button , FormGroup , ControlLabel , FormControl , Modal } from 'react-bootstrap';
import  Select  from 'react-select';
import  { serializeObject } from '../utils.jsx';



class TableGadget extends Component {
    
        constructor(props) {
            super(props);
            console.log('Table : layout type =>',this.props.type)
            this.state = {  showModal: false,
                            detectorOption:[],
                            eleOption:[],
                            detector_source : 'analysis_A1_A2_Blend',
                            gadget_type:'System_Messages',
                            gadget_name:'',
                            detectorInfo:detectorInfo,  // detectorInfo is set in create view file
                            lay_id : this.props.layoutID,
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
            
            
            
            this.handleDetectorChange = this.handleDetectorChange.bind(this);
            this.handleEleChange   = this.handleEleChange.bind(this);
           this.handleSizeChange     = this.handleSizeChange.bind(this);
        
            
            
        }
        
        this.baseState              = this.state;    // user to revert back to initial state        
        this.close                  = this.close.bind(this);
        this.open                   = this.open.bind(this);
        this.edit                   = this.edit.bind(this);
        this.handleInputChange      = this.handleInputChange.bind(this);
        this.handleSubmit           = this.handleSubmit.bind(this);
        this.selectElements         = this.selectElements.bind(this);
        this.handleDetectorChange   = this.handleDetectorChange.bind(this);
        this.handleEleChange        = this.handleEleChange.bind(this);
        this.handleSizeChange       = this.handleSizeChange.bind(this);
        this.handleFeedOutChange    = this.handleFeedOutChange.bind(this);
        this.handleFeedInputChange  = this.handleFeedInputChange.bind(this);
        this.updateGadget           = this.updateGadget.bind(this);
        this.createGadget           = this.createGadget.bind(this);

  
  }
  
    close() {
    this.setState({ showModal: false });
    $("#gadget-select").show();
  }

  open(){
     this.setState({ showModal: true });
     $("#gadget-select").hide();
     //this.props.parentClose();  //to close gadget select modal
  }
  
  edit(id){
      
 
     
          axios.get(baseUrl+'/index.php/Gadgets/table-gadget/view?&id=' + this.props.data.gadget_data_id, {
            headers: {
            'Content-Type': 'application/json',
                    'X-Access-Token': access_token
            }
            }
            ).then( (response, b, c) => {
              //  self.loadTable()
              
              let tableData     = response.data.data;
              let feedData      = tableData.feedrate;
        
              
                for(let x in tableData ){
                    
                    this.setState({ [x] : tableData[x]})
                    
                }
              
               if(feedData.length != 0){
                     
                    this.setState({ feedrate_input :  feedData[0].feedrate_input, feedrate_output : feedData[0].feedrate_output});
                
               }
                  
             this.open();
              
            }).catch( (response ) => {
            swal('Error','Something Went wrong ','error');
            });
  }
  


 createGadget(){
     
     
            
   let data = {
    gadget_type     : this.state.gadget_type,
    gadget_name     : this.state.gadget_name,
    detector_source : this.state.detector_source,
    gadget_size     : this.state.gadget_size,
    display_style   : this.state.display_style,
    data_source     : this.state.data_source,
    lay_id          : this.state.lay_id,   
    gadget_data_id  : this.state.gadget_data_id,
    group_style     : this.state.group_style == true ? 'average' : ''
    } 
    
    
    
    
    if(this.props.type == 'feedrate'){
        
     
        data.feedrate_input = this.state.feedrate_input;
        data.feedrate_output = this.state.feedrate_output;
        
    }
    
      let validator = $("#table_gadget_form").validate(this.state.validationOption);
        validator.form();
        let valid = validator.valid();
        
        if(!valid){
            return false;
        }
           
        axios.post(baseUrl+'/index.php/Gadgets/table-gadget/create', data, {
            headers: {
                'Content-Type': 'application/json',
                'X-Access-Token': access_token
            }
        }
        ).then((response) => {
            
            swal("Sucess",'Table created Successfully','success');
            
            this.close();
            this.props.onSubmit(this.state.lay_id);
            this.props.onClick();  //to close gadget select
            
        }).catch( (response) => {
            
            this.close();
           swal("Error",'Some problem occured , couldn\'t create Table','warning')
           
        });
    }
 
updateGadget(){
     

              let data = {
                            gadget_type     : this.state.gadget_type,
                            gadget_name     : this.state.gadget_name,
                            detector_source : this.state.detector_source,
                            gadget_size     : this.state.gadget_size,
                            display_style   : this.state.display_style,
                            data_source     : this.state.data_source,
                            lay_id          : this.state.lay_id,   
                            gadget_data_id  : this.state.gadget_data_id,
                             group_style     : this.state.group_style == true ? 'average' : ''

                        };
    
    
    
    if(this.props.type == 'feedrate'){
        
     
        data.feedrate_input = this.state.feedrate_input;
        data.feedrate_output = this.state.feedrate_output;
        
    }
    
    
    
      let validator = $("#table_gadget_form").validate(this.state.validationOption);
        validator.form();
        let valid = validator.valid();
        
        if(!valid){
            return false;
        }
            axios.put(baseUrl+'/index.php/Gadgets/table-gadget/update?&id='+this.props.data.gadget_data_id, data, {
            headers: {
            'Content-Type': 'application/json',
                    'X-Access-Token': access_token
            }
            }
            ).then( (response, b, c) => {
             this.close();
            this.props.onSubmit(this.state.lay_id);
            swal('Success','Table Gadget Updated Successfully','success')
              
    }).catch(function (response) {
        swal('Error','Some Error Occured','Sucess','warning')
    });
 }
 

  handleFeedOutChange(value){
      
       this.setState({ feedrate_output  :  value });
      
  }
  
  handleFeedInputChange(value){
      
  
         this.setState({  feedrate_input :  value });
         
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
           
            this.setState({ data_source :  value });
    }


    handleSizeChange (value) {
            console.log('You\'ve selected:', value);
            
            this.setState({ gadget_size : value });
    }
    
  handleSubmit(event) {
    
   
    event.preventDefault();  
    var url ;
    
    var successMessage = '';
    if(this.props.action === 'edit'){
        
    
         this.updateGadget();
    }else{
        
         this.createGadget();   
    }
    
    return true;

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
        
        for(const x in detectorInfo){
            detectorArray.push({value : x , label : detectorInfo[x]['display_name']});
        }
        
        
        // Build source option 
        var sourceArray = Array();
        
        
         for(const i in sources){
             
         
            sourceArray.push({value : sources[i].src_id , label : sources[i].src_name});
        }
        
        
        
        this.setState({detectorOption:detectorArray,sourceOption : sourceArray});
        
        
        if(this.props.action === 'edit'){
            
            let model = this.props.data;
            this.setState({});
            this.handleDetectorChange(model.detector_source) 
            this.handleEleChange(model.data_source)
            this.handleSizeChange(model.gadget_size)   
            
        }else{
            
             this.handleDetectorChange(this.state.detector_source)
        }
        
        
        let feedRate =  this.props.feedrate ? this.props.feedrate : false;
        
        this.setState({feedRate : feedRate});
        
        
  }
   render() {
       
       var actionBtn;
       if(this.props.action == 'edit'){
           
           
        actionBtn = <a href="javascript:;" className="btn blue btn-sm" onClick={() => { this.edit(this.props.data.gadget_data_id) ;}}>
            Edit &nbsp; <i className="fa fa-pencil font-white"></i>   
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
                <span className="caption-subject bold uppercase font-blue ">Table Gadget</span>
            </Modal.Title>
          </Modal.Header>
          <Modal.Body>
              <form id="table_gadget_form" className="form-horizontal" role="form" onSubmit={this.handleSubmit}>
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
                                    <input type="text" name='gadget_type' readOnly={true} className="form-control" placeholder="Gadget Type" onChange={this.handleInputChange}  value={this.state.gadget_type}/> </div>
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
                           
                            
                            { 
                            
                                this.props.type !="feedrate" && 
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
                                            required={true}
                                    />
                                    </div>
                                </div>
                            }
                            
                            
                             { 
                             
                    
                                this.props.type =="feedrate" && 
                                <div className="form-group">
                                    <label className="col-md-3 control-label"> Feeder Input</label>
                                    <div className="col-md-9">
                                    <Select
                                        name="feedrate_input"
                                        closeOnSelect={!this.state.stayOpen}
                                            multi
                                            required={true}
                                            onChange={this.handleFeedInputChange}
                                            options={this.state.sourceOption}
                                            placeholder="Select  Feeder Input (s)"
                                            simpleValue
                                            value={this.state.feedrate_input}
                                    />
                                    </div>
                                </div>
                            
                            }
                            
                            
                            
                             { 
                             
                    
                                this.props.type =="feedrate" && <div className="form-group">
                                <label className="col-md-3 control-label"> Feeder Output</label>
                                <div className="col-md-9">
                                <Select
                                    name="feedrate_output"
                                    closeOnSelect={!this.state.stayOpen}
					multi
                                         required={true}
					onChange={this.handleFeedOutChange}
					options={this.state.sourceOption}
					placeholder="Select  Feeder Output(s)"
					simpleValue
					value={this.state.feedrate_output}
                                />
                                </div>
                            </div>
                            
                            }
                            
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
                             
                              <div className="form-group">
                                <label className="col-md-3 control-label">Display Avg</label>
                                <div className="col-md-9">
                               <input type="checkbox" name="group_style"  value="group_style"  onChange={this.handleInputChange}/>
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



export default TableGadget;