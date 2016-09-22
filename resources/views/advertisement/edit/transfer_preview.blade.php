<div id="canvas" ng-mouseup="saveItemPosition()" ng-mousedown="moveItems($event)">
    <?php if($data){ ?>
        <?php foreach($data as $item){ ?>
            <div data-id="<?=$item->id?>" class="seat item" style="position:absolute; top:<?=$item->y_pos?>px;left:<?=$item->x_pos?>px">
                <div class="number"><?=$item->number?></div>
            </div>
        <?php } ?>
    <?php } ?>
</div>
