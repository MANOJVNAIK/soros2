import React, { Component } from 'react';
import { Button, FormGroup, ControlLabel, FormControl, Modal } from 'react-bootstrap';
import Select from 'react-select';


class AssignSetPoins extends Component {

    constructor(props) {
    super(props);
    

    this.state = {  showModal: false,
                    element_type : this.props.elementOption.status_name,
                    element_colorset : '3_color_set',
                    data : this.props.data
                  
                   
                  
                };

    this.close              = this.close.bind(this);
    this.open               = this.open.bind(this);
    this.handleInputChange  = this.handleInputChange.bind(this);
    this.handleSubmit       = this.handleSubmit.bind(this);
    this.populateForm       = this.populateForm.bind(this);
    this.handleColorSetChange = this.handleColorSetChange.bind(this);
    
 
    }

    close() {

    this.setState({ showModal: false });
    }

    open() {

    this.setState({ showModal: true });
    }
    
    populateForm(data){
        
        

        
//        this.state =   Object.assign({}, this.state, formData);
        
    }
    handleInputChange(event) {


    const target = event.target;
            const value = target.type === 'checkbox' ? target.checked : target.value;
            const name = target.name;
            
            
            this.setState({
            [name]: value
            });
    }
    
 
    
    
    handleColorSetChange (value) {
        
    
            this.setState({ element_colorset :  value });
            this.setState({isFiveSet : value == '5_color_set' ? true : false})
            
    }


handleSubmit(e) {

//    alert('berfor sending');
   e.preventDefault();
 
   let formData = {}
   
   formData.normal          = this.state.normal;
   formData.warning         = this.state.warning;
   formData.error           = this.state.error;
   formData.element_type    = this.state.element_type;
   formData.show_value      = this.state.show_value
   
   this.close();
   this.props.onSubmit({ [this.state.element_type] : formData});
}

componentDidMount(){


//console.log(" Ismail" ,this.props)

            
    if(this.props.action === 'edit'){



        let jData;

             try{
              jData  = JSON.parse( this.props.data.element_setpoint );
             }catch(err){
                 return false;
             }

     //        debugger;
             var  formData = Object.assign({}, jData ,
             {   showModal  : false  , 
                 show_value : this.props.data.show_value === 'true'? true : false 

             });


             this.setState(formData);

//                                                                                  this.setState({normal : '40', warning : '5',error:'10'},this.render);
             this.populateForm(this.props.data.element_setpoint);

    };

//                                                           
}
render() {

 let data = this.props.data;
  const btnStyle = data === 'undefined' ? 'status-btn btn-xxl green float-left' : 'status-btn btn-xxl green float-left';
  const adjustStyle = { minWidth: '150px' , margin : '10px'}
   let setPointStr;
var fiveSetPoint =  { display : this.state.isFiveSet ? 'block' : 'none' };
 if(this.props.elementOption.type !== 'binary'){

            
            setPointStr =   <div className="form-group">
                                <label  className="form-label col-md-4 ">
                                    Define set points .
                                </label>
                                <div className="col-md-8">
                                <ul id="AlertsgadgetColorList" className="isotope-widgets ">
                                    <li className="dash-order isotope-item extrasm">
                                        <a className="small button-blue" href="javascript:void(0)"> 
                                        </a>
                                       <input type="text" className="form-control" value={this.state.normal} name="normal" onChange={this.handleInputChange}     />
                                     </li>
                                    <li className="dash-order isotope-item extrasm">
                                    <a className="small button-orange" href="javascript:void(0)">

                                    </a>
                                     <input type="text" className="form-control" name="warning" value={this.state.warning} onChange={this.handleInputChange}     />
                                  </li>
                                    <li className="dash-order isotope-item extrasm">
                                    <a className="small button-red" href="javascript:void(0)">

                                    </a>
                                      <input type="text" className="form-control" name="error" value={this.state.error} onChange={this.handleInputChange}     />
                                 </li>


                                </ul>
                                </div>
                            </div>
            }else{
         
            
            
            
            setPointStr  =  <div className="row">
                                
                                        <div className="col-md-3"> <input type="hidden" className="form-control" value={this.state.normal} name="normal" onChange={this.handleInputChange}     />
                                            <input type="hidden" className="form-control" name="error" value={this.state.error} onChange={this.handleInputChange}     />
                                        </div>
                                        <div className="form-group col-md-5">
                                            <label className="col-md-3 control-label">
                                            ON                                                       
                                            </label>
                                             <div className="col-md-9">
                                             <button className="status-btn blue" type="button"> On</button>
                                         </div>
                                         </div>

                                        <div className="form-group col-md-5">
                                           <label className="col-md-3 control-label">
                                          OFF                                                       
                                           </label>
                                           <div className="col-md-9">
                                               <button className="status-btn red" type="button">Off</button>
                                            </div>
                                       </div>     
                                
                            </div>    
                    }
return (
        
       
        
<div>

    
    <a href="javascript:;" className={btnStyle}  onClick={this.open}  style={adjustStyle}>
         {this.state.element_type} <i className="icon-note"></i>
    </a>
    <Modal show={this.state.showModal} onHide={this.close}>
        <Modal.Header closeButton>
            <Modal.Title>Assign Set Points</Modal.Title>
        </Modal.Header>
        <Modal.Body>
            <form className="form-horizontal" role="form" onSubmit={this.handleSubmit}>
                <div className="form-body">
                    
                    
                                            <div className="form-group">
                                                <label className="col-md-4 control-label"> Status Element</label>
                                                <div className="col-md-8">
                                                
                                                    <input className="form-control"  value={this.state.element_type} name="element-type"  onChange={this.handleInputChange}/>
                                                 
                                                </div>
                                            </div>
                                            <div className="form-group">
                                                <label className="col-md-4 control-label"> Color set</label>
                                                <div className="col-md-8">
                                                <Select
                                                        name="element_colorset"
                                                        closeOnSelect={!this.state.stayOpen}
                                                        
                                                        disabled = {true}
                                                        onChange={this.handleColorSetChange}
                                                        options={[{value:'3_color_set',label:'3 Color Set'},{value:'5_color_set',label:'5 Color Set'}]}
                                                        placeholder="Select  Colorset"
                                                        simpleValue
                                                        value={this.state.element_colorset}
                                                    />
                                                </div>
                                            </div>
                                            
                                            <div className="form-group">
                                                <label className="col-md-4 control-label">
                                                Show Actual Value                                                        
                                                </label>
                                                <div className="col-md-8">
                                                      <input type="checkbox" value={this.state.show_value} name="show_value" onChange={this.handleInputChange}/>

                                            </div>
                                            </div>
                                            
                                            { setPointStr }
                                                 

                </div>
                <div className="clearfix"> </div>
                
            </form>

                

        </Modal.Body>
        <Modal.Footer>
                <div className="form-actions ">
                    
                    <button type="submit" className="btn blue" onClick={this.handleSubmit}>Submit</button>
                    <button type="button" onClick={this.close} className="btn btn-default">Cancel</button>
                </div>
        </Modal.Footer>
    </Modal>
</div>

);
}
}


export default AssignSetPoins;