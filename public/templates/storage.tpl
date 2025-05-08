<?php if (!empty($data)): ?>
    <div class="storage">
        <?php foreach ($data as $dkey => $dval): ?>
            <div class="subtype">
                <h3><?= htmlspecialchars($dkey) ?></h3>
                <div class="equipment_card">
                    <?php foreach ($dval as $unit): ?>
                        <div class="unit">
                            <br>
                            <?php foreach ($unit as $ukey=>$uval): ?>                        
                                <p class="equipment_card_row"><?= htmlspecialchars($ukey) ?> : 
                                <?= htmlspecialchars($uval) ?></p>
                            <?php endforeach; ?>
                                <div class="buttons">
                                    <form action="/storage/delete" method="post">
                                    <input type="hidden" name="tablename" value="<?= htmlspecialchars($dkey) ?>">
                                    <input type="hidden" name="target" 
                                        value="<?= htmlspecialchars($unit['serial_number'] ?? $unit['name']) ?>">
                                    <input type="submit" value="DELETE"></form>
                                    <form action="/storage/update" method="post">
                                    <input type="hidden" name="tablename" value="<?= htmlspecialchars($dkey) ?>">
                                    <input type="hidden" name="target" 
                                        value="<?= htmlspecialchars($unit['serial_number'] ?? $unit['name']) ?>">
                                   <input type="submit" value="UPDATE"></form>
                                </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p class="no-data">No equipment found</p>
<?php endif; ?>
