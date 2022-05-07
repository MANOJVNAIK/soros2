import React, { Component } from 'react';
import update from 'react/lib/update';



export default class LightComponent extends Component {
    constructor(props) {
        super(props);
        // this.hangleLayoutChange = this.hangleLayoutChange.bind(this);
        
        console.log("Light gadget",this.props.data);
        this.state = { 
                        statusElements : this.props.data.gadlayElements
                    }
        
        this.renderStatusEle = this.renderStatusEle.bind(this);
        
    }
    
    
    
    renderStatusEle(){
        
        let status;
        
        
       status =  this.state.statusElements.map((value , key) => {
           
                return <button key={key} className="status-btn btn-xl  green">{ value.element_type }</button>
       });
       
       return status;
    }
    
    componentDidMount(){
        
        
        
        
        let cols = this.props.data.data_source.split(',') ;
        
        let columns = new Array();
        
         columns = cols.map((value,key) => {
            
                return {data : value}
        });
        
        
        this.setState({ columns : columns});
        
       let  clientOptions = {
            processing : true,
            serverSide : true,
            columns : columns,
            searching : false,
            lengthChange : false,
            ordering : false,

            ajax : {
                url : "../../backend/web/index.php/table-widget",
                type : 'GET',
               // 'data' : {'startTime' : $this->startTime, 'endTime' : $this->endTime},
                beforeSend : ''
            },
        };
        
        
        
                clientOptions.ajax.beforeSend = function (request) {
                    request.setRequestHeader("X-Access-Token", "47fa16acebf6cb14bb7d2bfc474483b6");
                }
                
                
                $('#' + this.props.type + "-" + this.props.data.gadget_data_id).DataTable(clientOptions);
    }

    render() {




              
            
            return  <div>
            
                        { 
                        this.renderStatusEle() 
                        
                        }
                        
                        
                    </div>



    }
};
