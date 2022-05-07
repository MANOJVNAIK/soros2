<?php
        /* @var $this ProductProfileController */
        /* @var $model ProductProfile */
        
        $addLink = Yii::app()->createAbsoluteUrl('rawmix/settings');

        $cs = Yii::app()->clientScript;
        $baseUrl = Yii::app()->baseUrl;

        //$cs->registerScriptFile($baseUrl . '/js/rawmix.js', CClientScript::POS_END);
        //$cs->registerScriptFile($baseUrl . '/js/formvalidator.js', CClientScript::POS_END);
?>
<section class="main-section grid_8">
    <nav class="">
        <?php
        $layoutY = $this->layout;
        $them = Yii::app()->theme->name;

        $this->renderPartial('rawmixLeftMenu');
        ?>
    </nav>
    <div class="main-content">

        <section class="container_2 clearfix">
            <!-- Tabs inside Portlet -->
            <div class="grid_2 leading">

<?php

	require_once '/var/www/html/usrCalObj.php';
	require_once '/var/www/html/usrCalUtils.php';
	require_once '/var/www/html/configfile.php';
	

	function performDefault( $usrCal, $showLoadBut )
	{
	    echo "<script type=\"text/javascript\" src=\"js/usrCalClient.js\"></script>";
	    echo '<div class="portlet collapsible" id="calibration">
                 <header>
                        <h2>Update Calibration</h2>
                 </header>
                 <section class="no-padding clearfix">';
	    
		$stdCal = local_readStdCal();
		local_performLoadStdCal( $usrCal, $stdCal, $showLoadBut );
	    echo "	</section>";
	    echo "</div>";
	}


    function local_performLoadStdCal( $usrCal, $stdCal, $showLoadBut )
    {
		
        echo "<div class=\"grid_2\">";
        echo "<br/>";
        echo "<form action=\"". $baseUrl ."\" method=\"post\">";
        echo "<table border=2>";

        echo "<tr><td colspan=2><br/></td></tr>";
        echo "<tr>";
	        echo "<td style=\"text-align:center\">";
	        echo "Load Calibration";
	        echo "</td>";
	        echo "<td>";
	        local_drawStdCalSelectBox( $stdCal);
	        echo "</td>";
        echo "</tr>";
        echo "<tr><td colspan=2><br/></td></tr>";
        if($showLoadBut){
        echo "<tr id='showCalib' >";
	        echo "<td colspan=2 style=\"text-align:left\">";
			echo '<button id="stdCalSelectBox" class="ui-button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="submit" aria-disabled="false">
					<span class="ui-button-text" >Load Standard Calibration</span>
				</button>';	        
	        echo "<input type=\"hidden\" name=\"perform\" value=\"submitLoadStdCal\" />";
	        echo "</td>";
        echo "</tr>";
        }else {
        echo "<tr >";
	        echo "<td>";
			echo "<input style='width:150px !important;' type=\"password\" name=\"passworde\" value=\"\" />";
			echo "</td>";
			echo "<td>";
			echo '<button id="authBut" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="submit" aria-disabled="false">
					<span class="ui-button-text" >Authorize</span>
				</button>';
	        echo "</td>";
        echo "</tr>";
        }        

        echo "</table>";
        echo "</td>";

        echo "</tr>";
        echo "</table>";
        echo "</form>"; 
        if($stdCal)
        {
            echo "<hr>";
            echo "<table border=2>";
            echo "<tr style='text-align:center;'><td style='font-weight:bold;'> Active Calibration</td><td> ";
            echo '<button id="stdCalSelectBox" class="ui-button ui-button ui-widget ui-state-highlight ui-corner-all ui-button-text-only" role="button" aria-disabled="false">
					<span class="ui-button-text" style="color:red;">'.$stdCal.'</span>
				 </button>';
            echo "</td></tr>";
            echo "</table>";
        }
        else
        {
            echo "<br/>Problem reading standard calibration selection<br/>";
        }

        echo "</div>";

    }

    $usrCal = new usrCalObj();

    $perform = getPassedVar( 'perform' );
    $toLoad  = getPassedVar( 'calselector' );
    if(isset($_REQUEST["passworde"]) && ($_REQUEST["passworde"] == "calib")) {
       	$showLoadBut = 1;
    }else {
       	$showLoadBut = 0;
    }    

    switch ($perform)
    {
    case "submitLoadStdCal":

        if ( !(local_writeStdCal($toLoad)) )
        {
           echo "Problem loading standard calibration.<br/>";
        }
        else
            performDefault( $usrCal , $showLoadBut);

        break;        

    default:

        performDefault( $usrCal, $showLoadBut );

        break;
    }


    function local_drawStdCalSelectBox( $sessionCal )
    {
	    global $stdCalNames;
		include( CAL_PARAM_NAME_FILE );//TF062414
		
        echo "<select name=\"calselector\" >";
        foreach( $stdCalNames as $cal)
        {
            if( $cal == $sessionCal )
               echo "<option value=$cal selected=$cal>$cal</option>";
            else
                echo "<option value=$cal>$cal</option>";
        }
        echo "</select>";
    }

    
	function local_readStdCal( )
	{
	    $cadj = new ConfigFile();
	    if ( $cadj->load( CAL_ADJUST_FILE ) )
	    {
	        $cadj->setPath( "/STDCAL" );
	        $stdCal = $cadj->readEntry( "std_display_list", "" );
	    }
	    else
	    {
	        return FALSE;
	    }
	
	    return $stdCal;
	}
	
	function local_writeStdCal( $stdCal )
	{
	    $cadj = new ConfigFile();
	    if ( $cadj->load( CAL_ADJUST_FILE, false ) )
	    {
	        $cadj->setPath( "/STDCAL");
	        $cadj->writeEntry( "std_display_list", $stdCal );
	        $cadj->flush();
	    }
	    else
	    {
	        return FALSE;
	    }
	
	    return TRUE;
	}    
    
  ?>
	     </div><!-- grid_6 leading -->
	</section><!-- container_6 clearfix -->
    </div><!-- main-content -->
</section><!-- main-section grid_8 -->