<?php // var_dump($savedColumns) ?>


<select style="width:500px;height: 300px;" id="column-list" class="multiselect" multiple="multiple" name="countries[]">

    <?php
    foreach ($columns as $column):

        $selected = '';
        $inArray = array_search($column['COLUMN_NAME'], $savedColumns);

            if ($inArray)
            $selected = 'selected';
        ?>


        <option value="<?php echo $column['COLUMN_NAME'] ?>"  <?php echo $selected ?> > <?php echo $column['COLUMN_NAME'] ?>  </option>

    <?php endforeach; ?>

</select>
