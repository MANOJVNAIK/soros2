import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { findDOMNode } from 'react-dom';
import { DragSource, DropTarget } from 'react-dnd';
import ItemTypes from './ItemTypes';

import Table from '../TableWidget.jsx';

const style = {
  border: '1px dashed gray',
  padding: '0.5rem 1rem',
  marginBottom: '.5rem',
  backgroundColor: 'white',
  cursor: 'move',
};

const cardSource = {
  beginDrag(props) {
    return {
      gadget_data_id: props.gadget_data_id,
      index: props.index,
    };
  },
};

const cardTarget = {
  hover(props, monitor, component) {
    const dragIndex = monitor.getItem().index;
    const hoverIndex = props.index;

    // Don't replace items with themselves
    if (dragIndex === hoverIndex) {
      return;
    }

    // Determine rectangle on screen
    const hoverBoundingRect = findDOMNode(component).getBoundingClientRect();

    // Get vertical middle
    const hoverMiddleY = (hoverBoundingRect.bottom - hoverBoundingRect.top) / 2;

    // Determine mouse position
    const clientOffset = monitor.getClientOffset();

    // Get pixels to the top
    const hoverClientY = clientOffset.y - hoverBoundingRect.top;

    // Only perform the move when the mouse has crossed half of the items height
    // When dragging downwards, only move when the cursor is below 50%
    // When dragging upwards, only move when the cursor is above 50%

    // Dragging downwards
    if (dragIndex < hoverIndex && hoverClientY < hoverMiddleY) {
      return;
    }

    // Dragging upwards
    if (dragIndex > hoverIndex && hoverClientY > hoverMiddleY) {
      return;
    }

    // Time to actually perform the action
    props.moveCard(dragIndex, hoverIndex);

    // Note: we're mutating the monitor item here!
    // Generally it's better to avoid mutations,
    // but it's good here for the sake of performance
    // to avoid expensive index searches.
    monitor.getItem().index = hoverIndex;
  },
};

@DropTarget(ItemTypes.CARD, cardTarget, connect => ({
  connectDropTarget: connect.dropTarget(),
}))
@DragSource(ItemTypes.CARD, cardSource, (connect, monitor) => ({
  connectDragSource: connect.dragSource(),
  isDragging: monitor.isDragging(),
}))
export default class Card extends Component {
  static propTypes = {
    connectDragSource: PropTypes.func.isRequired,
    connectDropTarget: PropTypes.func.isRequired,
    index: PropTypes.number.isRequired,
    isDragging: PropTypes.bool.isRequired,
    gadget_data_id: PropTypes.any.isRequired,
    gadget_name: PropTypes.string.isRequired,
    gadget_type : PropTypes.string.isRequired,
    moveCard: PropTypes.func.isRequired,
  };

  render() {

var editwidget = '';
 
 if(this.props.type === 'System_Messages'){
      editwidget = <TableWidget   data={ this.props.data } action="edit"/>

 }else if(this.props.type === 'Charts'){
     editwidget = <ChartWidget   data={ this.props.data } action="edit"/>

 }else if(this.props.type === 'IdiotLights'){
      editwidget = <LightWidget   data={ this.props.data } action="edit"/>

 }

    const { gadget_name, isDragging, connectDragSource, connectDropTarget  } = this.props;
    const opacity = isDragging ? 0 : 1;


return (
       connectDragSource(connectDropTarget( <div className="col-md-4 column sortable">
            <div className="portlet portlet-sortable light bordered">
                <div className="portlet-title ui-sortable-handle">
                    <div className="caption font-green-sharp">
                        <span className="caption-subject bold uppercase"> {this.props.gadget_name}</span>
                    </div>
                    <div className="actions">
                    
                    { editwidget }
                        
                        <a href="javascript:;" className="btn btn-circle btn-default btn-sm" onClick={()=>{this.props.onClick(this.props.gadgetID)}}>
                            <i className="fa fa-trash-o" ></i> </a>    
                    </div>
                </div>
                <div className="portlet-body">
                <div className={this.props.gadget_type}>
                </div>
                </div>
            </div>
        </div>
        ))


            
        );
       }

}
