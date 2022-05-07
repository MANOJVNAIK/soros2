import React, { Component } from 'react';
import { Button , FormGroup , ControlLabel , FormControl , Modal } from 'react-bootstrap';
import update from 'react/lib/update';
import axios from 'axios';
import swal from 'sweetalert';
import JsonTable from '../JsonTable.jsx'
import Select from 'react-select';
import ActionButton from "../ActionButton.jsx";
import { DeleteModelButton } from "../configs/GlobalConfig.jsx";
//import precircle form 


//const access_token = access_token ;



export default class TagSettings extends Component {
  constructor(props) {
    super(props);
   
           let tagGroupOption = Array();
                
                for(let index in tagGroups ){
                    
                  tagGroupOption.push({label : tagGroups[index].tagGroupName ,value : tagGroups[index].tagGroupID});  
                }
                
               let  tagGOption = tagGroups.map((ele,i) => {
            
            
                return <option value={ele.tagGroupID} key={ele.tagGroupID}> {ele.tagGroupName}</option>});
             
        this.state = {
                        
                        showModal : false,
                        viewModal : false,
                        tagGroupID : '',
                        tagID : '',
                        tagName : '',
                        LocalstartTime : '',
                        LocalendTime : '',
                        formAction : function(){ alert('empty'); return false; },
                        tagList : [],
                        tagGroupOption: tagGOption,
                        
                        columns : [
                            {key: 'tagName', label: 'Tag Name'},
                            {key: 'tagGroupName', label: 'Tag Group'},
                            {key: 'LocalstartTime', label: 'Start Time'},
                            {key: 'LocalendTime', label: 'End TIme'},
                            {key: 'action',className :'action-button', label: 'Action', cell: ( item, columnKey ) => {
                                return <span> 
                                                <ActionButton className="btn  blue " onClick={this.edit  } id={item.tagID} title="Edit"/>
                                                <ActionButton className="btn   green"   onClick={this.view} id={item.tagID} title="View"/> 
                                                <ActionButton className="btn   red"   onClick={this.delete} id={item.tagID} title="Delete"/> 
                                                
                                        </span> ;
                        }}
                    ],
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
                                                }    
                    }
                    
        this.close          = this.close.bind(this);
        this.closeView      =  this.closeView.bind(this);
        this.open           = this.open.bind(this);
        this.view           = this.view.bind(this);
        this.edit           = this.edit.bind(this);
        this.delete         = this.delete.bind(this);
        this.getTagQueued   = this.getTagQueued.bind(this);
        this.loadTable = this.loadTable.bind(this);
        this.open = this.open.bind(this);
        this.handleCreateTag = this.handleCreateTag.bind(this);
        this.handleInputChange = this.handleInputChange.bind(this); //
        this.handleTagGroupChange = this.handleTagGroupChange.bind(this);
        this.serializeObject = this.serializeObject.bind(this);
        this.updateTag = this.updateTag.bind(this);
        this.createTag = this.createTag.bind(this);
      
        $('.datetimepicker').datetimepicker();
    }
  
    close(){
      
      this.setState({showModal : false})
    }
    open(){
       this.setState({showModal : true},() => { 
           
            $('.datetimepicker').datetimepicker({format : 'YYYY-MM-DD HH:mm:ss'});
    })
    }
    
    closeView(){
        
        this.setState({viewModal : false});
    }

  
          view(id){
        
    
    var param = "?&id=" + id;
    let self    = this;
    axios.get(baseUrl+'/index.php/tag-queued/view' + param, {
        headers: {
            'Content-Type': 'application/json',
            'X-Access-Token': access_token
        }
    }
    ).then(function (response) {
      
        let data = response.data.data;
      for(let x in data){
          
       
           self.setState({
                        [x]: data[x]
                       });
      }

            self.setState({viewModal : true});
    }).catch(function (response) {
        swal('Error',response.message,'error');
    }); //end of axios
       
    }
  
    getTagQueued(id){
        
    
    var param = "?&id=" + id;
    let self    = this;
    axios.get(baseUrl+'/index.php/tag-queued/view' + param, {
        headers: {
            'Content-Type': 'application/json',
            'X-Access-Token': access_token
        }
    }
    ).then(function (response) {
      
        let data = response.data.data;
      for(let x in data){
          
        console.log('Form populating',x,data[x])
           self.setState({
                        [x]: data[x]
                       });
      }//end of for
      
      self.handleTagGroupChange(data['tagGroupID']);
       
    }).catch(function (response) {
        swal('Error',response.message,'error');
    }); //end of axios
       
    }
  
    handleCreateTag(){
        
//      $('.datetimepicker').datetimepicker({format : 'YYYY-MM-DD HH:mm:ss'});
     this.setState({formAction:this.createTag ,   
                        tagName : '',
                        LocalstartTime : '',
                        LocalendTime : '',});
     this.open();
  }

    updateTag(){


           let validator = $("#tag_form").validate(this.state.validationOption);
        validator.form();
        let valid = validator.valid();
        
        if(!valid){
            return false;
        }
    let self = this;
            var param = "?&id=" + this.state.tagID;
            var data = this.serializeObject($('#tag_form'));
            axios.put(baseUrl+'/index.php/tag-queued/update' + param, data, {
            headers: {
            'Content-Type': 'application/json',
                    'X-Access-Token': access_token
            }
            }
            ).then( (a, b, c) => {
  
            swal('Success','Tag have been updated succesfully','success');
//              this.props.onChange(); 
                this.loadTable();
              this.close();
              
    }).catch(function (response) {
    swal('Error',response.message,'error')
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
    
    handleTagGroupChange(value){
        
//        alert(value)
        this.setState({
                    tagGroupID : value
            });
    }

    edit(id){

            
            this.getTagQueued(id)
            this.setState({formAction:this.updateTag});
            this.open();
//                $('.datetimepicker').datetimepicker({format : 'YYYY-MM-DD HH:mm:ss'});
            
    }
    delete(id){
      
  
      var param = '?&id=' + id
    
    
      swal({
            title: "Are you sure?",
            text:  "Do you want to delete this Tag ?",
            dangerMode: true,
            buttons : DeleteModelButton,
          })
            .then((willDelete) => 
                 {
                    if (willDelete) {

                                 axios.delete(baseUrl+'/index.php/tag-queued/delete'+param,{
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-Access-Token': access_token
                                                }
                                                }
                                            ).then( (response)  => {

                                              swal("Deleted",'Tag delete Sucessfully','success')
                                    //           this.props.onChange();
                                                this.loadTable();
                                                this.close();

                                            }).catch( (response) => {
                                               // alert(response.message);
                                                 swal('Error','Something went wrong','warning');
                                                  this.loadTable();

                                            });

            } else {
                                      //swal("Your imaginary file is safe!");
                    }
    }); //End of confirm
    
  
  }
    

    
    loadTable(){
        
        let self = this;

          axios.get(baseUrl+'/index.php/tag-queued/index',{
            headers: {
                'Content-Type': 'application/json',
                'X-Access-Token': access_token
            }
        }
        ).then( (response) => {
            
            
        this.close();
         self.setState( { tagTable : <JsonTable rows={ response.data.data } columns={ self.state.columns } className='table table-bordered table-blue' />},this.render) 
//         this.props.onChange(); 
        }).catch(function (response) {
            alert(response.message);
            
            
        });
        
         // 

      
        
    }
    

   createTag(){
    {
        
        let validator = $("#tag_form").validate(this.state.validationOption);
        validator.form();
        let valid = validator.valid();
        
        if(!valid){
            return false;
        }
        const self = this , data = this.serializeObject($('#tag_form'));
        axios.post(baseUrl+'/index.php/tag-queued/create', data, {
            headers: {
                'Content-Type': 'application/json',
                'X-Access-Token': access_token
            }
        }
        ).then((response) => {
            
            swal("Sucess",'Tag created Successfully','success')
            this.loadTable();
            this.close();
        }).catch( (response) => {
            swal("Error ",response.message,'error')
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

    
    componentDidMount(){
       
       
        this.setState( {tagTable : <JsonTable rows={ this.state.tagList } columns={ this.state.columns } className='table table-bordered table-blue' />}) 
        this.loadTable();
  
    }
    

  render() {

    return (
          
          
          
<div className="row">
    <div className="col-md-12">

            <div className="portlet light  bordered">
                <div className="portlet-title">
                    <div className="caption">

                        <span className="caption-subject font-blue sbold uppercase">Queued Tags</span>
                    </div>
                    <div className="actions">
                        <div className="btn-group btn-group-devided" data-toggle="buttons">
                          <button className="btn  blue" onClick={this.handleCreateTag}> Add Tag   <i className="fa fa-plus-circle"> </i></button>
                        </div>
                    </div>
                </div>
                <div className="portlet-body ">
                    <div className="table-responsive" >
                        {this.state.tagTable}
                    </div>
                </div>
            </div>
            
            <Modal show={this.state.showModal} onHide={this.close} className='modal-m'>
                  <Modal.Header closeButton>
                    <Modal.Title className=" font-blue">Tag</Modal.Title>
                  </Modal.Header>
                  <Modal.Body>
                    <form id='tag_form' className="form-horizontal has-validation" role="form" onSubmit={(e) => {  e.preventDefault() ; handleSubmit(); } }>

                        <input type="hidden"  name='tagID' value={this.state.tagID}
                                           onChange={this.handleInputChange} /> 


                        <div className="form-group">
                            <label className="col-md-3 control-label">Tag Name</label>
                            <div className="col-md-9">
                              <input type="text" className="form-control " required  placeholder="Tag Name"  name='tagName' value={this.state.tagName}
                               onChange={this.handleInputChange} /> 
                                </div>
                        </div>
                        
                        
                        <div className="form-group">
                            <label className="col-md-3 control-label">Tag Group</label>
                            <div className="col-md-9">

                            <select className="form-control" name="tagGroupID" value={this.state.tagGroupID} onChange={this.handleInputChange}>
                            {this.state.tagGroupOption}
                            </select>
                                
                            </div>
                      </div>

                        <div className="form-group">
                            <label className="col-md-3 control-label">Start Time</label>
                            <div className="col-md-9">
                            
                                <div className="input-group date  bs-datetime datetimepicker" >
                                   <input type="text" className="form-control " required  placeholder="Start Time"  name='LocalstartTime' value={this.state.LocalstartTime}
                                        onChange={this.handleInputChange} /> 
                                    <span className="input-group-addon">
                                        <button className="btn default date-set" type="button">
                                            <i className="fa fa-calendar"></i>
                                        </button>
                                    </span>
                                </div>
                              
                            </div>
                        </div>

                        <div className="form-group">
                            <label className="col-md-3 control-label">End Time</label>
                            <div className="col-md-9">
                            
                            
                                <div className="input-group date  bs-datetime datetimepicker" >
                                   
                              <input type="text" className="form-control" required  placeholder="End Time"  name='LocalendTime' value={this.state.LocalendTime}
                               onChange={this.handleInputChange} /> 
                                    <span className="input-group-addon">
                                        <button className="btn default date-set" type="button">
                                            <i className="fa fa-calendar"></i>
                                        </button>
                                    </span>
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
                
                
                <Modal show={this.state.viewModal} onHide={this.closeView}  className='modal-m'>
                  <Modal.Header closeButton>
                    <Modal.Title>Tag</Modal.Title>
                  </Modal.Header>
                  <Modal.Body>
                  
                  
                    <table className="table table-advanced">
                    <tbody>
                    <tr><th>Tag Name</th><td>{this.state.tagName}</td></tr>
                    <tr><th>Tag Group</th><td>{this.state.tagGroupName}</td></tr>
                    <tr><th>Start Time</th><td>{this.state.LocalstartTime}</td></tr>
                    <tr><th>EndTime Time</th><td>{this.state.LocalendTime}</td></tr>
                    </tbody>
                    </table>
                  </Modal.Body>

                  <Modal.Footer>
                        <div className="form-actions float-right">

                        <button className="btn btn-default " onClick={this.closeView}> Cancel</button>


                        </div>
                  </Modal.Footer>
                </Modal>


    </div>
        
    </div>

            
            )}

}
