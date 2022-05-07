import React, { Component } from 'react';
import { Button, FormGroup, ControlLabel, FormControl, Modal } from 'react-bootstrap';
import {LayoutTypeList} from './configs/LayoutConfig.jsx';
import Select from 'react-select';
import GadgetSelect from './GadgetSelect.jsx'
//import swal from 'react-sweetalert';

const style = {
 
};


class AddLayout extends Component {

constructor(props) {
super(props);
        this.state = {
        showModal: false,
        newLayoutCreated : false,
        type: '',
        layout :[]
        };
        this.baseState = this.state;
        this.close = this.close.bind(this);
        this.open = this.open.bind(this);
        this.handleInputChange = this.handleInputChange.bind(this);
        this.createLayout    = this.createLayout.bind(this);
        this.handgleLayoutTypeChange = this.handgleLayoutTypeChange.bind(this);
        this.onSubmit = this.onSubmit.bind(this);
        
}

close() {
this.setState({ showModal: false });
}


onSubmit(id){
    
    this.close();
    this.props.onSubmit(id);
    
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
       // alert('tr');
}

handgleLayoutTypeChange(type){
   
        
        this.setState({ type : type})
}


componentDidMount(){


}

createLayout(e){

e.preventDefault();


        let validator = $('#add-layout-form').validate({
                                                    errorElement: "span",
                                                    errorClass: "help-block help-block-error",
                                                    focusInvalid: !1,
                                                    ignore: "",

                                                    errorPlacement: function(e, r) {
                                                        var i = $(r).parent(".input-group");
                                                        i.size() > 0 ? i.after(e) : r.after(e)
                                                    },
                                                    highlight: function(e) {
                                                        $(e).closest(".form-group").addClass("has-error")
                                                    },
                                                    unhighlight: function(e) {
                                                        $(e).closest(".form-group").removeClass("has-error")
                                                    },
                                                    success: function(e) {
                                                        e.closest(".form-group").removeClass("has-error")
                                                    },
                                                    submitHandler: function(e) {
                                                        i.show(), r.hide()
                                                    }
                                                }  
                                                );
        
        
        validator.form();
        let valid = validator.valid();
        
        if(!valid){
            return false;
        }
    

    let formData ={ GadlayLayouts : {subname:this.state.layoutName , type: this.state.type}} ;
    $.ajax({
        type:'POST',
        url: baseUrl+'/index.php/gadlay-layouts/create',
        data: formData ,
        success:(response) =>{
            
            const layout = response.data;
            
            this.close();
            swal('Success','New Dashboard is created','success');

            this.props.handleNewLayout(layout)

           // this.props.onChange();
        },
        error:(responste,a,b) =>{
         
                swal('Error','Dashboard Name can\'t be blank','error')
        }
        
    });

}

render() {


return (
<div>
    
    
    
    
        <div className="form-group">
            <label className="" >
            <a href="javascript:;" className="btn btn-lg blue" onClick={this.open} style={{width:'355px'}}>
             Create New Dashboard &nbsp; <i className="fa fa-plus"></i>  
            </a>
                    
            </label>
        </div>

    <Modal show={this.state.showModal} onHide={this.close} dialogClassName="add-layout-modal" >
        <Modal.Header closeButton>
            <Modal.Title className="text-center font-blue">Create New Dashboard</Modal.Title>
        </Modal.Header>
        
        <Modal.Body>
        <form  id='add-layout-form' className="form-horizontal has-validation" role="form" onSubmit={this.handleSubmit}>
        
        
        <div className="form-body">
        
        <div className="form-group">
            <label className="col-md-3 control-label">Layout Type</label>
            <div className="col-md-8">
                 <Select


                    name="element_type"
                    
                    closeOnSelect={!this.state.stayOpen}
                    required={true}
                    onChange={this.handgleLayoutTypeChange}
                    options={LayoutTypeList}
                    placeholder="Select Type"
                    simpleValue
                    value={this.state.type}

                />
            </div>
        </div>
        
        
        <div className="form-group">
            <label className="col-md-3 control-label">Name</label>
            <div className="col-md-8">
                 <input  type="text" 
                 required="required" 
                 className="form-control " placeholder="Layout Name"  name='layoutName' value={this.state.gadgetName}
                                   onChange={this.handleInputChange} /> 
        
            </div>
        </div>
        
        
        </div>
                </form>

        <div className="clearfix"> </div>

        </Modal.Body>
        <Modal.Footer>
            
            <Button className="blue" onClick={this.createLayout}>Create</Button>
            <Button onClick={this.close}>Cancel</Button>
                    
        </Modal.Footer>
        
    </Modal>
    
        <Modal show={this.state.newLayoutCreated} onHide={this.close}>
            <Modal.Header closeButton>
                <Modal.Title  style={ style } ><span className="caption-subject bold uppercase font-blue-hokki">New Layout Created</span></Modal.Title>
            </Modal.Header>
            <Modal.Body>
             <div className="actions">
                    <div className="note note-success">
                                        <h4 className="block">Success! new layout created</h4>
                                        <p>  </p>
                     </div>
                  { this.state.newLayoutCreated && this.state.addGadget    }
                
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


export default AddLayout;