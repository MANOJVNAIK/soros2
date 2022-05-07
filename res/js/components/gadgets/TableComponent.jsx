import React, { Component } from 'react';
import update from 'react/lib/update';



export default class TableComponent extends Component {
    constructor(props) {
        super(props);
        // this.hangleLayoutChange = this.hangleLayoutChange.bind(this);
        
        this.state = { 
                        columns : {}
                    }
        
        
        this.getCells = this.getCells.bind(this);
    }
    
    
    
    getCells(){
        
        
        let cols = this.props.data.data_source.split(',') ;
        
        let cells = cols.map((value,key) => {
            
                return <th key={key}>{value}</th>
        });
        
        
        return cells
        
    }
    
    
    configDataTable(){
        
        
        
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
    
    componentWillUpdate(){
        
    }
    componentDidMount(){
        
        
        
        let self = this;
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
                $('#' + self.props.type + "-" + self.props.data.gadget_data_id).DataTable(clientOptions);
    }

    render() {


            
           return <table id={ this.props.type + "-" + this.props.data.gadget_data_id} className="table table-blue">
                    <thead><tr>{ this.getCells() }</tr></thead>
                  </table>

    }
};
