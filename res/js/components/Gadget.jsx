import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { DragSource, DropTarget } from 'react-dnd';
import ItemTypes            from './dnd/ItemTypes';
import TableGadget          from './dashboard/TableGadget.jsx';
import ChartGadget          from './dashboard/ChartGadget.jsx';
import LightGadget          from './dashboard/LightGadget.jsx';
import SetPointsGadget      from './dashboard/SetPointsGadget.jsx';
import SystemAlertGadget    from './dashboard/SystemAlertGadget.jsx';
import SilosGadget          from './dashboard/SilosGadget.jsx';
import { findDOMNode }      from 'react-dom';
import { Button, FormGroup, ControlLabel, FormControl, Modal } from 'react-bootstrap';


import TableComponent         from './gadgets/TableComponent.jsx';
import LightComponent         from './gadgets/LightComponent.jsx';
import RawmixRunComponent     from './gadgets/RawmixRunComponent.jsx';
import SetPointsComponent     from './gadgets/SetPointsComponent.jsx';
import SystemAlertsComponent  from './gadgets/SystemAlertsComponent.jsx';
import SiloComponent          from './gadgets/SiloComponent.jsx';
import ChartComponent         from './gadgets/ChartComponent.jsx';

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
export default class Gadget extends Component {

    static propTypes = {
        connectDragSource: PropTypes.func.isRequired,
        connectDropTarget: PropTypes.func.isRequired,
        index: PropTypes.number.isRequired,
        isDragging: PropTypes.bool.isRequired,
        gadget_data_id: PropTypes.any.isRequired,
        gadget_type: PropTypes.any.isRequired,
        gadget_name: PropTypes.string.isRequired,
        moveGadget: PropTypes.func.isRequired,
    };

    constructor(props) {
        super(props);
        this.state = {
            gadget_name: this.props.gadget_name,
            gadget_type: this.props.gadget_type,
            gadget_data_id: this.props.gadget_data_id
        };
        this.handleInputChange = this.handleInputChange.bind(this);
    }

    close() {
        this.setState({showModal: false});
    }

    open() {
// alert('open modal');
        this.setState({showModal: true});
    }

    handleInputChange(event) {

        const target = event.target;
        const value = target.type === 'checkbox' ? target.checked : target.value;
        const name = target.name;
        this.setState({
            [name]: value
        });
    }

    componentDidMount() {


    }

    handleSubmit(e) {
        e.preventDefault();
    }

    render() {

        let editwidget = '';
        let gadget = '';
        let gadgetHeight = '';

        if (this.props.gadget_type === 'System_Messages') {

            
           gadgetHeight =  " gadget-proto-table"
            gadget = <TableComponent gadget_data_id={this.props.gadget_data_id} data={this.props.data} type="gadget"/>;
            editwidget = <TableGadget layoutID={this.props.layoutID} type={this.props.layout.type} onSubmit={this.props.onSubmit} data={ this.props.data } action="edit" />

        } else if (this.props.gadget_type === 'Charts') {

           gadgetHeight =  " gadget-proto-chart"
            gadget = <ChartComponent gadget_data_id={this.props.gadget_data_id} data={this.props.data} type="gadget" />;
            editwidget = <ChartGadget  layoutID={this.props.layoutID}  type={this.props.layout.type} onSubmit={this.props.onSubmit} data={ this.props.data } action="edit"/>

        } else if (this.props.gadget_type === 'IdiotLights') {

            gadget = <LightComponent gadget_data_id={this.props.gadget_data_id} data={this.props.data} type="gadget" />
            editwidget = <LightGadget  layoutID={this.props.layoutID} type={this.props.layout.type}  onSubmit={this.props.onSubmit} data={ this.props.data } action="edit"/>

        } else if (this.props.gadget_type === 'SetPoints') {


            gadget = <SetPointsComponent gadget_data_id={this.props.gadget_data_id} data={this.props.data} type="gadget" />;
            editwidget = <SetPointsGadget  layoutID={this.props.layoutID} type={this.props.layout.type}  onSubmit={this.props.onSubmit} data={ this.props.data } action="edit"/>

        } else if (this.props.gadget_type === 'SystemAlert') {


            gadget = <SystemAlertsComponent gadget_data_id={this.props.gadget_data_id} data={this.props.data} type="gadget" />;
            editwidget = <SystemAlertGadget  layoutID={this.props.layoutID} type={this.props.layout.type}  onSubmit={this.props.onSubmit} data={ this.props.data } action="edit"/>

        } else if (this.props.gadget_type === 'Silos') {


            gadget = <SiloComponent gadget_data_id={this.props.gadget_data_id} data={this.props.data} type="gadget" />;
            editwidget = <SilosGadget  layoutID={this.props.layoutID}  type={this.props.layout.type} onSubmit={this.props.onSubmit} data={ this.props.data } action="edit"/>

        } else if (this.props.gadget_type === 'RawmixRun') {
            gadget = <RawmixRunComponent   gadget_data_id={this.props.gadget_data_id}  data={ this.props.data } type="gadget"/>

        }

        const {gadget_name, isDragging, connectDragSource, connectDropTarget} = this.props;
        const opacity = isDragging ? 0 : 1;

        let gadgetSize;
        let portlet = '';

        if (this.props.gadget_type === 'SetPoints') {

            gadgetSize = 'col-md-3';
            portlet = 'portlet no-shadow';
        } else
        if (this.props.gadget_type === 'SystemAlert') {

            gadgetSize = 'ramixgadget';
            portlet = 'portlet no-shadow';
        } else if (this.props.gadget_type === 'Silos') {

            gadgetSize = 'col-md-7';
            portlet = 'portlet no-shadow';
        } else
        if (this.props.data.gadget_size === 'large') {
            gadgetSize = 'col-md-12 ';

            portlet = 'portlet'

        } else if (this.props.data.gadget_size === 'medium') {
            gadgetSize = 'col-md-8 ';
            portlet = 'portlet'
        } else {
            gadgetSize = 'col-md-4 ';
            portlet = 'portlet'
        }


        return (
                connectDragSource(connectDropTarget(
                        <div className={ gadgetSize  + gadgetHeight } id={'gadget-proto-'+this.props.gadget_data_id}  style={{marginBottom:"20px" , background:'white'}}>
                        
                            <div className={"portlet-sortable " + portlet }>
                                <div className="portlet-title ui-sortable-handle">
                                    <div className="caption font-blue">
                                        <span className="caption-subject bold uppercase"> {this.props.gadget_name}</span>
                                    </div>
                                    <div className="actions">
                        
                                        { editwidget }
                        
                                        <a href="javascript:;" className="btn btn-sm red" onClick={() => {
                                            this.props.onClick(this.props.gadget_data_id)
                                            }}>
                                            Del&nbsp;<i className="fa fa-trash-o font-white" ></i> </a>    
                                    </div>
                                </div>
                                <div className="portlet-body">
                                    <div className={this.props.gadget_type + "debug"}>
                        
                                        { gadget }
                        
                        
                                        <div className="clearfix"> </div>
                                    </div>
                                </div>
                            </div>
                        
                        
                        </div>

                            ))



                            );
            }
        }
