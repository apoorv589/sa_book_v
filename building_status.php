<style>
    .legend {
        display: inline-block;
        padding: 5px 10px;
        color: #909090;
    }

    .bg-occupied {
        background-color: #FFFF99;
    }

    .bg-warning{
      background-color:#C0C0C0;
    }
</style>

<?php
    $ui = new UI();

    $tabBox = $ui->tabBox()
            ->uiType('primary')
            //->title('Building Status')
		    ->title("Building Status")
            ->id('building_tab')
            ->tab('old_tab', 'Old Building', 'true')
            ->tab('extension_tab', 'Extension Building')
		    ->open();
    echo '<span class="legend bg-success">Available</span>
    <span class="legend bg-danger">Booked</span>
    <span class="legend bg-occupied">Checked In</span>
    <span class="legend bg-warning">Blocked</span>';

    echo '<span id="auth" style="display:none;">'.$auth.'</span>';

    $old_tab = $ui->tabPane()
            ->id('old_tab')
            ->active()
            ->open();

    $old_tab->close();

    $ex_tab = $ui->tabPane()
            ->id('extension_tab')
            ->open();

    $ex_tab->close();
?>
