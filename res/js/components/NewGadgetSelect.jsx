import React, { Component } from 'react';

import { Button, FormGroup, ControlLabel, FormControl, Modal } from 'react-bootstrap';

import TableGadget from './dashboard/TableGadget.jsx';
import ChartGadget from './dashboard/ChartGadget.jsx';
import LightGadget from './defaultGadgets/LightDefaultGadget.jsx';
import SilosGadget   from './dashboard/SilosGadget.jsx';
import SetPointsGadget      from './dashboard/SetPointsGadget.jsx';
import SystemAlertGadget   from './dashboard/SystemAlertGadget.jsx';

class GadgetSelect extends Component {

    constructor(props) {
    super(props);
    console.log(this.props.layout)
    this.state = {
                    showModal: false,
                    layoutOption: false,
                    layout : this.props.layout
                  };
    
    this.close = this.close.bind(this);
    this.open = this.open.bind(this);
    this.handleInputChange = this.handleInputChange.bind(this);
  
    }

    close() {
    this.setState({ showModal: false });
    }

    open() {
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


    componentDidMount(){
       

    }

    handleSubmit(e){

            this.props.updateLayout();
    }
    handleDelete(){
        
    }
    render() {


    const style = { textAlign : 'center'}
    return (
    <div>

        <form className="form-inline" role="form" onSubmit={(e) => {e.preventDefault()}}>
            <div className="form-group">
                <label className="" >
                <a href="javascript:;" className="btn btn-default green font-white" onClick={this.open}>
                            <i className="fa fa-plus"></i> Add Gadget 
                </a>
                </label>
            </div>
        </form>

        <Modal show={this.state.showModal} onHide={this.close}>
            <Modal.Header closeButton>
                <Modal.Title  style={ style } ><span className="caption-subject bold uppercase font-blue-hokki">Select Gadget</span></Modal.Title>
            </Modal.Header>
            <Modal.Body>

            <div style={ style } className="row">
                <TableGadget layoutID={this.state.layout.lay_id} onSubmit={this.props.onSubmit}  onClick={this.close} onChange={this.props.onChange} action="new"/>
                <LightGadget layoutID={this.state.layout.lay_id} onSubmit={this.props.onSubmit}  onClick={this.close} onChange={this.props.onChange} action="new"/>
                <ChartGadget layoutID={this.state.layout.lay_id} onSubmit={this.props.onSubmit}  onClick={this.close} onChange={this.props.onChange} action="new"/>
           
                 {
                 this.state.layout.type === 'rawmix' && 
                         <SystemAlertGadget  layoutID={this.state.layout.lay_id} onSubmit={this.props.onSubmit}  onClick={this.close} onChange={this.props.onChange} action="new"/>
                 }
                
                
                {
                 this.state.layout.type === 'rawmix' && 
                  <SetPointsGadget productProfile={this.state.productProfile} layoutID={this.state.layout.lay_id} onSubmit={this.props.onSubmit}  onClick={this.close} onChange={this.props.onChange} action="new"/>
                 }{
                 
                 
                    this.state.layout.type === 'rawmix' && 
                  <SilosGadget layoutID={this.state.layout.lay_id} onSubmit={this.props.onSubmit}  onClick={this.close} onChange={this.props.onChange} action="new"/>
                 
    
            }
           
            </div>    
            <div className="clearfix"> </div>

            </Modal.Body>
            <Modal.Footer>
                <Button onClick={this.close}>Cancel</Button>
            </Modal.Footer>
        </Modal>
        
        
        
       
    </div>

              );
           }
        }

export default GadgetSelect;