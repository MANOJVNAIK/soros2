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

@DragDropContext(HTML5Backend)
export default class Container extends Component {
  constructor(props) {
    super(props);
    this.moveGadget = this.moveGadget.bind(this);
    
     this.updatelayout      = this.updatelayout.bind(this);
    this.renderLayout       = this.renderLayout.bind(this);
    this.deleteGadget       = this.deleteGadget.bind(this);
    this.onClick            = this.onClick.bind(this);
    this.onSubmit           = this.onSubmit.bind(this);
    this.setDefaultLayout   = this.setDefaultLayout.bind(this);
    this.hangleLayoutChange = this.hangleLayoutChange.bind(this);

    console.log(this.props.data);
    
    this.state = {
      gadgets:[],
      selectedLayout: 'Select layout',
      layoutID : ''
    };
  }
  
  
  setDefaultLayout(){


    const formData ={ GadlayLayouts : { lay_id : this.state.layoutID }} ;
    $.ajax({
        type:'POST',
        url: baseUrl+'/index.php?r=gadlay-layouts/update',
        data: formData ,
        success:function(msg){
            
            let jObject = JSON.parse(msg);
            this.close();
            
            layouts.push(jObject['layout'])
            this.props.onChange();
        }.bind(this)
        
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
    
    
    hangleLayoutChange(value){
        
    
    this.setState({layoutID : value});
    this.updatelayout(value);     

    }
    
    updatelayout(layoutID){
      
        var gadgets ;
        
            $.ajax({
                type:'POST',
                url : baseUrl+'/index.php?r=gadgets-data/index', //have to figure out yii2 routing
                data:{ lay_id : layoutID },
                success:function(msg){
                  
                       let  jsObject = JSON.parse(msg);
                       
                       var array = Array();
                        array = jsObject.map((gad,i) => {
                                        return gad;
                                    });
                       
                       this.setState({gadgetList : array , gadgets :  array , layoutID : layoutID });
                       
                       
                       
                   // let gadgets = this.state.gadgetList;
        
                       
                                
                }.bind(this)
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
        
            var res = confirm('Do you want to delete?');
            
            if(!res)
                return false;
            $.ajax({
                type:'GET',
                url : baseUrl+'/web/index.php?r=gadgets-data/delete', //have to figure out yii2 routing
                data:{ id : id },
                success:function(msg){
                  
                       let  jsObject = JSON.parse(msg);
                       if(jsObject.error){
                           alert('Operation Failed')
                       }else{
                           alert(jsObject.msg)
                       }
                       
                   this.updatelayout(this.state.layoutID)    
                       
                }.bind(this)
            }); 
    }
    
    componentDidMount(){
        
        console.log(this.state.gadgetList)
        
        
        var temp = Array();
        
         const otemp = layouts.map(lay => { temp.push( { value:lay.lay_id, label : lay.subname +' [' +lay.type +'] '})  })
        this.setState({layoutOption:temp});
        
               
                
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

            <div className="m-portlet m-portlet--success m-portlet--head-solid-bg">
            <div className="m-portlet__head">
            
                 <div className="m-portlet__head-caption">
                    <div className="m-portlet__head-title">
                            <span className="m-portlet__head-icon">
                                    <i className="flaticon-placeholder-2"></i>
                            </span>
                            <h3 className="m-portlet__head-text">
                                    Layout
                            </h3>
                    </div>
                </div>
                    
                   


<div className="m-portlet__head-tools">
    <ul className="m-portlet__nav">
        
            <li className="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" data-dropdown-toggle="hover" aria-expanded="true">
                    <a href="#" className="m-portlet__nav-link m-portlet__nav-link--icon m-dropdown__toggle">
                         <i className="la la-cog"></i> 
                    </a>
                    <div className="m-dropdown__wrapper">
                            <span className="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust" ></span>
                            <div className="m-dropdown__inner">
                                    <div className="m-dropdown__body">
                                            <div className="m-dropdown__content">
                                                    <ul className="m-nav">
                                                            <li className="m-nav__section m-nav__section--first">
                                                                    <span className="m-nav__section-text">
                                                                            Quick Actions
                                                                    </span>
                                                            </li>
                                                            <li className="m-nav__item" onClick={this.setDefaultLayout}>
                                                                    <a href="" className="m-nav__link">
                                                                            <i className="m-nav__link-icon flaticon-share"></i>
                                                                            <span className="m-nav__link-text">
                                                                                    Set as Default Layout
                                                                            </span>
                                                                    </a>
                                                            </li>

                                                    </ul>
                                            </div>
                                    </div>
                            </div>
                    </div>
            </li>
    </ul>
    </div>

                
            </div>
            <div className=" m-portlet__body ">
            
                
            <div className="row">
            
            <div className="col-md-1">
            <label className=""><b>Select Layout</b></label>

            </div>
                <div className="form-group col-md-3">
                
                     <Select
                        name="layoutID"
                        closeOnSelect={!this.state.stayOpen}

                        onChange={this.hangleLayoutChange}
                        options={this.state.layoutOption}
                        placeholder="Select  Layout"
                        simpleValue
                        value={this.state.layoutID}
                    />
                </div>
                
                
            <div className="col-md-2">
                 <AddLayout onChange={this.updateLayout} />
            </div>  

                </div>  
              
            </div>

            </div>
        </div>          
          
          
          
            <div className="m-portlet m-portlet--success m-portlet--head-solid-bg">
            <div className="m-portlet__head">
                <div className="m-portlet__headcaption">
                    <div className="m-portlet__head-title">
                            <span className="m-portlet__head-icon">
                                    <i className="flaticon-placeholder-2"></i>
                            </span>
                            <h3 className="m-portlet__head-tools">
                                    Gadgets
                            </h3>
                    </div>
                   
                </div>
                <div className="actions">
                    
                    <GadgetSelect   layoutID={this.state.layoutID} onSubmit={this.onSubmit} />    
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
        </div>
        
        </div>
      
    );
  }
}
