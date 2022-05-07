import React, { Component } from 'react';

import { Button , FormGroup , ControlLabel , FormControl , Modal } from 'react-bootstrap';
import {LightGadgetConfig} from '../configs/GadgetConfig.jsx';
import  Select  from 'react-select';
import AssignSetpoints from './AssignSetPoints.jsx'



class CustomizeElements extends Component {
    
    constructor(props) {
       
       
        super(props);
        

        this.state = {  showModal       : false,
                        element_type    : 'Customize',
                        statusElement   : [],
                        ele             : {},
                        gadgetSize      :this.props.gadgetSize,
                        selectedElements : '',
                         systemStatusElement : [],
                    };
         
        this.addElementEdit = this.addElementEdit.bind(this);
        this.addElementNew  = this.addElementNew.bind(this);
        this.close          = this.close.bind(this);
        this.open           = this.open.bind(this);
        this.handleSubmit   = this.handleSubmit.bind(this);
        this.renderElements = this.renderElements.bind(this);
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
  
  
    addElementEdit(){
      
        let data = this.props.data;
        let selectedElement = [];
        
        let  gadlayElements = this.props.data.gadlayElements;
        
        let object = {};
        
        for(let x in gadlayElements){
            
           
            
            let item = gadlayElements[x];
            let setPoints = gadlayElements[x].element_setpoint;
            
            let setPointsJson = JSON.parse(setPoints);
            
            //Populate set points
            for(let y in setPointsJson){
                
               item[y] = setPointsJson[y]; 
            }
            
//            console.log("Set Point => ",item);
            
            
           object[gadlayElements[x].element_type] = item;
           
           
            selectedElement.push(gadlayElements[x].element_type);
            
        }
        
        
        //Existing status elements 
        const tmrStr = selectedElement.join(',');
//        console.log("Selected Elements",tmrStr);
        this.setState({selectedElements:tmrStr} , this.renderElements);
        
        this.setState({ele : object}) // load existing elements
      
        var count = 0;
        var eleEditArray = data.gadlayElements.map((ele,i) => {
                    count++ ;
            
                    return ele 
        });
        
        const gSize = this.props.gadget_size;
        var  eleArray;
        
        
//        console.log('Debug add element',eleEditArray)
        return eleEditArray.concat(eleArray);; //end here to debug
   
  }
  
    close() {
        
    this.setState({ showModal: false });

  }

    open() {
//     console.log('Open model');
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
        

      var newElements = Object.assign({}, this.state.ele, element);
      this.setState({ ele : newElements});
      
     


  }
    renderElements(){
      
      if(this.state.selectedElements.length === 0){
          
          
            return  this.setState({custElements:<p> <b>Select Status element </b></p>},this.render) ;
           
      }
      let selectedElementsArray = this.state.selectedElements.split(',');
      
      
      
      let content = selectedElementsArray.map((val,key) => {
          
               let data = this.state.ele[val]  ?  this.state.ele[val] : {};
             return <AssignSetpoints data={data} onSubmit={this.handleSubmit} key={key} index={key} elementOption={system_status[val]} action={this.props.action} /> 
      })
      
      
      this.setState({custElements:content},this.render) ;
  }
    addGadget(){
      
      this.close();
      
      //console.log("Existing elements" ,this.state.ele);
      let selectedElementsArray = this.state.selectedElements.split(',');
      
      let eleArray = selectedElementsArray.map((val,key) => {
          
             return this.state.ele[val];
      });
      
      
      //console.log("New elements" ,eleArray);
      let formData = {};
      
      formData.name = this.state.element_type;
      formData.ele  = eleArray;
      this.props.onSubmit(formData);
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
//        debugger 
        if(this.props.action === 'edit'){

            //this.state = { ele : this.props.data}
           var tstatusElement = this.addElementEdit();
            
            statusElement =        $.map(system_status, function(el) {  return el; });
             

        }else {
             statusElement =        $.map(system_status, function(el) {  return el; });
                                           
             
           
              ele = false;
        
        }
        
        this.setState({statusElement: statusElement , systemStatusElement : systemStatusElement},this.render);
  }
    render() {
       
       
       
      return (
              
        <span>
        <button className="btn btn blue "   onClick={this.open}>
                        Customize
        </button>
        <Modal   show={this.state.showModal} onHide={this.close} dialogClassName="element-select-modal">
          <Modal.Header closeButton>
            <Modal.Title>Assign Set Points</Modal.Title>
          </Modal.Header>
        <Modal.Body>
           
        <div className="portlet">
        
        <div className="portlet-title">
        
                  <div className="col-md-3">
                  
                     <h4> Select Set points </h4>
                  </div>
                  
                  <div className="col-md-9">
                  

                    <Select
                        name="selectedElements"
                        closeOnSelect={!this.state.stayOpen}
                        multi
                        onChange={(value) => { console.log('Selected status log',value) ;this.setState({selectedElements:value},this.renderElements)}}
                        options={ this.state.systemStatusElement}
                        placeholder="Select Table Type "
                        simpleValue
                        value={this.state.selectedElements}
                    />
                  </div>
        
        </div>
        
        
        <div className="portlet-body" style={{minHeight:'400px' , paddingTop:"100px"}}>


                     {
                     
                     this.state.custElements
                     
                     
                     }



                     <div className="clearfix"></div>
        </div>

        
        
        </div>
        </Modal.Body>
        <Modal.Footer>
            
                <div className="form-actions float-right">
                
                            <button type="submit" className="btn blue" onClick={this.addGadget} >Add Gadget</button>
                            <button type="button" className="btn btn-default" onClick={this.close}>Cancel</button>
                        
                </div>
        </Modal.Footer>
        </Modal>
        </span>
      
      );
   }
}


export default CustomizeElements;