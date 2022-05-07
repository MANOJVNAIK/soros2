import React, { Component } from 'react';
import update from 'react/lib/update';
import { Button , FormGroup , ControlLabel , FormControl , Modal } from 'react-bootstrap';

var defaultSettings = {
    header: true,
    noRowsMessage: 'No items',
    className: 'btn btn-outline btn-default',
    title: 'Action',
},
        getSetting = function (name) {
            var settings = this.props.settings;

            if (!settings || typeof settings[ name ] == 'undefined')
                return defaultSettings[ name ];

            return settings[ name ];
        }
;


export default class ConfirmDialog extends Component {
    constructor(props) {
        super(props);
        // this.hangleLayoutChange = this.hangleLayoutChange.bind(this);
        this.state = {  
                        id : this.props.id,
                        getSettings : getSetting,
                        showModal : this.props.showModal,
                        title : this.props.title,
                        message : this.props.message
                     };
                     
                     this.close = this.close.bind(this);
    }

    close(){
        this.setState({showModal : false});
    }
    open(){
        
        this.setState({showModal : true});
    }
    render() {

        return ( 
             <Modal show={this.state.showModal} onHide={this.close} className='modal-m'>
          <Modal.Header closeButton>
            <Modal.Title> {this.state.title}</Modal.Title>
          </Modal.Header>
          <Modal.Body>
          <div>
          <h3> {this.state.message}</h3>      
              <div className="form-actions float-right">
                        
                        <button className="btn   blue" onClick={  () => {  alert(this.state.id);  this.props.onClick(this.state.id)}}> Delete</button>
                        
                        <button className="btn btn-default " onClick={this.close}> Cancel</button>
                        
                         
                        </div>             
                            
           </div>
          </Modal.Body>
          
          <Modal.Footer>
                     
          </Modal.Footer>
        </Modal>
             
        )

    }
};
