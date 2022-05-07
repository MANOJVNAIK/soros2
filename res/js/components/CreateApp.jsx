import React, { Component } from 'react';
import { Button, FormGroup, ControlLabel, FormControl, Modal } from 'react-bootstrap';
import update from 'react/lib/update';
   
import { DragDropContext } from 'react-dnd';
import HTML5Backend from 'react-dnd-html5-backend';

import GadgetSelect from './GadgetSelect.jsx';
import Gadget       from './Gadget.jsx';
import Container     from './dnd/Container';

import AddLayout    from './AddLayout.jsx';
 

@DragDropContext(HTML5Backend)

export default class CreateApp extends Component {

    constructor(props) {
    super(props);
    this.state = {  
        
        gadgetList : [],
        layoutID:null
        
    
                
    };
    this.componentDidMount  = this.componentDidMount.bind(this);
    this.updatelayout       = this.updatelayout.bind(this);
    this.renderLayout       = this.renderLayout.bind(this)
//   this.onClick            = this.onClick(this);
    
    this.moveCard = this.moveCard.bind(this);
    
    }
    
    
    
    moveCard(dragIndex, hoverIndex) {
        
        console.log(this.state.gadgetList);
        const { gadgetList } = this.state;
        const dragGadget = gadgetList[dragIndex];

        this.setState(update(this.state, {
                                            gadgetList: {
                                              $splice: [
                                                [dragIndex, 1],
                                                [hoverIndex, 0, dragGadget],
                                              ],
                                            },
                                         }),()=> console.log(this.state.gadgetList));
    
    
    console.log()
  }


    handleInputChange(event) {

    const target = event.target;
            const value = target.type === 'checkbox' ? target.checked : target.value;
            const name = target.name;
            this.setState({
            [name]: value
            });
            
    }
    
    
    hangleLayoutChange(event){
        
    const target    = event.target;
    const value     = target.type === 'checkbox' ? target.checked : target.value;
    const name      = target.name;
    
    this.setState({layoutID : value});
    this.updatelayout(value);     

    }
    
    updatelayout(layoutID){
      
        var gadgets ;
        
            $.ajax({
                type:'POST',
                url : baseUrl+'?r=gadgets-data/index', //have to figure out yii2 routing
                data:{ lay_id : layoutID },
                success:function(msg){
                  
                       let  jsObject = JSON.parse(msg);
                       
                       
                       var array = jsObject.map((gad,i) => {
                                        return gad;
                                    });
                       
                       this.setState({gadgetList : array},this.renderLayout); //promis
                       
                   // let gadgets = this.state.gadgetList;
        
                       
                                
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
                            onClick={this.deleteGadget} 
                            key={gad.gadget_data_id}
                            index={i}
                            gadget_data_id={gad.gadget_data_id}
                            gadget_name={gad.gadget_name}
                            gadget_type ={gad.gadget_type}
                            moveCard={this.moveCard}
                            action="edit"        
                            data={gad}
                        
                        />
                        });
                     //   console.log(gadgetDivs)
                        
                        this.setState({gadgetDivs : gadgetDivs})
                        
        
    }
    
    deleteGadget(id){
        
            var res = confirm('Do you want to delete?');
            
            if(!res)
                return false;
            $.ajax({
                type:'GET',
                url :  baseUrl+'index.php?r=gadgets-data/delete', //have to figure out yii2 routing
                data:{ id : id },
                success:function(msg){
                  
                       let  jsObject = JSON.parse(msg);
                       if(jsObject.error){
                           alert('Operation Failed')
                       }else{
                           alert(jsObject.msg)
                       }
                       
                }
            }); 
    }
    
    componentDidMount(){
        
        console.log(this.state.gadgetList)
        //set in create view
        const temp = layouts.map(lay => { return <option key={lay.lay_id} value={lay.lay_id}> {lay.subname}</option> })
        this.setState({layoutOption:temp});
        
               
                
    }
    
    handleSubmit(e){
        
        e.preventDefault();
        
    }
    
    
    render() {

    const { cards } = this.state;

    return (
            
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
                        <a href="" className="collapse" data-original-title="" title=""> </a>
                        <a href="" className="remove" data-original-title="" title=""> </a>
                    </div>
                
            </div>
            <div className="m-portlet__body">
            
                
            <div className="row">
            
            <div className="col-md-2">
                <label className="">Select Layout</label>

            </div>
                <div className="form-group col-md-2">

                    <select className="form-control" name="layoutID" value={this.state.layoutID} onChange={e => { this.hangleLayoutChange(e); } }>
                        <option>  Select Layout </option>        
                        {this.state.layoutOption}
                    </select>
                </div>
            
            <div className="col-md-2">
                 <AddLayout onChange={this.updateLayout} />
            </div>    
            </div>

            </div>
        </div>

        
        
        
        <div className="portlet box grey">
            <div className="portlet-title">
                <div className="caption">
                    <i className="fa fa-list"></i>Gadgets  </div>
                <div className="actions">
                    
                        { false && <GadgetSelect   layoutID={this.state.layoutID} onChange={ (x) => { this.hangleLayoutChange(x) }}/>    }
                    </div>
            </div>
            <div className="row ui-sortable">
            
                    { this.state.gadgetDivs  }
                    
                    
            </div>
        </div>
        
        
        
        <div className="portlet box grey">
            <div className="portlet-title">
                <div className="caption">
                    <i className="fa fa-list"></i>Gadgets </div>
                <div className="actions">
                    
                        <GadgetSelect   layoutID={this.state.layoutID} onChange={ (x) => { this.hangleLayoutChange(x) } }/>    
                    </div>
            </div>
            <div className="row ui-sortable">
                  
            </div>
        </div>


            </div>
          );
       }
    }

//export default CreateApp;