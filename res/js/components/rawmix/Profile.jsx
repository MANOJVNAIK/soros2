import React, { Component } from 'react';
import update from 'react/lib/update';
import axios from 'axios';
import swal from 'sweetalert';
const inputStyle = {

    padingLeft: '15px'
}
export default class Profile extends Component {
    constructor(props) {
        super(props);
        // this.hangleLayoutChange = this.hangleLayoutChange.bind(this);

        let product_name = '', product_id = '';
       // console.log("Profile log", product_name, product_id, this.props.productProfile);

            
        let profile = this.props.productProfile;
        
        if (profile) {
            product_name = profile.product_name ;
            product_id = profile.product_id ;
        }

        this.state = {
            product_name: profile.product_name,
            product_id: profile.product_id,
        }


        this.createProfile      = this.createProfile.bind(this);
        this.saveProfileName    = this.saveProfileName.bind(this);
        this.handleInputChange  = this.handleInputChange.bind(this);
        this.serializeObject    = this.serializeObject.bind(this);

    }

    handleInputChange(event) {

        const target = event.target;
        const value = target.type === 'checkbox' ? target.checked : target.value;
        const name = target.name;
        this.setState({
            [name]: value
        });
    }



    saveProfileName(){
 
        let productProfile = this.props.productProfile;
        productProfile.product_name  = this.state.product_name;
        
     
        axios.put(baseUrl+'/product-profile/update?&id='+this.state.product_id, productProfile, {
            headers: {
                'Content-Type': 'application/json',
                'X-Access-Token': access_token
            }
        }
        ).then((response) => {

            swal("Success", 'Product name updated', 'success')
        
        }).catch((response) => {
          //  alert(response.message);
          
          swal("Alert", 'Product name can\'t be empty', 'warning')

        }); // end of axios
        
    }
    componentDidMount() {




    }
    serializeObject($form) {
        var unindexed_array = $form.serializeArray();
        var indexed_array = {};

        $.map(unindexed_array, function (n, i) {
            indexed_array[n['name']] = n['value'];

        });

        return indexed_array;
    }

    createProfile() {


        let name = document.getElementById('product_name');
//             let data = {name : name};
        let data = this.serializeObject($('#product-profile-form'));
//             alert(baseUrl);
        axios.post(baseUrl+'/product-profile/create', data, {
            headers: {
                'Content-Type': 'application/json',
                'X-Access-Token': access_token
            }
        }
        ).then((response) => {

            swal("Sucess", 'Setpoint created Successfully', 'success')
            this.props.onChange();
            this.close();
        }).catch((response) => {
            //alert(response.message);

            console.log(response);
        }); // end of axios
    }
  
    render() {

        return (
                <div className="portlet light ">
                    <div className="portlet-title">
                        <div className="caption font-blue">
                            <i className="icon-settings font-blue"></i>
                            <span className="caption-subject bold uppercase"><b> Product Profile</b></span>
                        </div>
                    </div>
                    <div className="portlet-body">
                    
                   
                        <div className="bs-example" data-example-id="form-group-height-sizes">

                                <form id="product-profile-form" className="form-horizontal"> 

                                 <input type="hidden" required="required" name="profile_id" id="product_id" value={this.state.product_id}/>

                                <div className="form-group form-group-lg"> 
                                    <label className="col-md-4 control-label" >Product name</label> 
                                    <div className="col-md-4"> 
                                       <input  style={inputStyle} type="text" 
                                                className="form-control input" 
                                                required="required" 
                                                name="product_name" 
                                                id="product_name" 
                                                value={this.state.product_name}
                                                onChange={this.handleInputChange}      
                                                />
                                     </div> 
                                    <div className="col-md-2"> 
                                      { !this.state.profile_name && <button type="button" className="btn btn-lg btn-success blue" onClick={this.saveProfileName}>Save</button>}

                                               { this.state.profile_name && <button  type="button" className="btn btn-success btn-lg blue" onClick={this.createProfile}>Create</button>}


                                    </div>
                                 </div> 

                                 </form>
                        </div>

                    </div>
                </div>





                )
    }

}
