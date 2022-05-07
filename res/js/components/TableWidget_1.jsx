import React, { Component } from 'react';

import { fromJS  , Map  } from 'immutable' 

import { Button , FormGroup , ControlLabel , FormControl , Modal } from 'react-bootstrap';

class TableWidget extends Component {
    
        constructor(props) {
                super(props);
                this.state = {  showModal: false,
                                elements :[1,2,4],
                                element : 2,
                                detectorOption:false,
                                eleOption:false,
                                detectorInfo:detectorInfo,// detectorInfo is set in create view file
                                
                     };
                     
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

  handleSubmit(event) {
      
    
    alert('A name was submitted: ' + this.state);
    
    axios.post('/user', {
    gadgetType  : this.state.gadgetType,
    gadgetName  : this.state.gadgetName,
    detectorName: this.state.detectorSource,
    elements    : this.state.elements,
    gadgetSize  : this.state.size
    })
    .then(function (response) {
      console.log(response);
    })
    .catch(function (error) {
      console.log(error);
    });

    event.preventDefault();
  }
  
 handleDetectorChange(e){
     
     const value = e.target.value;
     this.selectElements(this.state.detectorInfo[value]);
 } 
  
  selectElements(list){
      
      var elementArry = Array();
        
        for(const x in list){
            elementArry.push(list[x]);
        }
        
        var options = elementArry.map(d => { return <option  key={d} value={d}> {d } </option>});
        this.setState({eleOption:options})
        
        
  }
  
  
  componentDidMount(){
         
        var detectorArray = Array();
        
        for(const x in this.state.detectorInfo){
            detectorArray.push(x);
        }
        
        var options = detectorArray.map(d => { return <option  key={d} value={d}> {d } </option>})
        
        this.setState({detectorOption:options})
        
        
  }
   render() {
       
       
      return (
              
                <div>
        
        
         <button className="icon-btn" role="button"  onClick={this.open}>
                        <i className="fa fa-table"></i>
                        <div> Table </div>
        </button>
         

        <Modal show={this.state.showModal} onHide={this.close}>
          <Modal.Header closeButton>
            <Modal.Title>Table Widget</Modal.Title>
          </Modal.Header>
          <Modal.Body>
              <form className="form-horizontal" role="form" onSubmit={this.handleSubmit}>
                        <div className="form-body">
                            <div className="form-group">
                                <label className="col-md-3 control-label">Gadget Name</label>
                                <div className="col-md-9">
                                  <input type="text" className="form-control " placeholder="Gadget Name"  value={this.state.gadgetName}
                                   onChange={this.handleInputChange} /> 
                                    </div>
                            </div>
                        </div>
                        <div className="form-actions right1">
                            <button type="button" className="btn default">Cancel</button>
                            <button type="submit" className="btn green">Submit</button>
                        </div>
                    </form>
                
          </Modal.Body>
          <Modal.Footer>
            <Button onClick={this.close}>Close</Button>
          </Modal.Footer>
        </Modal>
        </div>
      
      );
   }
}



export default TableWidget;