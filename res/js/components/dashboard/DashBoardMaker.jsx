import React, { Component } from 'react';
        import update from 'react/lib/update';
        import { DragDropContext } from 'react-dnd';
        import Select from 'react-select'
        import Highlighter from 'react-highlight-words';
        import HTML5Backend from 'react-dnd-html5-backend';
        import Gadget from  '../../components/Gadget.jsx';
        import NewGadget from  '../NewGadget.jsx';
        import GadgetSelect from  '../../components/GadgetSelect.jsx';
        import NewGadgetSelect from '../../components/NewGadgetSelect.jsx';
        import AddLayout from '../AddLayout.jsx'
        import DefaultLayout from '../configs/DefaultLayout.jsx';
        import DashBoardWizard from '../configs/DashBoardConfig.jsx';
        import {gadgetLayout } from '../configs/GadgetConfig.jsx';
        import TableComponent         from '../gadgets/TableComponent.jsx';
        import LightComponent         from '../gadgets/LightComponent.jsx';
        import RawmixRunComponent     from '../gadgets/RawmixRunComponent.jsx';
        import SetPointsComponent     from '../gadgets/SetPointsComponent.jsx';
        import SystemAlertsComponent  from '../gadgets/SystemAlertsComponent.jsx';
        import SiloComponent          from '../gadgets/SiloComponent.jsx';
        import ChartComponent         from '../gadgets/ChartComponent.jsx';
        import { DeleteModelButton } from '../configs/GlobalConfig.jsx';
        import { Button, FormGroup, ControlLabel, FormControl, Modal } from 'react-bootstrap';
        const style = {

        };
        const portletStyle = {
        minHeight:'200px'
                };
        @DragDropContext(HTML5Backend)
        export default class Container extends Component {
        constructor(props) {
        super(props);
                this.state = {
                gadgets:[],
                        defaultGadgets    :[],
                        selectedLayout    : null,
                        layoutID          : '',
                        layoutOption      :  null,
                        tour              : '',
                        layoutList        :   {},
                        existingLayout    : false,
                        newLayoutCreated  : false,
                        newLayout         : null,
                        showPreview           : false

                };
                this.close = this.close.bind(this);
                this.showPreview = this.showPreview.bind(this);
                this.closePreview = this.closePreview.bind(this);
                this.saveDefaultGadgets = this.saveDefaultGadgets.bind(this);
                this.moveGadget = this.moveGadget.bind(this);
                this.updatelayout = this.updatelayout.bind(this);
                this.renderLayout = this.renderLayout.bind(this);
                this.deleteGadget = this.deleteGadget.bind(this);
                this.onClick = this.onClick.bind(this);
                this.onSubmit = this.onSubmit.bind(this);
                this.setDefaultLayout = this.setDefaultLayout.bind(this);
                this.handleLayoutChange = this.handleLayoutChange.bind(this);
                this.getlayouts = this.getlayouts.bind(this);
                this.deleteLayout = this.deleteLayout.bind(this);
                this.handleNewLayout = this.handleNewLayout.bind(this);
                this.renderNewLayout = this.renderNewLayout.bind(this);
                this.moveMockGadget = this.moveMockGadget.bind(this);
                this.startTour = this.startTour.bind(this);
                this.buildGuidedTour = this.buildGuidedTour.bind(this);
                this.renderExistingGadget = this.renderExistingGadget.bind(this);
                this.renderNewGadgets = this.renderNewGadgets.bind(this);
                this.updateDefaultGadgets = this.updateDefaultGadgets.bind(this);
                this.deleteDefaultGadget = this.deleteDefaultGadget.bind(this);
                this.renderDashPreview = this.renderDashPreview.bind(this);
        }


        close(){


        }

        closePreview(){
        this.setState({showPreview : false});
        }
        buildGuidedTour(){

        var tour = new Tour({
        name: "layout_toure" + this.state.layoutID,
                container: "body",
                smartPlacement: false,
                placement : 'top',
                keyboard: true,
                storage: window.localStorage,
                debug: false,
                backdrop: true,
                backdropContainer: 'body',
                backdropPadding: 0,
                redirect: true,
                orphan: false,
                duration: false,
                delay: false,
                basePath: "",
                autoscroll : true,
                template: `<div class='popover tour'>
                            <div class='arrow'></div>
                            <h3 class='popover-title'></h3>
                            <div class='popover-content'>
                                Customize gadget for Your requirement
                            </div>
                            <div class='popover-navigation'>
                                <button class='btn btn-outline blue' data-role='prev'>« Prev</button>
                                
                                <button class='btn btn-outline blue' data-role='next'>Next »</button>
                                <span data-role='separator'></span>
                                 <button class='btn btn-outline red' data-role='end'>End tour</button>
                            </div>
                           
                          </div>`,
        });
                console.log("******************* =>=>=>=>=>=>=>=> The state", this.state);
                const  defaultGadgets = this.state.gadgetList;
               
                for (let x in defaultGadgets){

        let selectorQuery = '#gadget-proto-' + defaultGadgets[x]['gadget_data_id'];
                console.log("******************* =>=>=>=>=>=>=>=>", selectorQuery);
                let elementId = selectorQuery;
                let gadgetName = defaultGadgets[x]['subname'];
                tour.addStep({
                element: elementId,
                        title: gadgetName,
                        content: "Configure Gadgets"
                });
        }


        tour.init();
// Start the tour
                tour.start();
        }



        saveDefaultGadgets(){

                //       alert('save default');
                swal('Sucess', " Layout have been saved", 'success');
                $('.button-previous').trigger('click');
                //    alert('Current layout id => '+ this.state.layoutID)
                this.handleLayoutChange(this.state.layoutID)

                return true;
                let dGadgets = this.state.defaultGadgets;
                dGadgets.map((dg) => {


                var url = baseUrl + '/index.php/gadgets-data/create';
                        var successMessage = 'Widget(s) have been added to  Dashboard successfully';
                        dg.lay_id = this.state.newLayout.lay_id

                        $.ajax({
                        type:'POST',
                                url:url,
                                data: {GadgetsData : dg},
                                success:(msg) => {

                        swal('Sucess', successMessage, 'success');
                                //  location.reload();

                                $('.button-previous').trigger('click');
                                //    alert('Current layout id => '+ this.state.layoutID)
                                this.handleLayoutChange(this.state.layoutID)


                                this.setState({existingLayout    : true,
                                        newLayoutCreated  : false}, () => {


                                $('.button-previous').trigger('click');
                                });
                        },
                                error: (request, status, errorThrown) => {


                        swal('Error', 'Opps something went wrong', 'error')


                        }

                        });
                })

        }
        setDefaultLayout(){


        const formData = { GadlayLayouts : { lay_id : this.state.layoutID }};
                swal({
                title: "Are you sure?",
                        text: "Do you want to set this as default Dashboard?",
                        buttons: true,
                        dangerMode: false,
                })
                .then((willDelete) =>
                {
                if (willDelete) {

                $.ajax({
                type:'POST',
                        url: baseUrl + '/index.php/gadlay-layouts/update',
                        data: formData,
                        success:(msg) => {

                // let jObject = JSON.parse(msg);
                // this.close();

                //layouts.push(jObject['layout']);

                swal('Success', 'Current Dashboard set as default Dashboard', 'success')
                        this.props.onChange();
                }

                });
                } else {
                }
                }); //End of confirm


                }

        deleteLayout(){


        swal({
        title: "Are you sure?",
                text: "Do you want to delete this Dashboard?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
        })
                .then((willDelete) =>
                {
                if (willDelete) {

                $.ajax({
                type:'POST',
                        url: baseUrl + '/index.php/gadlay-layouts/delete?&id=' + this.state.layoutID,
                        success:(msg) => {



                swal('Success', 'Dashboar deleted sucessfully', 'success');
                        this.setState({layoutID : null}, this.getlayouts)
                        this.props.onChange();
                }

                });
                } else {
                //swal("Your imaginary file is safe!");
                }
                }); //End of confirm

                }
        getlayouts (id){

        axios.get(get_layouts_url, {
        headers: {
        'Content-Type': 'application/json',
                'X-Access-Token': access_token
        }
        }
        ).then((response) => {

        let layoutList = response.data.data;
                let temp = Array();
                let lookUp = {}
//        let layLookUp = 

        const otemp = layoutList.map(lay => {

        temp.push({ value:lay.lay_id, label : lay.subname + ' [' + lay.type + '] '})
                lookUp[lay.lay_id] = lay;
        })


//            // console.log('Complete list',lookUp)

                this.setState({layoutOption:temp, layoutList : lookUp}, this.render);
        }).catch(function (response) {
        alert(response.message)
        });
        } // End of getlayouts



        handleInputChange(event) {

        const target = event.target;
                const value = target.type === 'checkbox' ? target.checked : target.value;
                const name = target.name;
                this.setState({
                [name]: value
                });
        }


        handleLayoutChange(layoutID){



        if (layoutID){


        this.updatelayout(layoutID);
                $('.button-next').removeClass('hide');
                $('.button-next').trigger('click'); // wizard not providing function interface

                this.setState({newLayout:false, existingLayout:true, layoutID: layoutID}, () => { this.render });
        }

        }

        updatelayout(layoutID){

//      // console.log('Selected layout =>',this.state.layoutList[layoutID])

        this.setState({selectedLayout : this.state.layoutList[layoutID]});
                var gadgets;
                $.ajax({
                type:'POST',
                        url : baseUrl + '/index.php/gadgets-data/index', //have to figure out yii2 routing
                        data:{ lay_id : layoutID },
                        success:(response) => {

                let  jsObject = JSON.parse(response);
                        var array = Array();
                        array = jsObject.map((gad, i) => {
                        return gad;
                        });
                        this.setState({gadgetList : array, gadgets :  array, layoutID : layoutID }, () => { this.buildGuidedTour(); this.render() });
                }
                });
        }

        updateGadget(gadget) {

        const data = {
        GadgetsData : gadget
        }

        var url = baseUrl + '/index.php/gadgets-data/update?&id=' + gadget.gadget_data_id;
                // Have to change  response code 302 in apache running in linux
                $.ajax({
                type:'POST',
                        url:url,
                        data: data,
                        success:function(msg){


                        }.bind(this),
                        error: function(request, status, errorThrown) {


                        //alert('Updated Successfully');

                        }.bind(this)

                });
        }


        renderLayout(){



        var gadgetDivs = this.state.gadgetList.map((gad, i) => {
        // // console.log(gad)
        return <Gadget 

    layoutID={gad.lay_id}
    gadgetID={gad.gadget_data_id}  
    onClick={this.onClick} 
    key={gad.gadget_data_id}
    index={i}
    gadget_data_id={gad.gadget_data_id}
    gadget_name={gad.gadget_name}
    gadget_type ={gad.gadget_type}
    moveGadget={this.moveGadget}
    action="edit"        
    data={gad}
    layout={this.state.selectedLayout}

    />
        });
                this.setState({gadgetDivs : gadgetDivs})


        }

        deleteGadget(id){


        //Delete confirm
        swal({
        title: "Are you sure?",
                text: "Do you want to delete Gadget!",
                icon: "warning",
                buttons: DeleteModelButton,
                dangerMode: true,
        })
                .then((willDelete) =>
                {
                if (willDelete) {

                $.ajax({
                type:'GET',
                        url : baseUrl + '/index.php/gadgets-data/delete', //have to figure out yii2 routing
                        data:{ id : id },
                        success:(msg) => {

                this.updatelayout(this.state.layoutID)
                        swal('Success', 'Deleted Successfully', 'success')

                },
                        error:(msg, a, b) => {
                swal('Error', 'Opps Something went wrong', 'error')
                }
                });
                } else {
                //swal("Your imaginary file is safe!");
                }
                }); //End of confirm


        }


        deleteDefaultGadget(pos){


        swal({
        title: "Are you sure?",
                text: "Do you want to delete gadget",
                icon: "warning",
                buttons: DeleteModelButton,
                dangerMode: true,
        })
                .then((willDelete) =>
                {
                if (willDelete) {


                let defaultGadgets = this.state.defaultGadgets;
                        defaultGadgets.splice(pos, 1);
                        this.setState({defaultGadgets : defaultGadgets}, this.renderNewGadgets);
                        swal("Success", 'Successfuly removed gadget', 'success');
                } else {
                // swal("Error",'Something went wrong','error');
                }
                }); //End of confirm


        }

        handleNewLayout(layout){


        $.ajax({
        type:'POST',
                url : baseUrl + '/index.php/gadgets-data/create-default', //have to figure out yii2 routing
                data:{ lay_id : layout.lay_id, gadgets :  DefaultLayout[layout.type]},
                success:(response) => {

        this.setState(
        {
        layoutID : layout.lay_id,
                existingLayout    : false,
                newLayoutCreated : true,
                newLayout : layout,
        }, () => {
        axios.get(get_layouts_url, {
        headers: {
        'Content-Type': 'application/json',
                'X-Access-Token': access_token
        }
        }
        ).then((response) => {

        let layoutList = response.data.data;
                let temp = Array();
                let lookUp = {}
        //        let layLookUp = 

        const otemp = layoutList.map(lay => {

        temp.push({ value:lay.lay_id, label : lay.subname + ' [' + lay.type + '] '})
                lookUp[lay.lay_id] = lay;
        })


                //            // console.log('Complete list',lookUp)

                this.setState({layoutOption:temp, layoutList : lookUp}, () => { this.render(); this.handleLayoutChange(layout.lay_id) });
        }).catch(function (response) {
        alert(response.message)
        });
        });
        }
        });
        }
        componentDidMount(){

        DashBoardWizard.init();
                this.getlayouts();
        }


        renderOption(option){

        }
        onClick(id){

        this.deleteGadget(id)
        }

        onSubmit(id){


        this.updatelayout(id)

        }

        showPreview(){

        this.setState({showPreview : true});
        }
        moveGadget(dragIndex, dropIndex) {

        const { gadgets } = this.state;
                var dragGadget = gadgets[dragIndex];
                var targetGadget = gadgets[dropIndex]


                this.setState(update(this.state, {
                gadgets: {
                $splice: [
                [dragIndex, 1],
                [dropIndex, 0, dragGadget],
                ],
                },
                }), () => {

                this.state.gadgets.map((gadget, i) => {
                //debugger  
                gadget.widgetsPos = i
                        this.updateGadget(gadget);
                });
                }
                );
        }
        moveMockGadget(dragIndex, dropIndex) {

        const { defaultGadgets } = this.state;
                var dragGadget = defaultGadgets[dragIndex];
                var targetGadget = defaultGadgets[dropIndex]


                this.setState(update(this.state, {
                defaultGadgets: {
                $splice: [
                [dragIndex, 1],
                [dropIndex, 0, dragGadget],
                ],
                },
                }), () => {

                this.state.defaultGadgets.map((gadget, i) => {
                //debugger  
                gadget.widgetsPos = i
                        this.updateGadget(gadget);
                });
                }
                );
        }

        startTour(){
        let tour = new Tour({
        steps: [
        {
        element: "#step1",
                title: "Title of my step",
                content: "Content of my step"
        },
        {
        element: "#step2",
                title: "Title of my step",
                content: "Content of my step"
        }
        ]});
                // Initialize the tour
                tour.init();
                // Start the tour
                tour.start();
        }


        renderDashPreview(){

        let gadgets = null;
                if (this.state.existingLayout){

        gadgets = this.state.gadgets;
        } else{

        gadgets = this.state.defaultGadgets;
        }
        return (
                this.state.showPreview && <div className="portlet light  ">

    <div className="portlet-body">

        <div className="row ">


            {
                gadgets.map((gadgetData, i) => {

                //console.log("Preview data =>" , gadgetData)
                let gadget;
                        if (gadgetData.gadget_type === 'System_Messages') {

                gadget = <TableComponent gadget_data_id={gadgetData.gadget_data_id} data={gadgetData} type="preview"/>;
            } else if (gadgetData.gadget_type === 'Charts') {


                        gadget = <ChartComponent gadget_data_id={gadgetData.gadget_data_id} data={gadgetData} type="preview"/>;
            } else if (gadgetData.gadget_type === 'IdiotLights') {

                        gadget = <LightComponent gadget_data_id={gadgetData.gadget_data_id} data={gadgetData} type="preview"/>

            } else if (gadgetData.gadget_type === 'SetPoints') {


                        gadget = <SetPointsComponent gadget_data_id={gadgetData.gadget_data_id} data={gadgetData} type="preview"/>;
            } else if (gadgetData.gadget_type === 'SystemAlert') {


                        gadget = <SystemAlertsComponent gadget_data_id={gadgetData.gadget_data_id} data={gadgetData} type="preview"/>;
            } else if (gadgetData.gadget_type === 'Silos') {


                        gadget = <SiloComponent gadget_data_id={gadgetData.gadget_data_id} data={gadgetData} type="preview"/>;
            } else if (gadgetData.gadget_type === 'RawmixRun') {
                        gadget = <RawmixRunComponent   gadget_data_id={gadgetData.gadget_data_id}  data={gadgetData} type="preview"/>

            }

            //gadget size

            let gadgetSize;

            let portlet = '';

            if (gadgetData.gadget_type === 'SetPoints') {

                        gadgetSize = 'col-md-3';
                        portlet = 'portlet no-shadow';
            } else
            if (gadgetData.gadget_type === 'SystemAlert') {

                        gadgetSize = 'ramixgadget';
                        portlet = 'portlet no-shadow';
            } else if (gadgetData.gadget_type === 'Silos') {

                        gadgetSize = 'col-md-7';
                        portlet = 'portlet no-shadow';
            } else
            if (gadgetData.gadget_size === 'large') {
                        gadgetSize = 'col-md-12 ';
                        portlet = 'portlet'

            } else if (gadgetData.gadget_size === 'medium'){

                        gadgetSize = 'col-md-8 ';
                        portlet = 'portlet'
            } else {
                        gadgetSize = 'col-md-4 ';
                        portlet = 'portlet'
            }


            return <div key={i}  className={gadgetSize}>
                { gadget }
            </div>                                         
            })
            }


        </div>
    </div>
</div>
                        );
                }
                renderNewLayout(){

                const gadgets = DefaultLayout.rawmix;
                        return (<div className="col-md-12"> { this.state.newLayout && <div className="portlet light  ">
        <div className="portlet-title ">
            <div className="caption font-blue ">
                <i className="fa fa-list font-blue font-blue"></i> Gadgets
            </div>
            <div className="actions">

                <GadgetSelect parentClose={this.close} layout={[]}  layoutType="" layoutID={this.state.layoutID} onSubmit={this.onSubmit} />    
            </div>
        </div>
        <div className="portlet-body">

            <div className="row ">


                {gadgets.map((gadget, i) => (
                <NewGadget
                    key={gadget.gadget_data_id}
                    index={i}
                    gadget_data_id={gadget.gadget_data_id}
                    gadget_name={gadget.gadget_name}
                    gadget_type ={gadget.gadget_type}
                    layoutID ={this.state.layoutID}
                    moveGadget={this.moveMockGadget}
                    action="edit"        
                    data={gadget}
                    onClick={this.deleteGadget}
                    onSubmit={this.onSubmit}        
                    />
                                ))}


            </div>
        </div>
    </div>}
</div>)
                }


                renderNewGadgets(){

                const defaultGadgets = this.state.defaultGadgets;
                        return (
                                this.state.newLayout && <div className="portlet light  ">
    <div className="portlet-title ">
        <div className="caption font-blue ">
            <i className="fa fa-list font-blue "></i> {this.state.newLayout.subname} Gadgets
        </div>
        <div className="actions">

            { false && this.state.layoutID && <NewGadgetSelect parentClose={this.close} layout={this.state.newLayout}  onSubmit={this.onSubmit} />    }
        </div>
    </div>
    <div className="portlet-body">

        <div className="row">
            <div className="note note-success">

                <strong>Success!  '{this.state.newLayout.subname}'</strong>  Dash have been created . Cofigure below gadgets according to your requirement

            </div>  
        </div>

        <div className="row ">

            <div style={ style }>
                {
                                defaultGadgets.map((gadget, i) => (
                <NewGadget
                    id ={"new-gadget-" + gadget.gadget_data_id}
                    key={i}
                    index={i}
                    gadget_data_id={gadget.gadget_data_id}
                    gadget_name={gadget.gadget_name}
                    gadget_type ={gadget.gadget_type}
                    layoutID ={this.state.layoutID}
                    moveGadget={this.moveMockGadget}
                    action="edit"        
                    data={gadget}
                    layout={this.state.newLayout}
                    onClick={this.deleteGadget}
                    onSubmit={this.onSubmit}  
                    updateDefaultGadgets={this.updateDefaultGadgets}  
                    deleteDefaultGadget = {this.deleteDefaultGadget}        
                    />
                                        ))
                }
            </div> 

        </div>
    </div>
</div>
                                );
                }

                updateDefaultGadgets(gadgetData){

                let defaultGadgets = this.state.defaultGadgets;
                        defaultGadgets[gadgetData.widgetsPos - 1] = gadgetData;
                        this.setState({defaultGadgets : defaultGadgets}, () => {

                        })


                        // console.log("Default Gadgets",defaultGadgets);


                }
                renderExistingGadget(){


                // console.log('layout id existing' ,this.state.layoutID)

                // console.log('layouts' ,this.state.layoutList);

                const gadgets = this.state.gadgets;
                        return (
                                this.state.existingLayout && this.state.layoutList[this.state.layoutID] && <div className="portlet light  ">
    <div className="portlet-title ">
        <div className="caption font-blue ">
            <i className="fa fa-list font-blue "></i> {this.state.layoutList[this.state.layoutID].subname} Gadgets
        </div>
        <div className="actions">

            { this.state.layoutID && <GadgetSelect parentClose={this.close} layout={this.state.selectedLayout} layoutType="" layoutID={this.state.layoutID} onSubmit={this.onSubmit} />    }
        </div>
    </div>
    <div className="portlet-body">

        <div className="row ">

            <div style={ style }>
                {gadgets.map((gadget, i) => (
                <Gadget
                    key={gadget.gadget_data_id}
                    index={i}
                    gadget_data_id={gadget.gadget_data_id}
                    gadget_name={gadget.gadget_name}
                    gadget_type ={gadget.gadget_type}
                    layoutID ={this.state.layoutID}
                    moveGadget={this.moveGadget}
                    action="edit"        
                    data={gadget}
                    onClick={this.deleteGadget}
                    onSubmit={this.onSubmit} 
                    layout={this.state.selectedLayout}        
                    />
                                ))}
            </div> 

        </div>
    </div>
</div>
                                );
                }

                render() {


                return (
<div>

    <div className="portlet light form-wizard" id="form-wizard" >
        <div className="portlet-title tabbable-line">


            <ul className="nav nav-pills nav-justified steps">
                <li>
                    <a href="#layout" data-toggle="tab" className="step active">
                        <span className="number"> 1 </span>
                        <span className="desc">
                            <i className="fa fa-check"></i> Dashboard </span>
                    </a>
                </li>
                <li>
                    <a href="#configure" data-toggle="tab" className="step">
                        <span className="number"> 2 </span>
                        <span className="desc">
                            <i className="fa fa-check"></i> Configure </span>
                    </a>
                </li>
                <li>
                    <a href="#verify" data-toggle="tab" className="step">
                        <span className="number"> 3 </span>
                        <span className="desc">
                            <i className="fa fa-check"></i> Verify </span>
                    </a>
                </li>

            </ul>
            <div id="bar" className="progress progress-striped" role="progressbar">
                <div className="progress-bar progress-bar-success"> </div>
            </div>


        </div>
        <div className="portlet-body ">

            <div className="tab-content">


                <div className="tab-pane active" id="layout" style = {{ minHeight:'400px'}}>

                    <div className="note note-info text-align-left">
                        <h4 className="block">
                            <span className="caption-subject bold uppercase"> Create or Customize Existing Dashboard</span>
                        </h4>
                        <p>
                            Create or Customize Existing Dashboard , You can add delete edit Gadgets according to your personal 
                            requirements .
                        </p>
                    </div>
                    <form id="dash_form" className="form form-horizontal" onSubmit= { (e) => { e.preventDefault()}}>
                    </form>
                    <div className="row">



                        <div className="col-md-6 text-center">

                            <AddLayout  onChange={this.updateLayout} onSubmit={this.onSubmit}   handleNewLayout={this.handleNewLayout}/>
                        </div>

                        <div className="col-md-6 text-center">


                            <div  style={{width:'410px', marginLeft:'auto', marginRight:'auto'}}>

                                <Select
                                    name="layoutID"
                                    className="btn-lg"
                                    closeOnSelect={!this.state.stayOpen}
                                    required={true}
                                    onChange={this.handleLayoutChange}
                                    options={this.state.layoutOption}
                                    placeholder="Select  Existing Dashboard Layout"
                                    simpleValue
                                    value={this.state.layoutID}

                                    />
                            </div>

                        </div>  



                    </div>

                </div>

                <div className="tab-pane row" id="configure">


                    <button className="btn btn-success  hide" onClick = {this.buildGuidedTour}> Config</button>


                    <div className="col-md-12" style = { { minHeight:'400px'}}>


                        {  this.renderExistingGadget()   }
                        

                    </div>
                </div>

                <div className="tab-pane" id="verify">

                    <div  className="row  " style={{minHeight:gadgetLayout.minHeight}}>

                        <div className="col-md-12 text-align-center" style={{marginTop:"10%",marginBottom:"auto"}}>

                            <div className="col-md-6">
                                <button className="btn  btn-lg purple" onClick={this.setDefaultLayout} style={{margin:'50px'},{width:'300px'}}> 
                                    Set As Default Dashboard
                                </button>

                            </div>

                            <div className="col-md-6">
                                <button className="btn btn-lg blue" onClick={this.showPreview} style={{margin:'50px'},{width:'300px'}}>
                                    Preview
                                </button>

                            </div>

                        </div>

                    </div>

                    <Modal show={this.state.showPreview} onHide={this.closePreview} dialogClassName="preview-modal">
                        <Modal.Header closeButton>
                            <Modal.Title className="text-center">
                                <span className="caption-subject bold uppercase font-blue ">Preview</span>
                            </Modal.Title>
                        </Modal.Header>
                        <Modal.Body>

                            {this.renderDashPreview()}

                        </Modal.Body>
                        <Modal.Footer>
                            <div className="form-actions right">
                                <button type="button" className="btn default" onClick={this.closePreview}>Close</button>
                            </div>
                        </Modal.Footer>
                    </Modal>
                </div>


            </div>

            <div className="form-actions">
                <div className="row">
                    <div className="col-md-12" style={{textAlign:'center'}}>
                        <a href="javascript:;" className="btn default button-previous " >
                            <i className="fa fa-angle-left"></i> Back </a>
                        {
                        <a href="javascript:;" className="btn  blue button-next hide"> Next
                            &nbsp;>>
                        </a>
                        }
                        {

                        <a href="javascript:;" className="btn blue button-submit" onClick={this.saveDefaultGadgets}> Save & Finish
                            <i className="fa fa-check"></i>
                        </a>

                        }


                    </div>
                </div>
            </div>

        </div>
    </div>


</div>


                        );
                }
                }
