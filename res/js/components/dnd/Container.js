import React, { Component } from 'react';
import update from 'react/lib/update';
import { DragDropContext } from 'react-dnd';
import Select from 'react-select'
import Highlighter from 'react-highlight-words';
import HTML5Backend from 'react-dnd-html5-backend';

import Gadget from  '../../components/Gadget.jsx';
import GadgetSelect from  '../../components/GadgetSelect.jsx';
import AddLayout from '../AddLayout.jsx'



const style = {
 
};


const portletStyle = {
            minHeight:'200px'
};

@DragDropContext(HTML5Backend)
export default class Container extends Component {
    constructor(props) {
    super(props);
    this.moveGadget = this.moveGadget.bind(this);
    
    this.close              = this.close.bind(this);
    this.updatelayout      = this.updatelayout.bind(this);
    this.renderLayout       = this.renderLayout.bind(this);
    this.deleteGadget       = this.deleteGadget.bind(this);
    this.onClick            = this.onClick.bind(this);
    this.onSubmit           = this.onSubmit.bind(this);
    this.setDefaultLayout   = this.setDefaultLayout.bind(this);
    this.handleLayoutChange = this.handleLayoutChange.bind(this);
    this.getlayouts         = this.getlayouts.bind(this);
    this.deleteLayout       = this.deleteLayout.bind(this);
    this.hangleNewLayout    = this.hangleNewLayout.bind(this);

    
    this.state = {
      gadgets:[],
      selectedLayout: 'Select layout',
      layoutID : '',
      layoutList:{}
    };
  }

  
  close(){
      
      
  }
    setDefaultLayout(){


    const formData ={ GadlayLayouts : { lay_id : this.state.layoutID }} ;
    
    
    swal({
            title: "Are you sure?",
            text: "Do you want to set it as default layout?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
            .then((willDelete) => 
                 {
                    if (willDelete) {

                    $.ajax({
                            type:'POST',
                            url: baseUrl+'/index.php?r=gadlay-layouts/update',
                            data: formData ,
                            success:(msg) =>{

                                let jObject = JSON.parse(msg);
                               // this.close();

                                layouts.push(jObject['layout']);
                                
                                swal('Success','Current Layout set as default layout','sucess')
                                this.props.onChange();
                            }

             });

            } else {
                                      //swal("Your imaginary file is safe!");
                    }
    }); //End of confirm
    

}

    deleteLayout(){
    
    
    swal({
            title: "Are you sure?",
            text: "Do you want to delete this layout?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
            .then((willDelete) => 
                 {
                    if (willDelete) {

                    $.ajax({
                            type:'POST',
                            url: baseUrl+'/index.php?r=gadlay-layouts/delete&id='+this.state.layoutID,
                            success:(msg) =>{


                                
                                swal('Success','Layout Addded sucessfully','success');
                                this.setState({layoutID : null},this.getlayouts)
                                this.props.onChange();
                            }

             });

            } else {
                                      //swal("Your imaginary file is safe!");
                    }
    }); //End of confirm
    
}
    getlayouts (id){
        
    axios.get(get_layouts_url , {
        headers: {
            'Content-Type': 'application/json',
            'X-Access-Token': access_token
        }
    }
    ).then( (response) => {
      
        let layoutList = response.data.data;

        let temp = Array();
        let lookUp = {}
//        let layLookUp = 
        
         const otemp =layoutList.map(lay => { 
             
                temp.push( { value:lay.lay_id, label : lay.subname +' [' +lay.type +'] '}) 
                lookUp[lay.lay_id] = lay;
            })
            
        this.setState({layoutOption:temp,layoutList : lookUp},this.render);
       
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
    
    
    handleLayoutChange(layoutID){
        
   
    this.setState({layoutID : null});
    this.updatelayout(layoutID);     

    }
    
    updatelayout(layoutID){
      
        var gadgets ;
        
            $.ajax({
                type:'POST',
                url : baseUrl+'/index.php?r=gadgets-data/index', //have to figure out yii2 routing
                data:{ lay_id : layoutID },
                success:(response) => {
                  
                       let  jsObject = JSON.parse(response);
                       
                       var array = Array();
                        array = jsObject.map((gad,i) => {
                                        return gad;
                                    });
                       
                       this.setState({gadgetList : array , gadgets :  array , layoutID : layoutID });
                                
                }
            });  
    }
    
    updateGadget(gadget) {
    
                 const data = { 
                    GadgetsData : gadget
                }
    
            var   url = baseUrl+'/index.php?r=gadgets-data/update&id='+gadget.gadget_data_id;

        // Have to change  response code 302 in apache running in linux
            $.ajax({
                type:'POST',
                url:url ,
                data: data,
                success:function(msg){


                }.bind(this),
                error: function(request,status,errorThrown) {


                //alert('Updated Successfully');

           }.bind(this)

            });

  }
  
    
    renderLayout(){
        
        
        //alert('render');
                        
                      var gadgetDivs = this.state.gadgetList.map((gad,i) => {  
                          // console.log(gad)
                           return <Gadget 
                           
                            layoutID={gad.lay_id}
                            gadgetID={gad.gadget_data_id}  
                            onClick={this.onClick} 
                            key={gad.gadget_data_id}
                            index={i}
                            gadget_data_id={gad.gadget_data_id}
                            gadget_name={gad.gadget_name}
                            gadget_type ={gad.gadget_type}
                            moveGadget={this.moveGadget}
                            action="edit"        
                            data={gad}
                        
                        />
                        });
                        
                        this.setState({gadgetDivs : gadgetDivs})
                        
        
    }
    
    deleteGadget(id){
        
        
     //Delete confirm
      swal({
            title: "Are you sure?",
            text: "Do yu want to delete Gadget!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
            .then((willDelete) => 
                 {
                    if (willDelete) {

                     $.ajax({
                                type:'GET',
                                url : baseUrl+'/index.php?r=gadgets-data/delete', //have to figure out yii2 routing
                                data:{ id : id },
                                success:(msg) =>{

                                     this.updatelayout(this.state.layoutID)
                                    swal('Success','Deleted Successfully','success')

                                },
                                error:(msg,a,b)=>{
                                     swal('Error','Opps Something went wrong','error')
                                }
                            }); 
           

                    } else {
                                      //swal("Your imaginary file is safe!");
                    }
    }); //End of confirm
           
    }
    hangleNewLayout(layout){
        
        this.setState({layoutID : null},this.getlayouts);
         this.handleLayoutChange(layout.lay_id);
        
    }
    componentDidMount(){
        
        
        this.getlayouts();
        
        
               
                
    }
    
    
    renderOption(option){
        
    }
    onClick(id){
        
        this.deleteGadget(id)
    }
    
    onSubmit(id){
        
        
        this.updatelayout(id)
        
    }
  
    moveGadget(dragIndex, dropIndex) {
    
    const { gadgets } = this.state;
    var dragGadget    = gadgets[dragIndex];
    var targetGadget  = gadgets[dropIndex]
    
   
    this.setState(update(this.state, {
                                        gadgets: {
                                                  $splice: [
                                                    [dragIndex, 1],
                                                    [dropIndex, 0, dragGadget],
                                                  ],
                                              },
                                                }), () => { 
                                                            
                                                              this.state.gadgets.map((gadget,i) => {
                                                                //debugger  
                                                                  gadget.widgetsPos = i
                                                              this.updateGadget(gadget);
                                                              });
                                                              
                                                          }
                         );
    
  }

    render() {
    const { gadgets } = this.state;

    return (
            
        <div>
            
        <div>

            <div className="portlet light" style={ portletStyle}>
            <div className="portlet-title">
                <div className="caption">
                    <i className="fa fa-newspaper-o font-green"></i>
                    <span className="caption-subject font-green bold uppercase">Simple Table</span>
                </div>
                {

                    this.state.layoutID && <div className="actions">
                            <div className="btn-group">
                                            
                                <a className="btn dark btn-outline  btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="true"> 
                                                <i className="fa fa-wrench"></i>
                                            </a>            
                                <ul className="dropdown-menu pull-right">
                                    <li onClick={this.setDefaultLayout}>
                                        <a href="javascript:;">
                                            Set as Default <i className="fa fa-pencil"></i> </a>

                                    </li>

                                    <li onClick={this.deleteLayout}>
                                        <a href="javascript:;">
                                            Delete  <i className="fa fa-trash"></i></a>

                                    </li>

                                </ul>
                            </div>
                        </div>
                }
            </div>
            
            <div className="portlet-body">
            
                
            <div className="row">
            
            <div className="col-md-1">
            <label className=""><b>Select Layout</b></label>

            </div>
            <div className="form-group col-md-3">

                 <Select
                    name="layoutID"
                    closeOnSelect={!this.state.stayOpen}

                    onChange={this.handleLayoutChange}
                    options={this.state.layoutOption}
                    placeholder="Select  Layout"
                    simpleValue
                    value={this.state.layoutID}
                />
            </div>
                
                
            <div className="col-md-2">
                 <AddLayout onChange={this.updateLayout} onSubmit={this.onSubmit}   hangleNewLayout={this.hangleNewLayout}/>
            </div>  

                </div>  
              
            </div>

            </div>
        </div>          
          
       { this.state.layoutID && <div className="portlet light  ">
            <div className="portlet-title ">
                <div className="caption font-green green">
                    <i className="fa fa-list font-green green"></i> {this.state.layoutList[this.state.layoutID].sub_name} Gadgets
                </div>
                <div className="actions">
                    
                  { this.state.layoutID && <GadgetSelect parentClose={this.close} layout={this.state.layoutList[this.state.layoutID]} layoutType="" layoutID={this.state.layoutID} onSubmit={this.onSubmit} />    }
                </div>
            </div>
            <div className="portlet-body">
            
            <div className="row ">
                   
                 <div style={ style }>
                    {gadgets.map((gadget, i) => (
                      <Gadget
                        key={gadget.gadget_data_id}
                        index={i}
                        gadget_data_id={gadget.gadget_data_id}
                        gadget_name={gadget.gadget_name}
                        gadget_type ={gadget.gadget_type}
                        layoutID ={this.state.layoutID}
                        moveGadget={this.moveGadget}
                        action="edit"        
                        data={gadget}
                        onClick={this.deleteGadget}
                        onSubmit={this.onSubmit}        
                        />
                     ))}
                </div> 
                  
            </div>
            </div>
        </div>}
        
        </div>
        
      
    );
  }
}
