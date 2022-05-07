<form id='setpoint-form' className="form-horizontal has-validation" role="form" >

    <input type="hidden"  name='sp_id' value={this.state.sp_id}
           onChange={this.handleInputChange} /> 
    <input type="hidden"  name='product_id' value={this.state.product_id}
           onChange={this.handleInputChange} />                    



    <div className="form-body">
        <div className="form-group">
            <label className="col-md-3 control-label">Setpoint Name</label>
            <div className="col-md-9">
                <input type="text" className="form-control " placeholder="SetPoint Name"  name='sp_name' value={this.state.sp_name}
                       onChange={this.handleInputChange} /> 
            </div>
        </div>


    </div>

    <div className="form-body">
        <div className="form-group">
            <label className="col-md-3 control-label">Value Number</label>
            <div className="col-md-9">
                <input type="text" className="form-control " placeholder="value Number" required  name='sp_value_num' value={this.state.sp_value_num}
                       onChange={this.handleInputChange} /> 
            </div>
        </div>


    </div>

    <div className="form-body">
        <div className="form-group">
            <label className="col-md-3 control-label">Setpont Measured</label>
            <div className="col-md-9">
                <input type="text" className="form-control " placeholder="Setpoint measured"  name='sp_measured' value={this.state.sp_measured}
                       onChange={this.handleInputChange} /> 
            </div>
        </div>


    </div>

    <div className="form-body">
        <div className="form-group">
            <label className="col-md-3 control-label">sp_value_den</label>
            <div className="col-md-9">
                <input type="text" className="form-control " placeholder="sp_value_den"  name='sp_value_den' value={this.state.sp_value_den}
                       onChange={this.handleInputChange} /> 
            </div>
        </div>


    </div>

    <div className="form-body">
        <div className="form-group">
            <label className="col-md-3 control-label">sp_const_value_num</label>
            <div className="col-md-9">
                <input type="text" className="form-control " placeholder="sp_const_value_num"  name='sp_const_value_num' value={this.state.sp_const_value_num}
                       onChange={this.handleInputChange} /> 
            </div>
        </div>


    </div>

    <div className="form-body">
        <div className="form-group">
            <label className="col-md-3 control-label">sp_const_value_den</label>
            <div className="col-md-9">
                <input type="text" className="form-control " placeholder="sp_const_value_den"  name='sp_const_value_den' value={this.state.sp_const_value_den}
                       onChange={this.handleInputChange} /> 
            </div>
        </div>


    </div>

    <div className="form-body">
        <div className="form-group">
            <label className="col-md-3 control-label">sp_tolerance_ulevel</label>
            <div className="col-md-9">
                <input type="text" className="form-control " placeholder="sp_tolerance_ulevel"  name='sp_tolerance_ulevel' value={this.state.sp_tolerance_ulevel}
                       onChange={this.handleInputChange} /> 
            </div>
        </div>


    </div>

    <div className="form-body">
        <div className="form-group">
            <label className="col-md-3 control-label">sp_tolerance_llevel</label>
            <div className="col-md-9">
                <input type="text" className="form-control " placeholder="sp_tolerance_llevel"  name='sp_tolerance_llevel' value={this.state.sp_tolerance_llevel}
                       onChange={this.handleInputChange} /> 
            </div>
        </div>


    </div>

    <div className="form-body">
        <div className="form-group">
            <label className="col-md-3 control-label">sp_weight</label>
            <div className="col-md-9">
                <input type="text" className="form-control " placeholder="sp_weight"  name='sp_weight' value={this.state.sp_weight}
                       onChange={this.handleInputChange} /> 
            </div>
        </div>


    </div>

    <div className="form-body">
        <div className="form-group">
            <label className="col-md-3 control-label">sp_status</label>
            <div className="col-md-9">
                <input type="text" className="form-control " placeholder="sp_status"  name='sp_status' value={this.state.sp_status}
                       onChange={this.handleInputChange} /> 
            </div>
        </div>


    </div>

    <div className="form-body">
        <div className="form-group">
            <label className="col-md-3 control-label">sp_priority</label>
            <div className="col-md-9">
                <input type="text" className="form-control " placeholder="sp_priority"  name='sp_priority' value={this.state.sp_priority}
                       onChange={this.handleInputChange} /> 
            </div>
        </div>


    </div>

</form>

</Modal.Body>

<Modal.Footer>
    <div className="form-actions float-right">

        <button className="btn btn-default  dark" onClick={this.close}> Cancel</button>

        <button className="btn   green" onClick={this.state.formAction}> Submit</button>

    </div>
</Modal.Footer>
</Modal>

</div>

)}
