import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { DragSource, DropTarget } from 'react-dnd';
import ItemTypes            from './dnd/ItemTypes';
import TableGadget          from './defaultGadgets/TableDefaultGadget.jsx'; 
import ChartGadget          from './defaultGadgets/ChartDefaultGadget.jsx';
import LightGadget          from './defaultGadgets/LightDefaultGadget.jsx';
import SetPointsGadget      from './defaultGadgets/SetPointsDefaultGadget.jsx';
import SystemAlertGadget    from './defaultGadgets/SystemAlertDefaultGadget.jsx';
import SilosGadget          from './defaultGadgets/SilosDefaultGadget.jsx';
import RawmixRunGadget      from './defaultGadgets/RawmixRunDefaultGadget.jsx';
import { findDOMNode }      from 'react-dom';
import { Button, FormGroup, ControlLabel, FormControl, Modal } from 'react-bootstrap';


const style = {
  border: '1px dashed gray',
  padding: '0.5rem 1rem',
  marginBottom: '.5rem',
  backgroundColor: 'white',
  cursor: 'move',
};

const gadgetSource = {
  beginDrag(props) {
    return {
      gadget_data_id: props.gadget_data_id,
      index: props.index,
    };
  },
};

const gadgetTarget = {
    
    
  hover(props, monitor, component) {
    const dragIndex = monitor.getItem().index;
    const hoverIndex = props.index;

    // Don't replace items with themselves
    if (dragIndex === hoverIndex) {
      return;
    }

    // Determine rectangle on screen
   // const hoverBoundingRect = findDOMNode(component).getBoundingClientRect();

    // Get vertical middle
   // const hoverMiddleY = (hoverBoundingRect.bottom - hoverBoundingRect.top) / 2;

    // Determine mouse position
   // const clientOffset = monitor.getClientOffset();

    // Get pixels to the top
   // const hoverClientY = clientOffset.y - hoverBoundingRect.top;

    // Only perform the move when the mouse has crossed half of the items height
    // When dragging downwards, only move when the cursor is below 50%
    // When dragging upwards, only move when the cursor is above 50%

    // Dragging downwards
   // if (dragIndex < hoverIndex && hoverClientY < hoverMiddleY) {
   //   return;
   // }

    // Dragging upwards
   // if (dragIndex > hoverIndex && hoverClientY > hoverMiddleY) {
   //   return;
   // }

    // Time to actually perform the action
    props.moveGadget(dragIndex, hoverIndex);

    // Note: we're mutating the monitor item here!
    // Generally it's better to avoid mutations,
    // but it's good here for the sake of performance
    // to avoid expensive index searches.
    monitor.getItem().index = hoverIndex;
  },
};

@DropTarget(ItemTypes.GADGET, gadgetTarget, connect => ({
  connectDropTarget: connect.dropTarget(),
}))
@DragSource(ItemTypes.GADGET, gadgetSource, (connect, monitor) => ({
  connectDragSource: connect.dragSource(),
  isDragging: monitor.isDragging(),
}))




export default class NewGadget extends Component {
    
 static propTypes = {
    connectDragSource: PropTypes.func.isRequired,
    connectDropTarget: PropTypes.func.isRequired,
    index: PropTypes.number.isRequired,
    isDragging: PropTypes.bool.isRequired,
    gadget_data_id: PropTypes.any.isRequired,
    gadget_type : PropTypes.any.isRequired,
    gadget_name: PropTypes.string.isRequired,
    moveGadget: PropTypes.func.isRequired,
  };
    
    


constructor(props) {
    
    
    
super(props);


//console.log('new gadget', this.props);
        this.state = {
        gadget_name:  this.props.gadget_name,
        gadget_type:  this.props.gadget_type,
        gadget_data_id  :  this.props.gadget_data_id,
        layout: this.props.layout,
        };
        this.handleInputChange = this.handleInputChange.bind(this);
}

close() {
this.setState({ showModal: false });
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


componentDidMount(){


}

handleSubmit(e){
e.preventDefault();
}

render() {

var editwidget = '';
 
 if(this.props.gadget_type === 'System_Messages'){
      editwidget = <TableGadget   data={this.props.data}   deleteDefaultGadget={this.props.deleteDefaultGadget} updateDefaultGadgets = {this.props.updateDefaultGadgets} layoutID={this.props.layout.lay_id} onSubmit={this.props.onSubmit} data={ this.props.data } action="edit"/>

 }else if(this.props.gadget_type === 'Charts'){
     editwidget = <ChartGadget      data={this.props.data}  deleteDefaultGadget={this.props.deleteDefaultGadget}  updateDefaultGadgets = {this.props.updateDefaultGadgets} layoutID={this.props.layout.lay_id}  onSubmit={this.props.onSubmit} data={ this.props.data } action="edit"/>

 }else if(this.props.gadget_type === 'IdiotLights'){
      editwidget = <LightGadget      data={this.props.data}  deleteDefaultGadget={this.props.deleteDefaultGadget} updateDefaultGadgets = {this.props.updateDefaultGadgets} layoutID={this.props.layout.lay_id}  onSubmit={this.props.onSubmit} data={ this.props.data } action="edit"/>

 }else if(this.props.gadget_type === 'SetPoints'){
      editwidget = <SetPointsGadget  data={this.props.data}  deleteDefaultGadget={this.props.deleteDefaultGadget}  updateDefaultGadgets = {this.props.updateDefaultGadgets} layoutID={this.props.layout.lay_id}  onSubmit={this.props.onSubmit} data={ this.props.data } action="edit"/>

 }else if(this.props.gadget_type === 'SystemAlert'){
      editwidget = <SystemAlertGadget   data={this.props.data} deleteDefaultGadget={this.props.deleteDefaultGadget}  updateDefaultGadgets = {this.props.updateDefaultGadgets} layoutID={this.props.layout.lay_id}  onSubmit={this.props.onSubmit} data={ this.props.data } action="edit"/>

 }else if(this.props.gadget_type === 'Silos'){
      editwidget = <SilosGadget     data={this.props.data}     deleteDefaultGadget={this.props.deleteDefaultGadget}  updateDefaultGadgets = {this.props.updateDefaultGadgets} layoutID={this.props.layout.lay_id}  onSubmit={this.props.onSubmit} data={ this.props.data } action="edit"/>

 }else if(this.props.gadget_type === 'RawmixRun'){
      editwidget = <RawmixRunGadget     data={this.props.data}   deleteDefaultGadget={this.props.deleteDefaultGadget}    updateDefaultGadgets = {this.props.updateDefaultGadgets} layoutID={this.props.layout.lay_id}  onSubmit={this.props.onSubmit} data={ this.props.data } action="edit"/>

 }

    const { gadget_name, isDragging, connectDragSource, connectDropTarget } = this.props;
    const opacity = isDragging ? 0 : 1;
    
    var gadgetSize;
//    debugger
    if(this.props.data.gadget_size === 'large'){
        gadgetSize = 'col-md-12';
    
        
    }else if(this.props.data.gadget_size === 'medium'){
       gadgetSize = 'col-md-8'; 
    }else{
        gadgetSize = 'col-md-4';
    }


return (
       connectDragSource(connectDropTarget( 
       <div className={gadgetSize} id={"new-gadget-"+this.props.gadget_data_id}>
            <div className="portlet portlet-sortable light bordered">
                <div className="portlet-title ui-sortable-handle">
                    <div className="caption font-green-sharp">
                        <span className="caption-subject bold uppercase"> {this.props.gadget_name}</span>
                    </div>
                    <div className="actions">
                    
                    { editwidget }
                        
                        <a href="javascript:;" className="btn red btn-sm" 
                            onClick={()=>{this.props.deleteDefaultGadget(this.props.index)}}>
                                Delete &nbsp; <i className="fa fa-trash-o" ></i>
                            </a>    
                    </div>
                </div>
                <div className="portlet-body">
               
                </div>
            </div>
        </div>
        ))


            
        );
       }
    }
