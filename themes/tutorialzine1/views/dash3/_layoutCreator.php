 <table id="dash-column"><tr>
   <td style="vertical-align: top; width:80%;">
    <?php
    $gridArr = array(0=>2,2=>1,4=>3,6=>4);

    for($i=0; $i < $columns; $i++)
    { 
        if( !empty ($portlets[$i]) ) {
         foreach($portlets[$i] as $row) {
        ?>
            <div class="grid_<?php if($row['size'][0]) echo $gridArr[$row['size'][0]]; else {echo '2';}?> portlet ui-sortable clearfix padMargin collapsible" title="<?php if($row['size'][0]) echo $gridArr[$row['size'][0]]; else {echo '2';}?>" draggable="true" id="<?php echo $row['id'] ?>">
                <header>
						<ul class="pagination clearfix leading minusPad" >
							<li class="page">
								<span class="spacer"></span>
							</li>
							<li class="page">
								<a href="#"><span class="ui-button-icon-primary ui-icon ui-icon-circle-close"/></a>
							</li>
							<li class="page">
								<?php echo $row['title'] ?>
							</li>
							<?php if($row['size'][0] && $row['size'][0] != 2)
							{ ?> 
								<li class="last fRight <?php if($row['size'][0]==6) echo 'current cY'; if(!in_array(6,$row['size'])) echo 'disabled'; ?> " id="<?php echo $row['id']; ?>_lBut">
									<a href="#"  <?php if(in_array(6,$row['size'])) echo "onClick='changeCss(\"#".$row['id']."\", \"l\", \"6\"); return false;'"; ?> title="Large Box"  > L</a>
								</li>
								<li class="last fRight <?php if($row['size'][0]==4) echo 'current cY'; if(!in_array(4,$row['size'])) echo 'disabled'; ?> " id="<?php echo $row['id']; ?>_mBut">
									<a href="#"  <?php if(in_array(6,$row['size'])) echo "onClick='changeCss(\"#".$row['id']."\", \"m\", \"4\"); return false;'"; ?> title="Medium Box"  > M</a>
								</li>
																											<?php 
							} ?>
							<input type="hidden" id="<?php echo $row['id'] ?>_Hid" name="<?php echo $row['id'] ?>" value="<?php echo $row['size'][0]; ?>"/>
						</ul>
                </header>
                <section>
				    <?php
				        if (@$row['renderContent']) {
				            $dataProvider=$row['info']['dataProvider'];
				            $this->renderPartial($row['view'], array('dataProvider'=>$dataProvider), $row['flag']);
				         } else {
				             echo $row['content'];
				         }
				    ?>
                </section>
            </div>
    <?php }} ?>
        </td>
<?php } ?>
    </td></tr></table>