import React from 'react';
import ReactDOM from 'react-dom';
import Container from './components/dnd/Container';
import RawmixSettings from './components/rawmix/RawmixSettings.jsx';
import TagSettings from './components/tags/TagSettings.jsx';
import TagGroupSettings from './components/tags/TagGroupSettings.jsx';
import DashBoardMaker  from './components/dashboard/DashBoardMaker.jsx';
import UsetProfile  from './components/userProfile/UserProfile.jsx';
////

if( document.getElementById('rawmix-settings')){
    ReactDOM.render(
        <RawmixSettings />
        ,
        document.getElementById('rawmix-settings')
        );



}else if( document.getElementById('create-app')){


ReactDOM.render(
        <DashBoardMaker />,
        document.getElementById('create-app')
        );



}

else if( document.getElementById('tag-settings')){


ReactDOM.render(
        <TagSettings />,
        document.getElementById('tag-settings')
        );



}
else if( document.getElementById('tag-group-settings')){


ReactDOM.render(
        <TagGroupSettings />,
        document.getElementById('tag-group-settings')
        );



}


else if( document.getElementById('user-profile')){


ReactDOM.render(
        <UsetProfile />,
        document.getElementById('user-profile')
        );



}
