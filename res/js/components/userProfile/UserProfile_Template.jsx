import React, { Component } from 'react';
import update from 'react/lib/update';
import axios from 'axios';
import swal from 'sweetalert';
//import precircle form 


export default class UserProfile extends Component {
  constructor(props) {
    super(props);
 
  }
  
    
    componentDidMount(){
        
  
                
    }
 
   
  
    getProfile(profileId){
        
        let param = "&id="+ profileId; 
        
          //Clear previous State
        this.setState( { productProfile : null}) ;
        this.render();
        
        
        axios.get(baseUrl+'?r=product-profile/detail' + param ,{
        headers: {
            'Content-Type': 'application/json',
            'X-Access-Token': access_token
        }
        }
        ).then( (response) => {
                
                  let profileDetail     =   response.data.data
                  this.setState( { productProfile   : profileDetail.product_profile }); 
                  this.setState( { setpointList     : profileDetail.setpoints}) ;
                  this.setState( { sourceList       : profileDetail.source}) ;
                  this.setState( { elementCompList  : []}) ;


                    $('#form-wizard').find('.progress-bar').css({
                        width: profileDetail.validation.progress + '%'
                    });

                  //this.setState({progress : profileDetail.validation.progress });
//                  
//                  $("#profile_progress").ionRangeSlider({
//                                                        min: 0,
//                                                        max: 100,
//                                                        from: profileDetail.validation.progress,
//                                                        step : 10,
//                                                        grid: true
//                                                    });
                  this.render();

            }).catch( (response)  =>{
                alert(response.message);
                }); 
    }

  render() {

            return (
                    
                   <div className="profile">
                        <div className="tabbable-line tabbable-full-width">
                            <ul className="nav nav-tabs">
                                <li className="active">
                                    <a href="#tab_1_1" data-toggle="tab" aria-expanded="true"> Overview </a>
                                </li>
                                <li className="">
                                    <a href="#tab_1_3" data-toggle="tab" aria-expanded="false"> Account </a>
                                </li>
                               
                            </ul>
                            <div className="tab-content">
                                <div className="tab-pane active" id="tab_1_1">
                                    <div className="row">
                                        <div className="col-md-3">
                                            <ul className="list-unstyled profile-nav">
                                                <li>
                                                    <img src="pages/media/profile/people19.png" className="img-responsive pic-bordered" alt="" />
                                                    <a href="javascript:;" className="profile-edit"> edit </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;"> Projects </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;"> Messages
                                                        <span> 3 </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;"> Friends </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;"> Settings </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div className="col-md-9">
                                          
                                        </div>
                                    </div>
                                </div>
                                <div className="tab-pane" id="tab_1_3">
                                    <div className="row profile-account">
                                        <div className="col-md-3">
                                            <ul className="ver-inline-menu tabbable margin-bottom-10">
                                                <li className="">
                                                    <a data-toggle="tab" href="#tab_1-1" aria-expanded="false">
                                                        <i className="fa fa-cog"></i> Personal info </a>
                                                    <span className="after"> </span>
                                                </li>
                                                <li className="">
                                                    <a data-toggle="tab" href="#tab_2-2" aria-expanded="false">
                                                        <i className="fa fa-picture-o"></i> Change Avatar </a>
                                                </li>
                                                <li className="">
                                                    <a data-toggle="tab" href="#tab_3-3" aria-expanded="false">
                                                        <i className="fa fa-lock"></i> Change Password </a>
                                                </li>
                                                <li className="active">
                                                    <a data-toggle="tab" href="#tab_4-4" aria-expanded="false">
                                                        <i className="fa fa-eye"></i> Privacity Settings </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div className="col-md-9">
                                            <div className="tab-content">
                                                <div id="tab_1-1" className="tab-pane">
                                                    <form role="form" action="#">
                                                        <div className="form-group">
                                                            <label className="control-label">First Name</label>
                                                            <input placeholder="John" className="form-control" type="text" /> </div>
                                                        <div className="form-group">
                                                            <label className="control-label">Last Name</label>
                                                            <input placeholder="Doe" className="form-control" type="text" /> </div>
                                                        <div className="form-group">
                                                            <label className="control-label">Mobile Number</label>
                                                            <input placeholder="+1 646 580 DEMO (6284)" className="form-control" type="text" /> </div>
                                                        <div className="form-group">
                                                            <label className="control-label">Interests</label>
                                                            <input placeholder="Design, Web etc." className="form-control" type="text" /> </div>
                                                        <div className="form-group">
                                                            <label className="control-label">Occupation</label>
                                                            <input placeholder="Web Developer" className="form-control" type="text" /> </div>
                                                        <div className="form-group">
                                                            <label className="control-label">About</label>
                                                            <textarea className="form-control" rows="3" placeholder="We are KeenThemes!!!"></textarea>
                                                        </div>
                                                        <div className="form-group">
                                                            <label className="control-label">Website Url</label>
                                                            <input placeholder="http://www.mywebsite.com" className="form-control" type="text" /> </div>
                                                        <div className="margiv-top-10">
                                                            <a href="javascript:;" className="btn green"> Save Changes </a>
                                                            <a href="javascript:;" className="btn default"> Cancel </a>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div id="tab_2-2" className="tab-pane">
                                                    <p> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
                                                        </p>
                                               
                                                </div>
                                                <div id="tab_3-3" className="tab-pane">
                                                    <form action="#">
                                                        <div className="form-group">
                                                            <label className="control-label">Current Password</label>
                                                            <input className="form-control" type="password" /> </div>
                                                        <div className="form-group">
                                                            <label className="control-label">New Password</label>
                                                            <input className="form-control" type="password" /> </div>
                                                        <div className="form-group">
                                                            <label className="control-label">Re-type New Password</label>
                                                            <input className="form-control" type="password" /> </div>
                                                        <div className="margin-top-10">
                                                            <a href="javascript:;" className="btn green"> Change Password </a>
                                                            <a href="javascript:;" className="btn default"> Cancel </a>
                                                        </div>
                                                    </form>
                                                    
                                           
                                                </div>
                                                <div id="tab_4-4" className="tab-pane active">
                                                    <form action="#">
                                                        <table className="table table-bordered table-striped">
                                                            <tbody><tr>
                                                                <td> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus.. </td>
                                                                <td>
                                                                    <div className="mt-radio-inline">
                                                                        <label className="mt-radio">
                                                                            <input name="optionsRadios1" value="option1" type="radio" /> Yes
                                                                            <span></span>
                                                                        </label>
                                                                        <label className="mt-radio">
                                                                            <input name="optionsRadios1" value="option2" checked="" type="radio" /> No
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td> Enim eiusmod high life accusamus terry richardson ad squid wolf moon </td>
                                                                <td>
                                                                    <div className="mt-radio-inline">
                                                                        <label className="mt-radio">
                                                                            <input name="optionsRadios21" value="option1" type="radio" /> Yes
                                                                            <span></span>
                                                                        </label>
                                                                        <label className="mt-radio">
                                                                            <input name="optionsRadios21" value="option2" checked="" type="radio" /> No
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td> Enim eiusmod high life accusamus terry richardson ad squid wolf moon </td>
                                                                <td>
                                                                    <div className="mt-radio-inline">
                                                                        <label className="mt-radio">
                                                                            <input name="optionsRadios31" value="option1" type="radio" /> Yes
                                                                            <span></span>
                                                                        </label>
                                                                        <label className="mt-radio">
                                                                            <input name="optionsRadios31" value="option2" checked="" type="radio" /> No
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td> Enim eiusmod high life accusamus terry richardson ad squid wolf moon </td>
                                                                <td>
                                                                    <div className="mt-radio-inline">
                                                                        <label className="mt-radio">
                                                                            <input name="optionsRadios41" value="option1" type="radio" /> Yes
                                                                            <span></span>
                                                                        </label>
                                                                        <label className="mt-radio">
                                                                            <input name="optionsRadios41" value="option2" checked="" type="radio" /> No
                                                                            <span></span>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                        <div className="margin-top-10">
                                                            <a href="javascript:;" className="btn green"> Save Changes </a>
                                                            <a href="javascript:;" className="btn default"> Cancel </a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    )

    }
  
}
