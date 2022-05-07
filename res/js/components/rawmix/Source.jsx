import React, { Component } from 'react';
import update from 'react/lib/update';
import { Button , FormGroup , ControlLabel , FormControl , Modal } from 'react-bootstrap';
import JsonTable from '../JsonTable.jsx'
import ActionButton from '../ActionButton.jsx';
import axios from 'axios';
import swal from 'sweetalert';
import {  DeleteModelButton , cancelModelButton } from '../configs/GlobalConfig.jsx';



export default class Source extends Component {
    constructor(props) {
    super(props);
     
      //$("#rawmix_product_id").val()
      
//        $("input[name='src_min_feedrate']").val( $("input[name='src_min_feedrate']").val() * 100);
//        
//        $("input[name='src_max_feedrate']").val( $("input[name='src_max_feedrate']").val() * 100);
      const product_id =  document.getElementById('rawmix_product_id').value;
        this.state = {  showModal: false,
                src_id: '',
                product_id: product_id,
                src_name:'',
                src_type:'',
                src_priority:'',
                src_distance:'',
                src_delay:'',
                src_min_feedrate:'',
                src_max_feedrate:'',
                src_measured_feedrate:'',
                src_proposed_feedrate:'',
                src_actual_feedrate:'',
                src_cost:'',
                src_status_mode :'',
                src_manual_feedrate : '',
                sourceTable : '',
                sourceList:this.props.sourceList,
                item:'',
                 validationOption : {
                errorElement: "span",
                errorClass: "help-block help-block-error",
                focusInvalid: !1,
                ignore: "",
                
                rules :{
                    
                        src_min_feedrate :{
                            
                           required : true,
                            
                            number:true,
                            min : 1,
                            max : 100,
                            min_feed : true
                        },
                        
                        src_max_feedrate : {
                            
                            number : true ,
                            required : true,
                            min : 1,
                            max : 100,
                            max_feed  : true        
                            
                        },
                        
                        src_delay : {
                            
                            number : true ,
                            required : true,
                            min : 1,
                            max : 100,
                            source_delay : true
                            
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
                } ,
                formAction : function(){ alert('empty'); return false; },
                columns :[
                            {key: 'src_name', label: 'Name'},
                            {key: 'src_type', label: 'Image', cell: ( item, columnKey ) => {
                                    
                                const classType = "btn   "+item.src_type+ '-bg';
                                return <span> 
                                <button className={classType.toLowerCase()}   style={{ width : "100px" , height :"50px"}} id={item.src_id} title="Delete">        </button>
                                               
                                        </span> ;
                            }},
                            {key: 'src_min_feedrate', label: 'Min Feedrate' , cell: ( item, columnKey ) => {
                                    
                                return <span> 
                                               {item.src_min_feedrate * 100}
                                        </span> ;
                            }},
                            {key: 'src_max_feedrate', label: 'Max Feedrate',cell: ( item, columnKey ) => {
                                    
                                return <span> 
                                               {item.src_max_feedrate * 100}
                                        </span> ;
                            }},
                            {key: 'src_delay', label: 'Delay'},
                            {key: 'src_cost', label: 'Cost'},
                            {key: 'action', label: 'Action', cell: ( item, columnKey ) => {
                                return <span> 
                                                <ActionButton className="btn  blue" onClick={this.edit  } id={item.src_id} title="Edit"/>
                                                
                                                <ActionButton className="btn  red"   onClick={this.delete} id={item.src_id} title="Delete"/> 
                                        </span> ;
                            }}
                        ]

        };
        this.close = this.close.bind(this);
        this.reset=  this.reset.bind(this);
        this.edit = this.edit.bind(this);
        this.delete = this.delete.bind(this);
        this.getSource = this.getSource.bind(this);
        this.loadTable = this.loadTable.bind(this);
        this.open = this.open.bind(this);
        this.handleCreateSource = this.handleCreateSource.bind(this);
        this.handleInputChange = this.handleInputChange.bind(this); //
        this.serializeObject = this.serializeObject.bind(this);
        this.updateSource = this.updateSource.bind(this);
        this.createSource = this.createSource.bind(this);
        //serializeObject getSource createSource
        // this.hangleLayoutChange = this.hangleLayoutChange.bind(this);

}
  
    close() {
    this.setState({showModal: false});

}

    open() {
     // alert('open modal');
     //this.setState(this.baseState);
     this.setState({ showModal: true });
  }
    handleCreateSource(){
      
      
     return false;
     this.setState(
             {
                 formAction:this.createSource ,
                src_name:'',
                src_type:'',
                src_priority:'',
                src_distance:'',
                src_delay:'',
                src_min_feedrate:'',
                src_max_feedrate:'',
                src_measured_feedrate:'',
                src_proposed_feedrate:'',
                src_actual_feedrate:'',
                src_cost:'',
                src_status_mode :'',
                src_manual_feedrate : '',
                
             });
     this.setState({showModal:true});
  }

    updateSource(){

        let validator = $("#source_form").validate(this.state.validationOption);
        validator.form();
        let valid = validator.valid();
        
        if(!valid){
            return false;
        }
        
    this.close();
    let self = this;
            var param = "?&id=" + this.state.src_id;
            
        $("input[name='src_min_feedrate']").val( $("input[name='src_min_feedrate']").val() / 100);
        
        $("input[name='src_max_feedrate']").val( $("input[name='src_max_feedrate']").val() / 100);
            var data = this.serializeObject($('#source_form'));
            axios.put(source_update_url + param, data, {
            headers: {
            'Content-Type': 'application/json',
                    'X-Access-Token': access_token
            }
            }
            ).then(  (response, b, c) =>  {
                
                
            swal('Success','Source have been updated succesfully','success');
                this.props.onChange();
                
    }).catch( (response) => {
        
         this.props.onChange();
         this.close();
    
   // alert(response.message)
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
            this.getSource(id)
            this.setState({formAction:this.updateSource});
            this.open();
    }
    delete(id){
      
  
      let self = this;
      var param = '?&id=' + id
    
  
        let  buttons = isAdmin === 1 ? DeleteModelButton  : cancelModelButton;
        
        let dMsg    =  isAdmin === 1 ? "Do you want to delete Source ?  "  : "Do you want to delete Source! - Contact Admin ";
      //Delete confirm
      swal({
            title: "Attention",
//            html :"<p>Do you want to delete Source! </p></b><p>Contact admin</p>",
            text: dMsg,
            icon: "warning",
             buttons: buttons,
            dangerMode: true,
          })
            .then((willDelete) => 
                 {
                    if (willDelete) {

   

            } else {
                       // swal("Your imaginary file is safe!");
                    }
    }); //End of confirm
    

  }
    
    componentDidMount(){
        
    
            var self =  this;
        jQuery.validator.addMethod("min_feed", function (value, element) {
           
            return this.optional(element) || value <=  self.state.src_max_feedrate  ;
        }, 'Min freedrate  smaller than Max feed rate');
        
         
        jQuery.validator.addMethod("max_feed", function (value, element) {
           
            return this.optional(element) ||    value >= self.state.src_min_feedrate  ;
        }, 'Max freedrate should be greater than Min feedrate');
        
        jQuery.validator.addMethod("source_delay", function (value, element) {
           
            return this.optional(element) ||    value >= cron_run_time * 5   ;
        }, 'Delay should be '+cron_run_time +' * 5');
           this.setState( { sourceTable : <JsonTable rows={ this.props.sourceList } columns={ this.state.columns } className='table table-blue table-bordered table-stripped' />}) 
    
            
            
            }
    
    loadTable(){
        
        const me = this;
        
               const columns = [
                            {key: 'src_name', label: 'Name'},
                            {key: 'src_type', label: 'Type'},
                            {key: 'src_priority', label: 'Priority'},
                            {key: 'src_distance', label: 'Distance'},
                            {key: 'src_delay', label: 'Delay'},
                            {key: 'src_cost', label: 'Cost'},
                            {key: 'action', label: 'Action', cell: function( item, columnKey ){
                                return <span> 
                                                <ActionButton className="btn  red"   onClick={me.delete} id={item.src_id} title="Delete"/> 
                                                <ActionButton className="btn  blue" onClick={me.edit  } id={item.src_id} title="Edit"/>
                                        </span> ;
                            }}
                        ]
      
          axios.get(source_list_url,{
            headers: {
                'Content-Type': 'application/json',
                'X-Access-Token': access_token
            }
        }
        ).then( (response) =>{
           // refreshSourceTable();
           //Close Form
           
           this.close();
         me.setState( { sourceTable : <JsonTable rows={ response.data.data } columns={ columns } className='table table-bordered table-stripped' />}) 
          
        }).catch( (response)  =>{
            alert(response.message);
            
            
        });
        
         // 

      
        
    }
    

    getSource(id){
        
    let data;    
    var param = "?&id=" + id;
    let me    = this;
    axios.get(source_get_url + param, {
        headers: {
            'Content-Type': 'application/json',
            'X-Access-Token': access_token
        }
    }
    ).then(function (response) {
      
        let data = response.data.data;
//      console.log(data);
      for(let x in data){
          
          
          let value = data[x];
           me.setState({
                        [x]:value
                       });
      }
      
      
      me.setState({src_min_feedrate : data['src_min_feedrate'] * 100 , src_max_feedrate : data['src_max_feedrate'] * 100 });
      

       
    }).catch(function (response) {
        alert(response.message)
    });
       
    }
    
    reset(){
     
    }
    createSource(){
    
                
                  let validator = $("#source_form").validate(this.state.validationOption);
        validator.form();
        let valid = validator.valid();
        
        if(!valid){
            return false;
        }
        
        this.setState
        
        $("input[name='src_min_feedrate']").val( $("input[name='src_min_feedrate']").val() / 100);
        
        $("input[name='src_max_feedrate']").val( $("input[name='src_max_feedrate']").val() / 100);
        const  data = this.serializeObject($('#source_form'));
        axios.post(source_create_url, data, {
            headers: {
                'Content-Type': 'application/json',
                'X-Access-Token': access_token
            }
        }
        ).then( (a) => {
            
            
            swal('Success','Source have been added succesfully','success');
            this.props.onChange();
            this.close();
        }).catch( (response) => {
            //alert()
            
            swal('Error',response.message,'error');
        });
      
    
}// End of createSource
    
    serializeObject($form) {
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function (n, i) {
        indexed_array[n['name']] = n['value'];

    });

    return indexed_array;
}


  render() {

            const sourceTable = this.state.sourceTable
            const sourceList  = this.state.sourceList;
    return (
               <section>

                      <a onClick={this.handleCreateSource1} href="javascript:void(0)" id="add_source" className="btn   blue margin-bottom-20 pull-right" role="button">

                         Add Source &nbsp;
                        <i className="fa fa-plus-square"></i>
                    </a>
                    <div className="clearfix">
                    
                    {
                    sourceList.length < 3 &&
                    <div className="alert alert-danger">
                                <strong>Error!</strong> Create at least 3 source
                    </div>
                    }
                    
                    </div>

                <div className="col-md-12">{ sourceTable }</div>
                    
            
        <Modal show={this.state.showModal} onHide={this.close} className='modal-m'>
          <Modal.Header closeButton>
            <Modal.Title>Source </Modal.Title>
          </Modal.Header>
          <Modal.Body>
              <form id='source_form' className="form-horizontal has-validation" role="form" onSubmit={(e) => {  e.preventDefault() ; handleSubmit(); } }>
                <input type="hidden"  name='src_id' value={this.state.src_id}
                                   onChange={this.handleInputChange} /> 
                <input type="hidden"  name='product_id' value={this.props.product_id}
                                   onChange={this.handleInputChange} />                    
                        
                          <div className="form-body">
                            <div className="form-group">
                                <label className="col-md-3 control-label"> Name</label>
                                <div className="col-md-9">
                                  <input type="text" className="form-control " required  placeholder="Source Name"  name='src_name' value={this.state.src_name}
                                   onChange={this.handleInputChange} /> 
                                    </div>
                            </div>
                            
                            <div className="form-group">
                                <label className="col-md-3 control-label"> Type</label>
                                <div className="col-md-9">
                                  <input type="text" className="form-control " required placeholder="Source Type"  name='src_type' value={this.state.src_type}
                                   onChange={this.handleInputChange} /> 
                                    </div>
                            </div>
                            
                     
                             <div className="form-group">
                                <label className="col-md-3 control-label">Delay</label>
                                <div className="col-md-9">
                                  <input type="number" className="form-control " required placeholder="Source Delay"  name='src_delay' value={this.state.src_delay}
                                   onChange={this.handleInputChange} /> 
                                </div>
                            </div>
                             <div className="form-group">
                                <label className="col-md-3 control-label">Min Feedrate</label>
                                <div className="col-md-9">
                                  <input type="number" className="form-control "  placeholder="Source Min,. feedrate"  name='src_min_feedrate' value={this.state.src_min_feedrate}
                                   onChange={this.handleInputChange} /> 
                                </div>
                            </div>
                             <div className="form-group">
                                <label className="col-md-3 control-label">Max Feedrate</label>
                                <div className="col-md-9">
                                  <input type="number" className="form-control "  placeholder="Source Max Feedrate"  name='src_max_feedrate' value={this.state.src_max_feedrate}
                                   onChange={this.handleInputChange} /> 
                                </div>
                            </div>
                            
               
                      
                            
                              <div className="form-group">
                                <label className="col-md-3 control-label">Cost</label>
                                <div className="col-md-9">
                                  <input type="number" className="form-control " placeholder="Source Cost"  name='src_cost' value={this.state.src_cost}
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

    </section>

          
       
    )}
  
}
