import React, { Component } from 'react';
import update from 'react/lib/update';



export default class SystemAlertsComponent extends Component {
    constructor(props) {
        super(props);
        // this.hangleLayoutChange = this.hangleLayoutChange.bind(this);
        
        console.log("Rawmix Run",this.props.data);
        this.state = { 
            
                        data : this.props.data
                    }
        
        
    }
    
    
    
    componentDidMount(){
    
        let self = this    
        $.ajax({
            
            url : baseUrl+'/index.php/Gadgets/system-alerts-gadget/index',
            data : {},
            success : function(response){
                
                $("#"+self.props.type + "-" + self.props.data.gadget_data_id).html(response)
            },
            
            error : function(){
             
              //  swal('rtt');
            }
            
        })
        
        
    }

    render() {




              
            
            return <div id={this.props.type + "-" + this.props.data.gadget_data_id}> </div>



    }
};