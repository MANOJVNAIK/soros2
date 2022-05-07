import React, { Component } from 'react';

import { Button , FormGroup , ControlLabel , FormControl , Modal } from 'react-bootstrap';
import AssignSetpoints from './AssignSetPoints.jsx'

import {LightGadgetConfig} from '../configs/GadgetConfig.jsx';

class CustomizeElements extends Component {
    
    constructor(props) {
       
       
        super(props);


        this.state = {  showModal: false,
                        element_type  : 'Customize',
                        statusElement : [],
                        ele : {},
                        gadgetSize:this.props.gadgetSize,
                        systemStatusElement : []
                    };
         
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
   

                //alert(gSize)
                if(gSize === 'large'){
                    
                eleArray = Array(9).fill(tmp); 
                    
                }else if(gSize === 'medium'){
                    
                
                     eleArray = Array(6).fill(tmp); 
                     
                }else{
                    
                
                     eleArray = Array(3).fill(tmp); 
             }
                  
       return  eleArray;
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

    /**
     * This funtion will add stystem status config to Light Gadget
     * @param {type} element
     * @returns {null}
     */
    handleSubmit(element) {
        
        console.log('before',this.state.ele);

      var newElements = Object.assign({}, this.state.ele, element);
      this.setState({ ele : newElements}, ()  => { console.log('after',this.state.ele);});
      
     


  }
    addElement(){
      
      
  }
    addGadget(){
      
      this.close();
      this.props.onSubmit(this.state);
  }
    componentDidMount(){
         
         
        var statusElement ;
        var ele;
        
        
        //Building system status dropdown list
        let systemStatusElement = Array();
            
              statusElement  =        $.map(system_status, function(el) {
                                                                            systemStatusElement.push({label:el.status_name,value:el.status_name});
                                                                            return el ;
            });
        
           
            ele = false;
        
        this.setState({statusElement: statusElement , systemStatusElement : systemStatusElement},this.render);
  }
    render() {
       
       
       
      return (
              
        <span>
        <button className="btn btn blue"   onClick={this.open}>
                        Next 
        </button>
        <Modal show={this.state.showModal} onHide={this.close}>
          <Modal.Header closeButton>
            <Modal.Title>Assign Set Points</Modal.Title>
          </Modal.Header>
        <Modal.Body>
           
                   { 
                    
                        
                     this.state.statusElement.map((data,key) => {
                   
//                        console.log('Key =>',key,'Value =>',data);
                       return <AssignSetpoints data={data} onSubmit={this.handleSubmit} key={key} index={key} elementOption={this.state.systemStatusElement} action={this.props.action} /> 
                       // console.log(key +  ' => ' +value)

                    }
                   
                    )
                    }
                    
                <div className="clearfix"> </div>
                
        </Modal.Body>
        <Modal.Footer>
            
                <div className="form-actions float-right">
                            <button type="submit" className="btn blue" onClick={this.addGadget} >Add Gadget</button>
                            <button type="button" className="btn default" onClick={this.close}>Cancel</button>        
                </div>
        </Modal.Footer>
        </Modal>
        </span>
      
      );
   }
}


export default CustomizeElements;