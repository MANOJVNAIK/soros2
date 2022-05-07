import React, { Component } from 'react';
import { Button, FormGroup, ControlLabel, FormControl, Modal } from 'react-bootstrap';
import Select from 'react-select';


class AssignSetPoins extends Component {

    constructor(props) {
    super(props);
    
    
   // console.log('data',JSON.parse(this.props.data.element_snapshot))
   
//   debugger
    this.state = {  showModal: false,
                    eleOption: this.props.gadgeteleOption,
                    element_type : this.props.data.element_type,
                    isFiveSet : true,
                    levelOne:'',
                    levelTwo:'',
                    levelThree:'',
                    levelFour:'',
                    levelFive:''

                };

    this.close = this.close.bind(this);
    this.open = this.open.bind(this);
    this.handleInputChange = this.handleInputChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
    this.handleEleChange = this.handleEleChange.bind(this);
    this.handleColorSetChange = this.handleColorSetChange.bind(this);
    this.populateForm = this.populateForm.bind(this);
    
    if(this.props.action === 'edit'){
        this.populateForm(this.props.data.element_snapshot);
        
       // console.log(JSON.parse(this.props.data.element_snapshot));
    }
    }

    close() {

    this.setState({ showModal: false });
    }

    open() {

    this.setState({ showModal: true });
    }
    
    populateForm(data){
        
       var jData
        
        try{
         jData  = JSON.parse( data );
        }catch(err){
            return false;
        }
        
//        debugger;
        var  formData = Object.assign({}, jData ,
        {   showModal  : false  , 
            isFiveSet  : data.isFiveSet  === 'true'? true : false,
            show_value : data.show_value === 'ture'? true : false 
        
        });
        
        this.state =   Object.assign({}, this.state, formData);
        
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
            
            this.setState({ element_type :  value });
    }
    
    
    handleColorSetChange (value) {
            console.log('You\'ve selected:', value);
            
            this.setState({ element_colorset :  value });
            
            this.setState({isFiveSet : value == '5_color_set' ? true : false})
            
            
    }


handleSubmit(e) {

    e.preventDefault();
    
   const  key   = this.props.index;
   const  state = this.state;
   this.close();
   this.props.onSubmit({ [key] : state})
   

}

componentDidMount(){
this.handleEleChange(this.state.element_type)

}
render() {

  
  const btnStyle = this.state.element_type === 'Customize' ? 'btn btn-default float-left' : 'btn green-turquoise  float-left';
  const adjustStyle = { minWidth: '150px' , margin : '10px'}

var fiveSetPoint =  { display : this.state.isFiveSet ? 'block' : 'none' };
return (
        
       
        
<div>

    
    <a href="javascript:;" className={btnStyle}  onClick={this.open}  style={adjustStyle}>
        <i className="icon-note"></i> {this.state.element_type}
    </a>
    <Modal show={this.state.showModal} onHide={this.close}>
        <Modal.Header closeButton>
            <Modal.Title>Assign Set Points</Modal.Title>
        </Modal.Header>
        <Modal.Body>
            <form className="form-horizontal" role="form" onSubmit={this.handleSubmit}>
                <div className="form-body">
                    
                    
                                            <div className="form-group">
                                                <label className="col-md-3 control-label">Chose Element</label>
                                                <div className="col-md-9">
                                                
                                                 <Select
                                                        name="element_type"
                                                        closeOnSelect={!this.state.stayOpen}
                                                        
                                                        onChange={this.handleEleChange}
                                                        options={this.state.eleOption}
                                                        placeholder="Select  element(s)"
                                                        simpleValue
                                                        value={this.state.element_type}
                                                    />
                                                </div>
                                            </div>
                                            <div className="form-group">
                                                <label className="col-md-3 control-label">Chose Color set</label>
                                                <div className="col-md-9">
                                                <Select
                                                        name="element_colorset"
                                                        closeOnSelect={!this.state.stayOpen}
                                                        
                                                        onChange={this.handleColorSetChange}
                                                        options={[{value:'3_color_set',label:'3 Color Set'},{value:'5_color_set',label:'5 Color Set'}]}
                                                        placeholder="Select  Colorset"
                                                        simpleValue
                                                        value={this.state.element_colorset}
                                                    />
                                                </div>
                                            </div>
                                            
                                            <div className="form-group">
                                                <label className="col-md-3 control-label">
                                                Show Actual Value                                                        
                                                </label>
                                                <div className="col-md-9">
                                                      <input type="checkbox" value={this.state.show_value} name="show_value" onChange={this.handleInputChange}/>

                                            </div>
                                            </div>
                                            
                                            <div className="form-group">
                                                <label  className="form-label col-md-3 col-lg-3">
                                                    Define set points .
                                                </label>
                                                <ul id="AlertsgadgetColorList" className="isotope-widgets col-md-9 col-md-9">
                                                    <li className="dash-order isotope-item extrasm">
                                                    <a className="small button-green" href="javascript:void(0)"> 
                                                    </a>
                                                   <input type="text" className="form-control" value={this.state.levelOne} name="levelOne" onChange={this.handleInputChange}     />
                                                 </li>
                                                    <li className="dash-order isotope-item extrasm">
                                                    <a className="small button-orange" href="javascript:void(0)">
                                                    
                                                    </a>
                                                     <input type="text" className="form-control" name="levelTwo" value={this.state.levelTwo} onChange={this.handleInputChange}     />
                                                  </li>
                                                    <li className="dash-order isotope-item extrasm">
                                                    <a className="small button-red" href="javascript:void(0)">
                                                    
                                                    </a>
                                                      <input type="text" className="form-control" name="levelThree" value={this.state.levelThree} onChange={this.handleInputChange}     />
                                                 </li>
                                                    
                                                    <li className="dash-order isotope-item extrasm" style={  fiveSetPoint }>
                                                    <a className="small button-blue" href="javascript:void(0)">
                                                    
                                                    </a>
                                                      <input type="text" className="form-control" name="levelFour" value={this.state.levelFour}  onChange={this.handleInputChange}     />
                                                 </li>
                                                    <li className="dash-order isotope-item extrasm" style={  fiveSetPoint }>
                                                    <a className="small button-white" href="javascript:void(0)">
                                                    
                                                    </a>
                                                      <input type="text" className="form-control"  name="levelFive"  value={this.state.levelFive} onChange={this.handleInputChange}     />
                                                 </li>
                                                </ul>
                                            </div>
                                                 

                </div>
                <div className="clearfix"> </div>
                
            </form>

                

        </Modal.Body>
        <Modal.Footer>
                <div className="form-actions ">
                    <button type="button" onClick={this.close} className="btn default">Cancel</button>
                    <button type="submit" className="btn green" onClick={this.handleSubmit}>Submit</button>
                </div>
        </Modal.Footer>
    </Modal>
</div>

);
}
}


export default AssignSetPoins;