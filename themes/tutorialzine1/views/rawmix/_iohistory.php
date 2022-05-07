<?php

	$Ar = $data;

	$inFeedValsText = '';
	$inAnyValsText = '';
	$outFeedValsText = "";
	$dataMarked = 0;
	$spValsCurAr = array();

	$inFeedVals = unserialize($Ar["rm_input_feed"]);
	$inAnyVals = unserialize($Ar["rm_input_analysis"]);
	$outFeedVals = unserialize($Ar["rm_output_feed"]);
	$timeStamp = $Ar["rm_updated"];
	$runType = $Ar["rm_run_type"];
	$newStyle = 0;
	$chkAr = $inFeedVals;

	if (count($chkAr) > 0) {
		foreach ($chkAr as $id => $ar) {
			if ($id == 0) {
				$newStyle = 1;
				break;
			} else {
				$newStyle = 0;
			}
		}//foreach
	}//if isset

	if ($newStyle) {

		$iFeedValsAr = array();
		if (count($inFeedVals) > 0) {
			foreach ($inFeedVals as $id => $ar) {
				if (count($ar) > 0) {
					foreach ($ar as $fname => $fval) {
						$iFeedValsAr[$fname] = $fval;
					}//foreach
				}//count ar
			}//foreach
		}//is_array
		
	} else {
		if (count($inFeedVals) > 0) {
			$dataMarked = 1;
			foreach ($inFeedVals as $vals) {
				if (isset($vals[0]))
					$inFeedValsText .= '<td>' . round($vals[0], 3) . '</td>';
				else
					$inFeedValsText .= '<td>-</td>';
			}//foreach
		}//if count											    		
	}//else


	$averagesAr = $inAnyVals["Averages"];

	if (count($spList) > 0) {
		foreach ($spList as $spAr) {
			$spName = $spAr["sp_name"];
			if (isset($averagesAr[$spName]))
				$inAnyValsText .= '<td class="ui-state-default">' . round($averagesAr[$spName], 3) . '</td>';
			else
				$inAnyValsText .= '<td>-</td>';
		}//foreach
	}//if count

	$oFeedValsAr = array();
	if (is_array($outFeedVals) && (count($outFeedVals) > 0)) {
		foreach ($outFeedVals as $id => $ar) {
			if (count($ar) > 0) {
				foreach ($ar as $fname => $fval) {
					$oFeedValsAr[$fname] = $fval;
				}//foreach
			}//if count ar
		}//foreach outfeedvals
	}//if count

	if (count($srcList) > 0) {

		foreach ($srcList as $spAr) {
			$classN = "";
			$style = 0;
			$spName = $spAr["src_name"];

			if (!$dataMarked) {
				if (isset($iFeedValsAr[$spName]) && isset($oFeedValsAr[$spName])) {
					if ($iFeedValsAr[$spName] != $oFeedValsAr[$spName]) {
						$classN = 'class="ui-state-highlight"';
						$style = 1;
					}
				}//if isset	                                                        	

				if (isset($iFeedValsAr[$spName]))
					$inFeedValsText .= "<td $classN $style>" . round($iFeedValsAr[$spName], 3) . '</td>';
				else
					$inFeedValsText .= '<td>-</td>';
			}
			if (($style))
				$style = 'style="color:red;font-weight:bold;"';

			if (isset($oFeedValsAr[$spName]))
				$outFeedValsText .= "<td $classN $style>" . round($oFeedValsAr[$spName], 3) . '</td>';
			else
				$outFeedValsText .= '<td>-</td>';
		}  //foreach    
	}//count  $srcList                              

	if ($i % 2 == 0) {
		echo '<tr class="gradeA odd">';
	} else {
		echo '<tr class="gradeB even">';
	}
	echo '<td > ' . $ki . '</td>';
	echo '<td > <a href="#" onclick="fetchErrorMsg(\'' . $Ar["rm_log_id"] . '\')">' . ($timeStamp) . '</a></td>';
	echo '<td >' . $runType . '</td>';
	echo $inFeedValsText;
	echo $inAnyValsText;
	echo $outFeedValsText;
	echo '</tr>';

	$i++;
	$ki++;
?>