import React, { Component } from 'react';

import { Button , FormGroup , ControlLabel , FormControl , Modal } from 'react-bootstrap';
import AssignSetpoints from './AssignSetPoints.jsx'

class CustomizeElements extends Component {
    
    constructor(props) {
       
       
        super(props);
        console.log("Element option => ",this.props.gadgeteleOption);
        
        var eleArray ;
        var ele;
        

            eleArray = this.addElementNew();
            ele = false;
        this.state = {  showModal: false,
                        eleOption:this.props.gadgeteleOption,
                        element_type  : 'Customize',
                        eleArray : eleArray,
                        ele : ele,
                        gadgetSize:this.props.gadgetSize
                    };
         
        this.addElementEdit = this.addElementEdit.bind(this);
        this.addElementNew  = this.addElementNew.bind(this);
        this.close          = this.close.bind(this);
        this.open           = this.open.bind(this);
        this.handleSubmit   = this.handleSubmit.bind(this);
        this.addGadget      = this.addGadget.bind(this)
        this.handleInputChange = this.handleInputChange.bind(this);
        

  
  }
  
    addElementNew(){
      
      const gSize = this.props.gadget_size;
      var  eleArray;
      var tmp = {element_type : 'Customize'}
      if(this.props.gadgetType  === 'Alerts'){
          
                eleArray = Array(3).fill(tmp); 

        }else{

                //alert(gSize)
                if(gSize === 'large'){
                    
                eleArray = Array(9).fill(tmp); 
                    
                }else if(gSize === 'medium'){
                    
                
                     eleArray = Array(6).fill(tmp); 
                     
                }else{
                    
                
                     eleArray = Array(3).fill(tmp); 
             }
        }
          
       return  eleArray;
  }
  
  /**
   * 
   * @returns {unresolved}
   */
    addElementEdit(){
      
        let data = this.props.gadlayElements;
        
        var count = 0;
        var eleEditArray = data.gadlayElements.map((ele,i) => {count++ ;return ele });
        
        const gSize = this.props.gadget_size;
        var  eleArray;
        var tmp = {element_type : 'Customize'}
        if(this.props.gadgetType  === 'Alerts'){
          
                eleArray = Array( 3 - count).fill(tmp); 

        }else{

                //alert(gSize)
                if(gSize === 'large'){
                    
                eleArray = Array(9 - count).fill(tmp); 
                    
                }else if(gSize === 'medium'){
                    
                
                     eleArray = Array(6 - count).fill(tmp); 
                     
                }else{
                    
                
                     eleArray = Array(3 -count).fill(tmp); 
             }
        }
        
        return eleEditArray.concat(eleArray);
  
      
  }
  
    close() {
        
    this.setState({ showModal: false });

  }

    open() {
//     console.log(this.props);
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
      var newEliments = Object.assign({}, this.state.ele, event);
      this.setState({ ele : newEliments});


  }
    addElement(){
      
      
  }
    addGadget(){
      
      this.close();
      this.props.onSubmit(this.state);
  }
    componentDidMount(){
         
        
  }
    render() {
       
       
      return (
              
        <span>
        <button className="btn btn green"   onClick={this.open}>
                        Next 
        </button>
        <Modal show={this.state.showModal} onHide={this.close}>
          <Modal.Header closeButton>
            <Modal.Title>Assign Set Points</Modal.Title>
          </Modal.Header>
        <Modal.Body>
           
                   { 
                     this.state.eleArray.map((key,value) => {
                   
                       return <AssignSetpoints data={key} onSubmit={this.handleSubmit} key={value} index={value} gadgeteleOption={this.props.gadgeteleOption} action={this.props.action} /> 
                       // console.log(key +  ' => ' +value)

                    }
                   
                    )
                    }
                    
                <div className="clearfix"> </div>
                
        </Modal.Body>
        <Modal.Footer>
            
                <div className="form-actions float-right">
                            <button type="button" className="btn default" onClick={this.close}>Cancel</button>
                            <button type="submit" className="btn green" onClick={this.addGadget} >Add Gadget</button>
                </div>
        </Modal.Footer>
        </Modal>
        </span>
      
      );
   }
}


export default CustomizeElements;