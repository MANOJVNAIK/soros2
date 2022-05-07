import React, { Component } from 'react';
import update from 'react/lib/update';
import  Select  from 'react-select';
import  JsonTable from '../JsonTable.jsx';
import ActionButton from '../ActionButton.jsx';
import ConfirmDialog from '../ConfirmDialog.jsx';
import { Button , FormGroup , ControlLabel , FormControl , Modal } from 'react-bootstrap';
import swal from 'sweetalert';
import { DeleteModelButton } from "../configs/GlobalConfig.jsx";

export default class ElementCompostion extends Component {
  constructor(props) {
      super(props);
   
      console.log("Construct ",this.props)
        const  sourceArray= new Array();
        const  sourceList = this.props.sourceList;
        for(const x in sourceList){
            sourceArray.push({ value : sourceList[x].src_id, label : sourceList[x].src_name});
        }
        this.state = {  showModal: false,
                
                source_id    :null,
                product_id   :'',
                elementTable:null,
                element_id : null,
                selected_source_id   : this.props.selected_source_id,
                element_name : null,
                element_value : null,
                status  : null,
                element_type : null,
                estimated_max : null,
                estimated_min : null,
                update_timestamp : null,
                sourceList: this.props.sourceList,
                elementCompList:this.props.elementCompList,
                sourceOption :sourceArray,
                deleteModal : false,
                deleteItem : false,
                validator: $("#element_composition_form").validate()
                ,
                 validationOption : {
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
                } ,
                
                formAction : function(){ alert('empty'); return false; 
                },
                columns : [
                            {key: 'element_name', label: 'Name'},
                            {key: 'element_value', label: 'Element  Value'},
                            {key: 'status', label: 'Status'},
                            
                            {key: 'estimated_min', label: 'Estimated Min'},
                            {key: 'estimated_max', label: 'Estimated Max'},
                            {key: 'action', label: 'Action', cell: ( item, columnKey ) => {
                                return <span> 
                                               
                                                   <ActionButton className="btn  blue" onClick={this.edit  } id={item.element_id} title="Edit"/>
                                            <ActionButton className="btn  red"   onClick={this.delete} id={item.element_id} title="Delete"/> 
                                            
                                        </span> ;
                        }}
                    ]

        };
        
        
        
     
        
       // this.state = {sourceOption : sourceArray};
        
        this.baseState          = this.state;
        this.prev               = this.prev.bind(this)
        this.open               = this.open.bind(this);
        this.close              = this.close.bind(this);
        this.handleSourceChange = this.handleSourceChange.bind(this);
        this.createElementComp  = this.createElementComp.bind(this);
        this.handleCreateElementComp= this.handleCreateElementComp.bind(this);
        this.edit               = this.edit.bind(this);
        this.loadTable          = this.loadTable.bind(this);
        this.delete             = this.delete.bind(this);
        this.deleteConfirm      = this.deleteConfirm.bind(this);
        this.updateElementComp  = this.updateElementComp .bind(this);
        this.getElementComp     = this.getElementComp.bind(this);
        this.renderCreateButton = this.renderCreateButton.bind(this);
        this.renderDeleteConfirm = this.renderDeleteConfirm.bind(this);
        this.handleInputChange  = this.handleInputChange.bind(this);

  }
  
  
  
  
 
 close(){
     
     this.setState({showModal : false});
 } 
 
 open(){
     
     this.setState({showModal : true});
 }
  
  handleSourceChange(selected_source_id){
      
    this.setState({
      selected_source_id: selected_source_id
    });
    
    //alert(selected_source_id)
   this.props.onChange(selected_source_id);
  }
  
    
    componentDidMount(){
        
        
        console.log("Element composition",this.props.elementCompList);
        const  sourceArray= new Array();
        const  sourceList = this.props.sourceList;
        for(const x in sourceList){
            sourceArray.push({ value : sourceList[x].src_id, label : sourceList[x].src_name});
        }
        this.setState({sourceOption : sourceArray});
        
        
        let source_id =  this.props.selected_source_id ? this.props.selected_source_id : sourceList[0].src_id;
        
        
        this.setState({selected_source_id : source_id , source_id : source_id});
     
         this.setState( { elementTable : <JsonTable rows={ this.props.elementCompList } columns={ this.state.columns } className='table table-blue' />}) 
                
    }
        handleCreateElementComp(){
      
      
     this.setState({formAction:this.createElementComp ,
                element_name : null,
                element_value : null,
                status  : null,
                element_type : null,
                estimated_max : null,
                estimated_min : null,
                update_timestamp : null,
                estimated_prob_error : null
            });
     this.setState({showModal:true});
  }

    updateElementComp(){


        let validator = $("#element_composition_form").validate(this.state.validationOption);
        validator.form();
        let valid = validator.valid();
        
        if(!valid){
            return false;
        }
        
        let self = this;
            var param = "?&id=" + this.state.element_id;
            var data = this.serializeObject($('#element_composition_form'));
            axios.put(element_composition_update_url + param, data, {
            headers: {
            'Content-Type': 'application/json',
                    'X-Access-Token': access_token
            }
            }
            ).then(  (response, b, c) =>  {
                
                
                
                this.props.onChange(this.state.selected_source_id);
                this.close();
                swal('Success','Element Updated Successfully','success');
    }).catch( (response) => {
                swal('Error','Some error occured','warning')
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

           // alert(id);
            this.getElementComp(id)
            this.setState({formAction:this.updateElementComp});
            this.open();
    }
    
    
    deleteConfirm(id){
        
        this.close();
         this.setState({deleteModal : false,deleteItem:false});
        this.setState({deleteModal : true,deleteItem:id});
        this.render();
    }
    
    delete(id){
      
  
      let self = this;
      var param = '?&id=' + id;
      swal({
            title: "Are you sure?",
            text: "Do you want to delete Element?",
            icon: "warning",
            buttons: DeleteModelButton,
            dangerMode: true,
          })
            .then((willDelete) => 
                 {
                    if (willDelete) {

                            axios.delete(element_composition_delete_url+param,{
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-Access-Token': access_token
                                        }
                                    }
                                    ).then( (response)  => {
                                       // refreshElementCompTable();

                                          swal("Element has been deleted!", {
                                                  icon: "success",
                                              });
                                       this.props.onChange(this.state.selected_source_id);
                                       this.close();

                                    }).catch( (response)  => {
                                       // alert(response.message);
                                         swal("Aww! Something went wrong", {
                                                  icon: "warning",
                                              });

                                    });

                                  } else {
                                      //swal("Your imaginary file is safe!");
                                    }
                });


  }
    

    loadTable(){
        
        const me = this;
        
               const columns = [
                            {key: 'element_name', label: 'Name'},
                            {key: 'element_value', label: 'Sp Value'},
                            {key: 'status', label: 'Priority'},
                            {key: 'estimated_min', label: 'sp_weight'},
                            {key: 'estimated_max', label: 'Measured'},
                            {key: 'action', label: 'Action', cell: ( item, columnKey ) => {
                                return <span> 
                                                <ActionButton className="btn  red"   onClick={this.delete} id={item.element_id} title="Delete"/> 
                                                <ActionButton className="btn  blue" onClick={this.edit  } id={item.element_id} title="Edit"/>
                                        </span> ;
                        }}
                    ]
      
          axios.get(element_composition,{
            headers: {
                'Content-Type': 'application/json',
                'X-Access-Token': access_token
            }
        }
        ).then( (response) =>{
           // refreshElementCompTable();
           //Close Form
           
           this.close();
         me.setState( { elementTable : <JsonTable rows={ response.data.data } columns={ columns } className='table table-bordered table-stripped' />}) 
          
        }).catch( (response)  =>{
            alert(response.message);
            
            
        });
        
         // 

      
        
    }
    

    getElementComp(id){
        
    let data;    
    var param = "?&id=" + id;
    let me    = this;
    axios.get(element_compositon_view + param, {
        headers: {
            'Content-Type': 'application/json',
            'X-Access-Token': access_token
        }
    }
    ).then( (response)  =>{
      
        let data = response.data.data;
        for(let x in data){
          
           me.setState({
                        [x]: data[x]
                       });
      }
    }).catch( (response)  =>{
        alert(response.message)
    });
       
    }
    createElementComp(){
    {
        
        
        let validator = $("#element_composition_form").validate(this.state.validationOption);
        validator.form();
        let valid = validator.valid();
        
        if(!valid){
            return false;
        }
        
        
  
        const  data = this.serializeObject($('#element_composition_form'));
        axios.post(element_composition_creat_url, data, {
            headers: {
                'Content-Type': 'application/json',
                'X-Access-Token': access_token
            }
        }
        ).then( (a) => {
            
             swal('Success','Element Created Successfully','success');
            this.props.onChange(this.state.selected_source_id);
            this.close();
            
        }).catch( (response) => {
            swal('Error','Some error occured','warning');
        });
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

    renderCreateButton(){
        
       if(this.state.selected_source_id){
           
        return <div className="col-md-6">
                            <a onClick={this.handleCreateElementComp} href="javascript:void(0)" id="add_source_element"
                               className="btn  blue  pull-right" role="button">
                                <span className="ui-button-text"> Add element </span><span className="fa fa-plus-square"></span></a>

                        </div>
                    
    }
    }
    renderDeleteConfirm(){
        
            return  <ConfirmDialog showModal={this.state.deleteModal} onCick={this.delete} id={this.state.deleteItem} title="ElementComposition"  message="Do you waht to delete element compostion" />
              
    }
    

prev(){
    
    $('a[href$="portlet_source"]').trigger('click');
}

    

  render() {

        const elementTable = this.state.elementTable;
        const elementList  = this.state.elementCompList;
        
    return (
               <section >

                    <div className="row margin-bottom-20">
                        

                        <div className="col-md-2">
                        <h4> Select Source</h4>
                        </div>
                        <div className="col-md-4">
                           <Select
                                    name="selected_source_id"
                                    closeOnSelect={!this.state.stayOpen}
					onChange={this.handleSourceChange}
					options={this.state.sourceOption}
					placeholder="Select  Source"
					simpleValue
					value={this.state.selected_source_id}
                                />

                        </div>
                        
                           {
                            
                               this.renderCreateButton()
                            }
                   
                       
                    </div>

            <div className="clearfix">
            
               {
                   elementList.length < 4 &&
                    <div className="alert alert-danger">
                                <strong>Info!</strong> Create at least 4 Element for this source 
                    </div>
               }
            </div>

                    <div id="element-composition-list">

                        {elementTable}
                    </div>
                    
                    
                    
               
                   <Modal show={this.state.showModal} onHide={this.close} className='modal-m'>
          <Modal.Header closeButton>
            <Modal.Title >Element Composition </Modal.Title>
          </Modal.Header>
          <Modal.Body>
              <form id='element_composition_form' className="form-horizontal has-validation" role="form" onSubmit={(e) => {  e.preventDefault() ; handleSubmit(); } }>
              
                <input type="hidden"  name='source_id' value={this.state.selected_source_id}
                                   onChange={this.handleInputChange} /> 
                <input type="hidden"  name='element_id' value={this.state.element_id}
                                   onChange={this.handleInputChange} />                    
                        
                
                        
                          <div className="form-body">
                            <div className="form-group">
                                <label className="col-md-3 control-label"> Name</label>
                                <div className="col-md-9">
                                  <input type="text" className="form-control " required placeholder="Element  Name"  name='element_name' value={this.state.element_name}
                                   onChange={this.handleInputChange} /> 
                                    </div>
                            </div>
                            <div className="form-group">
                                <label className="col-md-3 control-label"> Element Value</label>
                                <div className="col-md-9">
                                  <input type="number" className="form-control " required placeholder="Element Value"  name='element_value' value={this.state.element_value}
                                   onChange={this.handleInputChange} /> 
                                    </div>
                            </div>
                            <div className="form-group">
                                <label className="col-md-3 control-label"> Status</label>
                                <div className="col-md-9">
                                  <input type="" className="form-control "  required placeholder="Status"  name='status' value={this.state.status}
                                   onChange={this.handleInputChange} /> 
                                    </div>
                            </div>
                            
                            
                            <div className="form-group">
                                <label className="col-md-3 control-label"> Estimated Max</label>
                                <div className="col-md-9">
                                  <input type="number" className="form-control " required placeholder="estimated_max"  name='estimated_max' value={this.state.estimated_max}
                                   onChange={this.handleInputChange} /> 
                                    </div>
                            </div>
                            <div className="form-group">
                                <label className="col-md-3 control-label"> Estimated min</label>
                                <div className="col-md-9">
                                  <input type="number" className="form-control " required placeholder="estimated_min"  name='estimated_min' value={this.state.estimated_min}
                                   onChange={this.handleInputChange} /> 
                                    </div>
                            </div>
                            
                           
                            
                        </div>
                        
                    </form>
                
          </Modal.Body>
          
          <Modal.Footer>
                        <div className="form-actions float-right">
                        
                        
                        
                         <button className="btn   blue" onClick={this.state.formAction}> Submit</button>
                        <button className="btn btn-default " onClick={this.close}> Cancel</button>
                        
                        
                        </div>
          </Modal.Footer>
        </Modal>
             
           
                
                {this.renderDeleteConfirm()}
                </section>
                      
  
       
    )}
  
}
