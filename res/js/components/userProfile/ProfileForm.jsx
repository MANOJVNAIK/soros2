import React, { Component } from 'react';
import { Button, FormGroup, ControlLabel, FormControl, Modal } from 'react-bootstrap';
import Select from 'react-select';


class ProfileForm extends Component {

constructor(props) {
super(props);


const userData = props.userProfile;
console.log(userData)

        this.state = {
            
                    /*    first_name : userData.userProfile.first_name,
                        last_nale  : userData.userProfile.last_name,
                        email       : '',
                        refresh_rate : userData.userProfile.refresh_rate,
                        language : userData.userProfile.language, */
                        
                        
                        first_name : userData.userProfile.first_name,
                        last_name  : userData.userProfile.last_name,
                        email       : '',
                        refresh_rate : userData.userProfile.refresh_rate,
                        language : userData.userProfile.language,
                        
        }
        
   this.handleInputChange = this.handleInputChange.bind(this);
   this.close= this.close.bind(this);
   this.open= this.open.bind(this);
   this.onSubmit = this.onSubmit.bind(this);
}

close() {
this.setState({ showModal: false });
}


onSubmit(id){
    
    this.close();
    this.props.onSubmit(id);
    
}

open() {
// alert('open modal');

this.setState({ showModal: true });

}
handleInputChange(event) {

const target = event.target;
        const value = target.type === 'checkbox' ? target.checked : target.value;
        const name = target.name;
        this.setState({
        [name]: value
        });
       // alert('tr');
       
       console.log(vlaue);
}


componentDidMount(){


}


render() {


return (

                    <form role="form" action="#">
                        <div className="form-group">
                            <label className="control-label">First Name</label>
                            <input placeholder="John" className="form-control" type="text" name="first_name" value={this.state.first_name} onChange={this.handleInputChange}/> </div>
                        <div className="form-group">
                            <label className="control-label">Last Name</label>
                            <input placeholder="Doe" className="form-control" type="text" name="last_name" value={this.state.last_name} onChange={this.handleInputChange}/> </div>
                        <div className="form-group">
                            <label className="control-label">Language</label>
                            <select className="form-control" name="language" value={this.state.language} onChange={this.handleInputChange} >
                            <option>   Select Language</option>
                             <option value="en_us">  English</option>
                             <option value="zn">  Chinees</option>
                              <option value="en"> Spanish</option>
                            </select>
                        </div>
                        <div className="form-group">
                            <label className="control-label">Refresh Rate</label>
                            <input placeholder="Refresh Rate" className="form-control" type="text" name="refresh_rate" value={this.state.refresh_rate} onChange={this.handleInputChange} /> 
                        </div>


                        <div className="margiv-top-10">
                            <a href="javascript:;" className="btn green"> Save Changes </a>
                            <a href="javascript:;" className="btn default"> Cancel </a>
                        </div>
                    </form>
          );
       }
    }


export default ProfileForm;