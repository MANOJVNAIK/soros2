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



export default class TagGroupSettings extends Component {
  constructor(props) {
    super(props);
   
        this.state = {
                        
                        showModal : false,
                        formAction : function(){ alert('empty'); return false; },
                        tagGroupList : [],
                        rtaMasterOption: [],
                        tagGroupID : '',
                        rtaMasterID : '',
                        viewModal : false,
                        columns : [
                            {key: 'tagGroupName', label: 'Tag Group Name'},
                            {key: 'rtaMasterID', label: 'Rta Master ID'},
                            {key: 'action', label: 'Action', cell: ( item, columnKey ) => {
                                return <span> 
                                                <ActionButton className="btn  blue" onClick={this.edit  } id={item.tagGroupID} title="Edit"/>
                                                <ActionButton className="btn  green"   onClick={this.view} id={item.tagGroupID} title="View"/> 
                                                <ActionButton className="btn  red"   onClick={this.delete} id={item.tagGroupID} title="Delete"/> 
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
        this.open           = this.open.bind(this);
        this.edit           = this.edit.bind(this);
        this.view           = this.view.bind(this);
        this.delete         = this.delete.bind(this);
        this.getTagGroup   = this.getTagGroup.bind(this);
        this.loadTable = this.loadTable.bind(this);
        this.open = this.open.bind(this);
        this.handleCreateTagGroup = this.handleCreateTagGroup.bind(this);
        this.handleInputChange = this.handleInputChange.bind(this); //
        this.serializeObject = this.serializeObject.bind(this);
        this.updateTag = this.updateTag.bind(this);
        this.createTag = this.createTag.bind(this);
      
    }
  
    close(){
      
      this.setState({showModal : false})
    }
    open(){
       this.setState({showModal : true})
    }



    view(id){
        
    
    var param = "?&id=" + id;
    let self    = this;
    axios.get(baseUrl+'/index.php/tag-group/view' + param, {
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
  
  
  reset(){
      
      
      this.setState({ tagGroupName : ''  });
  }
    getTagGroup(id){
        
    
    var param = "?&id=" + id;
    let self    = this;
    axios.get(baseUrl+'/index.php/tag-group/view' + param, {
        headers: {
            'Content-Type': 'application/json',
            'X-Access-Token': access_token
        }
    }
    ).then(function (response) {
      
        let data = response.data.data;
      for(let x in data){
          
       
        console.log('tag group',x)
           self.setState({
                        [x]: data[x]
                       });
      }
       
    }).catch(function (response) {
        swal('Error',response.message,'error');
    }); //end of axios
       
    }
  
    handleCreateTagGroup(){
     this.setState({formAction:this.createTag ,   tagGroupName : '',
                        rtaMasterID : '',});
     this.setState({showModal:true});
  }

    updateTag(){


         let validator = $("#tag_group_form").validate(this.state.validationOption);
        validator.form();
        let valid = validator.valid();
        
        if(!valid){
            return false;
        }
    let self = this;
            var param = "?&id=" + this.state.tagGroupID;
            var data = this.serializeObject($('#tag_group_form'));
            axios.put(baseUrl+'/index.php/tag-group/update' + param, data, {
            headers: {
            'Content-Type': 'application/json',
                    'X-Access-Token': access_token
            }
            }
            ).then( (a, b, c) => {
  
            swal('Success','Tag Group have been updated succesfully','success');
//              this.props.onChange(); 
                this.loadTable();
              this.close();
              
    }).catch(function (response) {
    swall("Error",response.message,'error')
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

          
            this.getTagGroup(id)
            this.setState({formAction:this.updateTag});
            this.open();
    }
    
    reset(){
        
        
    }
    delete(id){
      
  
      var param = '?&id=' + id
    
    
      swal({
            title: "Are you sure?",
            text:  "Do you want to delete this Tag Group!",
            buttons : DeleteModelButton,
            dangerMode: true,
          })
            .then((willDelete) => 
                 {
                    if (willDelete) {

                                 axios.delete(baseUrl+'/index.php/tag-group/delete'+param,{
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-Access-Token': access_token
                                                }
                                                }
                                            ).then( (response)  => {

                                              swal("Deleted",'Tag group delete Sucessfully','success')
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

          axios.get(baseUrl+'/index.php/tag-group/index',{
            headers: {
                'Content-Type': 'application/json',
                'X-Access-Token': access_token
            }
        }
        ).then( (response) => {
            
            
        this.close();
         self.setState( { tagGroupTable : <JsonTable rows={ response.data.data } columns={ self.state.columns } className='table table-blue' />},this.render) 
//         this.props.onChange(); 
        }).catch(function (response) {
            swal("Error",response.message,'error');
            
            
        });
        
         // 

      
        
    }
    

   createTag(){
    {
        
        let validator = $("#tag_group_form").validate(this.state.validationOption);
        validator.form();
        let valid = validator.valid();
        
        if(!valid){
            return false;
        }
        const self = this , data = this.serializeObject($('#tag_group_form'));
        axios.post(baseUrl+'/index.php/tag-group/create', data, {
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

    reset(){
        
        
    }
    componentDidMount(){
       
     
         let rtaMasterOption =   configMaster.map((data,i) => {
                
        return <option value={data.rtaMasterID} key={i}> {data.DB_ID_string} </option>
            })
                
         
        this.setState( { rtaMasterOption : rtaMasterOption ,tagGroupTable : <JsonTable rows={ this.state.tagGroupList } columns={ this.state.columns } className='table table-blue' />}) 
//   
        this.loadTable();
    }
    

  render() {

    return (
          
          
<div className="row">
    <div className="col-md-12">

            <div className="portlet light  bordered">
                
                <div className="portlet-title">
                                    <div className="caption">
                                        
                                        <span className="caption-subject font-blue sbold uppercase">Tag Group</span>
                                    </div>
                                    <div className="actions">
                                        <div className="btn-group btn-group-devided" data-toggle="buttons">
                                          <button className="btn  blue" onClick={this.handleCreateTagGroup}> Add Tag  Group <i className="fa fa-plus-circle"> </i></button>
                                        </div>
                                    </div>
                                </div>
                <div className="portlet-body ">

                    <div className="table-responsive" >
            
            
            
             
            
            
            {this.state.tagGroupTable}
                    

                    
                    </div>
                    
                                    <Modal show={this.state.showModal} onHide={this.close} className='modal-m'>
                  <Modal.Header closeButton>
                    <Modal.Title className="text-centered font-blue">Tag Groups</Modal.Title>
                  </Modal.Header>
                  <Modal.Body>
                    <form id='tag_group_form' className="form-horizontal has-validation" role="form" onSubmit={(e) => {  e.preventDefault() ; handleSubmit(); } }>

                        <input type="hidden"  name='tagGroupID' value={this.state.tagGroupID}
                                            /> 


                        <div className="form-group">
                            <label className="col-md-3 control-label">Tag Group Name</label>
                            <div className="col-md-9">
                              <input type="text" className="form-control " 
                              required  placeholder="Tag Name"  
                              name='tagGroupName'
                              value={this.state.tagGroupName}
                               onChange={this.handleInputChange} /> 
                                </div>
                        </div>
                        
                        
                        <div className="form-group">
                            <label className="col-md-3 control-label">Rta Master ID</label>
                            <div className="col-md-9">

                           
                            <select className="form-control" name="rtaMasterID" onChange={this.handleInputChange}  value={this.state.rtaMasterID} >
                                {this.state.rtaMasterOption}
                            </select>
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
                
                
                <Modal show={this.state.viewModal} onHide={() => { this.setState({ viewModal : false});}} className='modal-m'>
                  <Modal.Header closeButton>
                    <Modal.Title className="text-centered font-blue">Tag Groups</Modal.Title>
                  </Modal.Header>
                  <Modal.Body>


                    <table className="table table-stripped ">
                    
                    <tbody>
                    <tr> <th>Tag Group Name</th> <td>{this.state.tagGroupName}</td></tr>
                    <tr> <th>Rta Master ID</th> <td>{this.state.rtaMasterID}</td></tr>
                    <tr> <th>Mass flow Weight</th> <td>{this.state.massflowWeight}</td></tr>
                    <tr> <th>Good Data Seconds Weight</th> <td>{this.state.goodDataSecondsWeight}</td></tr>
                    </tbody>
                    </table>

                  </Modal.Body>

                  <Modal.Footer>
                        <div className="form-actions float-right">

                        <button className="btn btn-default " onClick={() => { this.setState({ viewModal : false});}}> Cancel</button>

                        </div>
                  </Modal.Footer>
                </Modal>

                    </div>
                    </div>
                    </div>
                    </div>

            )}

}
