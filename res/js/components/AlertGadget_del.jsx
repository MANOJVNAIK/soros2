import React, { Component } from 'react';

import { fromJS  , Map  } from 'immutable' 

import { Button , FormGroup , ControlLabel , FormControl , Modal } from 'react-bootstrap';

import CustomizeElements from './CustomizeElements.jsx'

import axios from 'axios';




class AlertWidget extends Component {
    
        constructor(props) {
                super(props);
                this.state = {  showModal: false,
                                detectorOption:false,
                                eleOption:false,
                                gadgetType:'Alerts',
                                detectorInfo:detectorInfo,
                                lay_id : this.props.layoutID
                                // detectorInfo is set in create view file
                            };
         
        this.baseState = this.state;            
        this.close = this.close.bind(this);
        this.open = this.open.bind(this);
        this.handleInputChange = this.handleInputChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
        this.selectElements = this.selectElements.bind(this);
        
        
        this.handleDetectorChange = this.handleDetectorChange.bind(this);
  
  }
  
    close() {
    this.setState({ showModal: false });
//    this.state.showmodal = false;
    //alert('close modal')
  }

  open() {
     // alert('open modal');
     //this.setState(this.baseState);
     this.setState({ showModal: true });
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
      
    var  element = data.ele;    
    
    this.setState({ showModal: false });
   const formData = { GadgetsData : {
    gadget_type     : this.state.gadgetType,
    gadget_name     : this.state.gadgetName,
    detector_source : this.state.dataSource,
    gadget_size     : this.state.size,
    
    lay_id          : this.props.layoutID     
    
    } ,
    elements        : element 
}

    $.ajax({
        type:'POST',
        url:baseUrl+'/index.php?r=gadgets-data/create',
        data: formData,
        success:function(msg){
            let jObject = JSON.parse(msg);
            this.close();
        }.bind(this)
        
    });
  }
  
 handleDetectorChange(event){
     
     const value = event.target.value;
     this.selectElements(this.state.detectorInfo[value]);
     
     
    const target = event.target;
 //   const value  = value ;//target.type === 'checkbox' ? target.checked : target.value;
    const name   = target.name;
   
    this.setState({
      [name]: value
    });
    
 } 
  
  selectElements(list){
      
      var elementArry = Array();
        
        for(const x in list){
            elementArry.push(list[x]);
        }
        var options = elementArry.map(d => { return <option  key={d} value={d}> {d } </option>});
        this.setState({eleOption:options})
//        console.log(this.state.eleOption)
        
        
  }
  
  
  componentDidMount(){
         
        var detectorArray = Array();
        
        for(const x in detectorInfo){
            detectorArray.push(x);
        }
        var options = detectorArray.map(d => { return <option  key={d} value={d}> {d } </option>})
        this.setState({detectorOption:options})
        
        
  }
   render() {
       
       
      return (
              
                <span>
        
        
         <button className="icon-btn " role="button"  onClick={this.open}>
         <i className="fa fa-warning">
         </i>
                        <div> Alert </div>
        </button>
         

        <Modal show={this.state.showModal} onHide={this.close}>
          <Modal.Header closeButton>
            <Modal.Title className="text-center" ><span className="caption-subject bold uppercase font-green">Alert Widget</span></Modal.Title>
          </Modal.Header>
          <Modal.Body>
              <form className="form-horizontal" role="form" onSubmit={(e) => {  e.preventDefault() } }>
              
              
                        <div className="form-body">
                            <div className="form-group">
                                <label className="col-md-3 control-label">Gadget Name</label>
                                <div className="col-md-9">
                                  <input type="text" className="form-control " placeholder="Gadget Name"  name='gadgetName' value={this.state.gadgetName}
                                   onChange={this.handleInputChange} /> 
                                    </div>
                            </div>
                            <div className="form-group">
                                <label className="col-md-3 control-label">Gadget Type</label>
                                <div className="col-md-9">
                                    <input type="text" name='gadgetType' className="form-control" placeholder="Gadget Type" onChange={this.handleInputChange}  value={this.state.gadgetType}/> </div>
                            </div>
                            <div className="form-group">
                                <label className="col-md-3 control-label">Data Source</label>
                                <div className="col-md-9">
                                    <select className="form-control" name='dataSource'  onChange={this.handleDetectorChange}>
                                    <option> Select Detector</option>
                                        {this.state.detectorOption}
                                    </select>
                                </div>
                            </div>
                            <div className="form-group">
                                <label className="col-md-3 control-label">Size</label>
                                <div className="col-md-9">
                                    <select className="form-control" name="size" onChange={this.handleInputChange} >
                                        <option> Select Size</option>
                                        <option value="small"> Small</option>
                                        <option value="medium"> Medium</option>
                                        <option value="large"> Large</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                
          </Modal.Body>
          
          <Modal.Footer>
                        <div className="form-actions float-right">
                            <CustomizeElements gadgetSize={this.state.gadgetSize} gadgetType={this.state.gadgetType} gadgeteleOption={this.state.eleOption} onSubmit={this.handleSubmit}/>
                        </div>
          </Modal.Footer>
        </Modal>
        </span>
      
      );
   }
}



export default AlertWidget;