import React, { Component } from 'react';
import update from 'react/lib/update';



export default class RawmixRunComponent extends Component {
    constructor(props) {
        super(props);
        // this.hangleLayoutChange = this.hangleLayoutChange.bind(this);
        
        this.state = { 
            
                        data : this.props.data
                    }
        
        
    }
    
    
    
    componentDidMount(){
    
        let self = this    
        $.ajax({
            
            url : baseUrl+'/index.php/Gadgets/set-points-gadget/index',
            data : {},
            success : function(response){
                
                $("#"+self.props.type + "-" + self.props.data.gadget_data_id).html(response)
            },
            
            error : function(){
             
            }
            
        })
        
        
    }

    render() {
 
            
            return <div id={this.props.type + "-" + this.props.data.gadget_data_id}> </div>



    }
};
