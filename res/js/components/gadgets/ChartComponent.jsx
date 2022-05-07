import React, { Component } from 'react';
import update from 'react/lib/update';



export default class ChartComponent extends Component {
    constructor(props) {
        super(props);
        // this.hangleLayoutChange = this.hangleLayoutChange.bind(this);
        
//        console.log("chart",this.props.data);
        this.state = { 
            
                        data : this.props.data
                    }
        
        
    }
    
    
    
    componentDidMount(){
    
  let self = this;
            

$.getJSON(baseUrl+'/index.php/gadgets-charts-gadget/index?&id='+self.props.data.gadget_data_id, function (response) {
  // Create the chart
  Highcharts.stockChart( self.props.type + "-" + self.props.data.gadget_data_id, {


    rangeSelector: {
      selected: 4
    },

    title: {
      text: self.props.data.gadget_name
    },

    series: response.data.series,
    credits : false
  });
});


    }

    render() {


            return <div  id={this.props.type + "-" + this.props.data.gadget_data_id}> </div>



    }
};
