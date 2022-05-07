import React, { Component } from 'react';
import update from 'react/lib/update';
import { Button , FormGroup , ControlLabel , FormControl , Modal } from 'react-bootstrap';
import JsonTable from '../JsonTable.jsx'
import ActionButton from '../ActionButton.jsx';
import axios    from 'axios';
import swal     from 'sweetalert';
import {  DeleteModelButton } from '../configs/GlobalConfig.jsx';



export default class SetPointsGadget extends Component {
    constructor(props) {
    super(props);
    
    console.log("Data from parent",props)
        this.state = {  showModal: false,
                sp_id:'',
                product_id:'',
                sp_name:'',
                sp_value_num:'',
                sp_measured:'',
                sp_value_den:'',
                sp_const_value_num:'',
                sp_const_value_den:'',
                sp_tolerance_ulevel:'',
                sp_tolerance_llevel:'',
                sp_weight:'',
                sp_status:'',
                sp_priority:'',
                setpontTable : '',
                item:'',
                setpointList: this.props.setpointList,
               
                formAction : function(){ alert('empty'); return false; 
                },
                columns : [
                             {key: 'sp_name', label: 'Name'},
                            {key: 'sp_value_num', label: 'Value'},
                            {key: 'sp_priority', label: 'Priority'},
                            {key: 'sp_tolerance_ulevel', label: 'Tolerance Level (+/-)'},
                            {key: 'sp_status', label: 'Status'},
                            {key: 'action', label: 'Action', cell: ( item, columnKey ) => {
                                return <span> 
                                                
                                                <ActionButton className="btn  blue" onClick={this.edit  } id={item.sp_id} title="Edit"/>
                                                <ActionButton className="btn  red"   onClick={this.delete} id={item.sp_id} title="Delete"/> 
                                        </span> ;
                        }}
                    ]
                    ,
                validationOption : {
                errorElement: "span",
                errorClass: "help-block help-block-error",
                focusInvalid: !1,
                ignore: "",
                
                rules : {
                    
                        sp_name : {
                            
                                    required : true,
                        },
                        sp_value_num : {
                            
                             required : true,
                   
                             number: true
                        },
                        
                        sp_tolerance_ulevel : {
                            
                                    required : true,
                                     number :true,
                                    sp_tolerance : true,
                                   
                        }
                    
                    },
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

        };
        
        
        this.baseState = this.state;
        this.close = this.close.bind(this);
        this.edit = this.edit.bind(this);
        this.next   = this.next.bind(this);
        this.prev   = this.prev.bind(this);
        this.delete = this.delete.bind(this);
        this.getSetPoint = this.getSetPoint.bind(this);
        this.loadTable = this.loadTable.bind(this);
        this.open = this.open.bind(this);
        this.handleCreateSetPoint = this.handleCreateSetPoint.bind(this);
        this.handleInputChange = this.handleInputChange.bind(this); //
        this.serializeObject = this.serializeObject.bind(this);
        this.updateSetPoint = this.updateSetPoint.bind(this);
        this.createSetPoint = this.createSetPoint.bind(this);
        //serializeObject getSetPoint createSetPoint
        // this.hangleLayoutChange = this.hangleLayoutChange.bind(this);
        
        
        

}
  
    close() {
    this.setState({showModal: false});
//    this.state.showmodal = false;
    //alert('close modal')
}

    open() {
     // alert('open modal');
     //this.setState(this.baseState);
     this.setState({ showModal: true });
  }
    handleCreateSetPoint(){
      
      
     this.setState(
             {  formAction:this.createSetPoint , 
                sp_name : '' , 
                sp_value_num : '' , 
                sp_name:'',
                sp_value_num:'',
                sp_measured:'',
                sp_value_den:'',
                sp_const_value_num:'',
                sp_const_value_den:'',
                sp_tolerance_ulevel:'',
                sp_tolerance_llevel:'',
                sp_weight:'',
                sp_status:'',
                sp_priority:'',
            });
     this.setState({showModal:true});
  }

    updateSetPoint(){


           let validator = $("#setpoint_form").validate(this.state.validationOption);
        validator.form();
        let valid = validator.valid();
        
        if(!valid){
            return false;
        }
    let self = this;
            var param = "?&id=" + this.state.sp_id;
            var data = this.serializeObject($('#setpoint_form'));
            axios.put(setpoint_update_url + param, data, {
            headers: {
            'Content-Type': 'application/json',
                    'X-Access-Token': access_token
            }
            }
            ).then( (a, b, c) => {
              //  self.loadTable()
          
            swal('Success','Setpoint  updated successfully','success');
              this.props.onChange(); 
              this.close();
              
    }).catch(function (response) {
    alert(response.message)
    });
            }
    handleInputChange(event) {

    const target = event.target;
            const value = target.type === 'checkbox' ? target.checked : target.value;
            const name = target.name;
            this.setState({
            [name]: value
            });
    }

    edit(id){

            let self = this;
            this.getSetPoint(id)
            this.setState({formAction:this.updateSetPoint});
            this.open();
    }
    delete(id){
      
  
      var param = '?&id=' + id
    
    
     //Delete confirm
      swal({
            title: "Are you sure.",
            text:  "Do you want to delete Set point?",
            icon:  "warning",
            buttons: DeleteModelButton,
            dangerMode: true,
          })
            .then((willDelete) => 
                 {
                    if (willDelete) {

                                 axios.delete(setpoint_delete_url+param,{
            headers: {
                'Content-Type': 'application/json',
                'X-Access-Token': access_token
            }
        }
        ).then( (response)  => {
            
          swal("Deleted",'Setpoint delete Sucessfully','success')
           this.props.onChange();
           this.close();
          
        }).catch(function (response) {
           // alert(response.message);
             swal('Error','Something went wrong','warning')
            
        });

            } else {
                                      //swal("Your imaginary file is safe!");
                    }
    }); //End of confirm
    
  
  }
    
    componentDidMount(){
        
        
        var self =  this;
        jQuery.validator.addMethod("sp_tolerance", function (value, element) {
            // allow any non-whitespace characters as the host part
            
//            console.log('value =>' , value , 'Current tollerence => ' , self.state.sp_value_num)
            return this.optional(element) || (value  <=  self.state.sp_value_num * 0.05);
        }, 'Tolerance Level should be 5% of Set Point value');
          this.setState( { setpontTable : <JsonTable rows={ this.state.setpointList } columns={ this.state.columns } className='table table-blue table-bordered table-stripped' />}) 
//          this.loadTable();
        }
    
    loadTable(){
        
        let self = this;
       const columns = [
        {key: 'sp_name', label: 'Name'},
        {key: 'sp_value_num', label: 'Value'},
        {key: 'sp_priority', label: 'Priority'},
        {key: 'sp_tolerance_ulevel', label: 'Tolerance Level (+/-)'},
        {key: 'sp_status', label: 'Status'},
        {key: 'action', label: 'Action', cell: function( item, columnKey ){
            return <span> 
                            <ActionButton className="btn btn-outline red"   onClick={self.delete} id={item.sp_id} title="Delete"/> 
                            <ActionButton className="btn btn-outline green" onClick={self.edit  } id={item.sp_id} title="Edit"/>
                    </span> ;
    }}
];
          axios.get(setpoints_url,{
            headers: {
                'Content-Type': 'application/json',
                'X-Access-Token': access_token
            }
        }
        ).then( (response) => {
            
            
        this.close();
         self.setState( { setpontTable : <JsonTable rows={ response.data.data } columns={ self.state.columns } className='table table-bordered table-stripped' />}) 
         this.props.onChange(); 
        }).catch(function (response) {
            alert(response.message);
            
            
        });
        
         // 

      
        
    }
    

    getSetPoint(id){
        
    let data;    
    var param = "?&id=" + id;
    let self    = this;
    axios.get(setpoint_get_url + param, {
        headers: {
            'Content-Type': 'application/json',
            'X-Access-Token': access_token
        }
    }
    ).then(function (response) {
      
        let data = response.data.data;
      console.log(data);
      for(let x in data){
          
          console.log(data[x]);
          
           self.setState({
                        [x]: data[x]
                       });
      }
       
    }).catch(function (response) {
        alert(response.message)
    }); //end of axios
       
    }
    createSetPoint(){
    {
        
        let validator = $("#setpoint_form").validate(this.state.validationOption);
        validator.form();
        let valid = validator.valid();
        
        if(!valid){
            return false;
        }
        const self = this , data = this.serializeObject($('#setpoint_form'));
        axios.post(setpoint_create_url, data, {
            headers: {
                'Content-Type': 'application/json',
                'X-Access-Token': access_token
            }
        }
        ).then((response) => {
            
            swal("Sucess",'Setpoint created Successfully','success')
            this.props.onChange();
            this.close();
        }).catch( (response) => {
            alert(response.message)
        }); // end of axios
    }
}
    
    serializeObject($form) {
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function (n, i) {
        indexed_array[n['name']] = n['value'];

    });

    return indexed_array;
}

 prev(){
       $('a[href$="product-profile"]').trigger('click');
 }
 
 next(){
     
       $('a[href$="portlet_source"]').trigger('click');
 }

    render() {

    const  setpointTable =  this.state.setpontTable;
    const setpointList  =this.state.setpointList;
    return (
                
                  
              <section >
                    <a className="btn  pull-right blue margin-bottom-20" onClick={this.handleCreateSetPoint} href="javascript:void(0)" id="add_setpoint"  role="button">

                    Add Set Point &nbsp;
                        <i className="fa fa-plus-square"></i>
                    </a>

                    <div className="clearfix">
                  
                    {
                    setpointList.length < 0 &&
                    <div className="alert alert-danger">
                                <strong>Error!</strong> Create at least one set point
                    </div>
                    }
                    
                    </div>
                        <div className="full" id="set-point-list">
                        
                        {setpointTable}
                        </div>


                    
        <Modal show={this.state.showModal} onHide={this.close} className='modal-m'>
          <Modal.Header closeButton>
            <Modal.Title>Set points</Modal.Title>
          </Modal.Header>
          <Modal.Body>
              <form id='setpoint_form' 
              className="form-horizontal has-validation" 
              role="form" onSubmit={(e) => {  e.preventDefault() ; handleSubmit(); } }>
              
                <input type="hidden"  name='sp_id' value={this.state.sp_id}
                                   onChange={this.handleInputChange} /> 
                <input type="hidden"  name='product_id' value={this.props.product_id}
                                   onChange={this.handleInputChange} />                    
                        
                
                        
                            <div className="form-group">
                                <label className="col-md-3 control-label">Setpoint Name</label>
                                <div className="col-md-9">
                                  <input type="text" className="form-control "   placeholder="Setpoint Name"  name='sp_name' value={this.state.sp_name}
                                   onChange={this.handleInputChange} /> 
                                    </div>
                            </div>
                            
                            
                        
                        
                        <div className="form-group">
                                <label className="col-md-3 control-label">Setpoint Value</label>
                                <div className="col-md-9">
                                  <input type="number" className="form-control " placeholder="Value " required  name='sp_value_num' value={this.state.sp_value_num}
                                   onChange={this.handleInputChange} /> 
                                    </div>
                            </div>
                                                        
                            
                            <div className="form-group">
                                <label className="col-md-3 control-label">Tolerance level  </label>
                                <div className="col-md-9">
                                  <input type="number" className="form-control " placeholder="Tolerance  level"  name='sp_tolerance_ulevel' value={this.state.sp_tolerance_ulevel}
                                   onChange={this.handleInputChange} /> 
                                    </div>
                            </div>
                            
                        
                            <div className="form-group">
                                <label className="col-md-3 control-label">Status</label>
                                <div className="col-md-9">
                                  <input type="text" className="form-control " placeholder="Status"  name='sp_status' value={this.state.sp_status}
                                   onChange={this.handleInputChange} /> 
                                    </div>
                            </div>
                            
                            
                        
                            <div className="form-group">
                                <label className="col-md-3 control-label">Priority</label>
                                <div className="col-md-9">
                                  <input type="text" className="form-control " placeholder="Priority"  name='sp_priority' value={this.state.sp_priority}
                                   onChange={this.handleInputChange} /> 
                                    </div>
                            </div>
                            
                            
                        
                    </form>
                
          </Modal.Body>
          
          <Modal.Footer>
                        <div className="form-actions float-right">
                        
                        
                         <button className="btn   blue" onClick={this.state.formAction}> Submit</button>
                        <button className="btn btn-default  " onClick={this.close}> Cancel</button>
                        
                        
                        </div>
          </Modal.Footer>
        </Modal>
            
    </section>


            
            

    )}
  
}
