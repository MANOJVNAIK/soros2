import React, { Component } from 'react';

import { Button, FormGroup, ControlLabel, FormControl, Modal } from 'react-bootstrap';

import TableGadget from     './dashboard/TableGadget.jsx';
import ChartGadget from     './dashboard/ChartGadget.jsx';
import LightGadget from     './dashboard/LightGadget.jsx';
import SilosGadget          from './dashboard/SilosGadget.jsx';
import SetPointsGadget      from './dashboard/SetPointsGadget.jsx';
import SystemAlertGadget    from './dashboard/SystemAlertGadget.jsx';
import RawmixRunGadget      from './dashboard/RawmixRunGadget.jsx';
import RollingAnalysis      from './dashboard/RollingAnalysisGadget.jsx';


class GadgetSelect extends Component {

    constructor(props) {
    super(props);
//    console.log('Gadget select Selected layouta =>',this.props.layout)
    this.state = {
                    showModal: false,
                    layoutOption: false,
                    layout : this.props.layout,
                    gadgetSelected : false
                  };
    
    this.close = this.close.bind(this);
    this.open = this.open.bind(this);
    this.handleInputChange = this.handleInputChange.bind(this);
    this.hideGadgetSelect =  this.hideGadgetSelect.bind(this);
  
    }

    close() {
        
    this.setState({ showModal: false , gadgetSelected : true}, this.render);
    }

    hideGadgetSelect(){
        
    this.setState({  gadgetSelected : true}, this.render);
    }
    open() {
    this.setState({ showModal: true , gadgetSelected : false });
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


    
    const style = { textAlign : 'center'};
    const layoutType = this.props.layout.type;
    
    const layoutId = this.props.layout.lay_id;
    return (
    <div>

        <form className="form-inline" role="form" onSubmit={(e) => {e.preventDefault()}}>
            <div className="form-group">
                <label className="" >
                <a href="javascript:;" className="btn btn-default blue font-white" onClick={this.open}>
                             Add Gadget <i className="fa fa-plus"></i>
                </a>
                </label>
            </div>
        </form>

        <Modal show={this.state.showModal} onHide={this.close}>
            <Modal.Header closeButton>
                <Modal.Title  style={ style } ><span className="caption-subject bold uppercase font-blue-hokki">Select Gadget</span></Modal.Title>
            </Modal.Header>
            <Modal.Body>

            <div className="row" id="gadget-select">
            
           { 
            !this.state.gadgetSelected && <div style={{marginLeft:'auto',marginRight:'auto'}}>
            
                    {
                          (layoutType === 'rawmix' || layoutType === 'analyzer' ||  layoutType === 'report' || layoutType === 'feedrate' || layoutType === 'rawmix') &&
                          <TableGadget layoutID={layoutId} onSubmit={this.props.onSubmit}  parentClose={this.hideGadgetSelect} onClick={this.close} onChange={this.props.onChange} action="new" type={this.props.layout.type}/>
                    }
                    {
                    ( layoutType === 'analyzer' ||  layoutType === 'rawmix' ||  layoutType === 'feedrate') &&
                            <LightGadget layoutID={layoutId} onSubmit={this.props.onSubmit}  parentClose={this.hideGadgetSelect}  onClick={this.close} onChange={this.props.onChange} action="new" type={this.props.layout.type}/>
                    }
                     {
                          ( layoutType === 'rawmix' ||  layoutType === 'analyzer' || layoutType === 'plot' || layoutType === 'feedrate') && 
                            <ChartGadget layoutID={layoutId} onSubmit={this.props.onSubmit}  parentClose={this.hideGadgetSelect}  onClick={this.close} onChange={this.props.onChange} action="new" type={this.props.layout.type}/>
                    }
                    {
                            layoutType === 'rawmix' && 
                            <SystemAlertGadget  layoutID={layoutId} parentClose={this.hideGadgetSelect} onSubmit={this.props.onSubmit}  onClick={this.close} onChange={this.props.onChange} action="new" type={this.props.layout.type}/>
                    }
                    {
                            layoutType === 'rawmix' && 
                            <SetPointsGadget productProfile={this.state.productProfile} parentClose={this.hideGadgetSelect} layoutID={layoutId} onSubmit={this.props.onSubmit}  onClick={this.close} onChange={this.props.onChange} action="new" type={this.props.layout.type}/>
                    }
                    {
                            layoutType === 'rawmix' && 
                            <SilosGadget layoutID={layoutId} parentClose={this.hideGadgetSelect}  onSubmit={this.props.onSubmit}  onClick={this.close} onChange={this.props.onChange} action="new" type={this.props.layout.type}/>
                    }
                    {
                            layoutType === 'rawmix' && 
                            <RawmixRunGadget layoutID={layoutId} parentClose={this.hideGadgetSelect} onSubmit={this.props.onSubmit}  onClick={this.close} onChange={this.props.onChange} action="new"/>
                    }
                    {
                            layoutType === 'rolling_analysis' && 
                            <RollingAnalysis layoutID={layoutId} parentClose={this.hideGadgetSelect} onSubmit={this.props.onSubmit}  onClick={this.close} onChange={this.props.onChange} action="new"/>
                    }
                    <div className="clearfix"> </div>
                    
                    
                   
            </div>
             }
            </div>    
            

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