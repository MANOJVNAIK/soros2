<a class="chevron" href="#">»</a>
<?php


$tagGroupUrl  = Yii::app()->createAbsoluteUrl('tagGroup');
$tagUrl       = Yii::app()->createAbsoluteUrl('TagSettings');
$monitorUrl   =  Yii::app()->createAbsoluteUrl('Monitor');
$controlId = Yii::app()->controller->getId();

$tagsActive = '';
$tagGroupActive = '';

$menuIndex = strtolower($controlId);

if (in_array($menuIndex, array('taggroup','tags','tagqueued','tagcompleted','tagsettings'))) {
    $menuIndex = 'monitor';
}

if (in_array($menuIndex, array('rfidcalmap','wclrfidlogmessages'))) {
    $menuIndex = 'truckinfo';
}

$actionId = Yii::app()->getController()->getAction()->getId();
    


if(strtolower($actionId) === 'plot')
  $plotActive = 'current';    

    
$menuItem['rawmix'] = array(
    array(
        'label' => '<i class="navicon-house"></i> ' . Yii::t('leftmenu', "Dashboard"),
        'url' => array('/rawmix/dash')
    ),
    array(
        'label' => '<i class="navicon-photos"></i>' . Yii::t('leftmenu', "History"),
        'url' => array('/rawmix/history'),
        'visible' => 1
    ),
    array(
        'label' => '<i class="navicon-ekg"></i> ' . Yii::t('leftmenu', "Logs"),
        'url' => array('/rawmix/lmessages'),
        'visible' => 1
    ),
  
    array(
        'label' => '<i class="navicon-gear-1"></i> ' . Yii::t('leftmenu', "Settings"),
        'url' => array('/rawmix/rmsettings'),
    ),
    array(
        'label' => '<i class="icon-key"></i> '.Yii::t('leftmenu', 'RM-History'),
        'url' => array('/rawmix/iohistory'),
    ),
    array(
        'label' => '<i class="icon-key"></i> Log Out',
        'url' => array('site/logout'),
    )
    
);
                   
$menuItem['dash2'] = array(
    array(
        'label' => '<i class="navicon-house"></i> ' . Yii::t('leftmenu', "Dashboard"),
        'url' => array('dash')
    ),
    array(
        'label' => '<i class="icon-calendar"></i>' . Yii::t('leftmenu', "Layouts"),
        'url' => array('/dash/create'),
        'visible' => 0
    ),
    array(
        'label' => '<i class="navicon-cabinet"></i> ' . Yii::t('leftmenu', "Tag-Data"),
        'url' => array('dash/tagging'),
        'visible' => 0
    ),
  
    array(
        'label' => '<i class="icon-key"></i> Log Out',
        'url' => array('site/logout'),
    ),
);


$menuItem['dash'] = array(
    array(
        'label' => '<i class="navicon-house"></i> ' . Yii::t('leftmenu', "Dashboard"),
        'url' => array('/dash'),
        'linkOptions' => array(
            'class' => 'navicon-house',
            'title' => ''
        ),
    ),
    array(
        'label' => '<i class="navicon-id-graph"></i> ' . Yii::t('leftmenu', "Plot"),
        'url' => array('/dash/plot'),
        'linkOptions' => array(
            'class' => 'navicon-stats',
            'title' => 'Plots'
        ),
    ),
    
);


$calibmapActive = $controlId == 'rfidcalmap' ? 'current' : '';

$menuItem['truckinfo'] = array(
    array(
        'label' => '<i class="navicon-id-cards"></i> ' . Yii::t('leftmenu', "Dashboard"),
        'url' => array('/truckInfo/admin'),
        'linkOptions' => array(
            'class' => 'navicon-index-cards',
            'title' => 'Plots'
        ),
    ),
    array(
        'label' => '<i class="navicon-truck"></i> ' . Yii::t('leftmenu', "New (PB-2)"),
        'url' => array('/truckInfo/create'),
        'linkOptions' => array(
            'class' => 'navicon-truck',
            'title' => ''
        ),
    ),
    
    
    array(
        'label' => '<i class="navicon-truck"></i> ' . Yii::t('leftmenu', "Calib-map"),
        'url' => array('/rfidCalMap'),
        'itemOptions' => array('class' => $calibmapActive),
        'linkOptions' => array(
            'class' => 'navicon-truck',
            'title' => ''
        ),
    ),
    
    array(
        'label' => '<i class="navicon-truck"></i> ' . Yii::t('leftmenu', "Calib-Log"),
        'url' => array('/WclRfidLogMessages/admin'),
//        'itemOptions' => array('class' => ),
        'linkOptions' => array(
            'class' => 'navicon-truck',
            'title' => ''
        ),
    ),

    array(
        'label' => '<i class="navicon-truck"></i> ' . Yii::t('leftmenu', "Health-Log"),
        'url' => array('/healthLog/admin'),
//        'itemOptions' => array('class' => ),
        'linkOptions' => array(
            'class' => 'navicon-truck',
            'title' => ''
        ),
    ),

    
);


$monitorActive = $controlId == 'monitor' ? 'current' : '';

$menuItem['monitor'] = array(
    array(
        'label' => Yii::t('leftmenu', "Dashboard"),
        'url' => array('/monitor/dash'),
        'itemOptions' => array('class' => $monitorActive),
        'linkOptions' => array(
            'class' => 'navicon-house',
            'title' => ''
        ),
    ),
    
    array(
        'label' => Yii::t('leftmenu', 'Tag'),
        'url' => array('/TagSettings'),
        'itemOptions' => array('class' => $tagsActive),
        'linkOptions' => array(
            'class' => 'navicon-tag',
            'title' => ''
        ),
    ),
    array(
        'label' =>  Yii::t('leftmenu', 'Tag Groups'),
        'url' => array('/tagGroup'),
        'itemOptions' => array('class' => $tagGroupActive),
        'linkOptions' => array(
            'class' => 'navicon-tags',
            'title' => ''
        ),
    ),
    array(
        'label' => '<i class="navicon-id-card"></i> ' . Yii::t('leftmenu', "Logout"),
        'url' => array('/site/logout'),
        'linkOptions' => array(
            'class' => 'navicon-power',
            'title' => ''
        ),
    ),
    
);




$this->widget('zii.widgets.CMenu', array(
    'items' => $menuItem[$menuIndex],
    'activeCssClass'=>'current',
    'encodeLabel' => false,
    'htmlOptions' => array(
        // 'class' => 'nav pull-right',
        'id' => 'bodyLeftMenu',
    ),
));
