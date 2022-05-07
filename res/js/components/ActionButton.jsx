import React, { Component } from 'react';
import update from 'react/lib/update';

var defaultSettings = {
    header: true,
    noRowsMessage: 'No items',
    className: 'btn btn-outline btn-default',
    title: 'Action'
},
        getSetting = function (name) {
            var settings = this.props.settings;

            if (!settings || typeof settings[ name ] == 'undefined')
                return defaultSettings[ name ];

            return settings[ name ];
        }
;


export default class ActionButton extends Component {
    constructor(props) {
        super(props);
        // this.hangleLayoutChange = this.hangleLayoutChange.bind(this);
        this.state = { getSettings : getSetting};
    }

    render() {


        var buttonClass = this.props.className || this.state.getSetting('className');
        var title = this.props.title || this.state.getSetting('title');
        var id = this.props.id;


        return  <button className={buttonClass} onClick={() => {
                        this.props.onClick(this.props.id)
        }}> {title}</button>



    }
};
